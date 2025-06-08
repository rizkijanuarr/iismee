<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;

class AdminLecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dosen', [
            'title' => 'Dosen',
            'data' => Lecturer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add-dosen', [
            'title' => 'Tambahkan Dosen'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lecturer_id_number' => 'required|unique:lecturers',
            'name' => 'required',
            'email' => 'required|email|unique:lecturers',
            'phone_number' => 'required'
        ]);

        $validateCreateUser = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $validateCreateUser['is_active'] = true;
        $validateCreateUser['password'] = bcrypt($validatedData['lecturer_id_number']);
        $validateCreateUser['level'] = 'dosen';

        Lecturer::create($validatedData);
        User::create($validateCreateUser);

        return redirect()->intended('/manage-dosen')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecturer $manage_dosen)
    {
        return view('admin.edit-dosen', [
            'title' => 'Edit Dosen',
            'dosen' => $manage_dosen
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecturer $manage_dosen)
    {
        $rules = [
            'name' => 'required',
            'phone_number' => 'required'
        ];

        if ($request->lecturer_id_number != $manage_dosen->lecturer_id_number || $request->email != $manage_dosen->email) {
            $rules['lecturer_id_number'] =  'required|unique:lecturers,lecturer_id_number,' . $manage_dosen->id;
            $rules['email'] =  'email|unique:lecturers,email,' . $manage_dosen->id;
        }

        $validatedData = $request->validate($rules);

        if ($rules['name'] != $manage_dosen->name) {
            $validateCreateUser = $request->validate([
                'name' => 'required',
            ]);
        }

        User::where('name', $manage_dosen->name)->update($validateCreateUser);

        Lecturer::where('id', $manage_dosen->id)
            ->update($validatedData);

        return redirect()->intended('/manage-dosen')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $manage_dosen)
    {
        $email = $manage_dosen->email;
        User::where('email', $email)->delete();
        Lecturer::destroy($manage_dosen->id);
        return redirect('/manage-dosen')->with('success', 'Data Berhasil Dihapus !');
    }
}
