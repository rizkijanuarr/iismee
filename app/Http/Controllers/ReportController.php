<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateReportRequest;

class ReportController extends Controller
{
    public function index()
    {
        $mhs = Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail();

        return view('mahasiswa.laporan', [
            'title' => 'Laporan',
            'data' => Student::with('internship.lecturer')->where('email', '=', auth()->user()->email)->firstOrFail(),
            'laporan' => Report::where('student_id', '=', $mhs->id)->get()
        ]);
    }

    public function create() {}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'document_path' => 'required|file|mimes:pdf|max:2048',
            'student_id' => 'required|exists:students,id'
        ], [
            'document_path.required' => 'File laporan harus diupload!',
            'document_path.file' => 'File yang diupload harus berupa dokumen!',
            'document_path.mimes' => 'File harus berformat PDF!',
            'document_path.max' => 'Ukuran file maksimal 2MB!',
            'student_id.required' => 'Student ID tidak valid!',
            'student_id.exists' => 'Data mahasiswa tidak ditemukan!'
        ]);

        try {
            // Cek apakah file PDF kosong
            if ($request->file('document_path')->getSize() == 0) {
                return redirect()->back()->with('error', 'File PDF tidak boleh kosong!');
            }

            // Get original filename untuk logging/debugging
            $originalFileName = $request->file('document_path')->getClientOriginalName();

            // Get student data untuk custom filename
            $student = Student::findOrFail($request->student_id);

            // Generate custom filename yang lebih clean dan konsisten
            $timestamp = now()->format('YmdHis');
            $studentName = Str::slug($student->name); // Convert nama ke slug format
            $customFileName = "laporan_{$studentName}_{$timestamp}.pdf";

            // Validasi tambahan untuk memastikan filename yang dihasilkan valid
            if (strlen($customFileName) > 255) {
                // Jika nama terlalu panjang, potong nama mahasiswa
                $shortStudentName = Str::limit(Str::slug($student->name), 50, '');
                $customFileName = "laporan_{$shortStudentName}_{$timestamp}.pdf";
            }

            // Cek existing report berdasarkan student_id dan name "Laporan"
            $existingReport = Report::where('student_id', $request->student_id)
                ->where('name', 'Laporan')
                ->first();

            if ($existingReport) {
                // Delete existing file if exists
                if (Storage::exists($existingReport->document_path)) {
                    Storage::delete($existingReport->document_path);
                }

                // Store file dengan custom filename yang clean
                $filePath = $request->file('document_path')->storeAs('laporan', $customFileName);

                // Update existing report
                $existingReport->update([
                    'document_path' => $filePath,
                    'name' => 'Laporan', // Hardcoded
                    'type' => 'PDF', // Hardcoded
                    'validation_status' => 'Terverifikasi', // Hardcoded
                    'information' => 'Laporan ini telah diverifikasi' // Hardcoded
                ]);

                return redirect()->intended('/laporan')->with('success', 'Laporan berhasil di unggah dan telah terverifikasi!');
            } else {
                // Store file dengan custom filename yang clean
                $filePath = $request->file('document_path')->storeAs('laporan', $customFileName);

                // Create new report
                Report::create([
                    'student_id' => $request->student_id,
                    'name' => 'Laporan', // Hardcoded
                    'type' => 'PDF', // Hardcoded
                    'validation_status' => 'Terverifikasi', // Hardcoded
                    'information' => 'Laporan ini telah diverifikasi', // Hardcoded
                    'document_path' => $filePath
                ]);

                return redirect()->intended('/laporan')->with('success', 'Laporan berhasil di unggah dan telah terverifikasi!');
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Gagal mengupload laporan. Silakan coba lagi!');
        }
    }

    public function show(Report $report) {}

    public function edit(Report $report) {}

    public function update(UpdateReportRequest $request, Report $report) {}

    public function destroy($id)
    {
        try {
            $report = Report::findOrFail($id);

            if (Storage::exists($report->document_path)) {
                Storage::delete($report->document_path);
            }

            $report->delete();

            return redirect()->back()->with('success', 'Laporan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus laporan. Silakan coba lagi!');
        }
    }
}
