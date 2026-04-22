@extends('layout.master')

@section('content')
    <div class="container">
        <h3>Daftar Siswa</h3>

        <div class="alert alert-info">

            Siswa yang sudah dinilai bulan ini :

            <strong>{{ $sudahDinilai }}/{{ $totalSiswa }}</strong>

        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($siswa as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nis }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kelas->nama_kelas }}</td>
                        <td>{{ $item->kelas->guru->nama }}</td>

                        <td>
                            <a href="/penilaian/{{ $item->id }}" class="btn btn-primary btn-sm">
                                Nilai
                            </a>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
@endsection
