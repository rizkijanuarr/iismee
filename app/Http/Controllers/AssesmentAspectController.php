<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssesmentAspectRequest;
use App\Http\Requests\UpdateAssesmentAspectRequest;
use App\Models\AssesmentAspect;
use App\Models\Lecturer;
use App\Models\Subject;
use App\Models\Supervisor;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Mockery\Matcher\Subset;

class AssesmentAspectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        return view('admin.aspek-penilaian', [
            'title' => 'Aspek Penilaian',
            'matakuliah' => Subject::all(),
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
            return view('admin.add-aspek-penilaian', [
                'title' => 'Tambahkan Aspek Penilaian',
                'matakuliah' => Subject::all()
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
            'name' => 'required',
            'subject_id' => 'required',
            'description' => 'required'
        ]);

        AssesmentAspect::create($validatedData);
        return redirect()->intended('/aspek-penilaian')->with('success', 'Data Berhasil Ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssesmentAspect $assesmentAspect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssesmentAspect $aspek_penilaian)
    {
        return view('admin.edit-aspek-penilaian', [
            'title' => 'Edit Aspek Penilaian',
            'matakuliah' => Subject::all(),
            'aspek' => $aspek_penilaian
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssesmentAspect $aspek_penilaian)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'subject_id' => 'required',
            'description' => 'required'
        ]);

        AssesmentAspect::where('id', $aspek_penilaian->id)->update($validatedData);
        return redirect()->intended('/aspek-penilaian')->with('success', 'Data Berhasil Diubah !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssesmentAspect $aspek_penilaian)
    {
        AssesmentAspect::destroy($aspek_penilaian->id);
        return redirect()->intended('/aspek-penilaian')->with('success', 'Data Berhasil Dihapus !');
    }
}
