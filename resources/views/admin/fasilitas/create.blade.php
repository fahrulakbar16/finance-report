@extends('layouts.admin')

@section('page_title', 'Tambah Fasilitas')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="{{ route('fasilitas.index') }}" class="btn btn-light rounded-circle shadow-sm" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
        <div class="page-header-fi mb-0">
            <h4 class="mb-0">Tambah Fasilitas</h4>
        </div>
    </div>

    <div class="card card-fi border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('fasilitas.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Nama Fasilitas <span class="text-danger">*</span></label>
                            <input type="text" id="nameInput" name="nama" class="form-control form-control-fi" value="{{ old('nama') }}" required placeholder="Contoh: WiFi, AC, Kolam Renang">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Ikon Fasilitas</label>
                            <p class="text-muted small mb-2">Pilih ikon dari daftar di bawah atau ketikkan class Bootstrap Icons secara manual.</p>
                            
                            <div class="input-group mb-3 shadow-sm" style="border-radius: var(--fi-radius); overflow: hidden;">
                                <span class="input-group-text bg-light border-0" id="basic-addon1">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" id="iconInput" name="ikon" class="form-control form-control-fi border-0 ps-2" value="{{ old('ikon', 'bi-wifi') }}" placeholder="Contoh: bi-wifi">
                            </div>

                            <div class="mt-3 p-3 border rounded-3 bg-white shadow-sm">
                                <h6 class="text-muted mb-3 small text-uppercase fw-bold">Preview Tampilan</h6>
                                <div class="d-flex align-items-center gap-2 text-dark">
                                    <i id="iconPreview" class="bi {{ old('ikon', 'bi-wifi') }} fs-5 text-secondary"></i>
                                    <span id="namePreview" class="fw-medium">{{ old('nama', 'Nama Fasilitas') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark mb-3">Pilihan Ikon Umum</label>
                            <div class="row g-2" id="iconGrid">
                                @php
                                    $commonIcons = [
                                        'bi-wifi', 'bi-tv', 'bi-snow', 'bi-cup-hot', 'bi-car-front', 
                                        'bi-water', 'bi-house-door', 'bi-shield-check', 'bi-speaker', 'bi-fire', 
                                        'bi-fan', 'bi-tree', 'bi-bicycle', 'bi-camera-video', 'bi-hdd-network', 
                                        'bi-reception-4', 'bi-music-note-beamed', 'bi-lamp', 'bi-clock', 'bi-calendar-event',
                                        'bi-wind', 'bi-droplet', 'bi-plug', 'bi-controller', 'bi-key'
                                    ];
                                @endphp
                                @foreach($commonIcons as $icon)
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-light border text-dark icon-btn d-flex flex-column align-items-center justify-content-center p-2 rounded-3" style="width: 70px; height: 70px;" data-icon="{{ $icon }}" title="{{ $icon }}">
                                        <i class="bi {{ $icon }} fs-4 mb-1"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-3 text-muted small">
                                * Anda juga dapat mencari ikon lain di <a href="https://icons.getbootstrap.com/" target="_blank">dokumentasi Bootstrap Icons</a>.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-light">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('fasilitas.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Fasilitas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('nameInput');
        const iconInput = document.getElementById('iconInput');
        const iconPreview = document.getElementById('iconPreview');
        const namePreview = document.getElementById('namePreview');
        const iconBtns = document.querySelectorAll('.icon-btn');

        function updateIconPreview(iconClass) {
            // Hapus semua class kecuali 'bi' dan 'fs-5' dsb
            iconPreview.className = 'bi fs-5 text-secondary';
            
            if (iconClass) {
                const classes = iconClass.split(' ').filter(c => c.trim() !== '' && c !== 'bi');
                if (classes.length > 0) {
                    classes.forEach(c => iconPreview.classList.add(c));
                } else {
                    iconPreview.className = 'bi bi-question-circle fs-5 text-muted';
                }
            } else {
                iconPreview.className = 'bi bi-question-circle fs-5 text-muted';
            }
        }

        function updateNamePreview(name) {
            namePreview.textContent = name ? name : 'Nama Fasilitas';
        }

        iconInput.addEventListener('input', function(e) {
            updateIconPreview(e.target.value);
        });

        nameInput.addEventListener('input', function(e) {
            updateNamePreview(e.target.value);
        });

        iconBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const iconClass = this.getAttribute('data-icon');
                iconInput.value = iconClass;
                updateIconPreview(iconClass);
            });
        });
        
        // Initialize
        updateIconPreview(iconInput.value);
        updateNamePreview(nameInput.value);
    });
</script>
@endsection
