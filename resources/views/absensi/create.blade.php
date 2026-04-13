<style>
/* ===== Custom Select Style ===== */

.custom-select {
    width: 100%;
    padding: 10px 12px;
    font-size: 14px;

    border: 1px solid #ccc;
    border-radius: 6px;

    background-color: #fff;
    color: #333;

    outline: none;
    cursor: pointer;

    transition: all 0.2s ease;
}

/* hover */
.custom-select:hover {
    border-color: #888;
}

/* focus */
.custom-select:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 4px rgba(76, 175, 80, 0.4);
}

/* option text */
.custom-select option {
    color: #000;
    background: #fff;
}

</style>

@extends('layout.master')

@section('content')
<div class="container">

<h2>Tambah Absensi</h2>

<form action="{{ route('absensi.store') }}" method="POST">
@csrf

<label>Siswa</label>
<select name="user_id" class="custom-select">
@foreach($users as $u)
<option value="{{ $u->id }}">{{ $u->username }}</option>
@endforeach
</select>

<label>Tanggal</label>
<input type="date" name="tanggal" class="form-control">

<label>Status</label>
<select name="status" class="custom-select">
    <option>Hadir</option>
    <option>Sakit</option>
    <option>Ijin</option>
    <option>Alpha</option>
</select>

<br>
<button class="btn btn-success">Simpan</button>

</form>
</div>
@endsection