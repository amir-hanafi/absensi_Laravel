@extends('layout.master')

@section('title', 'Edit User')

@section('content')

<div class="container-fluid">

    <h3>Edit User</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- USER --}}
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" id="role" disabled>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                    <label style="font-size: small">  tidak bisa ganti role, harap buat akun baru</label>
                </div>

                {{-- FORM GURU --}}
                <div id="formGuru" style="display:none;">
                    <hr>
                    <h5>Data Guru</h5>

                    <div class="mb-2">
                        <label>No HP</label>
                        <input type="text" name="no_hp"
                            value="{{ old('no_hp', $user->guru->no_hp ?? '') }}"
                            class="form-control">
                    </div>
                </div>

                {{-- FORM SISWA --}}
                <div id="formSiswa" style="display:none;">
                    <hr>
                    <h5>Data Siswa</h5>

                    <div class="mb-2">
                        <label>Kelas</label>
                        <select name="kelas_id" >
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}"
                                    {{ old('kelas_id', $user->siswa->kelas_id ?? '') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const roleSelect = document.getElementById('role');
    const formGuru = document.getElementById('formGuru');
    const formSiswa = document.getElementById('formSiswa');

    function toggleForm() {
        let role = roleSelect.value;

        formGuru.style.display = (role === 'guru') ? 'block' : 'none';
        formSiswa.style.display = (role === 'siswa') ? 'block' : 'none';
    }

    // saat pertama load (penting untuk edit)
    toggleForm();

    roleSelect.addEventListener('change', toggleForm);
});
</script>

@endsection