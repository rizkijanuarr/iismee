@extends('layout.admin')

@section('konten')
    <div class="row justify-content-between">
        <div class="col">
            <div class="card mb-3">
                <div class="card-body">
                    <p>@lang('messages.student_data') :</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">@lang('messages.student_id_number')</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4"
                                        value="{{ $data->registration_number }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">@lang('messages.name')</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4" value="{{ $data->name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">@lang('messages.class')</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4" value="{{ $data->class }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">@lang('messages.company_name')</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4"
                                        value="{{ $data->company->company_name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">@lang('messages.address')</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4"
                                        value="{{ $data->company->company_address }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">@lang('messages.division')</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4" value="{{ $data->division }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">@lang('messages.internship_type')</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4" value="{{ $data->internship_type }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">@lang('messages.start_date') @lang('messages.to') @lang('messages.end_date')</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4"
                                        value="{{ $data->date_start }} s/d {{ $data->date_end }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mb-3">@lang('messages.edit') @lang('messages.assessment') : </h5>

            <div class="accordion" id="accordionExample">
                <form action="{{ url('penilaian') }}" method="post">
                    @method('PUT')
                    @csrf
                    @foreach ($mpks as $mpk)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapse{{ $mpk->id }}" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapse{{ $mpk->id }}">
                                    {{ $mpk->subject_name }} <i class="bi bi-caret-down-fill"></i>
                                </button>
                            </h2>
                            <label class="visually-hidden" for="inputName">Hidden input label</label>
                            <input type="hidden" class="form-control" name="lecturer_id" id="lecturer_id"
                                placeholder="" value="{{ $mpk->lecturer_id }}" style="display: none !important">
                            <label class="visually-hidden" for="inputName">Hidden input label</label>
                            <input type="hidden" class="form-control" name="student_id" id="student_id" placeholder=""
                                value="{{ $data->id }}" style="display: none !important">

                            @foreach ($mpk->assesmentAspect as $item)
                                <div id="panelsStayOpen-collapse{{ $mpk->id }}"
                                    class="accordion-collapse collapse text-dark" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul>
                                                    <li>
                                                        <h6> {{ $item->name }} </h6>
                                                        <p class="text-muted" style="font-size: 10pt!important">
                                                            {!! $item->description !!} </p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <input type="hidden" class="form-control" name="subject_id[]"
                                                id="subject_id" placeholder="" value="{{ $mpk->id }}"
                                                style="display: none !important">
                                            <input type="hidden" class="form-control" name="assesment_aspect_id[]"
                                                id="assesment_aspect_id" placeholder="" value="{{ $item->id }}"
                                                style="display: none !important">
                                            @foreach ($item->assessment as $assessment)
                                                @if ($assessment->student_id == $data->id)
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <input type="hidden" class="form-control"
                                                                name="assessment_id[]" value="{{ $assessment->id }}">
                                                            <input type="number" class="form-control" name="score[]"
                                                                id="score" value="{{ $assessment->score }}">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-0">@lang('messages.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
