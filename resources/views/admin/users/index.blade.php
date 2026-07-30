@extends('layouts.admin')

@section('page_title', 'Manajemen Pengguna')

@section('content')
<style>
    .page-hero { position: relative; background: var(--gradient-primary); border-radius: var(--radius-lg); padding: 1.75rem 2rem; margin-bottom: 1.75rem; overflow: hidden; box-shadow: var(--shadow-glow-primary); }
    .page-hero::before { content: ''; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; border-radius: 50%; background: rgba(201,168,76,0.1); pointer-events: none; }
    .page-hero::after  { content: ''; position: absolute; bottom: -35px; left: 40%; width: 140px; height: 140px; border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events: none; }
    .page-hero-content { position: relative; z-index: 1; }
    .page-hero-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(201,168,76,0.2); border: 1px solid rgba(201,168,76,0.35); color: var(--brand-accent-light); font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; padding: 0.25rem 0.7rem; border-radius: var(--radius-pill); margin-bottom: 0.5rem; }
    .page-hero-title { font-size: 1.45rem; font-weight: 800; color: #fff; letter-spacing: -0.03em; margin-bottom: 0.2rem; }
    .page-hero-subtitle { font-size: 0.82rem; color: rgba(255,255,255,0.55); font-weight: 500; margin: 0; }
    .btn-hero-add { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.84rem; font-weight: 700; border-radius: var(--radius-sm); padding: 0.6rem 1.25rem; background: var(--gradient-accent); color: var(--brand-primary); border: none; text-decoration: none; box-shadow: var(--shadow-glow-accent); transition: all 0.2s; cursor: pointer; white-space: nowrap; }
    .btn-hero-add:hover { transform: translateY(-2px); opacity: 0.9; color: var(--brand-primary); }
    .alert-premium { display: flex; align-items: center; gap: 0.75rem; border-radius: var(--radius-sm); padding: 0.85rem 1.1rem; font-size: 0.84rem; font-weight: 500; margin-bottom: 1rem; }
    .alert-premium.success { background: rgba(16,185,129,0.08); color: #065f46; border: 1px solid rgba(16,185,129,0.2); }
    .alert-premium.danger  { background: rgba(239,68,68,0.08);  color: #991b1b; border: 1px solid rgba(239,68,68,0.2); }
    .alert-premium .btn-close { margin-left: auto; }
    .stat-cards-row { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem; }
    .stat-card { flex: 1; min-width: 140px; background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); padding: 1rem 1.25rem; display: flex; align-items: center; gap: 0.9rem; transition: box-shadow 0.2s, transform 0.2s; }
    .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .stat-card-icon { width: 42px; height: 42px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .stat-card-icon.primary { background: rgba(27,61,47,0.08);  color: var(--brand-primary); }
    .stat-card-icon.info    { background: rgba(59,130,246,0.1); color: var(--info); }
    .stat-card-icon.warning { background: rgba(201,168,76,0.1); color: #A37D2A; }
    .stat-card-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); margin-bottom: 0.1rem; }
    .stat-card-value { font-size: 1.35rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.02em; line-height: 1; }
    .user-table-card { background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); overflow: hidden; }
    .user-table-header { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border-subtle); }
    .user-table-title { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; }
    .count-badge { background: rgba(27,61,47,0.08); color: var(--brand-primary); font-size: 0.68rem; font-weight: 700; padding: 0.15rem 0.55rem; border-radius: var(--radius-pill); }
    .user-table { width: 100%; border-collapse: collapse; }
    .user-table thead tr { background: var(--bg-app); border-bottom: 1px solid var(--border-subtle); }
    .user-table thead th { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); padding: 0.7rem 1rem; white-space: nowrap; }
    .user-table thead th:first-child { padding-left: 1.5rem; }
    .user-table thead th:last-child  { padding-right: 1.5rem; text-align: right; }
    .user-table tbody tr { border-bottom: 1px solid var(--border-subtle); transition: background 0.15s; }
    .user-table tbody tr:last-child { border-bottom: none; }
    .user-table tbody tr:hover { background: rgba(27,61,47,0.025); }
    .user-table tbody td { padding: 0.85rem 1rem; vertical-align: middle; }
    .user-table tbody td:first-child { padding-left: 1.5rem; }
    .user-table tbody td:last-child  { padding-right: 1.5rem; }
    .user-avatar { width: 36px; height: 36px; border-radius: var(--radius-pill); background: var(--gradient-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.82rem; font-weight: 800; flex-shrink: 0; letter-spacing: -0.02em; }
    .user-name { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); }
    .user-email { font-size: 0.75rem; color: var(--text-tertiary); font-weight: 500; }
    .email-link { color: var(--info); text-decoration: none; font-size: 0.82rem; font-weight: 500; }
    .email-link:hover { text-decoration: underline; }
    .role-badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.72rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: var(--radius-pill); }
    .role-badge.pengelola { background: rgba(201,168,76,0.1); color: #A37D2A; border: 1px solid rgba(201,168,76,0.25); }
    .role-badge.pemilik   { background: rgba(59,130,246,0.08); color: var(--info); border: 1px solid rgba(59,130,246,0.2); }
    .role-badge.admin     { background: rgba(239,68,68,0.08); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
    .role-badge.default   { background: rgba(27,61,47,0.08); color: var(--brand-primary); border: 1px solid rgba(27,61,47,0.15); }
    .action-btn-group { display: flex; align-items: center; justify-content: flex-end; gap: 0.35rem; }
    .action-btn { width: 32px; height: 32px; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); background: var(--surface); display: inline-flex; align-items: center; justify-content: center; font-size: 0.82rem; text-decoration: none; transition: all 0.15s; cursor: pointer; color: var(--text-secondary); }
    .action-btn:hover { transform: translateY(-1px); box-shadow: var(--shadow-xs); }
    .action-btn.edit:hover   { background: rgba(59,130,246,0.08); color: var(--info);   border-color: rgba(59,130,246,0.2); }
    .action-btn.delete:hover { background: rgba(239,68,68,0.08);  color: var(--danger); border-color: rgba(239,68,68,0.2); }
    .pagination-wrap { padding: 0.85rem 1.5rem; border-top: 1px solid var(--border-subtle); background: var(--bg-app); }
    /* Modal premium */
    .modal-premium .modal-content { border-radius: var(--radius-md) !important; border: none !important; box-shadow: var(--shadow-lg) !important; overflow: hidden; }
    .modal-premium .modal-hero { background: var(--gradient-primary); padding: 1.35rem 1.5rem; position: relative; overflow: hidden; }
    .modal-premium .modal-hero::before { content: ''; position: absolute; top: -30px; right: -30px; width: 100px; height: 100px; border-radius: 50%; background: rgba(201,168,76,0.15); }
    .modal-premium .modal-hero-title { font-size: 0.95rem; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 0.5rem; position: relative; z-index: 1; }
    .modal-premium .modal-hero-icon { width: 34px; height: 34px; border-radius: var(--radius-sm); background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1rem; flex-shrink: 0; }
    .modal-premium .modal-body-inner { padding: 1.5rem 1.5rem 0.5rem; }
    .modal-premium .modal-footer-inner { padding: 1rem 1.5rem 1.25rem; display: flex; justify-content: flex-end; gap: 0.5rem; border-top: 1px solid var(--border-subtle); }
    .fi-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-bottom: 0.4rem; display: block; }
    .fi-label span { color: var(--danger); }
    .fi-input { width: 100%; background: var(--bg-app); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 0.6rem 0.9rem; font-size: 0.84rem; font-weight: 500; color: var(--text-primary); transition: border-color 0.15s, box-shadow 0.15s; outline: none; appearance: auto; }
    .fi-input:focus { border-color: var(--brand-primary); box-shadow: 0 0 0 3px rgba(27,61,47,0.08); background: var(--surface); }
    .fi-divider { border: none; border-top: 1px solid var(--border-subtle); margin: 1rem 0; }
    .btn-submit { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.84rem; font-weight: 700; background: var(--gradient-primary); color: #fff; border: none; border-radius: var(--radius-sm); padding: 0.6rem 1.4rem; cursor: pointer; box-shadow: var(--shadow-glow-primary); transition: opacity 0.15s; }
    .btn-submit:hover { opacity: 0.88; }
    .btn-cancel { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.84rem; font-weight: 600; background: var(--bg-app); color: var(--text-secondary); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 0.6rem 1.2rem; cursor: pointer; transition: background 0.15s; }
    .btn-cancel:hover { background: #e2e5ea; color: var(--text-primary); }
    .is-invalid-fi { border-color: var(--danger) !important; }
    .invalid-feedback-fi { font-size: 0.72rem; color: var(--danger); margin-top: 0.25rem; }
</style>

<div class="container-fluid px-0 animate-in">

    <!-- HERO -->
    <div class="page-hero mb-4">
        <div class="page-hero-content d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="page-hero-badge"><i class="bi bi-people-fill"></i> Sistem</div>
                <h1 class="page-hero-title">Manajemen Pengguna</h1>
                <p class="page-hero-subtitle">Kelola akun pengguna dan hak akses sistem</p>
            </div>
            <button type="button" class="btn-hero-add" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-person-plus-fill"></i> Tambah User
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-premium success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert-premium danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>Terdapat kesalahan input form. Silakan periksa kembali isian Anda.</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- STAT CARDS -->
    <div class="stat-cards-row">
        <div class="stat-card">
            <div class="stat-card-icon primary"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-card-label">Total Pengguna</div>
                <div class="stat-card-value">{{ $users->total() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon warning"><i class="bi bi-person-badge-fill"></i></div>
            <div>
                <div class="stat-card-label">Pengelola</div>
                <div class="stat-card-value">{{ $users->filter(fn($u) => $u->hasRole('pengelola'))->count() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon info"><i class="bi bi-house-fill"></i></div>
            <div>
                <div class="stat-card-label">Pemilik Villa</div>
                <div class="stat-card-value">{{ $users->filter(fn($u) => $u->hasRole('pemilik'))->count() }}</div>
            </div>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="user-table-card">
        <div class="user-table-header">
            <div class="user-table-title">
                <i class="bi bi-list-ul" style="color: var(--brand-primary);"></i>
                Daftar Pengguna Sistem
                <span class="count-badge">{{ $users->total() }} total</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                    <div>
                                        <div class="user-name">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:{{ $user->email }}" class="email-link">{{ $user->email }}</a>
                            </td>
                            <td>
                                @foreach($user->roles as $role)
                                    @php
                                        $roleClass = match($role->name) {
                                            'pengelola' => 'pengelola',
                                            'pemilik'   => 'pemilik',
                                            'admin'     => 'admin',
                                            default     => 'default'
                                        };
                                        $roleIcon = match($role->name) {
                                            'pengelola' => 'bi-person-badge-fill',
                                            'pemilik'   => 'bi-house-fill',
                                            'admin'     => 'bi-shield-fill',
                                            default     => 'bi-person-fill'
                                        };
                                    @endphp
                                    <span class="role-badge {{ $roleClass }}">
                                        <i class="bi {{ $roleIcon }}"></i>
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="action-btn edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="pagination-wrap">{{ $users->links() }}</div>
        @endif
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade modal-premium" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-hero d-flex align-items-center justify-content-between">
                <div class="modal-hero-title">
                    <div class="modal-hero-icon"><i class="bi bi-person-plus-fill"></i></div>
                    Tambah Pengguna Baru
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('users.store') }}">
                <div class="modal-body-inner">
                    @csrf
                    <input type="hidden" name="form_type" value="create">
                    <div class="mb-3">
                        <label class="fi-label">Nama Lengkap <span>*</span></label>
                        <input type="text" class="fi-input @error('name') is-invalid-fi @enderror" name="name" value="{{ old('form_type') == 'create' ? old('name') : '' }}" required placeholder="Cth: Budi Santoso">
                        @if(old('form_type') == 'create') @error('name')<div class="invalid-feedback-fi">{{ $message }}</div>@enderror @endif
                    </div>
                    <div class="mb-3">
                        <label class="fi-label">Alamat Email <span>*</span></label>
                        <input type="email" class="fi-input @error('email') is-invalid-fi @enderror" name="email" value="{{ old('form_type') == 'create' ? old('email') : '' }}" required placeholder="Cth: budi@villa.com">
                        @if(old('form_type') == 'create') @error('email')<div class="invalid-feedback-fi">{{ $message }}</div>@enderror @endif
                    </div>
                    <div class="mb-3">
                        <label class="fi-label">Role Akses <span>*</span></label>
                        <select class="fi-input @error('role') is-invalid-fi @enderror" name="role" required>
                            <option value="" disabled selected>Pilih tingkat akses</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ (old('form_type') == 'create' && old('role') == $role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        @if(old('form_type') == 'create') @error('role')<div class="invalid-feedback-fi">{{ $message }}</div>@enderror @endif
                    </div>
                    <hr class="fi-divider">
                    <div class="mb-3">
                        <label class="fi-label">Password Sistem <span>*</span></label>
                        <input type="password" class="fi-input @error('password') is-invalid-fi @enderror" name="password" required placeholder="Minimal 8 karakter">
                        @if(old('form_type') == 'create') @error('password')<div class="invalid-feedback-fi">{{ $message }}</div>@enderror @endif
                    </div>
                    <div class="mb-3">
                        <label class="fi-label">Konfirmasi Password <span>*</span></label>
                        <input type="password" class="fi-input" name="password_confirmation" required placeholder="Ulangi password di atas">
                    </div>
                </div>
                <div class="modal-footer-inner">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit"><i class="bi bi-check-lg"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modals Edit -->
@foreach($users as $user)
<div class="modal fade modal-premium" id="editModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-hero d-flex align-items-center justify-content-between">
                <div class="modal-hero-title">
                    <div class="modal-hero-icon"><i class="bi bi-pencil-fill"></i></div>
                    Edit: <span style="color:var(--brand-accent-light);">{{ $user->name }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('users.update', $user) }}">
                <div class="modal-body-inner">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_type" value="edit_{{ $user->id }}">
                    <div class="mb-3">
                        <label class="fi-label">Nama Lengkap <span>*</span></label>
                        <input type="text" class="fi-input @error('name') is-invalid-fi @enderror" name="name" value="{{ old('form_type') == 'edit_'.$user->id ? old('name') : $user->name }}" required>
                        @if(old('form_type') == 'edit_'.$user->id) @error('name')<div class="invalid-feedback-fi">{{ $message }}</div>@enderror @endif
                    </div>
                    <div class="mb-3">
                        <label class="fi-label">Alamat Email <span>*</span></label>
                        <input type="email" class="fi-input @error('email') is-invalid-fi @enderror" name="email" value="{{ old('form_type') == 'edit_'.$user->id ? old('email') : $user->email }}" required>
                        @if(old('form_type') == 'edit_'.$user->id) @error('email')<div class="invalid-feedback-fi">{{ $message }}</div>@enderror @endif
                    </div>
                    <div class="mb-3">
                        <label class="fi-label">Role Akses <span>*</span></label>
                        <select class="fi-input @error('role') is-invalid-fi @enderror" name="role" required>
                            @foreach($roles as $role)
                                @php
                                    $oldRole = old('form_type') == 'edit_'.$user->id ? old('role') : null;
                                    $isSelected = $oldRole ? ($oldRole == $role->name) : ($user->roles->first()?->name == $role->name);
                                @endphp
                                <option value="{{ $role->name }}" {{ $isSelected ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        @if(old('form_type') == 'edit_'.$user->id) @error('role')<div class="invalid-feedback-fi">{{ $message }}</div>@enderror @endif
                    </div>
                    <hr class="fi-divider">
                    <div class="mb-3">
                        <label class="fi-label">Password Baru <small style="font-weight:500;text-transform:none;letter-spacing:0;">(Opsional)</small></label>
                        <input type="password" class="fi-input @error('password') is-invalid-fi @enderror" name="password" placeholder="Biarkan kosong jika tidak diubah">
                        @if(old('form_type') == 'edit_'.$user->id) @error('password')<div class="invalid-feedback-fi">{{ $message }}</div>@enderror @endif
                    </div>
                    <div class="mb-3">
                        <label class="fi-label">Konfirmasi Password Baru</label>
                        <input type="password" class="fi-input" name="password_confirmation" placeholder="••••••••">
                    </div>
                </div>
                <div class="modal-footer-inner">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit"><i class="bi bi-check-lg"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@if($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var formType = "{{ old('form_type') }}";
        if(formType === 'create') {
            var myModal = new bootstrap.Modal(document.getElementById('createModal'));
            myModal.show();
        } else if(formType.startsWith('edit_')) {
            var userId = formType.split('_')[1];
            var myModal = new bootstrap.Modal(document.getElementById('editModal' + userId));
            myModal.show();
        }
    });
</script>
@endif

@endsection
