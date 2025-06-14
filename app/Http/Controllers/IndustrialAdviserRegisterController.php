<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\IndustrialAdviser;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Http\Request;

class IndustrialAdviserRegisterController extends Controller
{
    public function index()
    {
        $registrasi = WebSetting::where('name', '=', 'Registrasi Pembimbing Industri')->firstOrFail();

        if ($registrasi->is_enable == true) {
            return view('pembimbing-industri.registrasi', [
                'title' => 'Registrasi',
                'perusahaan' => Company::all()
            ]);
        } else {
            return view('errors.403');
        }
    }

    public function create() {}

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
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $validateCreateUser['is_active'] = false;
        $validateCreateUser['password'] = bcrypt($validateCreateUser['password']);
        $validateCreateUser['level'] = 'pembimbing industri';

        IndustrialAdviser::create($validatedData);
        User::create($validateCreateUser);

        return redirect()->intended('/waiting');
    }

    public function show(IndustrialAdviser $industrialAdviser) {}

    public function edit(IndustrialAdviser $industrialAdviser) {}

    public function update(Request $request, IndustrialAdviser $industrialAdviser) {}

    public function destroy(IndustrialAdviser $industrialAdviser) {}
}
