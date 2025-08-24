<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CompaniesImport;
use App\Exports\CompaniesTemplateExport;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    public function index()
    {
        $companyTitle = trans('messages.company_manage_title', ['title' => trans('messages.sidebar_companies')]);
        $dataTitle = trans('messages.company_data_title', ['title' => trans('messages.sidebar_companies')]);
        return view('admin.perusahaan', [
            'title' => trans('messages.sidebar_companies'),
            'company_manage_title' => $companyTitle,
            'company_data_title' => $dataTitle,
            'data' => Company::orderByDesc('created_at')->get()
        ]);
    }

    public function create()
    {
        return view('admin.add-perusahaan', [
            'title' => trans('messages.company_add', ['title' => trans('messages.sidebar_companies')])
        ]);
    }

    public function store(Request $request)
    {
        if (empty($request->company_name)) {
            return redirect()->back()->with('error', trans('messages.company_name') . ' ' . trans('messages.validation_failed'));
        }

        if (empty($request->company_address)) {
            return redirect()->back()->with('error', trans('messages.company_address') . ' ' . trans('messages.validation_failed'));
        }

        if (empty($request->company_number)) {
            return redirect()->back()->with('error', trans('messages.company_phone') . ' ' . trans('messages.validation_failed'));
        }
        $validatedData = $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'company_number' => 'required'
        ]);

        Company::create($validatedData);
        return redirect()->intended('/manage-perusahaan')->with('success', trans('messages.company_add', ['title' => trans('messages.sidebar_companies')]) . ' ' . trans('messages.success'));
    }

    public function show(Company $company) {}

    public function edit(Company $manage_perusahaan)
    {
        return view('admin.edit-perusahaan', [
            'title' => trans('messages.company_edit') . ' ' . trans('messages.sidebar_companies'),
            'perusahaan' => $manage_perusahaan
        ]);
    }

    public function update(Request $request, Company $manage_perusahaan)
    {
        if (empty($request->company_name)) {
            return redirect()->back()->with('error', trans('messages.company_name') . ' ' . trans('messages.validation_failed'));
        }

        if (empty($request->company_address)) {
            return redirect()->back()->with('error', trans('messages.company_address') . ' ' . trans('messages.validation_failed'));
        }

        if (empty($request->company_number)) {
            return redirect()->back()->with('error', trans('messages.company_phone') . ' ' . trans('messages.validation_failed'));
        }

        $existingCompany = DB::select(
            "SELECT * FROM companies WHERE company_name = ? AND id != ? LIMIT 1",
            [$request->company_name, $manage_perusahaan->id]
        );
        if (!empty($existingCompany)) {
            return redirect()->back()->with('error', trans('messages.company_name') . ' ' . trans('messages.failed'));
        }

        $validatedData = $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'company_number' => 'required'
        ]);

        Company::where('id', $manage_perusahaan->id)->update($validatedData);
        return redirect()->intended('/manage-perusahaan')->with('success', trans('messages.company_edit') . ' ' . trans('messages.success'));
    }

    public function destroy(Company $manage_perusahaan)
    {
        Company::destroy($manage_perusahaan->id);
        return redirect()->intended('/manage-perusahaan')->with('success', trans('messages.company_delete') . ' ' . trans('messages.success'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new CompaniesImport, $request->file('file'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', trans('messages.failed') . ': ' . $e->getMessage());
        }

        return redirect()->back()->with('success', trans('messages.company_import_excel') . ' ' . trans('messages.success'));
    }

    public function downloadTemplate()
    {
        $filename = 'template-perusahaan.csv';
        Log::info('Company downloadTemplate: start');
        try {
            // Build CSV content
            $fp = fopen('php://temp', 'r+');
            if (!$fp) {
                Log::error('Company downloadTemplate: failed to open php://temp');
                return redirect()->back()->with('error', 'Gagal membuka stream memori.');
            }
            fputcsv($fp, ['company_name', 'company_number', 'company_address']);
            fputcsv($fp, ['PT Contoh Satu', '0211234567', 'Jl. Mawar No. 1, Jakarta']);
            fputcsv($fp, ['CV Contoh Dua', '081234567890', 'Jl. Melati No. 2, Bandung']);
            rewind($fp);
            $csv = stream_get_contents($fp);
            fclose($fp);
            Log::info('Company downloadTemplate: csv built', ['length' => strlen((string)$csv)]);

            // Debug quick check
            if (request()->boolean('debug')) {
                Log::info('Company downloadTemplate: debug mode outputting raw CSV');
                return response("company_name,company_number,company_address\nPT Contoh Satu,021-1234567,Jl. Mawar No. 1, Jakarta\nCV Contoh Dua,0812-3456-7890,Jl. Melati No. 2, Bandung\n", 200, [
                    'Content-Type' => 'text/plain; charset=UTF-8',
                ]);
            }

            // Save to storage temporary path
            $path = 'tmp/' . $filename;
            Storage::disk('local')->put($path, $csv);
            $fullPath = storage_path('app/' . $path);
            Log::info('Company downloadTemplate: file saved', ['path' => $fullPath, 'exists' => file_exists($fullPath)]);

            // Send as download and delete after send
            $response = response()->download($fullPath, $filename, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ])->deleteFileAfterSend(true);
            Log::info('Company downloadTemplate: response prepared');
            return $response;
        } catch (\Throwable $e) {
            Log::error('Company downloadTemplate: exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Gagal mengunduh template perusahaan: ' . $e->getMessage());
        }
    }
}
