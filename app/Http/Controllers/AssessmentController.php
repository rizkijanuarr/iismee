<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\UpdateAssessmentRequest;
use App\Models\Assessment;

class AssessmentController extends Controller
{
    public function index() {}

    public function create() {}

    public function store(StoreAssessmentRequest $request) {}

    public function show(Assessment $assessment) {}

    public function edit(Assessment $assessment) {}

    public function update(UpdateAssessmentRequest $request, Assessment $assessment) {}

    public function destroy(Assessment $assessment) {}
}
