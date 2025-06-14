<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentInternshipController extends Controller
{
    public function index()
    {
        $mhs = Student::where('email', '=', auth()->user()->email)->firstOrFail();

        $subjects = Subject::with(['assessment' => function ($query) use ($mhs) {
            $query->where('student_id', $mhs->id);
        }, 'assesmentAspect', 'lecturer'])
            ->whereIn('subjects.id', function ($query) {
                $query->select('subject_id')->from('assessments');
            })
            ->selectRaw('subjects.subject_name AS subject_name, subjects.sks, lecturers.*, ROUND((SUM(assessments.score) / (subjects.max_score * COUNT(assesment_aspects.id))) * 100, 2) AS nilai')
            ->leftJoin('assessments', 'subjects.id', '=', 'assessments.subject_id')
            ->leftJoin('lecturers', 'lecturers.id', '=', 'subjects.lecturer_id')
            ->leftJoin('assesment_aspects', 'assessments.assesment_aspect_id', '=', 'assesment_aspects.id')
            ->groupBy('subjects.id')
            ->where('assessments.student_id', '=', $mhs->id)
            ->get();


        return view('mahasiswa.magang', [
            'title' => 'Magang',
            'data' => Student::where('email', '=', auth()->user()->email)->firstOrFail(),
            'mpk' => $subjects
        ]);
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(Internship $internship) {}

    public function edit(Internship $internship) {}

    public function update(Request $request, Internship $internship) {}

    public function destroy(Internship $internship) {}
}
