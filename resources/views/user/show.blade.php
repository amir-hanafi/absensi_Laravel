@extends('layout.master')

@section('title','Detail User')

@section('content')

<div class="container-fluid">

    <h3>Detail User</h3>

    <div class="card">
        <div class="card-body">

            <p><b>Username:</b> {{ $user->username }}</p>
            <p><b>Role:</b> {{ $user->role }}</p>

            <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>

        </div>
    </div>

</div>

@endsection