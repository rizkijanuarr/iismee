<?php

namespace App\Http\Controllers;

use App\Models\AssesmentAspect;
use App\Models\Assessment;
use App\Models\Document;
use App\Models\Internship;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use App\Models\WebSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupervisorAssessmentController extends Controller
{
    public function index()
    {
        $email = auth()->user()->email;
        $dosen = Lecturer::where('email', '=', $email)->firstOrFail();

        $is_assessment = Internship::selectRaw('IF(internships.student_id IN (SELECT assessments.student_id FROM assessments), true, false) AS is_assessment, internships.*, documents.document_path, companies.*')
            ->leftJoin('students', 'internships.student_id', '=', 'students.id')
            ->join('companies', 'students.company_id', '=', 'companies.id')
            ->leftJoin('documents', function ($join) {
                $join->on('students.id', '=', 'documents.student_id')
                    ->where('documents.type', '=', 'Surat Persetujuan Magang');
            })
            ->where('lecturer_id', $dosen->id)
            ->orderBy('is_assessment', 'asc')
            ->get();


        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        return view('pembimbing.penilaian', [
            'title' => 'Penilaian',
            'mahasiswa' => $is_assessment,
            'penilaian' => $penilaian
        ]);
    }

    public function cetakPenilaian()
    {
        $dosen = Lecturer::where('email', '=', auth()->user()->email)->firstOrFail();
        // dd($dosen->id);

        $notEvaluated = Student::selectRaw("students.*, '-' AS matakuliah1, '-' AS matakuliah2, '-' AS matakuliah3")
            ->join('internships', 'internships.student_id', '=', 'students.id')
            ->where('internships.lecturer_id', '=', $dosen->id)
            ->whereNotIn('students.id', Assessment::select('student_id')->get())
            ->groupBy('students.id')
            ->get();

        // dd($notEvaluated);

        $data = Student::selectRaw("students.name, students.registration_number, 
        COALESCE(
            (SELECT ROUND((SUM(assessments.score)/(subjects.max_score*COUNT(assesment_aspects.id))*100), 2) AS nilai
            FROM assessments 
            JOIN assesment_aspects ON assesment_aspects.id = assessments.assesment_aspect_id
            JOIN subjects ON subjects.id = assessments.subject_id
            WHERE subjects.id = 1 AND assessments.student_id = students.id), 
            '-'
        ) AS matakuliah1,
        COALESCE(
            (SELECT ROUND((SUM(assessments.score)/(subjects.max_score*COUNT(assesment_aspects.id))*100), 2) AS nilai
            FROM assessments 
            JOIN assesment_aspects ON assesment_aspects.id = assessments.assesment_aspect_id
            JOIN subjects ON subjects.id = assessments.subject_id
            WHERE subjects.id = 2 AND assessments.student_id = students.id), 
            '-'
        ) AS matakuliah2,
        COALESCE(
            (SELECT ROUND((SUM(assessments.score)/(subjects.max_score*COUNT(assesment_aspects.id))*100), 2) AS nilai
            FROM assessments 
            JOIN assesment_aspects ON assesment_aspects.id = assessments.assesment_aspect_id
            JOIN subjects ON subjects.id = assessments.subject_id
            WHERE subjects.id = 3 AND assessments.student_id = students.id), 
            '-'
        ) AS matakuliah3")
            ->leftJoin('assessments', 'students.id', '=', 'assessments.student_id')
            ->join('subjects', 'subjects.id', '=', 'assessments.subject_id')
            ->join('assesment_aspects', 'assesment_aspects.id', '=', 'assessments.assesment_aspect_id')
            ->join('internships', 'students.id', '=', 'internships.student_id')
            ->groupBy('students.name')
            ->where('internships.lecturer_id', '=', $dosen->id)
            ->get();

        $data = $data->concat($notEvaluated);

        $pdf = Pdf::loadView('pembimbing.print-penilaian', [
            'data' => $data,
            'title' => 'Cetak Penilaian'
        ]);

        return $pdf->stream('penilaian.pdf');
    }

    public function show(Request $request, $registration_number)
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        if ($penilaian->is_enable == true) {
            return view('pembimbing.penilaian-details', [
                'title' => 'Penilaian',
                'data' => Student::with('company')->where('registration_number', '=', $registration_number)->firstOrFail(),
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
            ->selectRaw('subjects.subject_name AS subject_name, lecturers.*, ROUND((SUM(assessments.score) / (subjects.max_score * COUNT(assesment_aspects.id))) * 100, 2) AS nilai')
            ->leftJoin('assessments', 'subjects.id', '=', 'assessments.subject_id')
            ->leftJoin('lecturers', 'lecturers.id', '=', 'subjects.lecturer_id')
            ->leftJoin('assesment_aspects', 'assessments.assesment_aspect_id', '=', 'assesment_aspects.id')
            ->groupBy('subjects.id')
            ->where('assessments.student_id', '=', $mhs->id)
            ->get();


        return view('pembimbing.penilaian-show', [
            'title' => 'Penilaian',
            'data' => Student::with('company')->where('registration_number', '=', $registration_number)->firstOrFail(),
            'matakuliah' => $subjects
        ]);
    }

    public function edit($registration_number)
    {

        $mhs = Student::where('registration_number', '=', $registration_number)->firstOrFail();
        // $subjects = Subject::with(['assessment' => function ($query) use ($mhs) {
        //     $query->where('student_id', '=', 1);
        // }, 'assessment.assesmentAspect'])->whereIn('id', function ($query) {
        //     $query->select('subject_id')->from('assesment_aspects');
        // })->get();

        $subjects = Subject::with(['assessment' => function ($query) use ($mhs) {
            $query->where('student_id', $mhs->id);
        }, 'assesmentAspect'])->whereIn('id', function ($query) {
            $query->select('subject_id')->from('assessments');
        })->get();


        $assesment = Assessment::with(['assesmentAspect', 'student', 'lecturer', 'subject'])
            ->where('student_id', '=', $mhs->id)->get();


        return view('pembimbing.penilaian-edit', [
            'title' => 'Penilaian',
            'data' => Student::where('registration_number', '=', $registration_number)->firstOrFail(),
            'assessment' => $assesment,
            'mpks' => $subjects
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lecturer_id' => 'required',
            'student_id' => 'required',
            'subject_id' => 'required',
            'assesment_aspect_id' => 'required',
            'score' => 'required'
        ]);

        // dd($validatedData['subject_id']);

        foreach ($validatedData['score'] as $score => $value) {
            $item = new Assessment();
            $item->lecturer_id = $validatedData['lecturer_id'];
            $item->student_id = $validatedData['student_id'];
            $item->subject_id = $validatedData['subject_id'][$score];
            $item->assesment_aspect_id = $validatedData['assesment_aspect_id'][$score];
            $item->score = $validatedData['score'][$score];
            $item->save();
        }

        return redirect()->intended('/penilaian');
    }

    public function update(Request $request)
    {
        $data = $request->all();
        foreach ($data['score'] as $key => $score) {
            $assessment = Assessment::find($data['assessment_id'][$key]);
            if ($assessment->student_id == $data['student_id'] && $assessment->subject_id == $data['subject_id'][$key] && $assessment->assesment_aspect_id == $data['assesment_aspect_id'][$key]) {
                $assessment->update(['score' => $score]);
            }
        }
        return redirect('/penilaian');
    }
}
