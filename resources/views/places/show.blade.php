@extends('layout.master')

@section('title','Detail Lokasi')

@section('content')

<div class="container-fluid">

    <h3>Detail Lokasi</h3>

    <div class="card">
        <div class="card-body">

            <p><b>Nama:</b> {{ $place->name }}</p>
            <p><b>Latitude:</b> {{ $place->latitude }}</p>
            <p><b>Longitude:</b> {{ $place->longitude }}</p>
            <p><b>Radius:</b> {{ $place->allowed_radius }} meter</p>

            <a href="{{ route('places.index') }}" class="btn btn-secondary">Kembali</a>

        </div>
    </div>

</div>

@endsection