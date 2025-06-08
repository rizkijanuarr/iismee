<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class SupervisorDashboardController extends Controller
{
    public function index()
    {
        $dosen = Lecturer::where('email', '=', auth()->user()->email)->firstOrFail();

        $is_assessment = Internship::selectRaw('IF(internships.student_id IN (SELECT assessments.student_id FROM assessments), true, false) AS is_assessment, internships.*, documents.document_path, companies.*')
            ->leftJoin('students', 'internships.student_id', '=', 'students.id')
            ->join('companies', 'students.company_id', '=', 'companies.id')
            ->leftJoin('documents', function ($join) {
                $join->on('students.id', '=', 'documents.student_id')
                    ->where('documents.type', '=', 'Surat Persetujuan Magang');
            })
            ->where('lecturer_id', $dosen->id)
            ->orderBy('is_assessment', 'asc')
            ->get();

        return view('pembimbing.dashboard', [
            'title' => "Dashboard",
            'mahasiswa' => $is_assessment->count()
        ]);
    }
}
