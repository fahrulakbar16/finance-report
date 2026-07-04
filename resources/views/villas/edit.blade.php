@extends('layouts.admin')

@section('page_title', 'Edit Villa')

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
            <h4>Edit Villa: {{ $villa->name }}</h4>
            <p>Perbarui informasi detail untuk villa ini</p>
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
                    <button type="button" class="position-absolute top-0 translate-middle btn btn-sm btn-light border rounded-pill step-indicator" style="width: 2rem; height:2rem; left: 25% !important;" data-step="2">2</button>
                    <button type="button" class="position-absolute top-0 translate-middle btn btn-sm btn-light border rounded-pill step-indicator" style="width: 2rem; height:2rem; left: 50% !important;" data-step="3">3</button>
                    <button type="button" class="position-absolute top-0 translate-middle btn btn-sm btn-light border rounded-pill step-indicator" style="width: 2rem; height:2rem; left: 75% !important;" data-step="4">4</button>
                    <button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-light border rounded-pill step-indicator" style="width: 2rem; height:2rem;" data-step="5">5</button>
                </div>
            </div>

            <form id="villaForm" method="POST" action="{{ route('villas.update', $villa) }}" enctype="multipart/form-data" class="p-4 p-md-5">
                @csrf
                @method('PUT')

                <!-- Step 1: Informasi Dasar -->
                <div class="form-step active" id="step1">
                    <h5 class="mb-4 fw-bold">1. Informasi Dasar Villa</h5>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium text-dark">Nama Villa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-fi @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $villa->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium text-dark">Pemilik <span class="text-danger">*</span></label>
                            <select class="form-select form-control-fi @error('pemilik_id') is-invalid @enderror" id="pemilik_id" name="pemilik_id" required>
                                <option value="" selected disabled>-- Pilih Pemilik --</option>
                                @foreach($pemiliks as $pemilik)
                                    <option value="{{ $pemilik->id }}" {{ old('pemilik_id', $villa->pemilik_id) == $pemilik->id ? 'selected' : '' }}>
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
                            <input type="email" class="form-control form-control-fi @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $villa->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-medium text-dark">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-fi @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $villa->price) }}" required min="0">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Deskripsi</label>
                        <textarea class="form-control form-control-fi @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $villa->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Gambar Thumbnail</label>
                        @if($villa->image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($villa->image) }}" alt="Thumbnail" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        @endif
                        <input type="file" class="form-control form-control-fi @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row bg-light p-3 rounded-3 mb-4 mx-0">
                        <h6 class="fw-bold mb-3">Persentase Bagi Hasil</h6>
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-medium text-dark small">Pengelola (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('persenan_pengelola') is-invalid @enderror" id="persenan_pengelola" name="persenan_pengelola" value="{{ old('persenan_pengelola', $villa->persenan_pengelola) }}" required min="0" max="100">
                            @error('persenan_pengelola')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-dark small">Pemilik (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="persenan_pemilik" name="persenan_pemilik" value="{{ old('persenan_pemilik', $villa->persenan_pemilik) }}" disabled>
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
                            @php
                                $roomsData = old('rooms', $villa->rooms);
                            @endphp
                            
                            @if($roomsData && count($roomsData) > 0)
                                @foreach($roomsData as $index => $room)
                                    <div class="row room-row align-items-center mb-2">
                                        <div class="col-md-7 mb-2 mb-md-0">
                                            <input type="text" class="form-control form-control-fi" name="rooms[{{$index}}][name]" value="{{ is_array($room) ? $room['name'] : $room->name }}" placeholder="Nama Kamar (Cth: Kamar Utama)" required>
                                        </div>
                                        <div class="col-md-3 mb-2 mb-md-0">
                                            <input type="number" class="form-control form-control-fi" name="rooms[{{$index}}][amount]" value="{{ is_array($room) ? $room['amount'] : $room->amount }}" placeholder="Jumlah" min="1" required>
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
                            @php
                                $selectedFasilitas = old('fasilitas', $villa->fasilitas->pluck('id')->toArray());
                            @endphp
                            @foreach($fasilitas as $fas)
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <div class="form-check custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="fasilitas[]" value="{{ $fas->id }}" id="fas_{{ $fas->id }}" {{ in_array($fas->id, is_array($selectedFasilitas) ? $selectedFasilitas : []) ? 'checked' : '' }}>
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
                        <textarea class="form-control form-control-fi @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $villa->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-medium text-dark">Latitude</label>
                            <input type="text" class="form-control form-control-fi @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $villa->latitude) }}" required>
                            @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-dark">Longitude</label>
                            <input type="text" class="form-control form-control-fi @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $villa->longitude) }}" required>
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
                        <button type="button" class="btn btn-primary px-4 py-2 fw-bold" onclick="nextStep(3)">Selanjutnya <i class="bi bi-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- Step 4: Galeri Kamar -->
                <div class="form-step d-none" id="step4">
                    <h5 class="mb-4 fw-bold">4. Galeri Kamar</h5>
                    <p class="text-muted mb-4">Unggah foto baru atau hapus foto yang sudah ada dari galeri villa. Format yang diterima: JPG, PNG, GIF (maks. 2MB per foto).</p>

                    @if($villa->galleries && $villa->galleries->count() > 0)
                    <div class="mb-4">
                        <h6 class="fw-medium text-dark mb-3">Foto Galeri Saat Ini</h6>
                        <div class="row g-3" id="existingGalleryContainer">
                            @foreach($villa->galleries as $gallery)
                            <div class="col-6 col-md-3" id="gallery-item-{{ $gallery->id }}">
                                <div class="position-relative">
                                    <img src="{{ Storage::url($gallery->image) }}" class="img-fluid rounded-3 border" style="height: 140px; object-fit: cover; width: 100%;" alt="Foto galeri">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle delete-gallery-btn" style="width: 1.5rem; height: 1.5rem; padding: 0; line-height: 1;" data-id="{{ $gallery->id }}" title="Hapus foto ini">
                                        <i class="bi bi-x" style="font-size: 0.8rem;"></i>
                                    </button>
                                    <input type="hidden" class="deleted-gallery-input" name="deleted_galleries[]" value="{{ $gallery->id }}" disabled>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark" for="gallery">Tambah Foto Baru</label>
                        <input type="file" class="form-control form-control-fi @error('gallery.*') is-invalid @enderror" id="gallery" name="gallery[]" multiple accept="image/jpeg,image/png,image/gif">
                        @error('gallery.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Anda bisa memilih lebih dari satu foto sekaligus.</small>
                    </div>

                    <div id="galleryPreviewContainer" class="row g-3 mt-2"></div>

                    <div class="d-flex justify-content-between mt-5">
                        <button type="button" class="btn btn-light border px-4 py-2" onclick="prevStep(4)"><i class="bi bi-arrow-left me-2"></i> Sebelumnya</button>
                        <button type="button" class="btn btn-primary px-4 py-2 fw-bold" onclick="showPreview()">Selanjutnya <i class="bi bi-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- Step 5: Preview -->
                <div class="form-step d-none" id="step5">
                    <h5 class="mb-4 fw-bold">5. Konfirmasi Update Villa</h5>
                    <div class="alert alert-info">
                        Silakan periksa kembali data yang telah Anda ubah. Klik "Update Data" jika sudah benar.
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
                                <tr><th class="ps-3 py-3">Galeri (Baru)</th><td id="prevGallery" class="py-3"></td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-5">
                        <button type="button" class="btn btn-light border px-4 py-2" onclick="prevStep(5)"><i class="bi bi-arrow-left me-2"></i> Sebelumnya</button>
                        <button type="submit" class="btn btn-success px-5 py-2 fw-bold">Update Data <i class="bi bi-check-lg ms-2"></i></button>
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

        // --- Gallery: Delete existing image logic ---
        document.querySelectorAll('.delete-gallery-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const item = document.getElementById('gallery-item-' + id);
                if(item) {
                    item.style.opacity = '0.4';
                    item.querySelector('.deleted-gallery-input').disabled = false;
                    this.innerHTML = '<i class="bi bi-arrow-counterclockwise" style="font-size: 0.8rem;"></i>';
                    this.title = 'Batalkan hapus';
                    this.classList.replace('btn-danger', 'btn-warning');
                    this.removeEventListener('click', arguments.callee);
                    this.addEventListener('click', function() {
                        item.style.opacity = '1';
                        item.querySelector('.deleted-gallery-input').disabled = true;
                        this.innerHTML = '<i class="bi bi-x" style="font-size: 0.8rem;"></i>';
                        this.title = 'Hapus foto ini';
                        this.classList.replace('btn-warning', 'btn-danger');
                    });
                }
            });
        });

        // --- Gallery Preview for new uploads ---
        const galleryInput = document.getElementById('gallery');
        const galleryPreviewContainer = document.getElementById('galleryPreviewContainer');
        galleryInput.addEventListener('change', function() {
            galleryPreviewContainer.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-3';
                    col.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded-3 border" style="height: 140px; object-fit: cover; width: 100%;" alt="preview">`;
                    galleryPreviewContainer.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
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
        const progress = (currentStep / 4) * 100;
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
        const progress = ((currentStep - 2) / 4) * 100;
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

        const galleryCount = document.getElementById('gallery').files.length;
        document.getElementById('prevGallery').textContent = galleryCount > 0 ? galleryCount + ' foto baru diunggah' : 'Tidak ada foto baru';

        // Move to step 5
        nextStep(4);
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
