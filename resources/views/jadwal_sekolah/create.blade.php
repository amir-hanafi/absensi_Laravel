@extends('layout.master')

@section('title','Tambah Jadwal')

@section('content')

<div class="container-fluid">

    <h3>Tambah Jadwal</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('jadwal-sekolah.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Hari</label>
                    <select name="hari" >
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Jam Ke</label>
                    <input type="number" name="jam_ke" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control">
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('jadwal-sekolah.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

@endsection