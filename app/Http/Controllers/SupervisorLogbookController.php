<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SupervisorLogbookController extends Controller
{
    public function index($registration_number)
    {
        $mhs = Student::with('company')->where('registration_number', '=', $registration_number)->firstOrFail();

        return view('pembimbing.logbook', [
            'title' => 'Logbook ' . $mhs->name,
            'data' => $mhs,
            'logbook' => Logbook::where('student_id', '=', $mhs->id)->get(),
        ]);
    }

    public function responseIndex($logbook_id)
    {
        return view('pembimbing.tanggapan', [
            'title' => 'Tambahkan Tanggapan',
            'logbook' => Logbook::where('id', '=', $logbook_id)->firstOrFail()
        ]);
    }

    public function addResponse(Request $request)
    {
        $validatedData = $request->validate([
            'response' => 'required'
        ]);

        Logbook::where('id', '=', $request->id)->update($validatedData);

        return redirect()->intended('/penilaian');
    }

    public function printLogbook($registration_number)
    {
        $mhs = Student::with('company')->where('registration_number', '=', $registration_number)->firstOrFail();

        $data = Logbook::where('student_id', '=', $mhs->id)->get();

        $pdf = Pdf::loadView('mahasiswa.print-logbook', [
            'data' => $data,
            'mhs' => $mhs,
            'title' => 'Cetak Logbook'
        ]);

        return $pdf->stream('logbook.pdf');
    }
}
