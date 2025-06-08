<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Subject;
use App\Models\WebSetting;
use Illuminate\Http\Request;

class AdminSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        return view('admin.matakuliah', [
            'title' => 'Mata Kuliah',
            'data' => Subject::all(),
            'penilaian' => $penilaian
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();
        if ($penilaian->is_enable == false) {
            return view('admin.add-matakuliah', [
                'title' => 'Tambahkan Mata Kuliah',
                'dosen' => Lecturer::all()
            ]);
        } else {
            return view('errors.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject_name' => 'required',
            'lecturer_id' => 'required',
            'sks' => 'required',
            'max_score' => 'required'
        ]);

        Subject::create($validatedData);
        return redirect()->intended('/manage-matakuliah')->with('success', 'Data Berhasil Ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $manage_matakuliah)
    {
        return view('admin.edit-matakuliah', [
            'title' => 'Edit Mata Kuliah',
            'matakuliah' => $manage_matakuliah,
            'dosen' => Lecturer::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $manage_matakuliah)
    {
        $validatedData = $request->validate([
            'subject_name' => 'required',
            'lecturer_id' => 'required',
            'sks' => 'required',
            'max_score' => 'required'
        ]);

        Subject::where('id', $manage_matakuliah->id)->update($validatedData);
        return redirect()->intended('/manage-matakuliah')->with('success', 'Data Berhasil Diubah !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $manage_matakuliah)
    {
        Subject::destroy($manage_matakuliah->id);
        return redirect()->intended('/manage-matakuliah')->with('success', 'Data Berhasil Dihapus !');
    }
}
