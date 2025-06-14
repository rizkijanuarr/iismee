<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();

        $customHelper = new CustomHelper();
        $now = $customHelper->defaultDateTime('hari') . ', ' . $customHelper->defaultDateTime('tanggal');
        $tanggalNow = $customHelper->defaultDateTime('tanggalDb');
        $cekAbsensiDatang = Student::selectRaw('IF(students.id IN (SELECT attendances.student_id FROM attendances WHERE DATE(attendances.absent_entry) = "' . $tanggalNow . '"), true, false) AS is_absen')
            ->join('attendances', 'attendances.student_id', '=', 'students.id')
            ->where('students.id', '=', $mhs->id)
            ->first();

        $cekAbsensi = Student::selectRaw('IF(students.id IN (SELECT attendances.student_id FROM attendances WHERE DATE(attendances.absent_entry) = "' . $tanggalNow . '" AND DATE(attendances.absent_out) = "' . $tanggalNow . '"), true, false) AS is_absen')
            ->where('id', '=', $mhs->id)
            ->first();

        if ($cekAbsensi->is_absen == true) {
            return view('errors.403');
        } else {
            return view('mahasiswa.absensi', [
                'title' => 'Absensi',
                'data' => Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail(),
                'now' => $now,
                'is_absen_datang' => $cekAbsensiDatang->is_absen ?? false,
                'is_absen' => $cekAbsensi->is_absen ?? false
            ]);
        }
    }

    public function create() {}

    public function store(Request $request)
    {
        try {
            $customHelper = new CustomHelper();

            // Validasi manual satu per satu

            // 1. Cek apakah file diupload
            if (!$request->hasFile('entry_proof')) {
                return redirect()->back()->with('error', 'Bukti kehadiran datang harus diupload!')->withInput();
            }

            $file = $request->file('entry_proof');

            // 2. Cek apakah file valid
            if (!$file->isValid()) {
                return redirect()->back()->with('error', 'File yang diupload tidak valid!')->withInput();
            }

            // 3. Cek ukuran file (maksimal 1MB = 1024KB = 1048576 bytes)
            if ($file->getSize() > 1048576) {
                return redirect()->back()->with('error', 'Ukuran bukti kehadiran maksimal 1MB!')->withInput();
            }

            // 4. Cek ekstensi file
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExtensions = ['png', 'jpg', 'jpeg'];
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()->with('error', 'Bukti kehadiran harus berformat PNG, JPG, atau JPEG!')->withInput();
            }

            // 5. Cek MIME type
            $mimeType = $file->getMimeType();
            $allowedMimes = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!in_array($mimeType, $allowedMimes)) {
                return redirect()->back()->with('error', 'File yang diupload harus berupa gambar yang valid!')->withInput();
            }

            // 6. Cek signature file gambar
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
                return redirect()->back()->with('error', 'File yang diupload bukan gambar yang valid!')->withInput();
            }

            // 7. Cek apakah student_id ada
            if (!$request->student_id) {
                return redirect()->back()->with('error', 'Student ID tidak valid!')->withInput();
            }

            // Semua validasi lolos, proses upload
            $validatedData = [];
            $validatedData['student_id'] = $request->student_id;
            $validatedData['absent_entry'] = $customHelper->defaultDateTime('default');
            $validatedData['entry_proof'] = $file->store('bukti-kehadiran');

            Attendance::create($validatedData);

            return redirect()->intended('/logbook')->with('success', 'Absensi datang berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan absensi. Silakan coba lagi!')->withInput();
        }
    }

    public function show(Attendance $attendance) {}

    public function edit(Attendance $attendance) {}

    public function update(Request $request, Attendance $attendance)
    {
        try {
            $customHelper = new CustomHelper();
            $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();

            $tanggalNow = $customHelper->defaultDateTime('tanggalDb');

            // Perbaikan 1: Cek apakah sudah ada absensi datang hari ini
            $attendanceToday = Attendance::where('student_id', $mhs->id)
                ->whereDate('absent_entry', $tanggalNow)
                ->first();

            // Perbaikan 2: Validasi apakah sudah absen datang
            if (!$attendanceToday) {
                return redirect()->back()->with('error', 'Anda belum melakukan absensi datang hari ini!')->withInput();
            }

            // Perbaikan 3: Cek apakah sudah absen pulang
            if ($attendanceToday->absent_out) {
                return redirect()->back()->with('error', 'Anda sudah melakukan absensi pulang hari ini!')->withInput();
            }

            // Validasi manual satu per satu

            // 1. Cek apakah file diupload
            if (!$request->hasFile('out_proof')) {
                return redirect()->back()->with('error', 'Bukti kehadiran pulang harus diupload!')->withInput();
            }

            $file = $request->file('out_proof');

            // 2. Cek apakah file valid
            if (!$file->isValid()) {
                return redirect()->back()->with('error', 'File yang diupload tidak valid!')->withInput();
            }

            // 3. Cek ukuran file (maksimal 1MB = 1024KB = 1048576 bytes)
            if ($file->getSize() > 1048576) {
                return redirect()->back()->with('error', 'Ukuran bukti kehadiran maksimal 1MB!')->withInput();
            }

            // 4. Cek ekstensi file
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExtensions = ['png', 'jpg', 'jpeg'];
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()->with('error', 'Bukti kehadiran harus berformat PNG, JPG, atau JPEG!')->withInput();
            }

            // 5. Cek MIME type
            $mimeType = $file->getMimeType();
            $allowedMimes = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!in_array($mimeType, $allowedMimes)) {
                return redirect()->back()->with('error', 'File yang diupload harus berupa gambar yang valid!')->withInput();
            }

            // 6. Cek signature file gambar
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
                return redirect()->back()->with('error', 'File yang diupload bukan gambar yang valid!')->withInput();
            }

            // Semua validasi lolos, proses upload
            $validatedData = [];
            $validatedData['absent_out'] = $customHelper->defaultDateTime('default');
            $validatedData['out_proof'] = $file->store('bukti-kehadiran');

            // Perbaikan 4: Update menggunakan object yang sudah ditemukan
            $attendanceToday->update([
                'absent_out' => $validatedData['absent_out'],
                'out_proof' => $validatedData['out_proof']
            ]);

            return redirect()->intended('/logbook')->with('success', 'Absensi pulang berhasil disimpan!');
        } catch (\Exception $e) {
            // Perbaikan 5: Log error untuk debugging
            return redirect()->back()->with('error', 'Gagal menyimpan absensi. Silakan coba lagi! Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Attendance $attendance) {}
}
