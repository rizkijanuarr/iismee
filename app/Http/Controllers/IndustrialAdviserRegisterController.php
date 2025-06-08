<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\IndustrialAdviser;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Http\Request;

class IndustrialAdviserRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function edit(IndustrialAdviser $industrialAdviser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IndustrialAdviser $industrialAdviser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndustrialAdviser $industrialAdviser)
    {
        //
    }
}
