<h1>Detail Jadwal</h1>

<p><b>Hari:</b> {{ $jadwal->hari }}</p>
<p><b>Jam Ke:</b> {{ $jadwal->jam_ke }}</p>
<p><b>Kelas:</b> {{ $jadwal->kelas->nama_kelas ?? '-' }}</p>
<p><b>Guru:</b> {{ $jadwal->guru->nama ?? '-' }}</p>
<p><b>Mata Pelajaran:</b> {{ $jadwal->matapel->mata_pelajaran ?? '-' }}</p>

<a href="{{ route('jadwal.index') }}">Kembali</a>

