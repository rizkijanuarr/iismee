<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupervisorRequest;
use App\Http\Requests\UpdateSupervisorRequest;
use App\Models\Supervisor;

class SupervisorController extends Controller
{
    public function index() {}

    public function create() {}

    public function store(StoreSupervisorRequest $request) {}

    public function show(Supervisor $supervisor) {}

    public function edit(Supervisor $supervisor) {}

    public function update(UpdateSupervisorRequest $request, Supervisor $supervisor) {}

    public function destroy(Supervisor $supervisor) {}
}
