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

        $request->validate([
            'lecturer_id' => 'required',
            'student_id' => 'required|array|min:1'
        ]);

        $input = $request->all();
        $lecturerId = $input['lecturer_id'];
        $studentIds = $request->input('tambahkan');

        $data = [
            'lecturer_id' => $lecturerId,
            'student_id' => $studentIds
        ];

        // dd($validatedData['student_id']);

        Internship::create($data);
        return redirect()->intended('/manage-magang/create')->with('success', 'Data Berhasil Ditambahkan !');
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
