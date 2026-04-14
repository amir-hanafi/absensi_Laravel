@extends('layout.master')

@section('title', 'Leaderboard Poin')

@section('content')

<div class="container-fluid">

    <h3 class="mb-3">🏆 Leaderboard Poin Siswa</h3>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped text-center">

                <thead class="table-dark">
                    <tr>
                        <th>Rank</th>
                        <th>Nama</th>
                        <th>Poin</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($users as $key => $user)
                        <tr>

                            {{-- 🥇🥈🥉 TOP 3 --}}
                            <td>
                                @if ($key == 0)
                                    🥇
                                @elseif ($key == 1)
                                    🥈
                                @elseif ($key == 2)
                                    🥉
                                @else
                                    {{ $key + 1 }}
                                @endif
                            </td>

                            <td>{{ $user->username }}</td>

                            <td>
                                <b style="color: {{ $user->total_point >= 0 ? 'green' : 'red' }}">
                                    {{ $user->total_point }}
                                </b>
                            </td>

                        </tr>
                    @empty

                        <tr>
                            <td colspan="3">Belum ada data</td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection