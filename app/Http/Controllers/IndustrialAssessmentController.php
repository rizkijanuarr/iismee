<?php

namespace App\Http\Controllers;

use App\Models\IndustrialAdviser;
use App\Models\IndustrialAssessment;
use App\Models\Student;
use App\Models\Subject;
use App\Models\WebSetting;
use Illuminate\Http\Request;

class IndustrialAssessmentController extends Controller
{
    public function index()
    {
        $email = auth()->user()->email;
        $pembimbing = IndustrialAdviser::where('email', '=', $email)->firstOrFail();
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        $is_assessment = Student::selectRaw('IF(students.id IN (SELECT industrial_assessments.student_id FROM industrial_assessments), true, false) AS is_assessment, students.*, documents.document_path')
            ->leftJoin('industrial_assessments', 'students.id', '=', 'industrial_assessments.student_id')
            ->leftJoin('documents', function ($join) {
                $join->on('students.id', '=', 'documents.student_id')
                    ->where('documents.type', '=', 'Surat Persetujuan Magang');
            })
            ->where('company_id', $pembimbing->company_id)
            ->groupBy('students.id')
            ->orderBy('is_assessment', 'asc')
            ->get();


        return view('pembimbing-industri.penilaian', [
            'title' => __('messages.assessment'),
            'mahasiswa' => $is_assessment,
            'penilaian' => $penilaian
        ]);
    }

    public function create() {}

    public function store(Request $request)
    {
        $data = $request->all();

        if (
            empty($data['student_id']) ||
            empty($data['industrial_adviser_id']) ||
            empty($data['subject_id']) || !is_array($data['subject_id']) ||
            empty($data['assesment_aspect_id']) || !is_array($data['assesment_aspect_id']) ||
            empty($data['score']) || !is_array($data['score'])
        ) {
            return redirect()->back()->with('error', __('messages.error_all_fields_required'));
        }

        foreach ($data['score'] as $key => $value) {
            if ($value === null || $value === '') {
                return redirect()->back()->with('error', __('messages.error_score_required'));
            }

            $item = new IndustrialAssessment();
            $item->industrial_adviser_id = $data['industrial_adviser_id'];
            $item->student_id = $data['student_id'];
            $item->subject_id = $data['subject_id'][$key] ?? null;
            $item->assesment_aspect_id = $data['assesment_aspect_id'][$key] ?? null;
            $item->score = $value;
            $item->save();
        }


        return redirect()->intended('/penilaian-industri')->with('success', __('messages.success_assessment_saved'));
    }

    public function show($registration_number)
    {
        $email = auth()->user()->email;
        $pembimbing = IndustrialAdviser::where('email', '=', $email)->firstOrFail();
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        if ($penilaian->is_enable == true) {
            return view('pembimbing-industri.penilaian-details', [
                'title' => __('messages.assessment'),
                'pembimbing' => $pembimbing,
                'data' => Student::where('registration_number', '=', $registration_number)->firstOrFail(),
                'mpk' => Subject::whereIn('id', function ($query) {
                    $query->select('subject_id')->from('assesment_aspects');
                })->get()
            ]);
        } else {
            return view('errors.403');
        }
    }

    public function showDetails($registration_number)
    {
        $mhs = Student::where('registration_number', '=', $registration_number)->firstOrFail();

        $subjects = Subject::with(['assessment' => function ($query) use ($mhs) {
            $query->where('student_id', $mhs->id);
        }, 'assesmentAspect', 'lecturer'])
            ->whereIn('subjects.id', function ($query) {
                $query->select('subject_id')->from('assessments');
            })
            ->selectRaw('subjects.subject_name AS subject_name, lecturers.*, ROUND((SUM(industrial_assessments.score) / (subjects.max_score * COUNT(assesment_aspects.id))) * 100, 2) AS nilai')
            ->leftJoin('industrial_assessments', 'subjects.id', '=', 'industrial_assessments.subject_id')
            ->leftJoin('lecturers', 'lecturers.id', '=', 'subjects.lecturer_id')
            ->leftJoin('assesment_aspects', 'industrial_assessments.assesment_aspect_id', '=', 'assesment_aspects.id')
            ->groupBy('subjects.id')
            ->where('industrial_assessments.student_id', '=', $mhs->id)
            ->get();

        return view('pembimbing-industri.penilaian-show', [
            'title' => __('messages.assessment'),
            'data' => Student::with('company')->where('registration_number', '=', $registration_number)->firstOrFail(),
            'matakuliah' => $subjects
        ]);
    }

    public function edit($registration_number)
    {
        $mhs = Student::where('registration_number', '=', $registration_number)->firstOrFail();

        $subjects = Subject::with(['industrialAssessment' => function ($query) use ($mhs) {
            $query->where('student_id', $mhs->id);
        }, 'assesmentAspect'])->whereIn('id', function ($query) {
            $query->select('subject_id')->from('industrial_assessments');
        })->get();


        $assesment = IndustrialAssessment::with(['assesmentAspect', 'student', 'industrialAdviser', 'subject'])
            ->where('student_id', '=', $mhs->id)->get();


        return view('pembimbing-industri.penilaian-edit', [
            'title' => __('messages.assessment'),
            'data' => Student::with('company')->where('registration_number', '=', $registration_number)->firstOrFail(),
            'assessment' => $assesment,
            'mpks' => $subjects
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        if (
            empty($data['student_id']) ||
            empty($data['assessment_id']) || !is_array($data['assessment_id']) ||
            empty($data['subject_id']) || !is_array($data['subject_id']) ||
            empty($data['assesment_aspect_id']) || !is_array($data['assesment_aspect_id']) ||
            empty($data['score']) || !is_array($data['score'])
        ) {
            return redirect()->back()->with('error', __('messages.error_all_fields_required'));
        }

        foreach ($data['score'] as $key => $score) {
            $assessment = IndustrialAssessment::find($data['assessment_id'][$key]);

            if (!$assessment) continue;

            if (
                $assessment->student_id == $data['student_id'] &&
                $assessment->subject_id == $data['subject_id'][$key] &&
                $assessment->assesment_aspect_id == $data['assesment_aspect_id'][$key]
            ) {
                $assessment->update(['score' => $score]);
            }
        }

        return redirect('/penilaian-industri')->with('success', __('messages.success_assessment_updated'));
    }


    public function destroy(IndustrialAssessment $industrialAssessment) {}
}
