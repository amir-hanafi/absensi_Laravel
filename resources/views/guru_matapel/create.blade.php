@extends('layout.master')

@section('content')

<div class="container-fluid">

    <h3>Tambah Relasi</h3>

    <form action="{{ route('guru-matapel.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Guru</label>
            <select name="guru_id" >
                @foreach($guru as $g)
                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Mata Pelajaran</label>
            <select name="matapel_id" >
                @foreach($matapel as $m)
                    <option value="{{ $m->id }}">{{ $m->mata_pelajaran }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('guru-matapel.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>

@endsection