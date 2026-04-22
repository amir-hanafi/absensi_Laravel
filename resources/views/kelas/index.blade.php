@extends('layout.master')

@section('title','Manajemen Kelas')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h3>Manajemen Kelas</h3>

        <a href="{{ route('kelas.create') }}" class="btn btn-primary">
            Tambah Kelas
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tingkat Kelas</th>
                        <th>Nama Kelas</th>
                        <th>Pembimbing/Wali Kelas</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($kelas as $key => $k)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $k->tingkat_kelas }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->guru->nama ?? '-' }}</td>

                        <td>
                            <a href="{{ route('kelas.show',$k->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('kelas.edit',$k->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('kelas.destroy',$k->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus data ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data</td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection