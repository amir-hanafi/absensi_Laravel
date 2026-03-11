<style>
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 25px;
        color: #ccc;
        cursor: pointer;
    }

    .star-rating input:checked~label {
        color: gold;
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container">

        <h3>Form Penilaian</h3>

        <p>
            Nama : {{ $siswa->nama }} <br>
            NIS : {{ $siswa->nis }} <br>
            Kelas : {{ $siswa->kelas->nama_kelas }}
        </p>

        <form action="/penilaian" method="POST">
            @csrf

            <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

            <table class="table">

                <tr>
                    <th>Indikator</th>
                    <th>Nilai</th>
                </tr>

                @foreach ($categories as $category)
                    <tr>

                        <td>
                            {{ $category->name }}
                        </td>

                        <td>

                            <div class="star-rating">

                                <input type="radio" name="score[{{ $category->id }}]" value="5"
                                    id="star5-{{ $category->id }}">
                                <label for="star5-{{ $category->id }}">★</label>

                                <input type="radio" name="score[{{ $category->id }}]" value="4"
                                    id="star4-{{ $category->id }}">
                                <label for="star4-{{ $category->id }}">★</label>

                                <input type="radio" name="score[{{ $category->id }}]" value="3"
                                    id="star3-{{ $category->id }}">
                                <label for="star3-{{ $category->id }}">★</label>

                                <input type="radio" name="score[{{ $category->id }}]" value="2"
                                    id="star2-{{ $category->id }}">
                                <label for="star2-{{ $category->id }}">★</label>

                                <input type="radio" name="score[{{ $category->id }}]" value="1"
                                    id="star1-{{ $category->id }}">
                                <label for="star1-{{ $category->id }}">★</label>

                            </div>

                        </td>

                    </tr>
                @endforeach

            </table>

            <div class="form-group">

                <label>Catatan</label>

                <textarea name="notes" class="form-control"></textarea>

            </div>

            <br>

            <button type="submit" class="btn btn-success">
                Simpan Penilaian
            </button>

        </form>

    </div>
@endsection
