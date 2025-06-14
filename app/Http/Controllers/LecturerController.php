<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;
use App\Models\Lecturer;

class LecturerController extends Controller
{
    public function index() {}

    public function create() {}

    public function store(StoreLecturerRequest $request) {}

    public function show(Lecturer $lecturer) {}

    public function edit(Lecturer $lecturer) {}

    public function update(UpdateLecturerRequest $request, Lecturer $lecturer) {}

    public function destroy(Lecturer $lecturer) {}
}
