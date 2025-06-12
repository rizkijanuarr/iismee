<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInternshipRequest;
use App\Http\Requests\UpdateInternshipRequest;
use App\Models\Internship;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Supervisor;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.magang', [
            'title' => 'Magang',
            'data' => Internship::groupBy('lecturer_id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add-magang', [
            'title' => 'Tambahkan Data Magang',
            'dosen' => Supervisor::all(),
            'mhs' => Student::whereNotIn('id', function ($query) {
                $query->select('student_id')->from('internships');
            })->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi dengan pesan custom
        $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
            'student_id' => 'required|array|min:1'
        ], [
            'lecturer_id.required' => 'Dosen pembimbing harus dipilih!',
            'lecturer_id.exists' => 'Dosen yang dipilih tidak valid!',
            'student_id.required' => 'Minimal satu mahasiswa harus dipilih!',
            'student_id.min' => 'Minimal satu mahasiswa harus dipilih!'
        ]);

        $lecturerId = $request->lecturer_id;
        $studentIds = $request->student_id;

        // Insert satu record internship untuk setiap student
        foreach ($studentIds as $studentId) {
            Internship::create([
                'lecturer_id' => $lecturerId,
                'student_id' => $studentId  // Single student ID per record
            ]);
        }

        return redirect()->intended('/manage-magang/')->with('success', 'Data Berhasil Ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Internship $manage_magang)
    {
        // dd($manage_magang->lecturer_id);
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

        // return view('admin.magang-details', [
        //     'title' => 'Detail Magang',
        //     'data' => Internship::where('lecturer_id', $manage_magang->lecturer_id)->get(),
        //     'magang' => $manage_magang
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Internship $internship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInternshipRequest $request, Internship $internship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Internship $manage_magang)
    {
        Internship::destroy($manage_magang->id);
        return redirect()->intended('/manage-magang')->with('success', 'Data Berhasil Dihapus !');
    }
}
