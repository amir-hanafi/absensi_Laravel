@extends('layout.master')

@section('title', $title)

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>{{ $title }}</h3>

        <a href="{{ $createRoute }}" class="btn btn-primary">
            Tambah User
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
                        @foreach ($columns as $col)
                            <th>{{ $col }}</th>
                        @endforeach
                        <th width="200">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($data as $key => $item)

                    <tr>
                        <td>{{ $key + 1 }}</td>

                        @foreach ($fields as $field)
                            <td>{{ $item->$field }}</td>
                        @endforeach

                        <td>
                            <a href="{{ route($route.'.show',$item->id) }}"
                               class="btn btn-info btn-sm">Detail</a>

                            <a href="{{ route($route.'.edit',$item->id) }}"
                               class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route($route.'.destroy',$item->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus user ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada data user
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection