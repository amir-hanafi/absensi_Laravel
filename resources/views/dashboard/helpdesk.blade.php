@extends('layout.master')

@section('title', 'Dashboard Helpdesk')

@section('content')

<div class="container-fluid">

    <h3>Dashboard Helpdesk</h3>

    <div class="row">

        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5>Avg Response Time</h5>
                <h3>{{ $avgResponse }} menit</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5>Avg Resolution Time</h5>
                <h3>{{ $avgResolution }} menit</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5>Avg Rating</h5>
                <h3>{{ $avgRating }}/5</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5>Total Ticket</h5>
                <h3>{{ $tickets->count() }}</h3>
            </div>
        </div>

    </div>

    <hr>

    <h5>Daftar Ticket</h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Rating</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($tickets as $key => $t)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $t->subject }}</td>
                <td>{{ $t->status }}</td>
                <td>{{ $t->rating->score ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection