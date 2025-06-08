<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebSettingRequest;
use App\Http\Requests\UpdateWebSettingRequest;
use App\Models\WebSetting;

class WebSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function setRegistrasiPembimbingIndustri()
    {
        $registrasi = WebSetting::where('name', '=', 'Registrasi Pembimbing Industri')->firstOrFail();

        if ($registrasi->is_enable == true) {
            WebSetting::where('name', '=', 'Registrasi Pembimbing Industri')
                ->update([
                    'is_enable' => false
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
                    'is_enable' => false
                ]);
        } else {
            WebSetting::where('name', '=', 'Periode Penilaian')
                ->update([
                    'is_enable' => true
                ]);
        }

        return redirect()->intended('/manage-matakuliah');
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
    public function store(StoreWebSettingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WebSetting $webSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebSetting $webSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebSettingRequest $request, WebSetting $webSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebSetting $webSetting)
    {
        //
    }
}
