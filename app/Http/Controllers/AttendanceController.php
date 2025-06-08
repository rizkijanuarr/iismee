<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();

        $customHelper = new CustomHelper();
        $now = $customHelper->defaultDateTime('hari') . ', ' . $customHelper->defaultDateTime('tanggal');
        $tanggalNow = $customHelper->defaultDateTime('tanggalDb');
        $cekAbsensiDatang = Student::selectRaw('IF(students.id IN (SELECT attendances.student_id FROM attendances WHERE DATE(attendances.absent_entry) = "' . $tanggalNow . '"), true, false) AS is_absen')
            ->join('attendances', 'attendances.student_id', '=', 'students.id')
            ->where('students.id', '=', $mhs->id)
            ->first();


        $cekAbsensi = Student::selectRaw('IF(students.id IN (SELECT attendances.student_id FROM attendances WHERE DATE(attendances.absent_entry) = "' . $tanggalNow . '" AND DATE(attendances.absent_out) = "' . $tanggalNow . '"), true, false) AS is_absen')
            ->where('id', '=', $mhs->id)->first();

        if ($cekAbsensi->is_absen == true) {
            return view('errors.403');
        } else {
            return view('mahasiswa.absensi', [
                'title' => 'Absensi',
                'data' => Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail(),
                'now' => $now,
                'is_absen_datang' => $cekAbsensiDatang->is_absen ?? false,
                'is_absen' => $cekAbsensi->is_absen ?? false
            ]);
        }
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
        $customHelper = new CustomHelper();
        $validatedData = $request->validate([
            'entry_proof' => 'required|image'
        ]);

        $validatedData['student_id'] = $request->student_id;
        $validatedData['absent_entry'] = $customHelper->defaultDateTime('default');
        $validatedData['entry_proof'] = $request->file('entry_proof')->store('bukti-kehadiran');

        Attendance::create($validatedData);

        return redirect()->intended('/logbook');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $customHelper = new CustomHelper();
        $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();

        $tanggalNow = $customHelper->defaultDateTime('tanggalDb');

        $cekAbsensiDatang = Student::selectRaw('IF(students.id IN (SELECT attendances.student_id FROM attendances WHERE DATE(attendances.absent_entry) = "' . $tanggalNow . '"), true, false) AS is_absen, attendances.id AS attendance_id')
            ->join('attendances', 'attendances.student_id', '=', 'students.id')
            ->where('students.id', '=', $mhs->id)
            ->first();

        $validatedData = $request->validate([
            'out_proof' => 'image'
        ]);

        $validatedData['absent_out'] = $customHelper->defaultDateTime('default');
        $validatedData['out_proof'] = $request->file('out_proof')->store('bukti-kehadiran');

        Attendance::where('id', '=', $cekAbsensiDatang->attendance_id)->update([
            'absent_out' => $validatedData['absent_out'],
            'out_proof' => $validatedData['out_proof']
        ]);

        return redirect()->intended('/logbook');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
