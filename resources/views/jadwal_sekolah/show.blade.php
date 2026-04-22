@extends('layout.master')

@section('title','Detail Jadwal')

@section('content')

<div class="container-fluid">

    <h3>Detail Jadwal</h3>

    <div class="card">
        <div class="card-body">

            <p><b>Hari:</b> {{ $jadwal_sekolah->hari }}</p>
            <p><b>Jam Ke:</b> {{ $jadwal_sekolah->jam_ke }}</p>
            <p><b>Mulai:</b> {{ $jadwal_sekolah->jam_mulai }}</p>
            <p><b>Selesai:</b> {{ $jadwal_sekolah->jam_selesai }}</p>

            <a href="{{ route('jadwal-sekolah.index') }}" class="btn btn-secondary">Kembali</a>

        </div>
    </div>

</div>

@endsection