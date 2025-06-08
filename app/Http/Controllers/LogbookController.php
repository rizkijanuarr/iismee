<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\Document;
use App\Models\Logbook;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;



class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customHelper = new CustomHelper();

        $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();
        $sptjm = Document::where('student_id', '=', $mhs->id)->where('type', '=', 'Surat Persetujuan Magang')->first();
        $tanggalNow = $customHelper->defaultDateTime('tanggalDb');

        $cekAbsensiDatang = Student::selectRaw('IF(students.id IN (SELECT attendances.student_id FROM attendances WHERE DATE(attendances.absent_entry) = "' . $tanggalNow . '"), true, false) AS is_absen')
            ->join('attendances', 'attendances.student_id', '=', 'students.id')
            ->where('students.id', '=', $mhs->id)
            ->first();

        // dd($cekAbsensiDatang->is_absen);

        if ($cekAbsensiDatang->is_absen ?? null) {
            return view('mahasiswa.logbook', [
                'title' => 'Logbook',
                'data' => Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail(),
                'logbook' => Logbook::where('student_id', '=', $mhs->id)->get(),
                'suratMagang' => $sptjm,
                'cekAbsensiDatang' => $cekAbsensiDatang->is_absen,
            ]);
        } else {
            return redirect()->intended('/absensi');
        }
    }

    public function printLogbook()
    {
        $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();

        $data = Logbook::where('student_id', '=', $mhs->id)->get();

        $pdf = Pdf::loadView('mahasiswa.print-logbook', [
            'title' => 'Cetak Logbook',
            'data' => $data,
            'mhs' => $mhs
        ]);

        return $pdf->stream('logbook.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.add-logbook', [
            'title' => 'Logbook'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mhs = Student::where('email', '=', auth()->user()->email)->firstOrFail();
        $helper = new CustomHelper();

        $validatedData = $request->validate([
            'activity_name' => 'required',
            'img' => 'required|image',
            'description' => 'required'
        ]);

        $validatedData['student_id'] = $mhs->id;
        $validatedData['activity_date'] = $helper->defaultDateTime('tanggalDb');
        $validatedData['img'] = $request->file('img')->store('logbook');

        Logbook::create($validatedData);
        return redirect()->intended('/logbook')->with('success', 'Data Berhasil Ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Logbook $logbook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logbook $logbook)
    {
        return view('mahasiswa.edit-logbook', [
            'title' => 'Logbook',
            'logbook' => $logbook
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logbook $logbook)
    {
        $mhs = Student::where('email', '=', auth()->user()->email)->firstOrFail();

        $validatedData = $request->validate([
            'activity_name' => 'required',
            'img' => 'image',
            'description' => 'required'
        ]);

        $validatedData['student_id'] = $mhs->id;
        if ($request->file('img')) {
            if ($request->oldimg) {
                Storage::delete($request->oldimg);
            }
            $validatedData['img'] = $request->file('img')->store('logbook');
        }

        Logbook::where('id', $logbook->id)->update($validatedData);
        return redirect()->intended('/logbook')->with('success', 'Data Berhasil Diubah !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logbook $logbook)
    {
        if ($logbook->img) {
            Storage::delete($logbook->img);
        }
        Logbook::destroy($logbook->id);
        return redirect()->intended('/logbook')->with('success', 'Data Berhasil Dihapus !');
    }
}
