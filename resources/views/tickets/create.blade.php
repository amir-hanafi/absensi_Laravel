@extends('layout.master')

@section('title', 'Tambah Ticket')

@section('content')

<div class="container-fluid">

    <h3>Tambah Ticket</h3>

    {{-- 🔥 ALERT DI ATAS --}}
    @if (session('similar'))
        <div class="alert alert-warning">
            <b>Aduan serupa ditemukan:</b>

            <ul>
                @foreach (session('similar') as $ticket)
                    <li>
                        <b>{{ $ticket->subject }}</b><br>
                        <small>{{ $ticket->description }}</small>
                    </li>
                @endforeach
            </ul>

            <p>Silakan cek dulu sebelum membuat tiket baru.</p>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf

                <div class="mb-2">
                    <label>Subject</label>
                    <input type="text" name="subject" class="form-control"
                           value="{{ old('subject') }}">
                </div>

                <div class="mb-2">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="mb-2">
                    <label>Kategori</label>
                    <select name="category_id" >
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <label>Priority</label>
                    <select name="priority" >
                        <option value="low" {{ old('priority')=='low'?'selected':'' }}>Low</option>
                        <option value="mid" {{ old('priority')=='mid'?'selected':'' }}>Mid</option>
                        <option value="high" {{ old('priority')=='high'?'selected':'' }}>High</option>
                    </select>
                </div>

                {{-- 🔥 tombol normal --}}
                <button type="submit" class="btn btn-primary">Simpan</button>

                {{-- 🔥 hanya muncul kalau ada duplikasi --}}
                @if (session('similar'))
                    <button type="submit" name="force" value="1" class="btn btn-danger">
                        Tetap Kirim
                    </button>
                @endif

                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

@endsection