@extends('layout.master')

@section('content')

<div class="container">

<h3>Edit Kategori Penilaian</h3>

<form action="{{ route('assessment-categories.update', $assessmentCategory->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label>Nama</label>
<input 
type="text" 
name="name" 
class="form-control" 
value="{{ $assessmentCategory->name }}" 
required>
</div>

<div class="mb-3">
<label>Deskripsi</label>
<textarea name="description" class="form-control">{{ $assessmentCategory->description }}</textarea>
</div>

<div class="mb-3">
<label>Type / Role</label>

<select name="type">

<option value="siswa" {{ $assessmentCategory->type == 'siswa' ? 'selected' : '' }}>
Siswa
</option>


</select>

</div>

<div class="mb-3">
<label>Status</label>
<br>

<input 
type="checkbox" 
name="is_active" 
value="1"
{{ $assessmentCategory->is_active ? 'checked' : '' }}>
Aktif

</div>

<button class="btn btn-primary">
Update
</button>

<a href="{{ route('assessment-categories.index') }}"
class="btn btn-secondary">
Kembali
</a>

</form>

</div>

@endsection