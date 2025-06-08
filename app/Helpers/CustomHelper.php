<?php

namespace App\Helpers;

use App\Models\Company;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomHelper
{
    public function generateRandomData()
    {
        Company::factory(10)->create();
        Student::factory(10)->create();
        Lecturer::factory(5)->create();

        $students = Student::all();

        foreach ($students as $student) {
            User::create([
                'name' => $student->name,
                'email' => $student->email,
                'password' => bcrypt($student->registration_number),
                'level' => 'mahasiswa',
                'is_active' => true
            ]);
        }

        $lecturers = Lecturer::all();

        foreach ($lecturers as $lecturer) {
            User::create([
                'name' => $lecturer->name,
                'email' => $lecturer->email,
                'password' => bcrypt($lecturer->lecturer_id_number),
                'level' => 'dosen',
                'is_active' => true
            ]);
        }
    }

    public function defaultDateTime($pilihan)
    {
        $date = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

        if ($pilihan == 'tanggalDb') {
            $date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        } elseif ($pilihan == 'tanggal') {
            $date = Carbon::now('Asia/Jakarta')->format('d-m-Y');
        } elseif ($pilihan == 'waktu') {
            $date = Carbon::now('Asia/Jakarta')->format('H:i:s');
        } elseif ($pilihan == 'tanggalWaktu') {
            $date = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        } elseif ($pilihan == 'hari') {
            $tgl = Carbon::now('Asia/Jakarta');
            $date = $tgl->locale('id_ID')->dayName;
        } elseif ($pilihan == 'bulan') {
            $tgl = Carbon::now('Asia/Jakarta');
            $date = $tgl->locale('id_ID')->monthName;
        } elseif ($pilihan == 'default') {
            $date = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        }

        return $date;
    }

    public function convertDate($tanggal)
    {
        $date = Carbon::parse($tanggal);
        $hari = $date->locale('id_ID')->dayName;

        $date = "$hari, " . $date->format('d-m-Y');

        return $date;
    }

    public function awalBulan($bulan)
    {
        $tanggal = Carbon::createFromDate(null, $bulan, 1)->startOfMonth();
        return $tanggal->toDateString();
    }

    public function akhirBulan($bulan)
    {
        $tanggal = Carbon::createFromDate(null, $bulan, 1)->startOfMonth()->addMonth(1);
        return $tanggal->toDateString();
    }

    public function konversiNilai($nilai)
    {
        $hasil = $nilai / 100 * 4;

        if ($hasil > 3.75) {
            $predikat = 'A';
        } elseif ($hasil > 3.50 && $hasil <= 3.75) {
            $predikat = 'A-';
        } elseif ($hasil > 3.00 && $hasil <= 3.50) {
            $predikat = 'B+';
        } elseif ($hasil > 2.75 && $hasil <= 3.00) {
            $predikat = 'B';
        } elseif ($hasil > 2.50 && $hasil <= 2.75) {
            $predikat = 'B-';
        } elseif ($hasil > 2.00 && $hasil <= 2.50) {
            $predikat = 'C+';
        } elseif ($hasil > 1.00 && $hasil <= 2.00) {
            $predikat = 'C';
        } elseif ($hasil > 0.00 && $hasil <= 1.00) {
            $predikat = 'D';
        } else {
            $predikat = '-';
        }


        return $predikat;
    }
}
