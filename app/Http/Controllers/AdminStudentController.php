<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminStudentController extends Controller
{
    public function index()
    {
        return view('admin.mahasiswa', [
            'title' => 'Mahasiswa',
            'data' => Student::with('company')->orderByDesc('created_at')->get()
        ]);
    }

    public function indexTambahMahasiswa()
    {
        return view('admin.add-mahasiswa', [
            'title' => 'Tambah Mahasiswa',
            'perusahaan' => Company::orderByDesc('created_at')->get()
        ]);
    }

    public function getDataPerusahaan(Request $request)
    {
        $selectValue = $request->input('company_id');
        $value = DB::table('companies')->where('id', $selectValue)->first();
        return response()->json($value);
    }

    public function create() {}

    public function store(Request $request)
    {
        if (empty($request->registration_number)) {
            return redirect()->back()->with('error', 'NIM wajib diisi!');
        }

        if (empty($request->name)) {
            return redirect()->back()->with('error', 'Nama Lengkap wajib diisi!');
        }

        if (empty($request->email)) {
            return redirect()->back()->with('error', 'Email wajib diisi!');
        }

        if (empty($request->class)) {
            return redirect()->back()->with('error', 'Kelas wajib diisi!');
        }

        if (empty($request->date_start)) {
            return redirect()->back()->with('error', 'Tanggal Mulai wajib diisi!');
        }

        if (empty($request->date_end)) {
            return redirect()->back()->with('error', 'Tanggal Selesai wajib diisi!');
        }

        if (empty($request->company_id)) {
            return redirect()->back()->with('error', 'Perusahaan wajib dipilih!');
        }

        if (empty($request->division)) {
            return redirect()->back()->with('error', 'Divisi wajib diisi!');
        }

        if (empty($request->internship_type)) {
            return redirect()->back()->with('error', 'Kategori Magang wajib diisi!');
        }

        $existingEmailUser = DB::select(
            "SELECT * FROM users WHERE email = ? LIMIT 1",
            [$request->email]
        );
        if (!empty($existingEmailUser)) {
            return redirect()->back()->with('error', 'Email tersebut sudah terdaftar!');
        }

        $validatedData = $request->validate([
            'registration_number' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'class' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'company_id' => 'required',
            'division' => 'required',
            'internship_type' => 'required',
        ]);

        $validateCreateUser = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $validateCreateUser['password'] = bcrypt('1234');
        $validateCreateUser['level'] = 'mahasiswa';
        $validateCreateUser['is_active'] = true;

        Student::create($validatedData);
        User::create($validateCreateUser);

        return redirect()->intended('/manage-mahasiswa')->with('success', 'Data Mahasiswa berhasil ditambahkan!');
    }

    public function show(Student $student) {}

    public function edit(Student $manage_mahasiswa)
    {
        return view('admin.edit-mahasiswa', [
            'mahasiswa' => $manage_mahasiswa,
            'title' => 'Edit Mahasiswa',
            'perusahaan' => Company::orderByDesc('created_at')->get()
        ]);
    }

    public function update(Request $request, Student $manage_mahasiswa)
    {
        if (empty($request->registration_number)) {
            return redirect()->back()->with('error', 'NIM wajib diisi!');
        }

        if (empty($request->name)) {
            return redirect()->back()->with('error', 'Nama Lengkap wajib diisi!');
        }

        if (empty($request->email)) {
            return redirect()->back()->with('error', 'Email wajib diisi!');
        }

        if (empty($request->class)) {
            return redirect()->back()->with('error', 'Kelas wajib diisi!');
        }

        if (empty($request->date_start)) {
            return redirect()->back()->with('error', 'Tanggal Mulai wajib diisi!');
        }

        if (empty($request->date_end)) {
            return redirect()->back()->with('error', 'Tanggal Selesai wajib diisi!');
        }

        if (empty($request->company_id)) {
            return redirect()->back()->with('error', 'Perusahaan wajib dipilih!');
        }

        if (empty($request->division)) {
            return redirect()->back()->with('error', 'Divisi wajib diisi!');
        }

        if (empty($request->internship_type)) {
            return redirect()->back()->with('error', 'Kategori Magang wajib diisi!');
        }

        $existingEmailUser = DB::select(
            "SELECT * FROM users WHERE email = ? AND email != ? LIMIT 1",
            [$request->email, $manage_mahasiswa->email]
        );
        if (!empty($existingEmailUser)) {
            return redirect()->back()->with('error', 'Email tersebut sudah terdaftar!');
        }

        $validatedData = $request->validate([
            'registration_number' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'class' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'company_id' => 'required',
            'division' => 'required',
            'internship_type' => 'required',
        ]);

        $validateCreateUser = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        User::where('email', $manage_mahasiswa->email)->update($validateCreateUser);
        Student::where('id', $manage_mahasiswa->id)->update($validatedData);

        return redirect()->intended('/manage-mahasiswa')->with('success', 'Data Mahasiswa Berhasil Diubah');
    }

    public function destroy(Student $manage_mahasiswa)
    {
        $email = $manage_mahasiswa->email;
        User::where('email', $email)->delete();
        Student::destroy($manage_mahasiswa->id);
        return redirect('/manage-mahasiswa')->with('success', 'Data Mahasiswa Berhasil Dihapus !');
    }
}
