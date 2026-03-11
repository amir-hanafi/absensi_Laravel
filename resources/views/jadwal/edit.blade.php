
<h1>Edit Jadwal</h1>

<form action="{{ route('jadwal.update',$jadwal->id) }}" method="POST">
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

<label>Guru</label>
<select name="guru_id">
@foreach ($guru as $g)
    <option value="{{ $g->id }}" {{ $jadwal->guru_id == $g->id ? 'selected' : '' }}>
        {{ $g->nama }}
    </option>
@endforeach
</select>

<br><br>

<label>Mata Pelajaran</label>
<select name="matapel_id">
@foreach ($matapel as $m)
    <option value="{{ $m->id }}" {{ $jadwal->matapel_id == $m->id ? 'selected' : '' }}>
        {{ $m->mata_pelajaran }}
    </option>
@endforeach
</select>

<br><br>

<button type="submit">Update</button>

</form>

<br>
<a href="{{ route('jadwal.index') }}">Kembali</a>

