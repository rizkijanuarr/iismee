<?php

namespace App\Http\Controllers;

use App\Models\IndustrialAdviser;
use App\Models\Student;
use Illuminate\Http\Request;

class IndustrialDashboardController extends Controller
{
    public function index()
    {
        $pembimbing = IndustrialAdviser::where('email', '=', auth()->user()->email)->firstOrFail();

        $is_assessment = Student::selectRaw('IF(students.id IN (SELECT industrial_assessments.student_id FROM industrial_assessments), true, false) AS is_assessment, students.*, documents.document_path')
            ->leftJoin('industrial_assessments', 'students.id', '=', 'industrial_assessments.student_id')
            ->leftJoin('documents', function ($join) {
                $join->on('students.id', '=', 'documents.student_id')
                    ->where('documents.type', '=', 'Surat Persetujuan Magang');
            })
            ->where('company_id', $pembimbing->company_id)
            ->groupBy('students.id')
            ->orderBy('is_assessment', 'asc')
            ->get();

        return view('pembimbing-industri.dashboard', [
            'title' => 'Dashboard',
            'mahasiswa' => $is_assessment->count()
        ]);
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(IndustrialAdviser $industrialAdviser) {}

    public function edit(IndustrialAdviser $industrialAdviser) {}

    public function update(Request $request, IndustrialAdviser $industrialAdviser) {}

    public function destroy(IndustrialAdviser $industrialAdviser) {}
}
