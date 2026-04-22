blade
@extends('layout.master')

@section('title', 'Manajemen Jadwal')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Manajemen Jadwal</h3>

            <a href="{{ route('jadwal.create') }}" class="btn btn-primary">
                Tambah Jadwal
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Jam Ke</th> {{-- 🔥 TAMBAHAN --}}
                            <th>Jam mulai - Jam selesai</th>
                            <th>Kelas</th>
                            <th>Guru</th>
                            <th>Mapel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($data as $j)
                            <tr>

                                <td>{{ $j->jadwalSekolah->hari }}</td>
                                <td>{{ $j->jadwalSekolah->jam_ke }}</td>
                                <td>
                                    {{ $j->jadwalSekolah->jam_mulai }} -
                                    {{ $j->jadwalSekolah->jam_selesai }}
                                </td>
                                <td>{{ $j->kelas->nama_kelas }}</td>
                                <td>{{ $j->guru->nama }}</td>
                                <td>{{ $j->matapel->mata_pelajaran }}</td>

                                <td>

                                    <a href="{{ route('jadwal.show', $j->id) }}" class="btn btn-info btn-sm">
                                        Detail
                                    </a>

                                    <a href="{{ route('jadwal.edit', $j->id) }}" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST"
                                        style="display:inline;">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal ini?')">
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center">
                                    Belum ada data jadwal
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

    </div>



@endsection
