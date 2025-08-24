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
            return back()->with('errorLogin', __('messages.login_email_not_registered'));
        }

        $level = $user->level;
        $aktif = $user->is_active;

        // Admin
        if ($level == 'admin') {
            if ($aktif == true) {
                if (Auth::attempt($inputan)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard-admin')->with('success', __('messages.login_success_admin'));
                } else {
                    return back()->with('errorLogin', __('messages.login_wrong_password'));
                }
            } else {
                return back()->with('errorLogin', __('messages.login_admin_inactive'));
            }
        }

        // Pembimbing
        if ($level == 'pembimbing') {
            if ($aktif == true) {
                if (Auth::attempt($inputan)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard-pembimbing')->with('success', __('messages.login_success_lecturer'));
                } else {
                    return back()->with('errorLogin', __('messages.login_wrong_password'));
                }
            } else {
                return back()->with('errorLogin', __('messages.login_lecturer_inactive'));
            }
        }

        // Pembimbing Industri
        if ($level == 'pembimbing industri') {
            if ($aktif == true) {
                if (Auth::attempt($inputan)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard-pembimbing-industri')->with('success', __('messages.login_success_industry_supervisor'));
                } else {
                    return back()->with('errorLogin', __('messages.login_wrong_password'));
                }
            } else {
                return back()->with('errorLogin', __('messages.login_industry_supervisor_inactive'));
            }
        }

        // Mahasiswa
        if ($level == 'mahasiswa') {
            if ($aktif == true) {
                if (Auth::attempt($inputan)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/mahasiswa')->with('success', __('messages.login_success_student'));
                } else {
                    return back()->with('errorLogin', __('messages.login_wrong_password'));
                }
            } else {
                return back()->with('errorLogin', __('messages.login_student_inactive'));
            }
        }

    // Jika level tidak dikenali
    return back()->with('errorLogin', __('messages.login_unknown_role'));
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
