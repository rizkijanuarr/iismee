<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\IndustrialAdviser;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::all();
        $dosen = Lecturer::all();
        $pembimbingIndustri = IndustrialAdviser::all();
        $perusahaan = Company::all();
        $pembimbing = User::where('level', '=', 'pembimbing industri')
            ->where('is_active', '=', false)->get();

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'mahasiswa' => $student->count(),
            'dosen' => $dosen->count(),
            'pembimbingIndustri' => $pembimbingIndustri->count(),
            'perusahaan' => $perusahaan->count(),
            'jml' => $pembimbing->count()
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
