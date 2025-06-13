<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Log MIME type for debugging
        if ($request->hasFile('document_path')) {
            \Log::info('UPLOAD MIME TYPE: ' . $request->file('document_path')->getMimeType());
        }
        // Validasi dengan pesan custom
        $validatedData = $request->validate([
            'document_path' => [
                'required',
                'file',
                'max:5120',
                function ($attribute, $value, $fail) use ($request) {
                    $allowed = ['pdf', 'png', 'jpg', 'jpeg', 'svg'];
                    $ext = strtolower($request->file('document_path')->getClientOriginalExtension());
                    if (!in_array($ext, $allowed)) {
                        $fail('Dokumen harus berformat PDF, PNG, JPG, JPEG, atau SVG!');
                    }
                }
            ],
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string'
        ], [
            'document_path.required' => 'Dokumen harus ditambahkan!',
            'document_path.file' => 'File yang diupload harus berupa dokumen!',
            'document_path.max' => 'Ukuran dokumen maksimal 5MB!',
            'student_id.required' => 'Student ID tidak valid!',
            'student_id.exists' => 'Data mahasiswa tidak ditemukan!',
            'type.required' => 'Tipe dokumen harus diisi!'
        ]);

        try {
            $existingDocument = Document::where('student_id', $request->student_id)
                                       ->where('type', $request->type)
                                       ->first();

            $file = $request->file('document_path');
            $ext = $file->getClientOriginalExtension();
            $prefix = $request->type === 'Sertifikat Magang' ? 'sertifikat_magang_' : 'surat_persetujuan_';
            $filename = $prefix . uniqid() . '.' . $ext;
            $path = $file->storeAs('dokumen', $filename);

            if ($existingDocument) {
                if (\Storage::exists($existingDocument->document_path)) {
                    \Storage::delete($existingDocument->document_path);
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

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Error uploading document: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupload dokumen. Silakan coba lagi!'
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal mengupload dokumen. Silakan coba lagi!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
