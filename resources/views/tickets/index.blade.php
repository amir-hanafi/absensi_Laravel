@extends('layout.master')

@section('title','Manajemen Ticket')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h3>Manajemen Ticket</h3>

        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            Tambah Ticket
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
                        <th>Subject</th>
                        <th>Status</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($data as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->subject }}</td>
                        <td>{{ $item->status }}</td>

                        <td>
                            <a href="{{ route('tickets.show',$item->id) }}"
                               class="btn btn-info btn-sm">Detail</a>

                            
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