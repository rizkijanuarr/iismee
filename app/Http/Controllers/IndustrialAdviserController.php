<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use App\Models\IndustrialAdviser;
use Illuminate\Support\Facades\DB;

class IndustrialAdviserController extends Controller
{
    public function index()
    {
        $pembimbing = User::where('level', '=', 'pembimbing industri')
            ->where('is_active', '=', false)->get();
        $pembimbing_industri = IndustrialAdviser::with('company')->selectRaw('industrial_advisers.*')->join('users', 'users.email', '=', 'industrial_advisers.email')->where('users.is_active', '=', true)->get()->sortByDesc('created_at');


        $registrasi = WebSetting::where('name', '=', 'Registrasi Pembimbing Industri')->firstOrFail();
        return view('admin.pembimbing-industri', [
            'title' => __('messages.industrial_advisor'),
            'data' => $pembimbing_industri,
            'registrasi' => $registrasi,
            'jml' => count($pembimbing)
        ]);
    }

    public function konfirmasiIndex()
    {
        return view('admin.konfirmasi-pembimbing-industri', [
            'title' => __('messages.industrial_advisor'),
            'data' => IndustrialAdviser::with('company')->join('users', 'users.email', '=', 'industrial_advisers.email')->where('users.is_active', '=', false)->get(),
        ]);
    }

    public function create()
    {
        return view('admin.add-pembimbing-industri', [
            'title' => __('messages.industrial_advisor_add', ['title' => __('messages.industrial_advisor')]),
            'perusahaan' => Company::orderByDesc('created_at')->get()
        ]);
    }

    public function store(Request $request)
    {
        // Validate required fields with i18n messages
        $validationRules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'position' => 'required',
            'company_id' => 'required'
        ];

        $validationMessages = [
            'name.required' => __('messages.industrial_advisor_required_name'),
            'email.required' => __('messages.industrial_advisor_required_email'),
            'email.email' => __('validation.email', ['attribute' => 'email']),
            'phone_number.required' => __('messages.industrial_advisor_required_phone'),
            'position.required' => __('messages.industrial_advisor_required_position'),
            'company_id.required' => __('messages.industrial_advisor_required_company'),
        ];

        $validatedData = $request->validate($validationRules, $validationMessages);

        // Check for existing email in industrial_advisers and users tables
        $existingEmailIndustrialAdviser = DB::select(
            "SELECT * FROM industrial_advisers WHERE email = ? LIMIT 1",
            [$request->email]
        );

        $existingEmailUser = DB::select(
            "SELECT * FROM users WHERE email = ? LIMIT 1",
            [$request->email]
        );

        if (!empty($existingEmailIndustrialAdviser) || !empty($existingEmailUser)) {
            return redirect()->back()->with('error', __('messages.industrial_advisor_email_exists'));
        }

        // Use the already validated data
        $validateCreateUser = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ];

        $validateCreateUser['is_active'] = true;
        $validateCreateUser['password'] = bcrypt('1234');
        $validateCreateUser['level'] = 'pembimbing industri';

        IndustrialAdviser::create($validatedData);
        User::create($validateCreateUser);

        return redirect()->intended('/manage-pembimbing-industri')
            ->with('success', __('messages.industrial_advisor_create_success'));
    }

    public function show(IndustrialAdviser $industrialAdviser) {}

    public function edit(IndustrialAdviser $manage_pembimbing_industri)
    {
        return view('admin.edit-pembimbing-industri', [
            'title' => __('messages.industrial_advisor_edit') . ' ' . __('messages.industrial_advisor'),
            'perusahaan' => Company::all(),
            'pembimbingIndustri' => $manage_pembimbing_industri
        ]);
    }

    public function update(Request $request, IndustrialAdviser $manage_pembimbing_industri)
    {
        // Validate required fields with i18n messages
        $validationRules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'position' => 'required',
            'company_id' => 'required'
        ];

        $validationMessages = [
            'name.required' => __('messages.industrial_advisor_required_name'),
            'email.required' => __('messages.industrial_advisor_required_email'),
            'email.email' => __('validation.email', ['attribute' => 'email']),
            'phone_number.required' => __('messages.industrial_advisor_required_phone'),
            'position.required' => __('messages.industrial_advisor_required_position'),
            'company_id.required' => __('messages.industrial_advisor_required_company'),
        ];

        $validatedData = $request->validate($validationRules, $validationMessages);

        // Check for existing email in industrial_advisers and users tables
        $existingEmailIndustrialAdviser = DB::select(
            "SELECT * FROM industrial_advisers WHERE email = ? AND id != ? LIMIT 1",
            [$request->email, $manage_pembimbing_industri->id]
        );

        $existingEmailUser = DB::select(
            "SELECT * FROM users WHERE email = ? AND email != ? LIMIT 1",
            [$request->email, $manage_pembimbing_industri->email]
        );

        if (!empty($existingEmailIndustrialAdviser) || !empty($existingEmailUser)) {
            return redirect()->back()->with('error', __('messages.industrial_advisor_email_exists'));
        }

        // Use the already validated data from above

        $validateCreateUser = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        User::where('email', $manage_pembimbing_industri->email)->update($validateCreateUser);
        IndustrialAdviser::where('id', $manage_pembimbing_industri->id)->update($validatedData);

        return redirect()->intended('/manage-pembimbing-industri')
            ->with('success', __('messages.industrial_advisor_update_success'));
    }

    public function konfirmasi(Request $request)
    {
        $email = $request->input('email');
        User::where('email', '=', $email)
            ->update([
                'is_active' => true
            ]);

        return redirect()->intended('/manage-pembimbing-industri')
            ->with('success', __('messages.industrial_advisor_confirm_success'));
    }

    public function destroy(IndustrialAdviser $manage_pembimbing_industri)
    {
        $email = $manage_pembimbing_industri->email;
        User::where('email', $email)->delete();
        IndustrialAdviser::destroy($manage_pembimbing_industri->id);
        return redirect('/manage-pembimbing-industri')
            ->with('success', __('messages.industrial_advisor_delete_success'));
    }
}
