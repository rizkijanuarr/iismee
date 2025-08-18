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
        // Basic validation first (without company_id conditional part)
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:industrial_advisers',
            'phone_number' => 'required',
            'position' => 'required',
        ]);

        // If manual company name is provided, create/find it and set company_id
        if ($request->filled('company_name_other')) {
            $validatedCompany = $request->validate([
                'company_name_other' => 'required|string|max:255',
                'company_address' => 'required|string|max:255',
                'company_number' => 'nullable|string|max:50',
            ]);

            // Create or get company by name, setting address/number on create
            $company = Company::firstOrCreate(
                ['company_name' => $validatedCompany['company_name_other']],
                [
                    'company_address' => $validatedCompany['company_address'],
                    'company_number' => $validatedCompany['company_number'] ?? null,
                ]
            );

            $validatedData['company_id'] = $company->id;
        } else {
            // Otherwise, company_id must be present and valid
            $request->validate([
                'company_id' => 'required|exists:companies,id',
            ]);
            $validatedData['company_id'] = $request->input('company_id');
        }

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
