@php
    use App\Helpers\CustomHelper;
    $customHelper = new CustomHelper();
    
@endphp


@extends('layout.print')

@section('konten')
    <main>
        <div class="container" style="margin: 0 16px 0 0;">
            <h3 style="text-align: center">Data Absensi Mahasiswa</h3>
            <hr>
        </div>
        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col" style="width: 2%;">No.</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Jam Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr class="">
                            <td style="width: 2%"> {{ $key + 1 }} </td>
                            <td scope="row"> {{ $customHelper->convertDate($item->tanggal) }} </td>
                            <td scope="row"> {{ $item->is_masuk }} </td>
                            <td scope="row"> {{ $item->is_keluar }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
