<h1>Edit Jadwal</h1>

<form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Hari</label>
    <select name="hari">
        <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
        <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
        <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
        <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
        <option value="Jumat" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
    </select>

    <br><br>

    <label>Jam Ke</label>
    <input type="number" name="jam_ke" value="{{ $jadwal->jam_ke }}">

    <br><br>

    <label>Kelas</label>
    <select name="kelas_id">
        @foreach ($kelas as $k)
            <option value="{{ $k->id }}" {{ $jadwal->kelas_id == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kelas }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Mata Pelajaran</label>
    <select name="matapel_id" id="matapel">
        <option value="">-- pilih mapel --</option>
        @foreach ($matapel as $m)
            <option value="{{ $m->id }}" {{ $jadwal->matapel_id == $m->id ? 'selected' : '' }}>
                {{ $m->mata_pelajaran }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Guru</label>
    <select name="guru_id" id="guru">
        <option value="">-- pilih guru --</option>
    </select>

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
