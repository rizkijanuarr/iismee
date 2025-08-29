<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\Document;
use App\Models\Logbook;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LogbookController extends Controller
{
    public function index()
    {
        $customHelper = new CustomHelper();

        $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();
        $sptjm = Document::where('student_id', '=', $mhs->id)->where('type', '=', 'Surat Persetujuan Magang')->first();
        $tanggalNow = $customHelper->defaultDateTime('tanggalDb');

        $cekAbsensiDatang = Student::selectRaw('IF(students.id IN (SELECT attendances.student_id FROM attendances WHERE DATE(attendances.absent_entry) = "' . $tanggalNow . '"), true, false) AS is_absen')
            ->join('attendances', 'attendances.student_id', '=', 'students.id')
            ->where('students.id', '=', $mhs->id)
            ->first();

        // Cek apakah sudah ada logbook hari ini
        $hasLogbookToday = Logbook::where('student_id', '=', $mhs->id)
            ->whereDate('created_at', $tanggalNow)
            ->exists();

        if ($cekAbsensiDatang->is_absen ?? null) {
            return view('mahasiswa.logbook', [
                'title' => 'Logbook',
                'data' => Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail(),
                'logbook' => Logbook::where('student_id', '=', $mhs->id)->get(),
                'suratMagang' => $sptjm,
                'cekAbsensiDatang' => $cekAbsensiDatang->is_absen,
                'hasLogbookToday' => $hasLogbookToday, // Tambahkan ini
            ]);
        } else {
            return redirect()->intended('/absensi');
        }
    }

    public function printLogbook()
    {
        $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();

        $data = Logbook::where('student_id', '=', $mhs->id)->get();

        $pdf = Pdf::loadView('mahasiswa.print-logbook', [
            'title' => __('messages.print_logbook'),
            'data' => $data,
            'mhs' => $mhs
        ]);

        return $pdf->stream('logbook.pdf');
    }

    public function create()
    {
        return view('mahasiswa.add-logbook', [
            'title' => 'Logbook'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $mhs = Student::where('email', '=', auth()->user()->email)->firstOrFail();
            $helper = new CustomHelper();
            $tanggalNow = $helper->defaultDateTime('tanggalDb');
            $hasLogbookToday = Logbook::where('student_id', '=', $mhs->id)
                ->whereDate('created_at', $tanggalNow)
                ->exists();

            if ($hasLogbookToday) {
                return redirect()->back()->with('error', __('messages.logbook_already_exists_today'));
            }

            // Validasi manual satu per satu
            $errors = [];

            // 1. Validasi activity_name
            if (empty($request->activity_name)) {
                $errors['activity_name'] = __('messages.activity_name_required');
            }

            // 2. Validasi description
            if (empty($request->description)) {
                $errors['description'] = __('messages.activity_description_required');
            }

            // 3. Validasi file img
            if (!$request->hasFile('img')) {
                $errors['img'] = __('messages.activity_photo_required');
            } else {
                $file = $request->file('img');

                // Cek apakah file valid
                if (!$file->isValid()) {
                    $errors['img'] = __('messages.invalid_file_upload');
                } else {
                    // Cek ukuran file (maksimal 1MB = 1024KB)
                    if ($file->getSize() > 1048576) { // 1024 * 1024 bytes
                        $errors['img'] = __('messages.image_max_size_1mb');
                    } else {
                        // Cek MIME type
                        $mimeType = $file->getMimeType();
                        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];

                        if (!in_array($mimeType, $allowedMimes)) {
                            $errors['img'] = __('messages.image_format_png_jpg_jpeg');
                        } else {
                            // Cek ekstensi file
                            $extension = strtolower($file->getClientOriginalExtension());
                            $allowedExtensions = ['jpeg', 'jpg', 'png'];

                            if (!in_array($extension, $allowedExtensions)) {
                                $errors['img'] = __('messages.valid_image_format_required');
                            } else {
                                // Validasi signature file gambar untuk memastikan file benar-benar gambar
                                $fileContent = file_get_contents($file->getRealPath());
                                $isValidImage = false;

                                // Check PNG signature
                                if (substr($fileContent, 0, 8) === "\x89PNG\r\n\x1a\n") {
                                    $isValidImage = true;
                                }
                                // Check JPEG signature
                                elseif (substr($fileContent, 0, 3) === "\xFF\xD8\xFF") {
                                    $isValidImage = true;
                                }

                                if (!$isValidImage) {
                                    $errors['img'] = __('messages.invalid_image_file');
                                }
                            }
                        }
                    }
                }
            }

            // Jika ada error, redirect kembali dengan error
            if (!empty($errors)) {
                return redirect()->back()->withErrors($errors)->withInput();
            }

            // Jika semua validasi berhasil, lanjutkan proses simpan
            $validatedData = [
                'activity_name' => $request->activity_name,
                'description' => $request->description,
                'student_id' => $mhs->id,
                'activity_date' => $helper->defaultDateTime('tanggalDb'),
                'img' => $request->file('img')->store('logbook')
            ];

            Logbook::create($validatedData);

            return redirect()->intended('/logbook')->with('success', __('messages.logbook_add_success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.logbook_save_failed'));
        }
    }

    public function show(Logbook $logbook) {}

    public function edit(Logbook $logbook)
    {
        return view('mahasiswa.edit-logbook', [
            'title' => 'Logbook',
            'logbook' => $logbook
        ]);
    }

    public function update(Request $request, Logbook $logbook)
    {
        try {
            $mhs = Student::where('email', '=', auth()->user()->email)->firstOrFail();

            $validatedData = $request->validate([
                'activity_name' => 'required',
                'img' => [
                    'nullable',
                    'file',
                    'max:1024', // 1MB dalam KB
                    'mimes:jpeg,jpg,png', // Validasi MIME type
                    function ($attribute, $value, $fail) {
                        // Validasi tambahan hanya jika ada file yang diupload
                        if ($value && $value->isValid()) {
                            $mimeType = $value->getMimeType();
                            $extension = strtolower($value->getClientOriginalExtension());

                            // Cek MIME type dan ekstensi
                            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
                            $allowedExtensions = ['jpeg', 'jpg', 'png'];

                            if (!in_array($mimeType, $allowedMimes) || !in_array($extension, $allowedExtensions)) {
                                $fail(__('messages.valid_image_format_required'));
                            }

                            // Validasi signature file gambar
                            $fileContent = file_get_contents($value->getRealPath());
                            $isValidImage = false;

                            // Check PNG signature
                            if (substr($fileContent, 0, 8) === "\x89PNG\r\n\x1a\n") {
                                $isValidImage = true;
                            }
                            // Check JPEG signature
                            elseif (substr($fileContent, 0, 3) === "\xFF\xD8\xFF") {
                                $isValidImage = true;
                            }

                            if (!$isValidImage) {
                                $fail(__('messages.invalid_image_file'));
                            }
                        }
                    }
                ],
                'description' => 'required'
            ], [
                'activity_name.required' => __('messages.activity_name_required'),
                'img.file' => __('messages.file_upload_required'),
                'img.max' => __('messages.image_max_size_1mb'),
                'img.mimes' => __('messages.image_format_png_jpg_jpeg'),
                'description.required' => __('messages.activity_description_required')
            ]);

            $validatedData['student_id'] = $mhs->id;

            if ($request->file('img')) {
                // Double check file sebelum proses
                $file = $request->file('img');
                if (!$file->isValid()) {
                    throw new \Exception('File tidak valid');
                }

                $ext = strtolower($file->getClientOriginalExtension());
                $allowedExtensions = ['png', 'jpg', 'jpeg'];

                if (!in_array($ext, $allowedExtensions)) {
                    throw new \Exception('File harus berformat PNG, JPG, atau JPEG');
                }

                // Hapus gambar lama
                if ($request->oldimg) {
                    Storage::delete($request->oldimg);
                }
                $validatedData['img'] = $request->file('img')->store('logbook');
            }

            Logbook::where('id', $logbook->id)->update($validatedData);

            return redirect()->intended('/logbook')->with('success', __('messages.logbook_update_success'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {

            return redirect()->back()->with('error', __('messages.logbook_update_failed'));
        }
    }

    public function destroy(Logbook $logbook)
    {
        try {
            if ($logbook->img) {
                Storage::delete($logbook->img);
            }
            Logbook::destroy($logbook->id);

            return redirect()->intended('/logbook')->with('success', __('messages.logbook_delete_success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.logbook_delete_failed'));
        }
    }
}
