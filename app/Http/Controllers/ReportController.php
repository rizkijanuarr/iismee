<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Report;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();

        return view('mahasiswa.laporan', [
            'title' => 'Laporan',
            'data' => Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail(),
            'laporan' => Report::where('student_id', '=', $mhs->id)->get()
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
        $validatedData = $request->validate([
            'document_path' => 'file|mimes:pdf',
            'name' => 'required',
            'student_id' => 'required'
        ]);

        $validatedData['validation_status'] = 'Menunggu Validasi';
        $validatedData['type'] = 'pdf';
        $validatedData['document_path'] = $request->file('document_path')->store('laporan');

        Report::create($validatedData);
        return redirect()->intended('/laporan')->with('success', 'Data Berhasil Ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $laporan)
    {
        if ($laporan->document_path) {
            Storage::delete($laporan->document_path);
        }
        Report::destroy($laporan->id);
        return redirect()->intended('/laporan')->with('success', 'Data Berhasil Dihapus !');
    }
}
