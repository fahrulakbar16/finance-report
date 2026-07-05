@extends('layouts.customer')

@section('title', 'Akun Saya - Athara Villas')

@section('header')
    <h1 class="header-title">Akun Saya</h1>
@endsection

@section('styles')
<style>
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
    }
</style>
@endsection

@section('content')

    <div class="profile-header fade-in">
        <div class="profile-avatar">
            <i class="bi bi-person-fill"></i>
        </div>
        <h2 class="profile-name">{{ Auth::user()->name }}</h2>
        <div class="profile-email">{{ Auth::user()->email }}</div>
    </div>

    <div class="menu-group fade-in" style="animation-delay: 0.1s;">
        <a href="#" class="menu-item">
            <div><i class="bi bi-person icon"></i> Edit Profil</div>
            <i class="bi bi-chevron-right text-muted"></i>
        </a>
        <a href="#" class="menu-item">
            <div><i class="bi bi-shield-lock icon"></i> Keamanan & Password</div>
            <i class="bi bi-chevron-right text-muted"></i>
        </a>
        <a href="#" class="menu-item">
            <div><i class="bi bi-bell icon"></i> Notifikasi</div>
            <i class="bi bi-chevron-right text-muted"></i>
        </a>
    </div>

    <div class="menu-group fade-in" style="animation-delay: 0.2s;">
        <a href="#" class="menu-item">
            <div><i class="bi bi-question-circle icon"></i> Bantuan & FAQ</div>
            <i class="bi bi-chevron-right text-muted"></i>
        </a>
        <a href="#" class="menu-item">
            <div><i class="bi bi-file-earmark-text icon"></i> Syarat & Ketentuan</div>
            <i class="bi bi-chevron-right text-muted"></i>
        </a>
    </div>

    <form method="POST" action="{{ route('customer.logout') }}" class="fade-in" style="animation-delay: 0.3s;">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100" style="border-radius: 14px; font-weight: 600; padding: 0.8rem;">
            Keluar Akun
        </button>
    </form>

@endsection
