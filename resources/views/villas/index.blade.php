@extends('layouts.admin')

@section('page_title', 'Manajemen Villa')

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
        <span class="fs-5 fw-bold text-dark">Daftar Villa</span>
        <button type="button" class="btn btn-sm btn-primary py-2 px-3" data-bs-toggle="modal" data-bs-target="#createVillaModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Villa
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3">Nama Villa</th>
                    <th class="py-3">Email Kontak</th>
                    <th class="py-3">Pemilik</th>
                    <th class="text-end pe-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($villas as $villa)
                    <tr>
                        <td class="ps-4 fw-medium text-dark">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 text-warning rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-house-door-fill fs-5"></i>
                                </div>
                                <div>{{ $villa->name }}</div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $villa->email }}</td>
                        <td>
                            <span class="badge rounded-pill bg-light text-dark border px-2 py-1 fw-medium" style="font-size: 0.75rem;">
                                {{ $villa->pemilik->name }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm rounded-pill" role="group">
                                <button type="button" class="btn btn-sm btn-light border" title="Edit" data-bs-toggle="modal" data-bs-target="#editVillaModal{{ $villa->id }}">
                                    <i class="bi bi-pencil text-muted"></i>
                                </button>
                                <form action="{{ route('villas.destroy', $villa) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus villa ini? Seluruh data transaksi juga akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger" title="Hapus" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Belum ada data villa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($villas->hasPages())
    <div class="card-footer bg-white border-top py-3 px-4">
        {{ $villas->links() }}
    </div>
    @endif
</div>

<!-- Modal Create Villa -->
<div class="modal fade" id="createVillaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow" style="border-radius: var(--fi-radius);">
      <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
        <h5 class="modal-title fw-bold">Tambah Villa Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('villas.store') }}">
          <div class="modal-body px-4 pt-4 pb-2">
              @csrf
              <input type="hidden" name="form_type" value="create_villa">

              <div class="mb-3">
                  <label for="pemilik_id" class="form-label fw-medium text-dark small">Pilih Pemilik</label>
                  <select class="form-select @error('pemilik_id') is-invalid @enderror" id="pemilik_id" name="pemilik_id" required>
                      <option value="" selected disabled>Pilih User Pemilik</option>
                      @foreach($pemiliks as $pemilik)
                          <option value="{{ $pemilik->id }}" {{ (old('form_type') == 'create_villa' && old('pemilik_id') == $pemilik->id) ? 'selected' : '' }}>
                              {{ $pemilik->name }} ({{ $pemilik->email }})
                          </option>
                      @endforeach
                  </select>
                  @if(old('form_type') == 'create_villa')
                    @error('pemilik_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label for="name" class="form-label fw-medium text-dark small">Nama Villa</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('form_type') == 'create_villa' ? old('name') : '' }}" required placeholder="Cth: Villa Sunset Paradise">
                  @if(old('form_type') == 'create_villa')
                    @error('name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label for="email" class="form-label fw-medium text-dark small">Email Kontak</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('form_type') == 'create_villa' ? old('email') : '' }}" required placeholder="Cth: info@villa.com">
                  @if(old('form_type') == 'create_villa')
                    @error('email')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label for="description" class="form-label fw-medium text-dark small">Deskripsi (Opsional)</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Keterangan singkat tentang villa...">{{ old('form_type') == 'create_villa' ? old('description') : '' }}</textarea>
                  @if(old('form_type') == 'create_villa')
                    @error('description')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4">Simpan Villa</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modals Edit Villa -->
@foreach($villas as $villa)
<div class="modal fade" id="editVillaModal{{ $villa->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow" style="border-radius: var(--fi-radius);">
      <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
        <h5 class="modal-title fw-bold">Edit Villa: {{ $villa->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('villas.update', $villa) }}">
          <div class="modal-body px-4 pt-4 pb-2">
              @csrf
              @method('PUT')
              <input type="hidden" name="form_type" value="edit_villa_{{ $villa->id }}">

              <div class="mb-3">
                  <label class="form-label fw-medium text-dark small">Pilih Pemilik</label>
                  <select class="form-select @error('pemilik_id') is-invalid @enderror" name="pemilik_id" required>
                      @foreach($pemiliks as $pemilik)
                          <option value="{{ $pemilik->id }}" {{ (old('form_type') == 'edit_villa_'.$villa->id ? old('pemilik_id') : $villa->pemilik_id) == $pemilik->id ? 'selected' : '' }}>
                              {{ $pemilik->name }}
                          </option>
                      @endforeach
                  </select>
                  @if(old('form_type') == 'edit_villa_'.$villa->id)
                    @error('pemilik_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label class="form-label fw-medium text-dark small">Nama Villa</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('form_type') == 'edit_villa_'.$villa->id ? old('name') : $villa->name }}" required>
                  @if(old('form_type') == 'edit_villa_'.$villa->id)
                    @error('name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label class="form-label fw-medium text-dark small">Email Kontak</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('form_type') == 'edit_villa_'.$villa->id ? old('email') : $villa->email }}" required>
                  @if(old('form_type') == 'edit_villa_'.$villa->id)
                    @error('email')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>

              <div class="mb-3">
                  <label class="form-label fw-medium text-dark small">Deskripsi (Opsional)</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('form_type') == 'edit_villa_'.$villa->id ? old('description') : $villa->description }}</textarea>
                  @if(old('form_type') == 'edit_villa_'.$villa->id)
                    @error('description')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                  @endif
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4">Update Villa</button>
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
        if(formType === 'create_villa') {
            var myModal = new bootstrap.Modal(document.getElementById('createVillaModal'));
            myModal.show();
        } else if(formType && formType.startsWith('edit_villa_')) {
            var villaId = formType.split('edit_villa_')[1];
            var myModal = new bootstrap.Modal(document.getElementById('editVillaModal' + villaId));
            myModal.show();
        }
    });
</script>
@endif
@endsection
