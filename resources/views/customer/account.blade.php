@extends('layouts.customer')

@section('title', 'Akun Saya - Athara Villas')

@section('header')
    <h1 class="header-title d-lg-none">Akun Saya</h1>
@endsection

@section('styles')
<style>
    /* Mobile-first styles (default) */
    .profile-header {
        background: var(--surface);
        padding: 2rem 1.25rem;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        margin-bottom: 1.5rem;
    }
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(201,168,76,0.1);
        color: var(--accent);
        font-size: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
    }
    .profile-name {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }
    .profile-email {
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    
    .menu-group {
        background: var(--surface);
        border-radius: 20px;
        padding: 0.5rem 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        margin-bottom: 1.5rem;
    }
    .menu-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        color: var(--text-dark);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    .menu-item:hover, .menu-item.active {
        color: var(--accent);
    }
    .menu-item:hover i.icon, .menu-item.active i.icon {
        color: var(--accent);
        background: rgba(201,168,76,0.1);
    }
    .menu-item:last-child {
        border-bottom: none;
    }
    .menu-item i.icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(0,0,0,0.03);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: var(--text-muted);
        transition: all 0.3s;
    }
    .logout-wrapper {
        margin-bottom: 1.5rem;
    }

    /* Content Area Styles (PC) */
    .content-card {
        background: var(--surface);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .form-label {
        font-weight: 500;
        font-size: 0.9rem;
        color: var(--text-dark);
    }
    .form-control, .form-select {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(0,0,0,0.1);
        font-size: 0.95rem;
        background: #f8fafc;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 0.2rem rgba(201,168,76,0.15);
        background: #fff;
    }
    
    .section-title {
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-family: 'Inter', sans-serif;
        font-size: 2rem;
    }

    /* PC Layout overrides */
    @media (min-width: 992px) {
        .pc-layout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 0;
        }
        .sidebar-wrapper {
            background: var(--surface);
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border: 1px solid rgba(0,0,0,0.05);
            overflow: hidden;
            padding-bottom: 1rem;
        }
        .sidebar-wrapper .profile-header {
            box-shadow: none;
            margin-bottom: 0;
            border-radius: 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 2.5rem 1.25rem;
        }
        .sidebar-wrapper .menu-group {
            box-shadow: none;
            margin-bottom: 0;
            border-radius: 0;
            padding: 0.5rem 0;
            background: transparent;
        }
        .sidebar-wrapper .menu-item {
            padding: 1rem 1.5rem;
            border-bottom: none;
        }
        .sidebar-wrapper .menu-item.active {
            background: rgba(201,168,76,0.05);
            border-right: 4px solid var(--accent);
        }
        .sidebar-wrapper .logout-wrapper {
            padding: 0.5rem 1.5rem;
            margin-bottom: 0;
        }
    }
</style>
@endsection

@section('content')

<div class="pc-layout-container">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-4 col-xl-3">
            <div class="sidebar-wrapper fade-in">
                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="profile-avatar">
                        @php
                            $initials = collect(explode(' ', Auth::user()->name))->map(function($word) { return strtoupper(substr($word, 0, 1)); })->take(2)->join('');
                        @endphp
                        {{ $initials }}
                    </div>
                    <h2 class="profile-name">{{ Auth::user()->name }}</h2>
                    <div class="profile-email">{{ Auth::user()->email }}</div>
                </div>

                <!-- Menus -->
                <div class="menu-group">
                    <a href="#" class="menu-item active">
                        <div><i class="bi bi-person icon"></i> Pengaturan Akun</div>
                        <i class="bi bi-chevron-right text-muted d-lg-none"></i>
                    </a>
                    <a href="{{ route('customer.history') }}" class="menu-item">
                        <div><i class="bi bi-clock-history icon"></i> Transaksi Saya</div>
                        <i class="bi bi-chevron-right text-muted d-lg-none"></i>
                    </a>
                    <a href="#" class="menu-item">
                        <div><i class="bi bi-ticket-perforated icon"></i> Voucher Promo</div>
                        <i class="bi bi-chevron-right text-muted d-lg-none"></i>
                    </a>
                    <a href="#" class="menu-item">
                        <div><i class="bi bi-shield-lock icon"></i> Keamanan & Password</div>
                        <i class="bi bi-chevron-right text-muted d-lg-none"></i>
                    </a>
                    <a href="#" class="menu-item">
                        <div><i class="bi bi-bell icon"></i> Notifikasi</div>
                        <i class="bi bi-chevron-right text-muted d-lg-none"></i>
                    </a>
                    <a href="#" class="menu-item">
                        <div><i class="bi bi-question-circle icon"></i> Bantuan & FAQ</div>
                        <i class="bi bi-chevron-right text-muted d-lg-none"></i>
                    </a>
                </div>
                
                <div class="logout-wrapper">
                    <form method="POST" action="{{ route('customer.logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100" style="border-radius: 12px; font-weight: 600; padding: 0.7rem;">
                            Keluar Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Area (Only visible on PC) -->
        <div class="col-lg-8 col-xl-9 d-none d-lg-block">
            <div class="fade-in" style="animation-delay: 0.1s;">
                <div class="mb-4">
                    <h2 class="section-title">Pengaturan Akun</h2>
                    <p class="text-muted" style="font-size: 1.05rem;">Berisi informasi akun, profil dan ubah password.</p>
                </div>

                <div class="content-card">
                    <div style="border-bottom: 1px solid rgba(0,0,0,0.1); margin-bottom: 2rem;">
                        <span style="display: inline-block; padding-bottom: 1rem; border-bottom: 3px solid var(--accent); color: var(--accent); font-weight: 700; font-size: 0.95rem; letter-spacing: 0.5px;">
                            PROFIL
                        </span>
                    </div>
                    
                    <form action="#" method="POST">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" placeholder="Masukkan nomor telepon">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi</label>
                                <select class="form-select">
                                    <option>Pilih Provinsi</option>
                                    <option>DKI Jakarta</option>
                                    <option>Jawa Barat</option>
                                    <option>Jawa Tengah</option>
                                    <option>Jawa Timur</option>
                                    <option>Bali</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kota/Kabupaten</label>
                                <select class="form-select">
                                    <option>Pilih Kota</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select">
                                    <option>-- Pilih Jenis Kelamin --</option>
                                    <option>Laki-laki</option>
                                    <option>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Profesi</label>
                                <input type="text" class="form-control" placeholder="Masukkan Profesi">
                            </div>
                            
                            <div class="col-12 mt-4 pt-2">
                                <button type="button" class="btn text-white px-5 py-2.5" style="background-color: var(--accent); border-radius: 12px; font-weight: 600; font-size: 1rem;">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
