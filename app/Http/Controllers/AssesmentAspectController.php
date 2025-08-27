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
            'title' => __('messages.assessment_aspect'),
            'matakuliah' => Subject::with('lecturer')->orderByDesc('created_at')->get(),
            'penilaian' => $penilaian
        ]);
    }

    public function create()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        if ($penilaian->is_enable == true) {
            return view('admin.add-aspek-penilaian', [
                'title' => __('messages.assessment_aspect_add'),
                'matakuliah' => Subject::with('lecturer')->orderByDesc('created_at')->get()
            ]);
        } else {
            abort(403, __('messages.evaluation_period_disabled'));
        }
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required'
        ], [
            'name.required' => __('messages.assessment_aspect_name_required'),
            'subject_id.required' => __('messages.assessment_aspect_subject_required'),
            'subject_id.exists' => __('messages.subject_not_found'),
            'description.required' => __('messages.assessment_aspect_description_required'),
        ]);

        try {
            AssesmentAspect::create($validatedData);
            return redirect()->intended('/aspek-penilaian')
                ->with('success', __('messages.assessment_aspect_create_success'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.general_error'));
        }
    }

    public function show(AssesmentAspect $assesmentAspect) {}

    public function edit(AssesmentAspect $aspek_penilaian)
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();
        
        if ($penilaian->is_enable == false) {
            abort(403, __('messages.evaluation_period_disabled'));
        }

        return view('admin.edit-aspek-penilaian', [
            'title' => __('messages.assessment_aspect_edit'),
            'matakuliah' => Subject::with('lecturer')->orderByDesc('created_at')->get(),
            'aspek' => $aspek_penilaian
        ]);
    }

    public function update(Request $request, AssesmentAspect $aspek_penilaian)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required'
        ], [
            'name.required' => __('messages.assessment_aspect_name_required'),
            'subject_id.required' => __('messages.assessment_aspect_subject_required'),
            'subject_id.exists' => __('messages.subject_not_found'),
            'description.required' => __('messages.assessment_aspect_description_required'),
        ]);

        try {
            $aspek_penilaian->update($validatedData);
            return redirect()->intended('/aspek-penilaian')
                ->with('success', __('messages.assessment_aspect_update_success'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.general_error'));
        }
    }

    public function destroy(AssesmentAspect $aspek_penilaian)
    {
        try {
            $aspek_penilaian->delete();
            return redirect()->intended('/aspek-penilaian')
                ->with('success', __('messages.assessment_aspect_delete_success'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('messages.general_error'));
        }
    }
}
