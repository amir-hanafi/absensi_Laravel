@extends('layout.master')

@section('content')

<div class="container">

<h3>Daftar Laporan Penilaian</h3>


<table class="table">
<tr>
<th>Nama</th>
<th>NIS</th>
<th>Kelas</th>
<th>Aksi</th>
</tr>

@foreach($siswa as $s)

<tr>
<td>{{ $s->nama }}</td>
<td>{{ $s->nis }}</td>
<td>{{ $s->kelas->nama_kelas }}</td>

<td>
<a href="{{ url('/laporan/'.$s->id) }}" class="btn btn-info">
Lihat Laporan
</a>
</td>

</tr>

@endforeach

</table>

</div>

@endsection