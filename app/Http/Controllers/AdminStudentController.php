<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.mahasiswa', [
            'title' => 'Mahasiswa',
            'data' => Student::with('company')->get()
        ]);
    }

    public function indexTambahMahasiswa()
    {
        return view('admin.add-mahasiswa', [
            'title' => 'Tambah Mahasiswa',
            'perusahaan' => Company::all()
        ]);
    }

    public function getDataPerusahaan(Request $request)
    {
        $selectValue = $request->input('company_id');
        $value = DB::table('companies')->where('id', $selectValue)->first();
        return response()->json($value);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'registration_number' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'class' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'company_id' => 'required',
            'division' => 'required',
            'internship_type' => 'required',
        ]);

        $validateCreateUser = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        $validateCreateUser['password'] = bcrypt($validatedData['registration_number']);
        $validateCreateUser['level'] = 'mahasiswa';
        $validateCreateUser['is_active'] = true;

        Student::create($validatedData);
        User::create($validateCreateUser);

        return redirect()->intended('/manage-mahasiswa')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $manage_mahasiswa)
    {
        return view('admin.edit-mahasiswa', [
            'mahasiswa' => $manage_mahasiswa,
            'title' => 'Edit Mahasiswa',
            'perusahaan' => Company::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $manage_mahasiswa)
    {
        $rules = [
            'registration_number' => 'required',
            'name' => 'required',
            'class' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'company_id' => 'required',
            'division' => 'required',
            'internship_type' => 'required',
        ];

        $validatedData = $request->validate($rules);

        if ($rules['name'] != $manage_mahasiswa->name) {
            $validateCreateUser = $request->validate([
                'name' => 'required',
            ]);
        }

        User::where('name', $manage_mahasiswa->name)->update($validateCreateUser);

        Student::where('id', $manage_mahasiswa->id)
            ->update($validatedData);

        return redirect()->intended('/manage-mahasiswa')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $manage_mahasiswa)
    {
        $email = $manage_mahasiswa->email;
        User::where('email', $email)->delete();
        Student::destroy($manage_mahasiswa->id);
        return redirect('/manage-mahasiswa')->with('success', 'Data Berhasil Dihapus !');
    }
}
