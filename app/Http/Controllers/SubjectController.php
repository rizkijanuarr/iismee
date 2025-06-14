<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index() {}

    public function create() {}

    public function store(StoreSubjectRequest $request) {}

    public function show(Subject $subject) {}

    public function edit(Subject $subject) {}

    public function update(UpdateSubjectRequest $request, Subject $subject) {}

    public function destroy(Subject $subject) {}
}
