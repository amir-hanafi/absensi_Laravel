@extends('layout.master')

@section('content')
<div class="container">

<h2>Edit Absensi</h2>

<form action="{{ route('absensi.update',$absensi->id) }}" method="POST">
@csrf
@method('PUT')

<select name="user_id" class="form-control">
@foreach($users as $u)
<option value="{{ $u->id }}"
    {{ $absensi->user_id == $u->id ? 'selected':'' }}>
    {{ $u->name }}
</option>
@endforeach
</select>

<input type="date" name="tanggal"
value="{{ $absensi->tanggal }}"
class="form-control">

<select name="status" class="form-control">
@foreach(['Hadir','Sakit','Ijin','Alpha'] as $s)
<option {{ $absensi->status==$s?'selected':'' }}>
{{ $s }}
</option>
@endforeach
</select>

<br>
<button class="btn btn-primary">Update</button>

</form>
</div>
@endsection