@extends('layout.master')

@section('title', 'Tambah Lokasi')

@section('content')

    <div class="container-fluid">

        <h3>Tambah Lokasi</h3>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('places.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Nama Lokasi</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Latitude</label>
                        <input type="text" id="latitude" name="latitude" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Longitude</label>
                        <input type="text" id="longitude" name="longitude" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Pilih Lokasi</label>
                        <div id="map" style="height:400px;"></div>
                    </div>

                    <div class="mb-3">
                        <label>Radius (meter)</label>
                        <input type="number" id="radius" name="allowed_radius" class="form-control" required>
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('places.index') }}" class="btn btn-secondary">Kembali</a>

                </form>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let map = L.map('map').setView([-6.8, 107.1], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            let marker = null;
            let circle = null;

            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const radiusInput = document.getElementById('radius');

            // klik map → set posisi + buat/update circle
            map.on('click', function(e) {

                let lat = e.latlng.lat;
                let lng = e.latlng.lng;

                latInput.value = lat;
                lngInput.value = lng;

                let radius = parseInt(radiusInput.value) || 300;

                // kalau belum ada, buat
                if (!marker) {
                    marker = L.marker([lat, lng]).addTo(map);
                    circle = L.circle([lat, lng], {
                        radius: radius
                    }).addTo(map);
                } else {
                    // kalau sudah ada, update saja
                    marker.setLatLng([lat, lng]);
                    circle.setLatLng([lat, lng]);
                    circle.setRadius(radius);
                }

            });

            // realtime update saat radius diubah
            radiusInput.addEventListener('input', function() {

                if (!circle || !marker) return; // belum klik map

                let radius = parseInt(this.value) || 300;

                circle.setRadius(radius);
            });

        });
    </script>

@endsection
