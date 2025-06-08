@extends('layout.print')

@section('konten')
    <main>
        <div class="container" style="margin: 0 16px 0 0;">
            <h3 style="text-align: center">Data Penilaian Mahasiswa</h3>
            <hr>
        </div>
        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col" style="width: 2%;">No.</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mahasiswa</th>
                        <th scope="col">MPK1</th>
                        <th scope="col">MPK2</th>
                        <th scope="col">MPK3</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr class="">
                            <td style="width: 2%"> {{ $key + 1 }} </td>
                            <td scope="row"> {{ $item->registration_number }} </td>
                            <td scope="row"> {{ $item->name }} </td>
                            <td scope="row"> {{ $item->matakuliah1 }} </td>
                            <td scope="row"> {{ $item->matakuliah2 }} </td>
                            <td scope="row"> {{ $item->matakuliah3 }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
