<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customHelper = new CustomHelper();

        $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();
        $tanggalNow = $customHelper->defaultDateTime('tanggalDb');

        $cekAbsensiDatang = Student::selectRaw('IF(students.id IN (SELECT attendances.student_id FROM attendances WHERE DATE(attendances.absent_entry) = "' . $tanggalNow . '"), true, false) AS is_absen')
            ->join('attendances', 'attendances.student_id', '=', 'students.id')
            ->where('students.id', '=', $mhs->id)
            ->first();

        return view('mahasiswa.dashboard', [
            'title' => 'Dashboard',
            'cekAbsensiDatang' => $cekAbsensiDatang->is_absen ?? false,
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
    public function store(StoreStudentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        dd($student->name);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
