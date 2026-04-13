

@extends('layout.master')

@section('content')
<div class="container">

<h2>Data Absensi</h2>

<a href="{{ route('absensi.create') }}" class="btn btn-primary mb-3">
    Tambah Absensi
</a>

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($absensis as $i => $a)
    <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $a->user->username }}</td>
        <td>{{ $a->tanggal }}</td>
        <td>{{ $a->status }}</td>
        <td>
            <a href="{{ route('absensi.edit',$a->id) }}"
               class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('absensi.destroy',$a->id) }}"
                  method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $absensis->links() }}

</div>
@endsection