<h1>Tambah Jadwal</h1>

<form action="{{ route('jadwal.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Jadwal (Hari & Jam)</label>
        <select name="jadwal_sekolah_id" class="form-control" required>
            <option value="">-- Pilih Jadwal --</option>

            @foreach ($jadwalSekolah as $js)
                <option value="{{ $js->id }}"
                    {{ old('jadwal_sekolah_id', $jadwal->jadwal_sekolah_id ?? '') == $js->id ? 'selected' : '' }}>

                    {{ $js->hari }} - Jam ke {{ $js->jam_ke }}
                    ({{ $js->jam_mulai }} - {{ $js->jam_selesai }})
                </option>
            @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label>Kelas</label>
        <select name="kelas_id" class="form-control" required>
            <option value="">-- Pilih Kelas --</option>

            @foreach ($kelas as $k)
                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Mata Pelajaran</label>
        <select name="matapel_id" id="matapel" class="form-control">
            @foreach ($mapel as $m)
                <option value="{{ $m->id }}">{{ $m->mata_pelajaran }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Guru</label>
        <select name="guru_id" id="guru" class="form-control">
            @foreach ($guru as $g)
                <option value="{{ $g->id }}">{{ $g->nama }}</option>
            @endforeach
        </select>
    </div>

    

    <br><br>

    <button type="submit">Simpan</button>

    @if (session('error_jadwal'))
        <div style="color: red; margin-top: 10px;">
            {{ session('error_jadwal') }}
        </div>
    @endif


</form>

<br>
<a href="{{ route('jadwal.index') }}">Kembali</a>



<script>
    document.getElementById('matapel').addEventListener('change', function() {

        let matapelId = this.value;
        let guruSelect = document.getElementById('guru');

        guruSelect.innerHTML = '<option>Loading...</option>';

        fetch('/get-guru-by-matapel/' + matapelId)
            .then(response => response.json())
            .then(data => {

                guruSelect.innerHTML = '<option value="">-- pilih guru --</option>';

                data.forEach(guru => {
                    guruSelect.innerHTML += `
                    <option value="${guru.id}">
                        ${guru.nama}
                    </option>
                `;
                });

            });
    });
</script>

<script>
    function loadGuru() {

        let matapel = document.getElementById('matapel').value;
        let jadwalSekolah = document.getElementById('jadwal_sekolah').value;
        let guruSelect = document.getElementById('guru');

        if (!matapel || !jadwalSekolah) return;

        guruSelect.innerHTML = '<option>Loading...</option>';

        fetch(`/get-guru-available?matapel_id=${matapel}&jadwal_sekolah_id=${jadwalSekolah}`)
            .then(res => res.json())
            .then(data => {

                guruSelect.innerHTML = '<option value="">-- pilih guru --</option>';

                if (data.length === 0) {
                    guruSelect.innerHTML = '<option>Tidak ada guru tersedia</option>';
                }

                data.forEach(guru => {
                    guruSelect.innerHTML += `
                    <option value="${guru.id}">
                        ${guru.nama}
                    </option>
                `;
                });

            });
    }

    // trigger
    document.getElementById('matapel').addEventListener('change', loadGuru);
    document.getElementById('jadwal_sekolah').addEventListener('change', loadGuru);
</script>
