@extends('layout.master')

@section('content')

    <div class="container">

        <h3 class="mb-4">Laporan Penilaian Siswa</h3>

        <div class="card mb-4">
            <div class="card-body">

                <h5>{{ $siswa->nama }}</h5>
                <p>
                    NIS : {{ $siswa->nis }} <br>
                    Kelas : {{ $siswa->kelas->nama_kelas }}
                </p>

            </div>
        </div>

        {{-- FILTER --}}
        <form method="GET" class="mb-4">
            <select name="periode" onchange="this.form.submit()">

                <option value="">Semua Periode</option>

                <option value="harian" {{ request('periode') == 'harian' ? 'selected' : '' }}>
                    Harian
                </option>

                <option value="mingguan" {{ request('periode') == 'mingguan' ? 'selected' : '' }}>
                    Mingguan
                </option>

                <option value="bulanan" {{ request('periode') == 'bulanan' ? 'selected' : '' }}>
                    Bulanan
                </option>

            </select>
        </form>

        {{-- RADAR CHART --}}
        <div class="card mb-4">

            <div class="card-header">
                Grafik Penilaian Siswa
            </div>

            <div class="card-body">

                <div style="max-width:300px; margin:auto;">
                    <canvas id="radarChart"></canvas>
                </div>

            </div>

        </div>

        {{-- DATA PENILAIAN --}}
        @forelse($assessments as $assessment)
            <div class="card mb-4">

                <div class="card-header bg-light">

                    <strong>Periode :</strong> {{ $assessment->period }} <br>

                    <small>
                        Tanggal Penilaian :
                        {{ $assessment->assessment_date->format('d M Y') }}
                    </small>

                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tr>
                            <th>Indikator</th>
                            <th>Nilai</th>
                        </tr>

                        @foreach ($assessment->details as $detail)
                            <tr>
                                <td>{{ $detail->category->name }}</td>

                                <td>

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $detail->score)
                                            <span style="color:gold">★</span>
                                        @else
                                            <span style="color:#ccc">★</span>
                                        @endif
                                    @endfor

                                </td>

                            </tr>
                        @endforeach

                    </table>
                    @if ($assessment->general_notes)
                        <div class="alert alert-secondary mt-3">
                            <strong>Catatan Guru :</strong><br>
                            {{ $assessment->general_notes }}
                        </div>
                    @endif
                </div>

            </div>

        @empty

            <div class="alert alert-warning">
                Belum ada data penilaian
            </div>
        @endforelse

    </div>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const labels = @json($labels);
            const scores = @json($scores);

            const ctx = document.getElementById('radarChart');

            if (ctx) {

                new Chart(ctx, {

                    type: 'radar',

                    data: {

                        labels: labels,

                        datasets: [{

                            label: 'Nilai Siswa',

                            data: scores,

                            backgroundColor: 'rgba(54,162,235,0.2)',

                            borderColor: 'rgb(54,162,235)',
                            borderWidth: 2

                        }]

                    },

                    options: {

                        responsive: true,

                        scales: {

                            r: {

                                min: 0,
                                max: 5,

                                ticks: {
                                    stepSize: 1
                                }

                            }

                        }

                    }

                });

            }

        });
    </script>

@endsection
