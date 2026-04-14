@extends('layout.master')

@section('title', 'Edit Rule')

@section('content')

    <div class="container-fluid">

        <h3 class="mb-3">Edit Rule Poin</h3>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('point-rules.update', $rule->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-3">
                            <input type="text" name="rule_name" value="{{ $rule->rule_name }}" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <select name="condition_operator" id="operator">
                                <option value="<" {{ $rule->condition_operator == '<' ? 'selected' : '' }}>Kurang Dari
                                </option>
                                <option value=">" {{ $rule->condition_operator == '>' ? 'selected' : '' }}>Lebih Dari
                                </option>
                                <option value="between" {{ $rule->condition_operator == 'between' ? 'selected' : '' }}>
                                    Antara</option>
                            </select>
                        </div>

                        <div class="col-md-4" id="value-container">
                            {{-- akan diisi JS --}}
                        </div>

                        <div class="col-md-2">
                            <input type="number" name="point_modifier" value="{{ $rule->point_modifier }}"
                                class="form-control">
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-success">Update</button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

    {{-- JS --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let operatorSelect = document.getElementById('operator');
            let container = document.getElementById('value-container');
            let value = "{{ $rule->condition_value }}";

            function renderInput(operator, value) {
                if (operator === 'between') {
                    let split = value.split('-');

                    container.innerHTML = `
                <div class="d-flex gap-2">
                    <input type="time" name="value1" value="${split[0] || ''}" class="form-control">
                    <input type="time" name="value2" value="${split[1] || ''}" class="form-control">
                </div>
            `;
                } else {
                    container.innerHTML = `
                <input type="time" name="value1" value="${value}" class="form-control">
            `;
                }
            }

            // render awal
            renderInput(operatorSelect.value, value);

            // saat dropdown berubah
            operatorSelect.addEventListener('change', function() {
                renderInput(this.value, '');
            });

        });
    </script>

@endsection
