<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.perusahaan', [
            'title' => 'Perusahaan',
            'data' => Company::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add-perusahaan', [
            'title' => 'Tambahkan Perusahaan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'company_number' => 'required'
        ]);

        Company::create($validatedData);
        return redirect()->intended('/manage-perusahaan')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $manage_perusahaan)
    {
        return view('admin.edit-perusahaan', [
            'title' => 'Edit Perusahaan',
            'perusahaan' => $manage_perusahaan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $manage_perusahaan)
    {
        $validatedData = $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'company_number' => 'required'
        ]);

        Company::where('id', $manage_perusahaan->id)->update($validatedData);
        return redirect()->intended('/manage-perusahaan')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $manage_perusahaan)
    {
        Company::destroy($manage_perusahaan->id);
        return redirect()->intended('/manage-perusahaan')->with('success', 'Data Berhasil Dihapus !');
    }
}
