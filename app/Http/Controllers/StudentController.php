<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;

class StudentController extends Controller
{
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

    public function create() {}

    public function store(StoreStudentRequest $request) {}

    public function show(Student $student) {}

    public function edit(Student $student) {}

    public function update(UpdateStudentRequest $request, Student $student) {}

    public function destroy(Student $student) {}
}
