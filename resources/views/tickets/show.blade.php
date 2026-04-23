@extends('layout.master')

@section('title', 'Detail Ticket')

@section('content')

    <div class="container-fluid">

        <h3>Detail Ticket</h3>



        <div class="card mb-3">
            <div class="card-body">
                <p><b>Subject:</b> {{ $ticket->subject }}</p>
                <p><b>Deskripsi:</b> {{ $ticket->description }}</p>
                <p><b>Status:</b> {{ $ticket->status }}</p>

                @php
                    $firstResponse = $ticket->responses->first();
                @endphp

                @if ($firstResponse)
                    <p>
                        <b>Response Time:</b>
                        {{ $ticket->created_at->diffInMinutes($firstResponse->created_at) }} menit
                    </p>
                @endif

                @if ($ticket->status == 'closed')
                    <p>
                        <b>Resolution Time:</b>
                        {{ $ticket->created_at->diffInMinutes($ticket->updated_at) }} menit
                    </p>
                @endif
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">

                <h5>Saran Jawaban</h5>

                @if ($replies->count())
                    @foreach ($replies as $reply)
                        <button type="button" class="btn btn-sm btn-secondary mb-1"
                            onclick="fillReply(`{{ $reply->message }}`)">
                            {{ $reply->message }}
                        </button>
                    @endforeach
                @else
                    <p class="text-muted">Tidak ada saran</p>
                @endif

            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <h5>Riwayat Percakapan</h5>

                @if ($ticket->responses->count())
                    @foreach ($ticket->responses as $res)
                        <div style="margin-bottom:10px; padding:10px; border:1px solid #ddd;">
                            <b>{{ $res->is_auto_reply ? 'Auto Reply' : 'Admin' }}</b>
                            <br>
                            {{ $res->message }}
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Belum ada response</p>
                @endif

                <form action="{{ route('tickets.response.store', $ticket->id) }}" method="POST">
                    @csrf

                    <textarea name="message" id="message" class="form-control mb-2"></textarea>

                    <button type="submit" class="btn btn-primary">Kirim</button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Kembali</a>
                </form>

                <form action="{{ route('tickets.close', $ticket->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success">Tandai Selesai</button>
                </form>

            </div>
        </div>

        @if ($ticket->status == 'closed')
            <hr>

            <h5>Rating Kepuasan</h5>

            @if (!$ticket->rating)
                <form action="{{ route('tickets.rating.store', $ticket->id) }}" method="POST">
                    @csrf

                    <div class="mb-2">
                        <label>Nilai</label>
                        <select name="score" >
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Feedback</label>
                        <textarea name="feedback" class="form-control"></textarea>
                    </div>

                    <button class="btn btn-primary">Kirim Rating</button>
                </form>
            @else
                <p><b>Nilai:</b> {{ $ticket->rating->score }}/5</p>
                <p><b>Feedback:</b> {{ $ticket->rating->feedback }}</p>
            @endif
        @endif

    </div>

    <script>
        function fillReply(text) {
            document.getElementById('message').value = text;
        }
    </script>

@endsection
