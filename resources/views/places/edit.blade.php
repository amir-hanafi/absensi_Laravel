@extends('layout.master')

@section('title', 'Edit Lokasi')

@section('content')

    <div class="container-fluid">

        <h3>Edit Lokasi</h3>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('places.update', $place->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Nama Lokasi</label>
                        <input type="text" name="name" value="{{ $place->name }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Latitude</label>
                        <input type="text" id="latitude" name="latitude" value="{{ $place->latitude }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Longitude</label>
                        <input type="text" id="longitude" name="longitude" value="{{ $place->longitude }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Pilih Lokasi</label>
                        <div id="map" style="height:400px;"></div>
                    </div>

                    <div class="mb-3">
                        <label>Radius (meter)</label>
                        <input type="number" id="radius" name="allowed_radius" value="{{ $place->allowed_radius }}"
                            class="form-control">
                    </div>

                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('places.index') }}" class="btn btn-secondary">Kembali</a>

                </form>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let lat = parseFloat(document.getElementById('latitude').value);
            let lng = parseFloat(document.getElementById('longitude').value);
            let radiusInput = document.getElementById('radius');

            let map = L.map('map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // ambil radius awal dari database
            let radius = parseInt(radiusInput.value) || 300;

            let marker = L.marker([lat, lng]).addTo(map);

            let circle = L.circle([lat, lng], {
                radius: radius
            }).addTo(map);

            // klik map → pindah posisi + update circle
            map.on('click', function(e) {

                let newLat = e.latlng.lat;
                let newLng = e.latlng.lng;

                document.getElementById('latitude').value = newLat;
                document.getElementById('longitude').value = newLng;

                marker.setLatLng([newLat, newLng]);

                let newRadius = parseInt(radiusInput.value) || 300;

                circle.setLatLng([newLat, newLng]);
                circle.setRadius(newRadius);
            });

            // saat radius diubah → update circle
            radiusInput.addEventListener('input', function() {
                let newRadius = parseInt(this.value) || 300;
                circle.setRadius(newRadius);
            });

        });
    </script>

@endsection
