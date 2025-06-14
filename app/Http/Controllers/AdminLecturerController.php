<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLecturerController extends Controller
{
    public function index()
    {
        return view('admin.dosen', [
            'title' => 'Dosen',
            'data' => Lecturer::orderByDesc('created_at')->get()
        ]);
    }

    public function create()
    {
        return view('admin.add-dosen', [
            'title' => 'Tambahkan Dosen'
        ]);
    }

    public function store(Request $request)
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
            "SELECT * FROM users WHERE email = ? LIMIT 1",
            [$request->email]
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

        $validateCreateUser = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $validateCreateUser['is_active'] = true;
        $validateCreateUser['password'] = bcrypt('1234');
        $validateCreateUser['level'] = 'dosen';

        Lecturer::create($validatedData);
        User::create($validateCreateUser);

        return redirect()->intended('/manage-dosen')->with('success', 'Data Dosen Berhasil Ditambahkan');
    }

    public function show(Lecturer $lecturer) {}

    public function edit(Lecturer $manage_dosen)
    {
        return view('admin.edit-dosen', [
            'title' => 'Edit Dosen',
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

        return redirect()->intended('/manage-dosen')->with('success', 'Data Dosen Berhasil Diubah');
    }

    public function destroy(Lecturer $manage_dosen)
    {
        $email = $manage_dosen->email;
        User::where('email', $email)->delete();
        Lecturer::destroy($manage_dosen->id);
        return redirect('/manage-dosen')->with('success', 'Data Dosen Berhasil Dihapus !');
    }
}
