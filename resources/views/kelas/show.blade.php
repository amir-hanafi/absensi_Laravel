@extends('layout.master')

@section('title', 'Detail Kelas')

@section('content')

    <div class="container-fluid">

        <h3>Detail Kelas</h3>

        <div class="card">
            <div class="card-body">

                <p><b>Nama Kelas:</b> {{ $kelas->nama_kelas }}</p>
                <p><b>Guru:</b> {{ $kelas->guru->nama ?? '-' }}</p>

                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>

            </div>
        </div>

        <hr>

        <h5>Daftar Siswa</h5>

        @if ($kelas->siswa->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelas->siswa as $index => $siswa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Belum ada siswa di kelas ini</p>
        @endif

    </div>

@endsection
