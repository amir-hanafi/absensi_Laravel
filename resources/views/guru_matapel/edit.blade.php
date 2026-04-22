@extends('layout.master')

@section('content')

<div class="container-fluid">

    <h3>Edit Relasi</h3>

    <form action="{{ route('guru-matapel.update',$data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Guru</label>
            <select name="guru_id" >
                @foreach($guru as $g)
                    <option value="{{ $g->id }}" {{ $data->guru_id == $g->id ? 'selected' : '' }}>
                        {{ $g->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Mata Pelajaran</label>
            <select name="matapel_id" >
                @foreach($matapel as $m)
                    <option value="{{ $m->id }}" {{ $data->matapel_id == $m->id ? 'selected' : '' }}>
                        {{ $m->mata_pelajaran }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('guru-matapel.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>

@endsection