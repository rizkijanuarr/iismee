<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Internship;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateInternshipRequest;

class InternshipController extends Controller
{
    public function index()
    {
        return view('admin.magang', [
            'title' => 'Magang',
            'data' => Internship::groupBy('lecturer_id')->get()
        ]);
    }

    public function create()
    {
        return view('admin.add-magang', [
            'title' => 'Tambahkan Data Magang',
            'dosen' => Supervisor::all(),
            'mhs' => Student::whereNotIn('id', function ($query) {
                $query->select('student_id')->from('internships');
            })->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        if (empty($request->lecturer_id)) {
            return redirect()->back()->with('error', 'Dosen pembimbing harus dipilih!');
        }

        if (empty($request->student_id) || !is_array($request->student_id) || count($request->student_id) < 1) {
            return redirect()->back()->with('error', 'Minimal satu mahasiswa harus dipilih!');
        }

        $existingLecturer = DB::select(
            "SELECT * FROM lecturers WHERE id = ? LIMIT 1",
            [$request->lecturer_id]
        );
        if (empty($existingLecturer)) {
            return redirect()->back()->with('error', 'Dosen wajib dipilih!');
        }

        $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
            'student_id' => 'required|array|min:1'
        ]);

        $lecturerId = $request->lecturer_id;
        $studentIds = $request->student_id;

        foreach ($studentIds as $studentId) {
            Internship::create([
                'lecturer_id' => $lecturerId,
                'student_id' => $studentId
            ]);
        }

        return redirect()->intended('/manage-magang/')->with('success', 'Data Berhasil Ditambahkan !');
    }

    public function show(Internship $manage_magang)
    {
        $data = Internship::select('internships.*', 'companies.*')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('companies', 'companies.id', '=', 'students.company_id')
            ->where('internships.lecturer_id', $manage_magang->lecturer_id)
            ->get();

        return view('admin.magang-details', [
            'title' => 'Detail Magang',
            'data' => $data,
            'magang' => $manage_magang
        ]);
    }

    public function edit(Internship $internship) {}

    public function update(UpdateInternshipRequest $request, Internship $internship) {}

    public function destroy(Internship $manage_magang)
    {
        Internship::destroy($manage_magang->id);
        return redirect()->intended('/manage-magang')->with('success', 'Data Berhasil Dihapus !');
    }
}
