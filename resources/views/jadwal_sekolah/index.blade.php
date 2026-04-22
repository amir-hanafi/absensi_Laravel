@extends('layout.master')

@section('title','Jadwal Sekolah')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h3>Jadwal Sekolah</h3>

        <a href="{{ route('jadwal-sekolah.create') }}" class="btn btn-primary">
            Tambah Jadwal
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
                        <th>Hari</th>
                        <th>Jam Ke</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $key => $j)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $j->hari }}</td>
                        <td>{{ $j->jam_ke }}</td>
                        <td>{{ $j->jam_mulai }}</td>
                        <td>{{ $j->jam_selesai }}</td>

                        <td>
                            <a href="{{ route('jadwal-sekolah.show',$j->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('jadwal-sekolah.edit',$j->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('jadwal-sekolah.destroy',$j->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus jadwal ini?')">
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