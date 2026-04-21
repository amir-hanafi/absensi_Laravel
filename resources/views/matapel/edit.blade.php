@extends('layout.master')

@section('title','Edit Mata Pelajaran')

@section('content')

<div class="container-fluid">

    <h3>Edit Mata Pelajaran</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('matapel.update',$matapel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Mata Pelajaran</label>
                    <input type="text" name="mata_pelajaran"
                           value="{{ $matapel->mata_pelajaran }}"
                           class="form-control" required>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('matapel.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

@endsection