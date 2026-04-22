<h1>Tambah Jadwal</h1>

<form action="{{ route('jadwal.store') }}" method="POST">
    @csrf

    <label>Hari</label>
    <select name="hari">
        <option value="Senin">Senin</option>
        <option value="Selasa">Selasa</option>
        <option value="Rabu">Rabu</option>
        <option value="Kamis">Kamis</option>
        <option value="Jumat">Jumat</option>
    </select>

    <label>Jam Ke</label>
    <input type="number" name="jam_ke"><br><br>

    <label>Kelas</label>
    <select name="kelas_id">
        @foreach ($kelas as $k)
            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
        @endforeach
    </select><br><br>

    <label>Mata Pelajaran</label>
    <select name="matapel_id" id="matapel">
        <option value="">-- pilih mapel --</option>
        @foreach ($matapel as $m)
            <option value="{{ $m->id }}">{{ $m->mata_pelajaran }}</option>
        @endforeach
    </select>

    <br><br>

    <label>Guru</label>
    <select name="guru_id" id="guru">
        <option value="">-- pilih guru --</option>
    </select>

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
        let hari = document.querySelector('[name="hari"]').value;
        let jam_ke = document.querySelector('[name="jam_ke"]').value;
        let guruSelect = document.getElementById('guru');

        if (!matapel || !hari || !jam_ke) return;

        guruSelect.innerHTML = '<option>Loading...</option>';

        fetch(`/get-guru-available?matapel_id=${matapel}&hari=${hari}&jam_ke=${jam_ke}`)
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

    // trigger semua
    document.getElementById('matapel').addEventListener('change', loadGuru);
    document.querySelector('[name="hari"]').addEventListener('change', loadGuru);
    document.querySelector('[name="jam_ke"]').addEventListener('input', loadGuru);
</script>
