<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index() {}

    public function create() {}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'document_path' => [
                'required',
                'file',
                'max:2048', // 2MB dalam KB
                'mimes:pdf', // Validasi MIME type untuk PDF
                function ($attribute, $value, $fail) {
                    // Validasi tambahan untuk memastikan file benar-benar PDF
                    if ($value && $value->isValid()) {
                        $mimeType = $value->getMimeType();
                        $extension = strtolower($value->getClientOriginalExtension());

                        // Cek MIME type dan ekstensi
                        if ($mimeType !== 'application/pdf' || $extension !== 'pdf') {
                            $fail('File yang diupload harus berformat PDF yang valid.');
                        }

                        // Validasi signature file PDF (opsional, untuk keamanan ekstra)
                        $fileContent = file_get_contents($value->getRealPath());
                        if (substr($fileContent, 0, 4) !== '%PDF') {
                            $fail('File yang diupload bukan PDF yang valid.');
                        }
                    }
                }
            ],
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string'
        ], [
            'document_path.required' => 'Dokumen harus ditambahkan!',
            'document_path.file' => 'File yang diupload harus berupa dokumen!',
            'document_path.max' => 'Ukuran dokumen maksimal 2MB!',
            'document_path.mimes' => 'Dokumen harus berformat PDF!',
            'student_id.required' => 'Student ID tidak valid!',
            'student_id.exists' => 'Data mahasiswa tidak ditemukan!',
            'type.required' => 'Tipe dokumen harus diisi!'
        ]);

        try {
            $existingDocument = Document::where('student_id', $request->student_id)
                ->where('type', $request->type)
                ->first();

            $file = $request->file('document_path');

            // Double check lagi sebelum proses
            if (!$file || !$file->isValid()) {
                throw new \Exception('File tidak valid');
            }

            $ext = $file->getClientOriginalExtension();

            // Pastikan ekstensi adalah PDF
            if (strtolower($ext) !== 'pdf') {
                throw new \Exception('File harus berformat PDF');
            }

            $prefix = $request->type === 'Sertifikat Magang' ? 'sertifikat_magang_' : 'surat_persetujuan_';
            $filename = $prefix . uniqid() . '.pdf'; // Paksa ekstensi PDF
            $path = $file->storeAs('dokumen', $filename);

            if ($existingDocument) {
                if (Storage::exists($existingDocument->document_path)) {
                    Storage::delete($existingDocument->document_path);
                }
                $existingDocument->update([
                    'document_path' => $path
                ]);
                $message = 'Dokumen berhasil diperbarui!';
            } else {
                Document::create([
                    'student_id' => $request->student_id,
                    'type' => $request->type,
                    'document_path' => $path
                ]);
                $message = 'Dokumen berhasil diupload!';
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {

            $errorMessage = 'Gagal mengupload dokumen. Pastikan file berformat PDF yang valid!';

            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function show(Document $document) {}

    public function edit(Document $document) {}

    public function update(UpdateDocumentRequest $request, Document $document) {}

    public function destroy(Document $document) {}
}
