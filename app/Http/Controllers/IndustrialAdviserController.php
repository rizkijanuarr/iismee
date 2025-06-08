<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIndustrialAdviserRequest;
use App\Http\Requests\UpdateIndustrialAdviserRequest;
use App\Models\Company;
use App\Models\IndustrialAdviser;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Http\Request;

class IndustrialAdviserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembimbing = User::where('level', '=', 'pembimbing industri')
            ->where('is_active', '=', false)->get();
        $pembimbing_industri = IndustrialAdviser::with('company')->selectRaw('industrial_advisers.*')->join('users', 'users.email', '=', 'industrial_advisers.email')->where('users.is_active', '=', true)->get();

        // dd($pembimbing_industri);

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add-pembimbing-industri', [
            'title' => 'Tambah Pembimbing Industri',
            'perusahaan' => Company::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:industrial_advisers',
            'phone_number' => 'required',
            'position' => 'required',
            'company_id' => 'required'
        ]);

        $validateCreateUser = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        $validateCreateUser['is_active'] = true;
        $validateCreateUser['password'] = bcrypt('1234');
        $validateCreateUser['level'] = 'pembimbing industri';

        IndustrialAdviser::create($validatedData);
        User::create($validateCreateUser);

        return redirect()->intended('/manage-pembimbing-industri')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(IndustrialAdviser $industrialAdviser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndustrialAdviser $manage_pembimbing_industri)
    {
        return view('admin.edit-pembimbing-industri', [
            'title' => 'Edit Pembimbing Industri',
            'perusahaan' => Company::all(),
            'pembimbingIndustri' => $manage_pembimbing_industri
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IndustrialAdviser $manage_pembimbing_industri)
    {
        $rules = [
            'name' => 'required',
            'position' => 'required',
            'phone_number' => 'required'
        ];

        if ($request->email != $manage_pembimbing_industri->email) {
            $rules['email'] = 'email|unique:industrial_advisers,email' . $manage_pembimbing_industri->id;
        }

        $validatedData = $request->validate($rules);

        if ($rules['name'] != $manage_pembimbing_industri->name) {
            $validateCreateUser = $request->validate([
                'name' => 'required'
            ]);
            User::where('email', $manage_pembimbing_industri->email)->update($validateCreateUser);
        }

        IndustrialAdviser::where('id', $manage_pembimbing_industri->id)
            ->update($validatedData);
        return redirect()->intended('/manage-pembimbing-industri')->with('success', 'Data Berhasil Diubah');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndustrialAdviser $manage_pembimbing_industri)
    {
        $email = $manage_pembimbing_industri->email;
        User::where('email', $email)->delete();
        IndustrialAdviser::destroy($manage_pembimbing_industri->id);
        return redirect('/manage-pembimbing-industri')->with('success', 'Data Berhasil Dihapus !');
    }
}
