<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use App\Models\IndustrialAdviser;
use Illuminate\Support\Facades\DB;

class IndustrialAdviserController extends Controller
{
    public function index()
    {
        $pembimbing = User::where('level', '=', 'pembimbing industri')
            ->where('is_active', '=', false)->get();
        $pembimbing_industri = IndustrialAdviser::with('company')->selectRaw('industrial_advisers.*')->join('users', 'users.email', '=', 'industrial_advisers.email')->where('users.is_active', '=', true)->get()->sortByDesc('created_at');


        $registrasi = WebSetting::where('name', '=', 'Registrasi Pembimbing Industri')->firstOrFail();
        return view('admin.pembimbing-industri', [
            'title' => 'Pembimbing Industri',
            'data' => $pembimbing_industri,
            'registrasi' => $registrasi,
            'jml' => count($pembimbing)
        ]);
    }

    public function konfirmasiIndex()
    {
        return view('admin.konfirmasi-pembimbing-industri', [
            'title' => 'Pembimbing Industri',
            'data' => IndustrialAdviser::with('company')->join('users', 'users.email', '=', 'industrial_advisers.email')->where('users.is_active', '=', false)->get(),
        ]);
    }

    public function create()
    {
        return view('admin.add-pembimbing-industri', [
            'title' => 'Tambah Pembimbing Industri',
            'perusahaan' => Company::orderByDesc('created_at')->get()
        ]);
    }

    public function store(Request $request)
    {
        if (empty($request->name)) {
            return redirect()->back()->with('error', 'Nama Lengkap wajib diisi!');
        }

        if (empty($request->email)) {
            return redirect()->back()->with('error', 'Email wajib diisi!');
        }

        if (empty($request->phone_number)) {
            return redirect()->back()->with('error', 'Nomor Telepon wajib diisi!');
        }

        if (empty($request->position)) {
            return redirect()->back()->with('error', 'Jabatan wajib diisi!');
        }

        if (empty($request->company_id)) {
            return redirect()->back()->with('error', 'Perusahaan wajib dipilih!');
        }

        $existingEmailIndustrialAdviser = DB::select(
            "SELECT * FROM industrial_advisers WHERE email = ? LIMIT 1",
            [$request->email]
        );
        if (!empty($existingEmailIndustrialAdviser)) {
            return redirect()->back()->with('error', 'Email tersebut sudah terdaftar!');
        }

        $existingEmailUser = DB::select(
            "SELECT * FROM users WHERE email = ? LIMIT 1",
            [$request->email]
        );
        if (!empty($existingEmailUser)) {
            return redirect()->back()->with('error', 'Email tersebut sudah terdaftar!');
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'position' => 'required',
            'company_id' => 'required'
        ]);

        $validateCreateUser = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $validateCreateUser['is_active'] = true;
        $validateCreateUser['password'] = bcrypt('1234');
        $validateCreateUser['level'] = 'pembimbing industri';

        IndustrialAdviser::create($validatedData);
        User::create($validateCreateUser);

        return redirect()->intended('/manage-pembimbing-industri')->with('success', 'Data Pembimbing Industri Berhasil Ditambahkan');
    }

    public function show(IndustrialAdviser $industrialAdviser) {}

    public function edit(IndustrialAdviser $manage_pembimbing_industri)
    {
        return view('admin.edit-pembimbing-industri', [
            'title' => 'Edit Pembimbing Industri',
            'perusahaan' => Company::all(),
            'pembimbingIndustri' => $manage_pembimbing_industri
        ]);
    }

    public function update(Request $request, IndustrialAdviser $manage_pembimbing_industri)
    {
        if (empty($request->name)) {
            return redirect()->back()->with('error', 'Nama Lengkap wajib diisi!');
        }

        if (empty($request->email)) {
            return redirect()->back()->with('error', 'Email wajib diisi!');
        }

        if (empty($request->phone_number)) {
            return redirect()->back()->with('error', 'Nomor Telepon wajib diisi!');
        }

        if (empty($request->position)) {
            return redirect()->back()->with('error', 'Jabatan wajib diisi!');
        }

        if (empty($request->company_id)) {
            return redirect()->back()->with('error', 'Perusahaan wajib dipilih!');
        }

        $existingEmailIndustrialAdviser = DB::select(
            "SELECT * FROM industrial_advisers WHERE email = ? AND id != ? LIMIT 1",
            [$request->email, $manage_pembimbing_industri->id]
        );
        if (!empty($existingEmailIndustrialAdviser)) {
            return redirect()->back()->with('error', 'Email tersebut sudah terdaftar!');
        }

        $existingEmailUser = DB::select(
            "SELECT * FROM users WHERE email = ? AND email != ? LIMIT 1",
            [$request->email, $manage_pembimbing_industri->email]
        );
        if (!empty($existingEmailUser)) {
            return redirect()->back()->with('error', 'Email tersebut sudah terdaftar!');
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'position' => 'required',
            'company_id' => 'required'
        ]);

        $validateCreateUser = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        User::where('email', $manage_pembimbing_industri->email)->update($validateCreateUser);
        IndustrialAdviser::where('id', $manage_pembimbing_industri->id)->update($validatedData);

        return redirect()->intended('/manage-pembimbing-industri')->with('success', 'Data Pembimbing Industri Berhasil Diubah');
    }

    public function konfirmasi(Request $request)
    {
        $email = $request->input('email');
        User::where('email', '=', $email)
            ->update([
                'is_active' => true
            ]);

        return redirect()->intended('/manage-pembimbing-industri')->with('success', 'Data Berhasil Dikonfirmasi');
    }

    public function destroy(IndustrialAdviser $manage_pembimbing_industri)
    {
        $email = $manage_pembimbing_industri->email;
        User::where('email', $email)->delete();
        IndustrialAdviser::destroy($manage_pembimbing_industri->id);
        return redirect('/manage-pembimbing-industri')->with('success', 'Data  Pembimbing Industri Berhasil Dihapus !');
    }
}
