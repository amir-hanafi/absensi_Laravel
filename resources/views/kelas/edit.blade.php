@extends('layout.master')

@section('title','Edit Kelas')

@section('content')

<div class="container-fluid">

    <h3>Edit Kelas</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('kelas.update',$kelas->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama Kelas</label>
                    <input type="text" name="nama_kelas"
                           value="{{ $kelas->nama_kelas }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Guru</label>
                    <select name="guru_id" >
                        @foreach ($gurus as $g)
                            <option value="{{ $g->id }}"
                                {{ $kelas->guru_id == $g->id ? 'selected' : '' }}>
                                {{ $g->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

@endsection