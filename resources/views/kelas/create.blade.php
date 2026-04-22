@extends('layout.master')

@section('title','Tambah Kelas')

@section('content')

<div class="container-fluid">

    <h3>Tambah Kelas</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Guru</label>
                    <select name="guru_id"  required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach ($gurus as $g)
                            <option value="{{ $g->id }}">{{ $g->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

@endsection