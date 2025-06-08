<?php

use App\Helpers\CustomHelper;
use App\Http\Controllers\AdminLecturerController;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\AdminSubjectController;
use App\Http\Controllers\AdminSupervisorController;
use App\Http\Controllers\AssesmentAspectController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\IndustrialAdviserController;
use App\Http\Controllers\IndustrialAdviserRegisterController;
use App\Http\Controllers\IndustrialAssessmentController;
use App\Http\Controllers\IndustrialDashboardController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentInternshipController;
use App\Http\Controllers\SupervisorAssessmentController;
use App\Http\Controllers\SupervisorAttendanceController;
use App\Http\Controllers\SupervisorDashboardController;
use App\Http\Controllers\SupervisorLogbookController;
use App\Http\Controllers\SupervisorReportController;
use App\Http\Controllers\WebSettingController;
use App\Models\Supervisor;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('login');


//admin Route 
Route::group(['middleware' => ['auth', 'ceklevel:admin']], function () {
    Route::get('dashboard-admin', [DashboardAdminController::class, 'index']);
    // Route::get('manage-mahasiswa', [AdminStudentController::class, 'index']);
    Route::get('add-mahasiswa', [AdminStudentController::class, 'indexTambahMahasiswa']);
    Route::resource('manage-mahasiswa', AdminStudentController::class);
    Route::resource('manage-dosen', AdminLecturerController::class);
    Route::resource('manage-matakuliah', AdminSubjectController::class);
    Route::resource('manage-dpl', AdminSupervisorController::class);
    Route::resource('aspek-penilaian', AssesmentAspectController::class);
    Route::resource('manage-magang', InternshipController::class);
    Route::resource('manage-perusahaan', CompanyController::class);
    Route::get('getDataPerusahaan', [AdminStudentController::class, 'getDataPerusahaan']);
    Route::resource('manage-pembimbing-industri', IndustrialAdviserController::class);
    Route::post('setRegistrasi', [WebSettingController::class, 'setRegistrasiPembimbingIndustri']);
    Route::post('setPenilaian', [WebSettingController::class, 'setPenilaian']);
    Route::get('konfirmasi-pembimbing-industri', [IndustrialAdviserController::class, 'konfirmasiIndex']);
    Route::put('konfirmasi', [IndustrialAdviserController::class, 'konfirmasi']);
});

//Pembimbing Route
Route::group(['middleware' => ['auth', 'ceklevel:pembimbing']], function () {
    Route::get('dashboard-pembimbing', [SupervisorDashboardController::class, 'index']);
    Route::get('penilaian', [SupervisorAssessmentController::class, 'index']);
    Route::get('penilaian/{registration_number}', [SupervisorAssessmentController::class, 'show']);
    Route::get('penilaian/{registration_number}/edit', [SupervisorAssessmentController::class, 'edit']);
    Route::get('penilaian/{registration_number}/show', [SupervisorAssessmentController::class, 'showDetails']);
    Route::post('penilaian', [SupervisorAssessmentController::class, 'store']);
    Route::put('penilaian', [SupervisorAssessmentController::class, 'update']);
    Route::get('logbook-show/{registration_number}', [SupervisorLogbookController::class, 'index']);
    Route::get('logbook-response/{logbook_id}/add-response', [SupervisorLogbookController::class, 'responseIndex']);
    Route::put('add-response', [SupervisorLogbookController::class, 'addResponse']);
    Route::get('laporan-show/{registration_number}', [SupervisorReportController::class, 'index']);
    Route::get('add-asistensi/{laporan_id}', [SupervisorReportController::class, 'asistensiIndex']);
    Route::put('add-asistensi', [SupervisorReportController::class, 'asistensi']);
    Route::get('cetak-penilaian', [SupervisorAssessmentController::class, 'cetakPenilaian']);
    Route::get('cetak-absensi/{registration_number}', [SupervisorAttendanceController::class, 'printAbsensi']);
});

// Pembimbing Industri Route
Route::group(['middleware' => ['auth', "ceklevel:pembimbing industri"]], function () {
    Route::get('dashboard-pembimbing-industri', [IndustrialDashboardController::class, 'index']);
    Route::get('penilaian-industri', [IndustrialAssessmentController::class, 'index']);
    Route::get('penilaian-industri/{registration_number}', [IndustrialAssessmentController::class, 'show']);
    Route::get('penilaian-industri/{registration_number}/show', [IndustrialAssessmentController::class, 'showDetails']);
    Route::get('penilaian-industri/{registration_number}/edit', [IndustrialAssessmentController::class, 'edit']);
    Route::post('penilaian-industri', [IndustrialAssessmentController::class, 'store']);
    Route::put('penilaian-industri', [IndustrialAssessmentController::class, 'update']);
    Route::get('logbook-shows/{registration_number}', [SupervisorLogbookController::class, 'index']);
});

// Mahasiswa Route
Route::group(['middleware' => ['auth', 'ceklevel:mahasiswa']], function () {
    Route::resource('mahasiswa', StudentController::class);
    Route::resource('magang', StudentInternshipController::class);
    Route::resource('logbook', LogbookController::class);
    Route::post('upload-dokumen', [DocumentController::class, 'store']);
    Route::resource('laporan', ReportController::class);
    Route::get('absensi', [AttendanceController::class, 'index']);
    Route::post('absensi', [AttendanceController::class, 'store']);
    Route::put('absensi', [AttendanceController::class, 'update']);
    Route::get('profile-user', [ProfileController::class, 'indexUser']);
    Route::put('gantiFoto', [ProfileController::class, 'gantiFoto']);
    Route::get('print-logbook', [LogbookController::class, 'printLogbook']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('gantiPassword', [ProfileController::class, 'indexGantiPassword']);
    Route::put('gantiPassword', [ProfileController::class, 'gantiPassword']);
    Route::get('print-logbook/{registration_number}', [SupervisorLogbookController::class, 'printLogbook']);
});

//auth Controller
Route::get('login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);


// Register Pembimbing Route
Route::get('daftar-pembimbing-industri', [IndustrialAdviserRegisterController::class, 'index']);
Route::post('daftar', [IndustrialAdviserRegisterController::class, 'store']);

Route::get('/waiting', function () {
    return view('errors.waiting');
});

Route::get('generate', [CustomHelper::class, 'generateRandomData']);
