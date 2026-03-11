@extends('layout.master')

@section('content')
    <div class="container">

        <h3>Tambah Kategori Penilaian</h3>

        <form action="{{ route('assessment-categories.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Type / Role</label>

                <select name="type" required>

                    <option value="">-- Pilih Role --</option>

                    <option value="siswa">Siswa</option>
                  

                </select>

            </div>

            <div class="mb-3">
                <label>Status</label>
                <br>
                <input type="checkbox" name="is_active" value="1" checked> Aktif
            </div>

            <button class="btn btn-success">
                Simpan
            </button>

            <a href="{{ route('assessment-categories.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
@endsection
