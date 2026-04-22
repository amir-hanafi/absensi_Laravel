@extends('layout.master')

@section('title','Detail Kelas')

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

</div>

@endsection