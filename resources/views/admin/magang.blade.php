@extends('layout.admin')

@section('konten')
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">{{ __('messages.manage') }} {{ $title }}</h4>
        </div>
        <div class="col">
            <a href="{{ route('internship.create') }}" class="btn btn-primary float-end">
                <i class="fas fa-plus me-2"></i>{{ __('messages.internship_add') }}
            </a>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6 class="text-black">{{ __('messages.data') }} {{ $title }}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.lecturer_id_number') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.full_name') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.email') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.phone_number') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data) == 0)
                                <tr>
                                    <td colspan="6" class="text-center">
                                            <div class="alert alert-danger bg-gradient-danger" role="alert">
                                                <h6 class="mb-0 text-white">{{ __('messages.no_data') }}</h6>
                                            </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($data as $data)
                                    <tr>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->lecturer['lecturer_id_number'] }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->lecturer['name'] }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->lecturer['email'] }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->lecturer['phone_number'] }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('internship.show', $data->id) }}"
                                                    class="btn btn-link text-info text-gradient px-3 mb-0">
                                                    <i class="fas fa-eye me-2" aria-hidden="true"></i>{{ __('messages.view_details') }}
                                                </a>
                                                <form action="{{ route('internship.destroy', $data->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('{{ __('messages.internship_delete_confirm') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0">
                                                        <i class="far fa-trash-alt me-2" aria-hidden="true"></i>{{ __('messages.delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form'); // Sesuaikan selector dengan form kamu

        if (form) {
            form.addEventListener('submit', function(e) {
                const lecturerSelect = document.querySelector('select[name="lecturer_id"]');
                const studentCheckboxes = document.querySelectorAll(
                    'input[name="student_id[]"]:checked');

                let errors = [];

                // Validasi lecturer
                if (!lecturerSelect || !lecturerSelect.value) {
                    errors.push('Dosen pembimbing harus dipilih!');
                }

                // Validasi student
                if (studentCheckboxes.length === 0) {
                    errors.push('Minimal satu mahasiswa harus dipilih!');
                }

                if (errors.length > 0) {
                    e.preventDefault();
                    alert(errors.join(
                        '\n')); // Simple alert, bisa diganti dengan SweetAlert jika sudah ada
                    return false;
                }
            });
        }
    });
</script>
