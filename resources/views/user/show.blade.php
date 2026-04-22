@extends('layout.master')

@section('title','Detail User')

@section('content')

<div class="container-fluid">

    <h3>Detail User</h3>

    <div class="card">
        <div class="card-body">

            <p><b>Username:</b> {{ $user->username }}</p>
            <p><b>Role:</b> {{ strtoupper($user->role) }}</p>

            <hr>

            {{-- ===================== --}}
            {{-- DATA GURU --}}
            {{-- ===================== --}}
            @if($user->role == 'guru' && $user->guru)
                <h5>Data Guru</h5>

                <p><b>Kode Guru:</b> {{ $user->guru->kode_guru }}</p>
                <p><b>Nama:</b> {{ $user->guru->nama }}</p>
                <p><b>No HP:</b> {{ $user->guru->no_hp }}</p>
            @endif


            {{-- ===================== --}}
            {{-- DATA SISWA --}}
            {{-- ===================== --}}
            @if($user->role == 'siswa' && $user->siswa)
                <h5>Data Siswa</h5>

                <p><b>NIS:</b> {{ $user->siswa->nis }}</p>
                <p><b>Nama:</b> {{ $user->siswa->nama }}</p>
                <p><b>Tahun Masuk:</b> {{ $user->siswa->tahun_masuk }}</p>
                <p><b>Status:</b> {{ $user->siswa->status }}</p>

                <p><b>Kelas:</b>
                    {{ $user->siswa->kelas->nama ?? '-' }}
                </p>
            @endif


            {{-- ===================== --}}
            {{-- ADMIN --}}
            {{-- ===================== --}}
            @if($user->role == 'admin')
                <h5>Admin</h5>
                <p>User ini adalah administrator sistem.</p>
            @endif


            <a href="{{ route('user.index') }}" class="btn btn-secondary mt-3">Kembali</a>

        </div>
    </div>

</div>

@endsection