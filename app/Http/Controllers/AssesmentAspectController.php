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
    public function index()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        return view('admin.aspek-penilaian', [
            'title' => 'Aspek Penilaian',
            'matakuliah' => Subject::orderByDesc('created_at')->get(),
            'penilaian' => $penilaian
        ]);
    }

    public function create()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        if ($penilaian->is_enable == false) {
            return view('admin.add-aspek-penilaian', [
                'title' => 'Tambahkan Aspek Penilaian',
                'matakuliah' => Subject::orderByDesc('created_at')->get()
            ]);
        } else {
            return view('errors.403');
        }
    }


    public function store(Request $request)
    {
        if (empty($request->subject_id)) {
            return redirect()->back()->with('error', 'Mata Kuliah wajib dipilih!');
        }

        if (empty($request->name)) {
            return redirect()->back()->with('error', 'Nama Aspek Penilaian wajib diisi!');
        }

        if (empty($request->description)) {
            return redirect()->back()->with('error', 'Deskripsi wajib diisi!');
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'subject_id' => 'required',
            'description' => 'required'
        ]);

        AssesmentAspect::create($validatedData);
        return redirect()->intended('/aspek-penilaian')->with('success', 'Data Aspek Penilaian Berhasil Ditambahkan !');
    }

    public function show(AssesmentAspect $assesmentAspect) {}

    public function edit(AssesmentAspect $aspek_penilaian)
    {
        return view('admin.edit-aspek-penilaian', [
            'title' => 'Edit Aspek Penilaian',
            'matakuliah' => Subject::orderByDesc('created_at')->get(),
            'aspek' => $aspek_penilaian
        ]);
    }

    public function update(Request $request, AssesmentAspect $aspek_penilaian)
    {
        if (empty($request->name)) {
            return redirect()->back()->with('error', 'Nama Aspek Penilaian wajib diisi!');
        }

        if (empty($request->subject_id)) {
            return redirect()->back()->with('error', 'Mata Kuliah wajib dipilih!');
        }

        if (empty($request->description)) {
            return redirect()->back()->with('error', 'Deskripsi wajib diisi!');
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'subject_id' => 'required',
            'description' => 'required'
        ]);

        AssesmentAspect::where('id', $aspek_penilaian->id)->update($validatedData);
        return redirect()->intended('/aspek-penilaian')->with('success', 'Data Aspek Penilaian Berhasil Diubah !');
    }

    public function destroy(AssesmentAspect $aspek_penilaian)
    {
        AssesmentAspect::destroy($aspek_penilaian->id);
        return redirect()->intended('/aspek-penilaian')->with('success', 'Data Berhasil Dihapus !');
    }
}
