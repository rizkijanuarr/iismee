<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;

class AdminSupervisorController extends Controller
{
    public function index()
    {
        return view('admin.pembimbing', [
            'title' => 'Dosen Pembimbing Lapangan',
            'data' => Supervisor::all()
        ]);
    }

    public function create()
    {
        $dosen = Lecturer::whereNotIn('id', function ($query) {
            $query->select('lecturer_id')
                ->from('supervisors');
        })->get();


        return view('admin.add-pembimbing', [
            'title' => 'Tambahkan Dosen Pembimbing Lapangan',
            'data' => $dosen
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(['lecturer_id' => 'required']);
        $email = $request->email;
        Supervisor::create($validatedData);
        User::where('email', $email)->update([
            'level' => 'pembimbing',
            'password' => bcrypt('1234')
        ]);
        return redirect()->intended('/manage-dpl/create')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function show(Supervisor $supervisor) {}

    public function edit(Supervisor $supervisor) {}

    public function update(Request $request, Supervisor $supervisor) {}

    public function destroy(Supervisor $manage_dpl)
    {
        $email = $manage_dpl->lecturer['email'];
        User::where('email', $email)->update(['level' => 'dosen']);
        Supervisor::destroy($manage_dpl->id);
        return redirect()->intended('/manage-dpl')->with('success', 'Data Berhasil Dihapus !');
    }
}
