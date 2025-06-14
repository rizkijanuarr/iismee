<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class AuthController extends Controller
{
    public function index()
    {

        if (auth()->user() != null) {
            if (auth()->user()->level == 'admin') {
                return redirect()->intended('/dashboard-admin');
            } elseif (auth()->user()->level == 'pembimbing') {
                return redirect()->intended('/dashboard-pembimbing');
            } elseif (auth()->user()->level == 'mahasiswa') {
                return redirect()->intended('/mahasiswa');
            } elseif (auth()->user()->level == 'pembimbing industri') {
                return redirect()->intended('/dashboard-pembimbing-industri');
            }
        } else {
            return view('auth.login', [
                'title' => 'Login'
            ]);
        }
    }

    public function login(Request $request)
    {
        $inputan = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Cek apakah email terdaftar
        $user = DB::table('users')->where('email', $inputan['email'])->first();
        if (!$user) {
            return back()->with('errorLogin', 'Email belum terdaftar!');
        }

        $level = $user->level;
        $aktif = $user->is_active;

        // Admin
        if ($level == 'admin') {
            if ($aktif == true) {
                if (Auth::attempt($inputan)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard-admin')->with('success', 'Berhasil login sebagai admin!');
                } else {
                    return back()->with('errorLogin', 'Password salah!');
                }
            } else {
                return back()->with('errorLogin', 'Akun admin belum aktif!');
            }
        }

        // Pembimbing
        if ($level == 'pembimbing') {
            if ($aktif == true) {
                if (Auth::attempt($inputan)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard-pembimbing')->with('success', 'Berhasil login sebagai pembimbing!');
                } else {
                    return back()->with('errorLogin', 'Password salah!');
                }
            } else {
                return back()->with('errorLogin', 'Akun pembimbing belum aktif!');
            }
        }

        // Pembimbing Industri
        if ($level == 'pembimbing industri') {
            if ($aktif == true) {
                if (Auth::attempt($inputan)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard-pembimbing-industri')->with('success', 'Berhasil login sebagai pembimbing industri!');
                } else {
                    return back()->with('errorLogin', 'Password salah!');
                }
            } else {
                return back()->with('errorLogin', 'Akun pembimbing industri belum aktif!');
            }
        }

        // Mahasiswa
        if ($level == 'mahasiswa') {
            if ($aktif == true) {
                if (Auth::attempt($inputan)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/mahasiswa')->with('success', 'Berhasil login sebagai mahasiswa!');
                } else {
                    return back()->with('errorLogin', 'Password salah!');
                }
            } else {
                return back()->with('errorLogin', 'Akun mahasiswa belum aktif!');
            }
        }

        // Jika level tidak dikenali
        return back()->with('errorLogin', 'Login gagal, role tidak dikenali!');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
