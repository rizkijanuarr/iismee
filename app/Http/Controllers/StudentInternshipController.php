<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class StudentInternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function show(Internship $internship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Internship $internship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Internship $internship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Internship $internship)
    {
        //
    }
}
