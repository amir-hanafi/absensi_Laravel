@extends('layout.master')

@section('title','Tambah Mata Pelajaran')

@section('content')

<div class="container-fluid">

    <h3>Tambah Mata Pelajaran</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('matapel.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Mata Pelajaran</label>
                    <input type="text" name="mata_pelajaran"
                           class="form-control"
                           value="{{ old('mata_pelajaran') }}"
                           required>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('matapel.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

@endsection