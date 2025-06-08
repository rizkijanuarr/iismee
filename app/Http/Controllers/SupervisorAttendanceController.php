<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupervisorAttendanceController extends Controller
{
    //

    public function printAbsensi($registration_number, Request $request)
    {

        $mhs = Student::where('registration_number', '=', $registration_number)->firstOrFail();

        $helper = new CustomHelper();

        $bulanNow = Carbon::now()->month;

        $bulan = $request->bulan ?? $bulanNow;

        $awalBulan = $helper->awalBulan($bulan);
        $akhirBulan = $helper->akhirBulan($bulan);

        $idMhs = $mhs->id;
        $tanggalMulai = $awalBulan;
        $tanggalAkhir = $akhirBulan;
        $idMahasiswa = $mhs->id;

        $data = DB::table(DB::raw("(SELECT DATE_ADD('$tanggalMulai', INTERVAL seq DAY) AS tanggal
                      FROM (SELECT (HUNDREDS*100 + TENS*10 + ONES) seq
                            FROM (SELECT 0 HUNDREDS UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) A,
                                 (SELECT 0 TENS UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) B,
                                 (SELECT 0 ONES UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) C
                           ) seq_0_to_999
                      WHERE DATE_ADD('$tanggalMulai', INTERVAL seq DAY) < '$tanggalAkhir'
                 ) t"))
            ->leftJoin('attendances AS a', function ($join) use ($idMahasiswa) {
                $join->on(DB::raw('DATE(a.absent_entry)'), '=', 't.tanggal')
                    ->on('a.student_id', '=', DB::raw($idMahasiswa));
            })
            ->select(DB::raw("t.tanggal, 
                                   CASE WHEN DATE(a.absent_entry) = t.tanggal THEN DATE_FORMAT(a.absent_entry, '%H:%i:%s') ELSE '-' END AS is_masuk,
                                   CASE WHEN DATE(a.absent_entry) = t.tanggal THEN DATE_FORMAT(a.absent_out, '%H:%i:%s') ELSE '-' END AS is_keluar"))
            ->whereRaw("DATE(a.absent_entry) = t.tanggal OR a.student_id IS NULL")
            ->groupBy('t.tanggal', 'a.absent_entry')
            ->orderBy('t.tanggal', 'ASC')
            ->get();




        $pdf = Pdf::loadView('pembimbing.print-absensi', [
            'data' => $data,
            'title' => 'Cetak Absensi'
        ]);

        return $pdf->stream('Absensi.pdf');
    }
}
