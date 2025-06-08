<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        $level = DB::table('users')->where('email', $inputan['email'])->value('level');
        $aktif = DB::table('users')->where('email', $inputan['email'])->value('is_active');


        if ($level == 'admin' && $aktif == true) {
            if (Auth::attempt($inputan)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard-admin');
            }
            return back()->with('errorLogin', 'Login Gagal !');
        }
        //  elseif ($level == 'user') {
        //     if (Auth::attempt($inputan)) {
        //         $request->session()->regenerate();
        //         return redirect()->intended('/user');
        //     }
        //     return back()->with('errorLogin', 'Login Gagal !');
        // } 
        // elseif ($level == 'dosen') {
        //     if (Auth::attempt($inputan)) {
        //         $request->session()->regenerate();
        //         return redirect()->intended('/dosen');
        //     }
        //     return back()->with('errorLogin', 'Login Gagal !');
        // } 
        elseif ($level == 'pembimbing' && $aktif == true) {
            if (Auth::attempt($inputan)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard-pembimbing');
            }
            return back()->with('errorLogin', 'Login Gagal !');
        } elseif ($level == 'pembimbing industri' && $aktif == true) {
            if (Auth::attempt($inputan)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard-pembimbing-industri');
            }
            return back()->with('errorLogin', 'Login Gagal !');
        } elseif ($level == 'mahasiswa' && $aktif == true) {
            if (Auth::attempt($inputan)) {
                $request->session()->regenerate();
                return redirect()->intended('/mahasiswa');
            }
            return back()->with('errorLogin', 'Login Gagal !');
        } else {
            return back()->with('errorLogin', 'Login Gagal !');
        }

        // if (Auth::attempt($inputan)) {
        //     $request->session()->regenerate();')
        //     return redirect()->intended('/');
        // }

        return back()->with('errorLogin', 'Login Gagal !');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
