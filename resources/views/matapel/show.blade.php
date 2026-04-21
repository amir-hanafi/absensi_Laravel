@extends('layout.master')

@section('title','Detail Mata Pelajaran')

@section('content')

<div class="container-fluid">

    <h3>Detail Mata Pelajaran</h3>

    <div class="card">
        <div class="card-body">

            <p><b>Mata Pelajaran:</b> {{ $matapel->mata_pelajaran }}</p>

            <a href="{{ route('matapel.index') }}" class="btn btn-secondary">Kembali</a>

        </div>
    </div>

</div>

@endsection