@extends('layout.master')

@section('title','Edit Jadwal')

@section('content')

<div class="container-fluid">

    <h3>Edit Jadwal</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('jadwal-sekolah.update',$jadwal_sekolah->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Hari</label>
                    <select name="hari" >
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                            <option {{ $jadwal_sekolah->hari == $hari ? 'selected' : '' }}>
                                {{ $hari }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Jam Ke</label>
                    <input type="number" name="jam_ke"
                           value="{{ $jadwal_sekolah->jam_ke }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Jam Mulai</label>
                    <input type="time" name="jam_mulai"
                           value="{{ $jadwal_sekolah->jam_mulai }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Jam Selesai</label>
                    <input type="time" name="jam_selesai"
                           value="{{ $jadwal_sekolah->jam_selesai }}"
                           class="form-control">
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('jadwal-sekolah.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

@endsection