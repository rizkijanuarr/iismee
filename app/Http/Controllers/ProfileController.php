<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function indexUser()
    {
        $mhs = Student::where('email', '=', auth()->user()->email)->firstOrFail();

        return view('mahasiswa.profil', [
            'title' => __('messages.profile'),
            'data' => $mhs
        ]);
    }

    public function gantiFoto(Request $request)
    {
        $mhs = Student::where('email', '=', auth()->user()->email)->firstOrFail();

        $validatedData = $request->validate([
            'img_path' => 'image'
        ]);

        if ($request->file('img_path')) {
            if ($request->oldimg != null) {
                Storage::delete($request->oldimg);
            }
            $validatedData['img_path'] = $request->file('img_path')->store('foto-profil');
        }

        Student::where('id', '=', $mhs->id)->update($validatedData);
        return redirect()->intended('/profile-user')
        ->with('success', __('messages.success_data_updated'));
    }

    public function indexGantiPassword()
    {
        $level = auth()->user()->level;

        if ($level == 'mahasiswa') {
            return view('mahasiswa.ganti-password', [
                'title' => __('messages.change_password')
            ]);
        } else {
            return view('akun.ganti-password', [
                'title' => __('messages.change_password')
            ]);
        }
    }

    public function gantiPassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::where('id', '=', auth()->user()->id)->update($validatedData);

        return redirect()->intended('/gantiPassword')
        ->with('success', __('messages.success_data_updated'));
    }
}
