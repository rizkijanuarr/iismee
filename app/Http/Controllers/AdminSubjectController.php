<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Lecturer;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSubjectController extends Controller
{
    public function index()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        return view('admin.matakuliah', [
            'title' => 'Mata Kuliah',
            'data' => Subject::orderByDesc('created_at')->get(),
            'penilaian' => $penilaian
        ]);
    }

    public function create()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();
        if ($penilaian->is_enable == false) {
            return view('admin.add-matakuliah', [
                'title' => 'Tambahkan Mata Kuliah',
                'dosen' => Lecturer::orderByDesc('created_at')->get()
            ]);
        } else {
            return view('errors.403');
        }
    }

    public function store(Request $request)
    {
        if (empty($request->subject_name)) {
            return redirect()->back()->with('error', 'Nama Mata Kuliah wajib diisi!');
        }

        if (empty($request->lecturer_id)) {
            return redirect()->back()->with('error', 'Dosen Pengajar wajib dipilih!');
        }

        if (empty($request->sks)) {
            return redirect()->back()->with('error', 'SKS wajib diisi!');
        }

        if (empty($request->max_score)) {
            return redirect()->back()->with('error', 'Skor Maksimal wajib diisi!');
        }

        $validatedData = $request->validate([
            'subject_name' => 'required',
            'lecturer_id' => 'required',
            'sks' => 'required|numeric',
            'max_score' => 'required|numeric'
        ]);

        Subject::create($validatedData);
        return redirect()->intended('/manage-matakuliah')->with('success', 'Data Mata Kuliah berhasil ditambahkan!');
    }

    public function show(Subject $subject) {}

    public function edit(Subject $manage_matakuliah)
    {
        return view('admin.edit-matakuliah', [
            'title' => 'Edit Mata Kuliah',
            'matakuliah' => $manage_matakuliah,
            'dosen' => Lecturer::all()
        ]);
    }

    public function update(Request $request, Subject $manage_matakuliah)
    {
        if (empty($request->subject_name)) {
            return redirect()->back()->with('error', 'Nama Mata Kuliah wajib diisi!');
        }

        if (empty($request->lecturer_id) || $request->lecturer_id == 'Pilih Dosen Pengajar') {
            return redirect()->back()->with('error', 'Dosen Pengajar wajib dipilih!');
        }

        if (empty($request->sks)) {
            return redirect()->back()->with('error', 'SKS wajib diisi!');
        }

        if (!is_numeric($request->sks) || $request->sks <= 0) {
            return redirect()->back()->with('error', 'SKS harus berupa angka positif!');
        }

        if (empty($request->max_score)) {
            return redirect()->back()->with('error', 'Skor Maksimal wajib diisi!');
        }

        if (!is_numeric($request->max_score) || $request->max_score <= 0) {
            return redirect()->back()->with('error', 'Skor Maksimal harus berupa angka positif!');
        }

        $existingSubject = DB::select(
            "SELECT * FROM subjects WHERE subject_name = ? AND id != ? LIMIT 1",
            [$request->subject_name, $manage_matakuliah->id]
        );
        if (!empty($existingSubject)) {
            return redirect()->back()->with('error', 'Mata Kuliah dengan nama tersebut sudah ada!');
        }

        try {
            Subject::where('id', $manage_matakuliah->id)->update([
                'subject_name' => $request->subject_name,
                'lecturer_id' => $request->lecturer_id,
                'sks' => $request->sks,
                'max_score' => $request->max_score
            ]);

            return redirect()->intended('/manage-matakuliah')->with('success', 'Data Mata Kuliah berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah data!');
        }
    }

    public function destroy(Subject $manage_matakuliah)
    {
        Subject::destroy($manage_matakuliah->id);
        return redirect()->intended('/manage-matakuliah')->with('success', 'Data Berhasil Dihapus !');
    }
}
