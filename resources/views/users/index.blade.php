@extends('layouts.admin')

@section('page_title', 'Manajemen Pengguna')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: var(--fi-radius);">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: var(--fi-radius);">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>Terdapat kesalahan input form. Silakan periksa kembali isian Anda.</div>
        </div>
        <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center border-0 pt-4 pb-3 px-4">
        <span class="fs-5 fw-bold text-dark">Daftar Pengguna Sistem</span>
        <button type="button" class="btn btn-sm btn-primary py-2 px-3" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah User
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3">Nama</th>
                    <th class="py-3">Email</th>
                    <th class="py-3">Role</th>
                    <th class="text-end pe-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="ps-4 fw-medium text-dark">{{ $user->name }}</td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning border border-warning border-opacity-50 px-2 py-1 fw-medium" style="font-size: 0.75rem;">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm rounded-pill" role="group">
                                <button type="button" class="btn btn-sm btn-light border" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">
                                    <i class="bi bi-pencil text-muted"></i>
                                </button>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger" title="Hapus" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                        <i class="bi bi-trash"></i>
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
    <div class="card-footer bg-white border-top py-3 px-4">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow" style="border-radius: var(--fi-radius);">
      <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
        <h5 class="modal-title fw-bold" id="createModalLabel">Tambah Pengguna Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('users.store') }}">
          <div class="modal-body px-4 pt-4 pb-2">
              @csrf
              <input type="hidden" name="form_type" value="create">

              <div class="mb-3">
                  <label for="name" class="form-label fw-medium text-dark small">Nama Lengkap</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('form_type') == 'create' ? old('name') : '' }}" required placeholder="Cth: Budi Santoso">
                  @if(old('form_type') == 'create')
                    @error('name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label for="email" class="form-label fw-medium text-dark small">Alamat Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('form_type') == 'create' ? old('email') : '' }}" required placeholder="Cth: budi@villa.com">
                  @if(old('form_type') == 'create')
                    @error('email')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label for="role" class="form-label fw-medium text-dark small">Role Akses</label>
                  <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                      <option value="" selected disabled>Pilih tingkat akses</option>
                      @foreach($roles as $role)
                          <option value="{{ $role->name }}" {{ (old('form_type') == 'create' && old('role') == $role->name) ? 'selected' : '' }}>
                              {{ ucfirst($role->name) }}
                          </option>
                      @endforeach
                  </select>
                  @if(old('form_type') == 'create')
                    @error('role')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label for="password" class="form-label fw-medium text-dark small">Password Sistem</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimal 8 karakter">
                  @if(old('form_type') == 'create')
                    @error('password')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label for="password-confirm" class="form-label fw-medium text-dark small">Konfirmasi Password</label>
                  <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required placeholder="Ulangi password di atas">
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modals Edit -->
@foreach($users as $user)
<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow" style="border-radius: var(--fi-radius);">
      <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
        <h5 class="modal-title fw-bold" id="editModalLabel{{ $user->id }}">Edit Pengguna: {{ $user->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('users.update', $user) }}">
          <div class="modal-body px-4 pt-4 pb-2">
              @csrf
              @method('PUT')
              <input type="hidden" name="form_type" value="edit_{{ $user->id }}">

              <div class="mb-3">
                  <label class="form-label fw-medium text-dark small">Nama Lengkap</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('form_type') == 'edit_'.$user->id ? old('name') : $user->name }}" required>
                  @if(old('form_type') == 'edit_'.$user->id)
                    @error('name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label class="form-label fw-medium text-dark small">Alamat Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('form_type') == 'edit_'.$user->id ? old('email') : $user->email }}" required>
                  @if(old('form_type') == 'edit_'.$user->id)
                    @error('email')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label class="form-label fw-medium text-dark small">Role Akses</label>
                  <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                      @foreach($roles as $role)
                          @php
                              $oldRole = old('form_type') == 'edit_'.$user->id ? old('role') : null;
                              $isSelected = $oldRole ? ($oldRole == $role->name) : ($user->roles->first()?->name == $role->name);
                          @endphp
                          <option value="{{ $role->name }}" {{ $isSelected ? 'selected' : '' }}>
                              {{ ucfirst($role->name) }}
                          </option>
                      @endforeach
                  </select>
                  @if(old('form_type') == 'edit_'.$user->id)
                    @error('role')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>
              
              <hr class="my-3 text-muted bg-opacity-10">

              <div class="mb-3">
                  <label class="form-label fw-medium text-dark small">Password Sistem <span class="text-muted fw-normal">(Opsional)</span></label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Biarkan kosong jika tidak diubah">
                  @if(old('form_type') == 'edit_'.$user->id)
                    @error('password')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label class="form-label fw-medium text-dark small">Konfirmasi Password Baru</label>
                  <input type="password" class="form-control" name="password_confirmation" placeholder="••••••••">
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4">Update Data</button>
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
