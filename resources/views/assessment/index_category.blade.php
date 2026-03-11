@extends('layout.master')

@section('content')

<div class="container">

<h3 class="mb-4">Kategori Penilaian</h3>

<a href="{{ route('assessment-categories.create') }}" class="btn btn-primary mb-3">
Tambah Kategori
</a>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<table class="table table-bordered">

<tr>
<th>No</th>
<th>Nama</th>
<th>Deskripsi</th>
<th>Type</th>
<th>Status</th>
<th width="200">Aksi</th>
</tr>

@foreach($categories as $category)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $category->name }}</td>

<td>{{ $category->description }}</td>

<td>{{ $category->type }}</td>

<td>
@if($category->is_active)
<span class="badge bg-success">Aktif</span>
@else
<span class="badge bg-secondary">Nonaktif</span>
@endif
</td>

<td>

<a href="{{ route('assessment-categories.edit',$category->id) }}"
class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('assessment-categories.destroy',$category->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('Hapus kategori?')">
Hapus
</button>

</form>

</td>

</tr>

@endforeach

</table>

{{ $categories->links() }}

</div>

@endsection