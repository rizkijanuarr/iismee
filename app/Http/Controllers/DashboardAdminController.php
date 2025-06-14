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

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
