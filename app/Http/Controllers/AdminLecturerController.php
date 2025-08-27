<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Imports\LecturersImport;

class AdminLecturerController extends Controller
{
    public function index()
    {
        return view('admin.dosen', [
            'title' => trans('messages.sidebar_lecturers'),
            'data' => Lecturer::orderByDesc('created_at')->get()
        ]);
    }

    public function create()
    {
        return view('admin.add-dosen', [
            'title' => trans('messages.lecturer_add', ['title' => trans('messages.sidebar_lecturers')])
        ]);
    }

    public function store(Request $request)
    {
        if (empty($request->lecturer_id_number)) {
            return redirect()->back()->with('error', trans('messages.lecturer_required_nip'));
        }

        if (empty($request->name)) {
            return redirect()->back()->with('error', trans('messages.lecturer_required_full_name'));
        }

        if (empty($request->email)) {
            return redirect()->back()->with('error', trans('messages.lecturer_required_email'));
        }

        if (empty($request->phone_number)) {
            return redirect()->back()->with('error', trans('messages.lecturer_required_phone'));
        }

        $existingEmailUser = DB::select(
            "SELECT * FROM users WHERE email = ? LIMIT 1",
            [$request->email]
        );
        if (!empty($existingEmailUser)) {
            return redirect()->back()->with('error', trans('messages.lecturer_email_already_registered'));
        }

        $validatedData = $request->validate([
            'lecturer_id_number' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required'
        ]);

        $validateCreateUser = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $validateCreateUser['is_active'] = true;
        $validateCreateUser['password'] = bcrypt('1234');
        $validateCreateUser['level'] = 'dosen';

        Lecturer::create($validatedData);
        User::create($validateCreateUser);

        return redirect()->intended('/manage-dosen')->with('success', trans('messages.lecturer_create_success'));
    }

    public function show(Lecturer $lecturer) {}

    public function edit(Lecturer $manage_dosen)
    {
        return view('admin.edit-dosen', [
            'title' => trans('messages.lecturer_edit') . ' ' . trans('messages.sidebar_lecturers'),
            'dosen' => $manage_dosen
        ]);
    }

    public function update(Request $request, Lecturer $manage_dosen)
    {
        if (empty($request->lecturer_id_number)) {
            return redirect()->back()->with('error', 'NIP Dosen wajib diisi!');
        }

        if (empty($request->name)) {
            return redirect()->back()->with('error', 'Nama Lengkap wajib diisi!');
        }

        if (empty($request->email)) {
            return redirect()->back()->with('error', 'Email wajib diisi!');
        }

        if (empty($request->phone_number)) {
            return redirect()->back()->with('error', 'Nomor Telepon wajib diisi!');
        }

        $existingEmailUser = DB::select(
            "SELECT * FROM users WHERE email = ? AND email != ? LIMIT 1",
            [$request->email, $manage_dosen->email]
        );
        if (!empty($existingEmailUser)) {
            return redirect()->back()->with('error', 'Email tersebut sudah terdaftar!');
        }

        $validatedData = $request->validate([
            'lecturer_id_number' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required'
        ]);

        $validateCreateUser = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        User::where('email', $manage_dosen->email)->update($validateCreateUser);
        Lecturer::where('id', $manage_dosen->id)->update($validatedData);

        return redirect()->intended('/manage-dosen')->with('success', trans('messages.lecturer_update_success'));
    }

    public function destroy(Lecturer $manage_dosen)
    {
        $email = $manage_dosen->email;
        User::where('email', $email)->delete();
        Lecturer::destroy($manage_dosen->id);
        return redirect('/manage-dosen')->with('success', trans('messages.lecturer_delete_success'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new LecturersImport, $request->file('file'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', trans('messages.lecturer_import_failed') . ' ' . $e->getMessage());
        }

        return redirect()->back()->with('success', trans('messages.lecturer_import_success'));
    }

    public function downloadTemplate()
    {
        $filename = 'template-dosen.csv';
        Log::info('Lecturer downloadTemplate: start');
        try {
            $fp = fopen('php://temp', 'r+');
            if (!$fp) {
                Log::error('Lecturer downloadTemplate: failed to open php://temp');
                return redirect()->back()->with('error', trans('messages.error_open_stream'));
            }
            fputcsv($fp, ['lecturer_id_number', 'name', 'email', 'phone_number']);
            fputcsv($fp, ['1987654321', 'Dr. Andi', 'andi@gmail.com', '081211112222']);
            fputcsv($fp, ['1998765432', 'Dr. Rina', 'rina@gmail.com', '081322223333']);
            rewind($fp);
            $csv = stream_get_contents($fp);
            fclose($fp);
            Log::info('Lecturer downloadTemplate: csv built', ['length' => strlen((string)$csv)]);

            if (request()->boolean('debug')) {
                Log::info('Lecturer downloadTemplate: debug mode outputting raw CSV');
                return response($csv, 200, [
                    'Content-Type' => 'text/plain; charset=UTF-8',
                ]);
            }

            $path = 'tmp/' . $filename;
            Storage::disk('local')->put($path, $csv);
            $fullPath = storage_path('app/' . $path);
            Log::info('Lecturer downloadTemplate: file saved', ['path' => $fullPath, 'exists' => file_exists($fullPath)]);

            $response = response()->download($fullPath, $filename, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ])->deleteFileAfterSend(true);
            Log::info('Lecturer downloadTemplate: response prepared');
            return $response;
        } catch (\Throwable $e) {
            Log::error('Lecturer downloadTemplate: exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', trans('messages.download_template_failed_lecturer') . ' ' . $e->getMessage());
        }
    }
}
