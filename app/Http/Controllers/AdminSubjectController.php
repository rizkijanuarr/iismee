<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Subject;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSubjectController extends Controller
{
    public function index()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        return view('admin.matakuliah', [
            'title' => __('messages.subject'),
            'data' => Subject::orderByDesc('created_at')->get(),
            'penilaian' => $penilaian
        ]);
    }

    public function create()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();
        if ($penilaian->is_enable) {
            return view('admin.add-matakuliah', [
                'title' => __('messages.subject_add'),
                'dosen' => Lecturer::orderByDesc('created_at')->get()
            ]);
        }
        
        return redirect()->back()
            ->with('error', __('messages.evaluation_period_disabled'));
    }

    public function store(Request $request)
    {
        $validationRules = [
            'subject_name' => 'required|unique:subjects,subject_name',
            'lecturer_id' => 'required|exists:lecturers,id',
            'sks' => 'required|numeric|min:1',
            'max_score' => 'required|numeric|min:1'
        ];

        $validationMessages = [
            'subject_name.required' => __('messages.subject_required_name'),
            'subject_name.unique' => __('messages.subject_name_exists'),
            'lecturer_id.required' => __('messages.subject_required_lecturer'),
            'lecturer_id.exists' => __('messages.lecturer_not_found'),
            'sks.required' => __('messages.subject_required_sks'),
            'sks.numeric' => __('messages.subject_numeric_sks'),
            'sks.min' => __('messages.subject_positive_sks'),
            'max_score.required' => __('messages.subject_required_max_score'),
            'max_score.numeric' => __('messages.subject_numeric_max_score'),
            'max_score.min' => __('messages.subject_positive_max_score')
        ];

        $validatedData = $request->validate($validationRules, $validationMessages);

        try {
            Subject::create($validatedData);
            return redirect()->intended('/manage-matakuliah')
                ->with('success', __('messages.subject_create_success'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.general_error'));
        }
    }

    public function show(Subject $subject) {}

    public function edit(Subject $manage_matakuliah)
    {
        return view('admin.edit-matakuliah', [
            'title' => __('messages.subject_edit'),
            'matakuliah' => $manage_matakuliah,
            'dosen' => Lecturer::all()
        ]);
    }

    public function update(Request $request, Subject $manage_matakuliah)
    {
        $validationRules = [
            'subject_name' => 'required',
            'lecturer_id' => 'required|not_in:Pilih Dosen Pengajar',
            'sks' => 'required|numeric|min:1',
            'max_score' => 'required|numeric|min:1'
        ];

        $validationMessages = [
            'subject_name.required' => __('messages.subject_required_name'),
            'lecturer_id.required' => __('messages.subject_required_lecturer'),
            'lecturer_id.not_in' => __('messages.subject_required_lecturer'),
            'sks.required' => __('messages.subject_required_sks'),
            'sks.numeric' => __('messages.subject_numeric_sks'),
            'sks.min' => __('messages.subject_positive_sks'),
            'max_score.required' => __('messages.subject_required_max_score'),
            'max_score.numeric' => __('messages.subject_numeric_max_score'),
            'max_score.min' => __('messages.subject_positive_max_score')
        ];

        $validatedData = $request->validate($validationRules, $validationMessages);

        $existingSubject = Subject::where('subject_name', $request->subject_name)
            ->where('id', '!=', $manage_matakuliah->id)
            ->first();
            
        if ($existingSubject) {
            return redirect()->back()->with('error', __('messages.subject_name_exists'));
        }

        try {
            Subject::where('id', $manage_matakuliah->id)->update([
                'subject_name' => $request->subject_name,
                'lecturer_id' => $request->lecturer_id,
                'sks' => $request->sks,
                'max_score' => $request->max_score
            ]);

            return redirect()->intended('/manage-matakuliah')
                ->with('success', __('messages.subject_update_success'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('messages.general_error'));
        }
    }

    public function destroy(Subject $manage_matakuliah)
    {
        try {
            $manage_matakuliah->delete();
            return redirect()->intended('/manage-matakuliah')
                ->with('success', __('messages.subject_delete_success'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('messages.general_error'));
        }
    }
}
