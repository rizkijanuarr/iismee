<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebSettingRequest;
use App\Http\Requests\UpdateWebSettingRequest;
use App\Models\WebSetting;

class WebSettingController extends Controller
{
    public function index() {}

    public function setRegistrasiPembimbingIndustri()
    {
        $registrasi = WebSetting::where('name', '=', 'Registrasi Pembimbing Industri')->firstOrFail();

        if ($registrasi->is_enable == true) {
            WebSetting::where('name', '=', 'Registrasi Pembimbing Industri')
                ->update([
                    'is_enable' => true
                ]);
        } else {
            WebSetting::where('name', '=', 'Registrasi Pembimbing Industri')
                ->update([
                    'is_enable' => true
                ]);
        }

        return redirect()->intended('/manage-pembimbing-industri');
    }

    public function setPenilaian()
    {
        $penilaian = WebSetting::where('name', '=', 'Periode Penilaian')->firstOrFail();

        if ($penilaian->is_enable == true) {
            WebSetting::where('name', '=', 'Periode Penilaian')
                ->update([
                    'is_enable' => true
                ]);
        } else {
            WebSetting::where('name', '=', 'Periode Penilaian')
                ->update([
                    'is_enable' => true
                ]);
        }

        return redirect()->intended('/manage-matakuliah');
    }

    public function create() {}

    public function store(StoreWebSettingRequest $request) {}

    public function show(WebSetting $webSetting) {}

    public function edit(WebSetting $webSetting) {}

    public function update(UpdateWebSettingRequest $request, WebSetting $webSetting) {}

    public function destroy(WebSetting $webSetting) {}
}
