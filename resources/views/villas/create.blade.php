@extends('layouts.admin')

@section('page_title', 'Tambah Villa')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map { height: 350px; z-index: 1; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div class="page-header-fi">
            <h4>Tambah Villa Baru</h4>
            <p>Lengkapi informasi di bawah ini untuk menambahkan villa baru</p>
        </div>
        <a href="{{ route('villas.index') }}" class="btn btn-light border d-flex align-items-center gap-2 shadow-sm rounded-3 px-3 py-2">
            <i class="bi bi-arrow-left"></i>
            <span class="fw-medium">Kembali</span>
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-fi alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
            <div>Terdapat kesalahan input form. Silakan periksa kembali isian Anda.</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-fi border-0 shadow-sm overflow-hidden mb-4">
        <div class="card-body p-0">
            <!-- Stepper Progress -->
            <div class="bg-light p-4 border-bottom d-none d-md-block">
                <div class="position-relative m-4">
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" id="stepperProgress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-pill step-indicator" style="width: 2rem; height:2rem;" data-step="1">1</button>
                    <button type="button" class="position-absolute top-0 start-33 translate-middle btn btn-sm btn-light border rounded-pill step-indicator" style="width: 2rem; height:2rem; left: 33.33% !important;" data-step="2">2</button>
                    <button type="button" class="position-absolute top-0 start-66 translate-middle btn btn-sm btn-light border rounded-pill step-indicator" style="width: 2rem; height:2rem; left: 66.66% !important;" data-step="3">3</button>
                    <button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-light border rounded-pill step-indicator" style="width: 2rem; height:2rem;" data-step="4">4</button>
                </div>
            </div>

            <form id="villaForm" method="POST" action="{{ route('villas.store') }}" enctype="multipart/form-data" class="p-4 p-md-5">
                @csrf

                <!-- Step 1: Informasi Dasar -->
                <div class="form-step active" id="step1">
                    <h5 class="mb-4 fw-bold">1. Informasi Dasar Villa</h5>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium text-dark">Nama Villa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-fi @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Villa Alam Asri">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium text-dark">Pemilik <span class="text-danger">*</span></label>
                            <select class="form-select form-control-fi @error('pemilik_id') is-invalid @enderror" id="pemilik_id" name="pemilik_id" required>
                                <option value="" selected disabled>-- Pilih Pemilik --</option>
                                @foreach($pemiliks as $pemilik)
                                    <option value="{{ $pemilik->id }}" {{ old('pemilik_id') == $pemilik->id ? 'selected' : '' }}>
                                        {{ $pemilik->name }} ({{ $pemilik->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pemilik_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium text-dark">Email Kontak <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-fi @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium text-dark">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-fi @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', 0) }}" required min="0">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Deskripsi</label>
                        <textarea class="form-control form-control-fi @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Jelaskan mengenai villa ini...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Gambar Thumbnail</label>
                        <input type="file" class="form-control form-control-fi @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row bg-light p-3 rounded-3 mb-4 mx-0">
                        <h6 class="fw-bold mb-3">Persentase Bagi Hasil</h6>
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-medium text-dark small">Pengelola (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('persenan_pengelola') is-invalid @enderror" id="persenan_pengelola" name="persenan_pengelola" value="{{ old('persenan_pengelola', 0) }}" required min="0" max="100">
                            @error('persenan_pengelola')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-dark small">Pemilik (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="persenan_pemilik" name="persenan_pemilik" value="{{ old('persenan_pemilik', 100) }}" disabled>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary px-4 py-2" onclick="nextStep(1)">Selanjutnya <i class="bi bi-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- Step 2: Spesifikasi & Fasilitas -->
                <div class="form-step d-none" id="step2">
                    <h5 class="mb-4 fw-bold">2. Spesifikasi Kamar & Fasilitas</h5>
                    
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Spesifikasi Kamar</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="addRoomBtn">
                                <i class="bi bi-plus-lg"></i> Tambah Kamar
                            </button>
                        </div>
                        <div id="roomContainer">
                            @if(old('rooms'))
                                @foreach(old('rooms') as $index => $room)
                                    <div class="row room-row align-items-center mb-2">
                                        <div class="col-md-7 mb-2 mb-md-0">
                                            <input type="text" class="form-control form-control-fi" name="rooms[{{$index}}][name]" value="{{ $room['name'] }}" placeholder="Nama Kamar (Cth: Kamar Utama)" required>
                                        </div>
                                        <div class="col-md-3 mb-2 mb-md-0">
                                            <input type="number" class="form-control form-control-fi" name="rooms[{{$index}}][amount]" value="{{ $room['amount'] }}" placeholder="Jumlah" min="1" required>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-room"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row room-row align-items-center mb-2">
                                    <div class="col-md-7 mb-2 mb-md-0">
                                        <input type="text" class="form-control form-control-fi" name="rooms[0][name]" placeholder="Nama Kamar (Cth: Kamar Utama)" required>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <input type="number" class="form-control form-control-fi" name="rooms[0][amount]" placeholder="Jumlah" min="1" required>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-room"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Fasilitas Villa</h6>
                        <div class="row">
                            @foreach($fasilitas as $fas)
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <div class="form-check custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="fasilitas[]" value="{{ $fas->id }}" id="fas_{{ $fas->id }}" {{ is_array(old('fasilitas')) && in_array($fas->id, old('fasilitas')) ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex align-items-center gap-2" for="fas_{{ $fas->id }}">
                                            <i class="bi {{ $fas->ikon }}"></i> {{ $fas->nama }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <button type="button" class="btn btn-light border px-4 py-2" onclick="prevStep(2)"><i class="bi bi-arrow-left me-2"></i> Sebelumnya</button>
                        <button type="button" class="btn btn-primary px-4 py-2" onclick="nextStep(2)">Selanjutnya <i class="bi bi-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- Step 3: Lokasi -->
                <div class="form-step d-none" id="step3">
                    <h5 class="mb-4 fw-bold">3. Lokasi Villa</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-fi @error('address') is-invalid @enderror" id="address" name="address" rows="3" required placeholder="Masukkan alamat lengkap villa...">{{ old('address') }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-medium text-dark">Latitude</label>
                            <input type="text" class="form-control form-control-fi @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', '-8.409518') }}" required>
                            @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-dark">Longitude</label>
                            <input type="text" class="form-control form-control-fi @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', '115.188916') }}" required>
                            @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Pilih Lokasi pada Peta</label>
                        <div id="map" class="rounded-3 border"></div>
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Klik pada peta untuk menentukan titik koordinat Latitude dan Longitude secara otomatis.</small>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <button type="button" class="btn btn-light border px-4 py-2" onclick="prevStep(3)"><i class="bi bi-arrow-left me-2"></i> Sebelumnya</button>
                        <button type="button" class="btn btn-primary px-4 py-2 fw-bold" onclick="showPreview()">Selanjutnya <i class="bi bi-arrow-right ms-2"></i></button>
                    </div>
                </div>
                
                <!-- Step 4: Preview -->
                <div class="form-step d-none" id="step4">
                    <h5 class="mb-4 fw-bold">4. Konfirmasi Data Villa</h5>
                    <div class="alert alert-info">
                        Silakan periksa kembali data yang telah Anda masukkan. Klik "Simpan Data" jika sudah benar.
                    </div>
                    
                    <div class="table-responsive border rounded-3 mb-4">
                        <table class="table table-borderless table-striped mb-0">
                            <tbody>
                                <tr><th style="width: 30%" class="ps-3 py-3">Nama Villa</th><td id="prevName" class="py-3"></td></tr>
                                <tr><th class="ps-3 py-3">Harga</th><td id="prevPrice" class="py-3"></td></tr>
                                <tr><th class="ps-3 py-3">Persentase</th><td id="prevPersen" class="py-3"></td></tr>
                                <tr><th class="ps-3 py-3">Alamat</th><td id="prevAddress" class="py-3"></td></tr>
                                <tr><th class="ps-3 py-3">Jumlah Kamar</th><td id="prevRooms" class="py-3"></td></tr>
                                <tr><th class="ps-3 py-3">Fasilitas</th><td id="prevFasilitas" class="py-3"></td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-5">
                        <button type="button" class="btn btn-light border px-4 py-2" onclick="prevStep(4)"><i class="bi bi-arrow-left me-2"></i> Sebelumnya</button>
                        <button type="submit" class="btn btn-success px-5 py-2 fw-bold">Simpan Data <i class="bi bi-check-lg ms-2"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- Bagi Hasil Logic ---
        const inputPengelola = document.getElementById('persenan_pengelola');
        const inputPemilik = document.getElementById('persenan_pemilik');
        
        inputPengelola.addEventListener('input', function() {
            let val = parseInt(this.value) || 0;
            if (val > 100) { val = 100; this.value = 100; }
            inputPemilik.value = 100 - val;
        });

        // --- Dynamic Rooms Logic ---
        const roomContainer = document.getElementById('roomContainer');
        const addRoomBtn = document.getElementById('addRoomBtn');
        let roomIndex = document.querySelectorAll('.room-row').length;

        addRoomBtn.addEventListener('click', function() {
            const row = document.createElement('div');
            row.className = 'row room-row align-items-center mb-2';
            row.innerHTML = `
                <div class="col-md-7 mb-2 mb-md-0">
                    <input type="text" class="form-control form-control-fi" name="rooms[${roomIndex}][name]" placeholder="Nama Kamar" required>
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <input type="number" class="form-control form-control-fi" name="rooms[${roomIndex}][amount]" placeholder="Jumlah" min="1" required>
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-danger btn-sm remove-room"><i class="bi bi-trash"></i></button>
                </div>
            `;
            roomContainer.appendChild(row);
            roomIndex++;
        });

        roomContainer.addEventListener('click', function(e) {
            if(e.target.closest('.remove-room')) {
                e.target.closest('.room-row').remove();
            }
        });
    });

    // --- Stepper Navigation ---
    function nextStep(currentStep) {
        // Simple Validation
        let isValid = true;
        document.querySelectorAll(`#step${currentStep} [required]`).forEach(input => {
            if(!input.value) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if(!isValid) return alert("Mohon lengkapi kolom yang wajib diisi!");

        document.getElementById(`step${currentStep}`).classList.add('d-none');
        document.getElementById(`step${currentStep}`).classList.remove('active');
        document.getElementById(`step${currentStep+1}`).classList.remove('d-none');
        document.getElementById(`step${currentStep+1}`).classList.add('active');
        
        // Update Progress Bar
        const progress = ((currentStep) / 3) * 100;
        document.getElementById('stepperProgress').style.width = progress + '%';
        
        // Update Indicators
        document.querySelectorAll('.step-indicator').forEach(indicator => {
            if(parseInt(indicator.dataset.step) <= currentStep + 1) {
                indicator.classList.replace('btn-light', 'btn-primary');
                indicator.classList.remove('border');
            } else {
                indicator.classList.replace('btn-primary', 'btn-light');
                indicator.classList.add('border');
            }
        });
        
        // Fix Leaflet map sizing issue when map container is hidden on initialization
        if(currentStep + 1 === 3 && map) {
            setTimeout(() => { map.invalidateSize(); }, 300);
        }
    }

    function prevStep(currentStep) {
        document.getElementById(`step${currentStep}`).classList.add('d-none');
        document.getElementById(`step${currentStep}`).classList.remove('active');
        document.getElementById(`step${currentStep-1}`).classList.remove('d-none');
        document.getElementById(`step${currentStep-1}`).classList.add('active');

        // Update Progress Bar
        const progress = ((currentStep - 2) / 3) * 100;
        document.getElementById('stepperProgress').style.width = progress + '%';
        
        document.querySelectorAll('.step-indicator').forEach(indicator => {
            if(parseInt(indicator.dataset.step) <= currentStep - 1) {
                indicator.classList.replace('btn-light', 'btn-primary');
                indicator.classList.remove('border');
            } else {
                indicator.classList.replace('btn-primary', 'btn-light');
                indicator.classList.add('border');
            }
        });
    }

    function showPreview() {
        // Simple Validation for step 3
        let isValid = true;
        document.querySelectorAll(`#step3 [required]`).forEach(input => {
            if(!input.value) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
        if(!isValid) return alert("Mohon lengkapi kolom yang wajib diisi!");

        // Populate Preview
        document.getElementById('prevName').textContent = document.getElementById('name').value;
        document.getElementById('prevPrice').textContent = "Rp " + (document.getElementById('price').value || "0");
        document.getElementById('prevPersen').textContent = document.getElementById('persenan_pengelola').value + "% Pengelola, " + document.getElementById('persenan_pemilik').value + "% Pemilik";
        document.getElementById('prevAddress').textContent = document.getElementById('address').value;
        
        let roomsCount = document.querySelectorAll('.room-row').length;
        document.getElementById('prevRooms').textContent = roomsCount + " tipe kamar";

        let selectedFas = [];
        document.querySelectorAll('input[name="fasilitas[]"]:checked').forEach(cb => {
            selectedFas.push(cb.nextElementSibling.textContent.trim());
        });
        document.getElementById('prevFasilitas').textContent = selectedFas.length > 0 ? selectedFas.join(', ') : '-';

        // Move to step 4
        nextStep(3);
    }
</script>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    var map, marker;
    document.addEventListener("DOMContentLoaded", function() {
        var latInput = document.getElementById('latitude');
        var lngInput = document.getElementById('longitude');
        
        var initLat = latInput.value ? parseFloat(latInput.value) : -8.409518; // Default Bali
        var initLng = lngInput.value ? parseFloat(lngInput.value) : 115.188916;

        map = L.map('map').setView([initLat, initLng], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        marker = L.marker([initLat, initLng]).addTo(map);

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            latInput.value = e.latlng.lat.toFixed(6);
            lngInput.value = e.latlng.lng.toFixed(6);
        });
        
        latInput.addEventListener('change', updateMarkerFromInput);
        lngInput.addEventListener('change', updateMarkerFromInput);
        
        function updateMarkerFromInput() {
            if(latInput.value && lngInput.value) {
                var newLatLng = new L.LatLng(parseFloat(latInput.value), parseFloat(lngInput.value));
                marker.setLatLng(newLatLng);
                map.setView(newLatLng);
            }
        }
    });
</script>
@endpush
