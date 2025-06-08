<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Student;
use Illuminate\Http\Request;

class SupervisorReportController extends Controller
{
    public function index($registration_number)
    {
        $mhs = Student::with('company')->where('registration_number', '=', $registration_number)->firstOrFail();

        return view('pembimbing.laporan', [
            'title' => 'Laporan ' . $mhs->name,
            'data' => $mhs,
            'laporan' => Report::where('student_id', '=', $mhs->id)->get()
        ]);
    }

    public function asistensiIndex($laporan_id)
    {
        return view('pembimbing.asistensi', [
            'title' => 'Tambahkan Asistensi',
            'laporan' => Report::where('id', '=', $laporan_id)->firstOrFail()
        ]);
    }

    public function asistensi(Request $request)
    {
        $validatedData = $request->validate([
            'validation_status' => 'required'
        ]);

        $validatedData['information'] = $request->input('information');

        Report::where('id', '=', $request->id)->update($validatedData);
        return redirect()->intended('/penilaian');
    }
}
