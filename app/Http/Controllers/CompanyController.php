<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    public function index()
    {
        return view('admin.perusahaan', [
            'title' => 'Perusahaan',
            'data' => Company::orderByDesc('created_at')->get()
        ]);
    }

    public function create()
    {
        return view('admin.add-perusahaan', [
            'title' => 'Tambahkan Perusahaan'
        ]);
    }

    public function store(Request $request)
    {
        if (empty($request->company_name)) {
            return redirect()->back()->with('error', 'Nama Perusahaan wajib diisi!');
        }

        if (empty($request->company_address)) {
            return redirect()->back()->with('error', 'Alamat Perusahaan wajib diisi!');
        }

        if (empty($request->company_number)) {
            return redirect()->back()->with('error', 'Nomor Telepon Perusahaan wajib diisi!');
        }
        $validatedData = $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'company_number' => 'required'
        ]);

        Company::create($validatedData);
        return redirect()->intended('/manage-perusahaan')->with('success', 'Data Perusahaan berhasil ditambahkan!');
    }

    public function show(Company $company) {}

    public function edit(Company $manage_perusahaan)
    {
        return view('admin.edit-perusahaan', [
            'title' => 'Edit Perusahaan',
            'perusahaan' => $manage_perusahaan
        ]);
    }

    public function update(Request $request, Company $manage_perusahaan)
    {
        if (empty($request->company_name)) {
            return redirect()->back()->with('error', 'Nama Perusahaan wajib diisi!');
        }

        if (empty($request->company_address)) {
            return redirect()->back()->with('error', 'Alamat Perusahaan wajib diisi!');
        }

        if (empty($request->company_number)) {
            return redirect()->back()->with('error', 'Nomor Telepon Perusahaan wajib diisi!');
        }

        $existingCompany = DB::select(
            "SELECT * FROM companies WHERE company_name = ? AND id != ? LIMIT 1",
            [$request->company_name, $manage_perusahaan->id]
        );
        if (!empty($existingCompany)) {
            return redirect()->back()->with('error', 'Nama perusahaan dengan nama tersebut sudah ada!');
        }

        $validatedData = $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'company_number' => 'required'
        ]);

        Company::where('id', $manage_perusahaan->id)->update($validatedData);
        return redirect()->intended('/manage-perusahaan')->with('success', 'Data Perusahaan Berhasil Diubah');
    }

    public function destroy(Company $manage_perusahaan)
    {
        Company::destroy($manage_perusahaan->id);
        return redirect()->intended('/manage-perusahaan')->with('success', 'Data Perusahaan Berhasil Dihapus !');
    }
}
