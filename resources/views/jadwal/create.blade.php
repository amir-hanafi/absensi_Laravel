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

    <label>Guru</label>
    <select name="guru_id">
        @foreach ($guru as $g)
            <option value="{{ $g->id }}">{{ $g->nama }}</option>
        @endforeach
    </select><br><br>

    <label>Mata Pelajaran</label>
    <select name="matapel_id">
        @foreach ($matapel as $m)
            <option value="{{ $m->id }}">{{ $m->mata_pelajaran }}</option>
        @endforeach
    </select><br><br>

    <button type="submit">Simpan</button>

</form>

<br>
<a href="{{ route('jadwal.index') }}">Kembali</a>
