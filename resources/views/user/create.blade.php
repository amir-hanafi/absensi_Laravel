@extends('layout.master')

@section('title', 'Tambah User')

@section('content')

    <div class="container-fluid">

        <h3>Tambah User</h3>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('user.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ old('username') }}">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" id="role">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        </select>
                    </div>

                    {{-- FORM GURU --}}
                    <div id="formGuru" style="display:none;">
                        <hr>
                        <h5>Data Guru</h5>


                        <input type="text" name="no_hp" class="form-control mb-2" placeholder="No HP">
                    </div>

                    {{-- FORM SISWA --}}
                    <div id="formSiswa" style="display:none;">
                        <hr>
                        <h5>Data Siswa</h5>

                        {{-- Tahun Masuk --}}
                        <div class="mb-2">
                            <label>Tahun Masuk</label>
                            <select name="tahun_masuk" >
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Kelas Dinamis --}}
                        <div class="mb-2">
                            <label>Kelas</label>
                            <select name="kelas_id">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary">Simpan</button>
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

            // saat pertama load
            toggleForm();

            // saat berubah
            roleSelect.addEventListener('change', toggleForm);

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const tahunInput = document.getElementById('tahun_masuk');
            const kelasSelect = document.getElementById('kelas');

            if (!tahunInput) return;

            tahunInput.addEventListener('input', function() {

                let tahunMasuk = this.value;
                let tahunSekarang = new Date().getFullYear();

                if (!tahunMasuk) return;

                let tingkat = (tahunSekarang - tahunMasuk) + 10;

                // validasi sederhana
                if (tingkat < 10 || tingkat > 12) {
                    kelasSelect.innerHTML = '<option>Tingkat tidak valid</option>';
                    return;
                }

                kelasSelect.innerHTML = '<option>Loading...</option>';


            });

        });
    </script>

@endsection
