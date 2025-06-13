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
    // Validasi dengan pesan custom
    $validatedData = $request->validate([
        'document_path' => 'required|file|mimes:pdf,png,jpg,jpeg,svg|max:5120',
        'name' => 'required|string|max:255',
        'student_id' => 'required|exists:students,id'
    ], [
        'document_path.required' => 'File laporan harus diupload!',
        'document_path.file' => 'File yang diupload harus berupa dokumen!',
        'document_path.mimes' => 'File harus berformat PDF, PNG, JPG, JPEG, atau SVG!',
        'document_path.max' => 'Ukuran file maksimal 5MB!',
        'name.required' => 'Jenis laporan harus dipilih!',
        'name.max' => 'Nama laporan terlalu panjang!',
        'student_id.required' => 'Student ID tidak valid!',
        'student_id.exists' => 'Data mahasiswa tidak ditemukan!'
    ]);

    try {
        // Cek apakah laporan dengan jenis yang sama sudah ada
        $existingReport = Report::where('student_id', $request->student_id)
                                ->where('name', $request->name)
                                ->first();

        if ($existingReport) {
            // Hapus file lama jika ada
            if (Storage::exists($existingReport->document_path)) {
                Storage::delete($existingReport->document_path);
            }
            
            // Tentukan tipe file berdasarkan ekstensi
            $fileExtension = $request->file('document_path')->getClientOriginalExtension();
            $fileType = in_array(strtolower($fileExtension), ['png', 'jpg', 'jpeg', 'svg']) ? 'image' : 'pdf';
            
            // Update laporan yang sudah ada
            $existingReport->update([
                'document_path' => $request->file('document_path')->store('laporan'),
                'type' => $fileType,
                'validation_status' => 'Menunggu Validasi',
                'information' => null // Reset keterangan
            ]);
            
            return redirect()->intended('/laporan')->with('success', 'Laporan berhasil diperbarui dan menunggu validasi ulang!');
        } else {
            // Tentukan tipe file berdasarkan ekstensi
            $fileExtension = $request->file('document_path')->getClientOriginalExtension();
            $fileType = in_array(strtolower($fileExtension), ['png', 'jpg', 'jpeg', 'svg']) ? 'image' : 'pdf';
            
            // Buat laporan baru
            Report::create([
                'student_id' => $request->student_id,
                'name' => $request->name,
                'type' => $fileType,
                'validation_status' => 'Menunggu Validasi',
                'document_path' => $request->file('document_path')->store('laporan')
            ]);
            
            return redirect()->intended('/laporan')->with('success', 'Laporan berhasil diupload dan menunggu validasi!');
        }
        
    } catch (\Exception $e) {
        // Log error untuk debugging
        \Log::error('Error uploading report: ' . $e->getMessage());
        
        return redirect()->back()->with('error', 'Gagal mengupload laporan. Silakan coba lagi!');
    }
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
    public function destroy($id)
{
    try {
        $report = Report::findOrFail($id);
        
        // Hapus file dari storage
        if (Storage::exists($report->document_path)) {
            Storage::delete($report->document_path);
        }
        
        // Hapus record dari database
        $report->delete();
        
        return redirect()->back()->with('success', 'Laporan berhasil dihapus!');
        
    } catch (\Exception $e) {
        // Log error untuk debugging
        \Log::error('Error deleting report: ' . $e->getMessage());
        
        return redirect()->back()->with('error', 'Gagal menghapus laporan. Silakan coba lagi!');
    }
}
}
