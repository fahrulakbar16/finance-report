@extends('layouts.admin')

@section('page_title', 'Edit Fasilitas')

@section('content')
<style>
    /* ============================================
       FASILITAS EDIT PAGE — PREMIUM DESIGN
    ============================================ */

    /* --- Page Hero --- */
    .page-hero {
        position: relative;
        background: var(--gradient-primary);
        border-radius: var(--radius-lg);
        padding: 1.5rem 2rem;
        margin-bottom: 1.75rem;
        overflow: hidden;
        box-shadow: var(--shadow-glow-primary);
    }
    .page-hero::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(201, 168, 76, 0.12);
        pointer-events: none;
    }
    .page-hero-content { position: relative; z-index: 1; }
    .btn-hero-back {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.82rem;
        font-weight: 600;
        border-radius: var(--radius-sm);
        padding: 0.45rem 1rem;
        background: rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.85);
        border: 1px solid rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-hero-back:hover { background: rgba(255,255,255,0.18); color: #fff; }
    .page-hero-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: rgba(201,168,76,0.2); border: 1px solid rgba(201,168,76,0.35);
        color: var(--brand-accent-light);
        font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.8px; padding: 0.25rem 0.7rem;
        border-radius: var(--radius-pill); margin-bottom: 0.4rem;
    }
    .page-hero-title { font-size: 1.3rem; font-weight: 800; color: #fff; letter-spacing: -0.03em; margin: 0; }

    /* --- Form Card --- */
    .form-card {
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .form-card-header {
        display: flex; align-items: center; gap: 0.6rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-subtle);
    }
    .form-card-icon {
        width: 34px; height: 34px;
        border-radius: var(--radius-sm);
        background: rgba(27,61,47,0.08);
        color: var(--brand-primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.95rem; flex-shrink: 0;
    }
    .form-card-title { font-size: 0.84rem; font-weight: 700; color: var(--text-primary); }
    .form-card-body { padding: 1.5rem; }

    /* --- Field Labels --- */
    .fi-label {
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; color: var(--text-secondary);
        margin-bottom: 0.4rem; display: block;
    }
    .fi-label span { color: var(--danger); }
    .fi-input {
        width: 100%;
        background: var(--bg-app);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-sm);
        padding: 0.6rem 0.9rem;
        font-size: 0.84rem; font-weight: 500; color: var(--text-primary);
        transition: border-color 0.15s, box-shadow 0.15s;
        outline: none;
    }
    .fi-input:focus {
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 3px rgba(27,61,47,0.08);
        background: var(--surface);
    }
    .fi-hint { font-size: 0.72rem; color: var(--text-tertiary); margin-top: 0.3rem; }

    /* --- Icon Input Group --- */
    .icon-input-group {
        display: flex; align-items: center;
        background: var(--bg-app);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-sm);
        overflow: hidden;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .icon-input-group:focus-within {
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 3px rgba(27,61,47,0.08);
        background: var(--surface);
    }
    .icon-input-prefix {
        padding: 0 0.75rem;
        color: var(--text-tertiary);
        border-right: 1px solid var(--border-subtle);
        display: flex; align-items: center;
        background: transparent;
        height: 100%;
    }
    .icon-input-group .fi-input-bare {
        border: none; background: transparent;
        padding: 0.6rem 0.9rem; flex: 1;
        font-size: 0.84rem; font-weight: 500; color: var(--text-primary);
        outline: none; width: 100%;
    }

    /* --- Preview Box --- */
    .preview-box {
        background: var(--bg-app);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-sm);
        padding: 1rem 1.25rem;
        display: flex; align-items: center; gap: 0.75rem;
    }
    .preview-icon-wrap {
        width: 40px; height: 40px;
        border-radius: var(--radius-sm);
        background: rgba(27,61,47,0.08);
        color: var(--brand-primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; flex-shrink: 0;
    }
    .preview-label {
        font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; color: var(--text-tertiary); margin-bottom: 0.1rem;
    }
    .preview-name { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); }

    /* --- Icon Grid --- */
    .icon-grid-wrap {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(58px, 1fr));
        gap: 6px;
    }
    .icon-grid-btn {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border-subtle);
        background: var(--bg-app);
        width: 100%; aspect-ratio: 1;
        font-size: 1.15rem;
        color: var(--text-secondary);
        cursor: pointer; transition: all 0.15s;
        padding: 0;
    }
    .icon-grid-btn:hover {
        border-color: var(--brand-primary);
        background: rgba(27,61,47,0.06);
        color: var(--brand-primary);
        transform: translateY(-1px);
        box-shadow: var(--shadow-xs);
    }
    .icon-grid-btn.selected {
        border-color: var(--brand-primary);
        background: rgba(27,61,47,0.1);
        color: var(--brand-primary);
        box-shadow: 0 0 0 2px rgba(27,61,47,0.15);
    }
    .icon-hint {
        font-size: 0.72rem; color: var(--text-tertiary);
        margin-top: 0.75rem;
    }
    .icon-hint a { color: var(--info); text-decoration: none; font-weight: 600; }
    .icon-hint a:hover { text-decoration: underline; }

    /* --- Divider --- */
    .form-divider { border: none; border-top: 1px solid var(--border-subtle); margin: 1.5rem 0; }

    /* --- Buttons --- */
    .btn-submit {
        display: inline-flex; align-items: center; gap: 0.4rem;
        font-size: 0.84rem; font-weight: 700;
        background: var(--gradient-primary); color: #fff;
        border: none; border-radius: var(--radius-sm);
        padding: 0.65rem 1.6rem; cursor: pointer;
        box-shadow: var(--shadow-glow-primary);
        transition: all 0.15s;
    }
    .btn-submit:hover { opacity: 0.88; }
    .btn-cancel-link {
        display: inline-flex; align-items: center; gap: 0.4rem;
        font-size: 0.84rem; font-weight: 600;
        background: var(--bg-app); color: var(--text-secondary);
        border: 1px solid var(--border-subtle); border-radius: var(--radius-sm);
        padding: 0.65rem 1.4rem; text-decoration: none;
        transition: all 0.15s;
    }
    .btn-cancel-link:hover { background: #e2e5ea; color: var(--text-primary); }
</style>

<div class="container-fluid px-0 animate-in">

    <!-- ============ PAGE HERO ============ -->
    <div class="page-hero mb-4">
        <div class="page-hero-content">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <a href="{{ route('fasilitas.index') }}" class="btn-hero-back">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="page-hero-badge"><i class="bi bi-grid-fill"></i> Fasilitas Villa</div>
            <h1 class="page-hero-title">Edit Fasilitas</h1>
        </div>
    </div>

    <!-- ============ FORM CARD ============ -->
    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-icon"><i class="bi bi-pencil-square"></i></div>
            <span class="form-card-title">Ubah Informasi Fasilitas</span>
        </div>
        <div class="form-card-body">
            <form action="{{ route('fasilitas.update', $fasilita->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- LEFT COLUMN: Inputs & Preview -->
                    <div class="col-md-6">

                        <!-- Nama Fasilitas -->
                        <div class="mb-4">
                            <label class="fi-label">Nama Fasilitas <span>*</span></label>
                            <input type="text" id="nameInput" name="nama"
                                   class="fi-input"
                                   value="{{ old('nama', $fasilita->nama) }}"
                                   required placeholder="Contoh: WiFi, AC, Kolam Renang">
                        </div>

                        <!-- Ikon Input -->
                        <div class="mb-4">
                            <label class="fi-label">Class Ikon Bootstrap Icons</label>
                            <div class="icon-input-group">
                                <div class="icon-input-prefix"><i class="bi bi-search"></i></div>
                                <input type="text" id="iconInput" name="ikon"
                                       class="fi-input-bare"
                                       value="{{ old('ikon', $fasilita->ikon) }}"
                                       placeholder="Contoh: bi-wifi">
                            </div>
                            <div class="fi-hint">Ketikkan nama class atau pilih dari grid ikon di kanan.</div>
                        </div>

                        <!-- Preview -->
                        <div>
                            <label class="fi-label">Preview Tampilan</label>
                            <div class="preview-box">
                                <div class="preview-icon-wrap">
                                    <i id="iconPreview" class="bi {{ old('ikon', $fasilita->ikon) }}"></i>
                                </div>
                                <div>
                                    <div class="preview-label">Fasilitas</div>
                                    <div class="preview-name" id="namePreview">{{ old('nama', $fasilita->nama) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Icon Grid -->
                    <div class="col-md-6">
                        <label class="fi-label">Pilihan Ikon Umum</label>
                        @php
                            $commonIcons = [
                                'bi-wifi', 'bi-tv', 'bi-snow', 'bi-cup-hot', 'bi-car-front',
                                'bi-water', 'bi-house-door', 'bi-shield-check', 'bi-speaker', 'bi-fire',
                                'bi-fan', 'bi-tree', 'bi-bicycle', 'bi-camera-video', 'bi-hdd-network',
                                'bi-reception-4', 'bi-music-note-beamed', 'bi-lamp', 'bi-clock', 'bi-calendar-event',
                                'bi-wind', 'bi-droplet', 'bi-plug', 'bi-controller', 'bi-key'
                            ];
                            $currentIcon = old('ikon', $fasilita->ikon);
                        @endphp
                        <div class="icon-grid-wrap" id="iconGrid">
                            @foreach($commonIcons as $icon)
                                <button type="button"
                                        class="icon-grid-btn {{ $currentIcon === $icon ? 'selected' : '' }}"
                                        data-icon="{{ $icon }}"
                                        title="{{ $icon }}">
                                    <i class="bi {{ $icon }}"></i>
                                </button>
                            @endforeach
                        </div>
                        <div class="icon-hint">
                            <i class="bi bi-info-circle me-1"></i>
                            Cari ikon lainnya di
                            <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>
                        </div>
                    </div>
                </div>

                <hr class="form-divider">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('fasilitas.index') }}" class="btn-cancel-link">
                        <i class="bi bi-x-lg"></i> Batal
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-lg"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput   = document.getElementById('nameInput');
    const iconInput   = document.getElementById('iconInput');
    const iconPreview = document.getElementById('iconPreview');
    const namePreview = document.getElementById('namePreview');
    const iconBtns    = document.querySelectorAll('.icon-grid-btn');

    function updateIconPreview(iconClass) {
        iconPreview.className = 'bi';
        const classes = (iconClass || '').split(' ').filter(c => c.trim() && c !== 'bi');
        if (classes.length > 0) {
            classes.forEach(c => iconPreview.classList.add(c));
        } else {
            iconPreview.className = 'bi bi-question-circle';
        }
    }

    function updateNamePreview(name) {
        namePreview.textContent = name || 'Nama Fasilitas';
    }

    function setActiveBtn(icon) {
        iconBtns.forEach(btn => {
            btn.classList.toggle('selected', btn.getAttribute('data-icon') === icon);
        });
    }

    iconInput.addEventListener('input', function() {
        updateIconPreview(this.value);
        setActiveBtn(this.value.trim());
    });

    nameInput.addEventListener('input', function() {
        updateNamePreview(this.value);
    });

    iconBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const iconClass = this.getAttribute('data-icon');
            iconInput.value = iconClass;
            updateIconPreview(iconClass);
            setActiveBtn(iconClass);
        });
    });

    // Initialize
    updateIconPreview(iconInput.value);
    updateNamePreview(nameInput.value);
});
</script>
@endsection
