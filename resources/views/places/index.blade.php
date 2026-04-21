@extends('layout.master')

@section('title','Manajemen Lokasi Absensi')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Manajemen Lokasi</h3>

        <a href="{{ route('places.create') }}" class="btn btn-primary">
            Tambah Lokasi
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
                        <th>Nama</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Radius (m)</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($places as $key => $p)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->latitude }}</td>
                        <td>{{ $p->longitude }}</td>
                        <td>{{ $p->allowed_radius }}</td>

                        <td>
                            <a href="{{ route('places.show',$p->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('places.edit',$p->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('places.destroy',$p->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus lokasi ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection