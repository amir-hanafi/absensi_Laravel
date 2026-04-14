@extends('layout.master')

@section('title', 'Rule Poin')

@section('content')

    <div class="container-fluid">

        <h3 class="mb-3">Rule Builder Poin</h3>

        {{-- FORM --}}
        <div class="card mb-4">
            <div class="card-body">

                <form id="rule-form" action="{{ route('point-rules.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="rule_id">

                    <div class="row">

                        <div class="col-md-3">
                            <input type="text" name="rule_name" class="form-control" placeholder="Nama Rule">
                        </div>

                        <div class="col-md-2">
                            <select name="condition_operator" id="operator">
                                <option value="<">Kurang Dari</option>
                                <option value=">">Lebih Dari</option>
                                <option value="between">Antara</option>
                            </select>
                        </div>

                        <div class="col-md-4" id="value-container">
                            <input type="time" name="value1" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <input type="number" name="point_modifier" class="form-control" placeholder="Point">
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-primary">Simpan</button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        {{-- TABLE --}}
        <div class="card">
            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rule</th>
                            <th>Kondisi</th>
                            <th>Poin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($rules as $key => $rule)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $rule->rule_name }}</td>
                                <td>{{ $rule->condition_operator }} {{ $rule->condition_value }}</td>
                                <td>
                                    <b style="color: {{ $rule->point_modifier >= 0 ? 'green' : 'red' }}">
                                        {{ $rule->point_modifier }}
                                    </b>
                                </td>
                                <td>
                                    <a href="{{ route('point-rules.edit', $rule->id) }}"
                                        class="btn btn-sm btn-warning me-2">
                                        Edit
                                    </a>

                                    <form action="{{ route('point-rules.destroy', $rule->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>

    {{-- JS --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const operator = document.getElementById('operator');
            const container = document.getElementById('value-container');

            // change operator
            operator.addEventListener('change', function() {
                let value = this.value;

                if (value === 'between') {
                    container.innerHTML = `
                <div class="d-flex gap-2">
                    <input type="time" name="value1" class="form-control" required>
                    <input type="time" name="value2" class="form-control" required>
                </div>
            `;
                } else {
                    container.innerHTML = `
                <input type="time" name="value1" class="form-control" required>
            `;
                }
            });

            // 🔥 EDIT BUTTON FIX


        });
    </script>

@endsection
