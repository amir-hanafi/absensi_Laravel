<h1>Edit Jadwal</h1>

<form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
    @csrf
    @method('PUT')

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

    <br><br>

    <div class="mb-3">
        <label>Kelas</label>
        <select name="kelas_id" class="form-control">
            @foreach ($kelas as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Guru</label>
        <select name="guru_id" class="form-control">
            @foreach ($guru as $g)
                <option value="{{ $g->id }}">{{ $g->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Mata Pelajaran</label>
        <select name="matapel_id" class="form-control">
            @foreach ($mapel as $m)
                <option value="{{ $m->id }}">{{ $m->mata_pelajaran }}</option>
            @endforeach
        </select>
    </div>

    <br><br>

    <button type="submit">Update</button>

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
    document.addEventListener('DOMContentLoaded', function() {

        function loadGuru(selectedGuruId = null) {

            let matapel = document.getElementById('matapel').value;
            let hari = document.querySelector('[name="hari"]').value;
            let jam_ke = document.querySelector('[name="jam_ke"]').value;
            let guruSelect = document.getElementById('guru');

            if (!matapel || !hari || !jam_ke) return;

            guruSelect.innerHTML = '<option>Loading...</option>';

            fetch(`/get-guru-available?matapel_id=${matapel}&hari=${hari}&jam_ke=${jam_ke}`)
                .then(res => res.json())
                .then(data => {

                    guruSelect.innerHTML = '<option value="">-- pilih guru --</option>';

                    data.forEach(guru => {

                        let selected = (guru.id == selectedGuruId) ? 'selected' : '';

                        guruSelect.innerHTML += `
                        <option value="${guru.id}" ${selected}>
                            ${guru.nama}
                        </option>
                    `;
                    });

                });
        }

        // 🔥 load pertama kali (biar langsung muncul)
        loadGuru({{ $jadwal->guru_id }});

        // trigger perubahan
        document.getElementById('matapel').addEventListener('change', () => loadGuru());
        document.querySelector('[name="hari"]').addEventListener('change', () => loadGuru());
        document.querySelector('[name="jam_ke"]').addEventListener('input', () => loadGuru());

    });
</script>
