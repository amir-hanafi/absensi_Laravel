@extends('layout.master')

@section('title','Detail Poin')

@section('content')

<div class="container-fluid">

    <div class="mb-3">
        <h3>Detail Transaksi Poin</h3>
        <p>Nama: <b>{{ $user->username }}</b></p>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Saldo</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($ledgers as $key => $item)

                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <span class="badge bg-{{ $item->transaction_type == 'PENALTY' ? 'danger' : 'success' }}">
                                {{ $item->transaction_type }}
                            </span>
                        </td>
                        <td>
                            <b style="color: {{ $item->amount >= 0 ? 'green' : 'red' }}">
                                {{ $item->amount }}
                            </b>
                        </td>
                        <td>{{ $item->current_balance }}</td>
                        <td>{{ $item->description }}</td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada transaksi
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection