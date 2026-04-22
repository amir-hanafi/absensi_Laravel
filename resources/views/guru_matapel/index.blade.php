@extends('layout.master')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h3>Guru - Mata Pelajaran</h3>

        <a href="{{ route('guru-matapel.create') }}" class="btn btn-primary">
            Tambah Relasi
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Guru</th>
                <th>Mata Pelajaran</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $key => $d)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $d->guru_nama }}</td>
                <td>{{ $d->matapel_nama }}</td>
                <td>
                    <a href="{{ route('guru-matapel.edit',$d->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('guru-matapel.destroy',$d->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection