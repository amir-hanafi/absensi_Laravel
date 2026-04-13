@extends('layout.master')

@section('title','Manajemen Poin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Manajemen Poin Siswa</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Poin</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($users as $key => $user)

                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                            <b style="color: {{ $user->point >= 0 ? 'green' : 'red' }}">
                                {{ $user->point }}
                            </b>
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada data poin
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection