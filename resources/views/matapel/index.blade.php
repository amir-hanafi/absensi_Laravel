@extends('layout.master')

@section('title', $title)

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>{{ $title }}</h3>

        <a href="{{ $createRoute }}" class="btn btn-primary">
            Tambah Mata Pelajaran
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
                        <th>Mata Pelajaran</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($data as $key => $item)

                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->mata_pelajaran }}</td>

                        <td>
                            <a href="{{ route('matapel.show',$item->id) }}"
                               class="btn btn-info btn-sm">Detail</a>

                            <a href="{{ route('matapel.edit',$item->id) }}"
                               class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('matapel.destroy',$item->id) }}"
                                  method="POST"
                                  style="display:inline;">
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
                        <td colspan="3" class="text-center">
                            Belum ada data
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection