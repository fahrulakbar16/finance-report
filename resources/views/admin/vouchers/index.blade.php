@extends('layouts.admin')

@section('page_title', 'Manajemen Voucher')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4 animate-in">
    <div class="page-header-fi">
        <h4>Manajemen Voucher</h4>
        <p>Kelola daftar voucher diskon untuk pengguna villa.</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-brand d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createVoucherModal">
            <i class="bi bi-plus-lg me-2"></i> Tambah Voucher Baru
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Terdapat kesalahan!</strong> Silakan periksa kembali input Anda.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card card-fi animate-in" style="animation-delay: 0.1s;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Voucher</th>
                        <th>Tipe Diskon</th>
                        <th>Jumlah Diskon</th>
                        <th>Penggunaan</th>
                        <th>Batas Waktu</th>
                        <th>Status</th>
                        <th width="15%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vouchers as $index => $voucher)
                    <tr>
                        <td class="text-muted">{{ $vouchers->firstItem() + $index }}</td>
                        <td>
                            <span class="fw-bold text-dark">{{ $voucher->code }}</span>
                        </td>
                        <td>
                            @if($voucher->discount_type === 'percentage')
                                <span class="badge bg-info bg-opacity-10 text-info px-2 py-1 border border-info border-opacity-25 rounded-pill">Persentase</span>
                            @else
                                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 border border-primary border-opacity-25 rounded-pill">Nominal</span>
                            @endif
                        </td>
                        <td class="fw-medium">
                            @if($voucher->discount_type === 'percentage')
                                {{ $voucher->discount_amount }}%
                            @else
                                Rp {{ number_format($voucher->discount_amount, 0, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                {{ $voucher->used_count }} / {{ $voucher->usage_limit ?: '∞' }}
                            </div>
                        </td>
                        <td>
                            @if($voucher->valid_until)
                                <span class="{{ $voucher->valid_until->isPast() ? 'text-danger' : 'text-success' }}">
                                    {{ $voucher->valid_until->format('d M Y H:i') }}
                                </span>
                            @else
                                <span class="text-muted">Tanpa Batas</span>
                            @endif
                        </td>
                        <td>
                            @if($voucher->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 border border-success border-opacity-25 rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i> Aktif
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 border border-danger border-opacity-25 rounded-pill">
                                    <i class="bi bi-x-circle me-1"></i> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editVoucherModal{{ $voucher->id }}" title="Edit Voucher">
                                    <i class="bi bi-pencil-square text-primary"></i>
                                </button>
                                <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus voucher ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light" title="Hapus Voucher">
                                        <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted mb-2"><i class="bi bi-ticket-perforated fs-1"></i></div>
                            <h6 class="fw-bold mb-1">Belum ada data voucher</h6>
                            <p class="small text-muted mb-3">Silakan tambahkan voucher diskon baru untuk pelanggan.</p>
                            <button type="button" class="btn btn-sm btn-brand" data-bs-toggle="modal" data-bs-target="#createVoucherModal">Tambah Voucher</button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($vouchers->hasPages())
    <div class="card-footer bg-transparent border-0 pt-3 pb-3 px-4">
        {{ $vouchers->links() }}
    </div>
    @endif
</div>

<!-- Create Modal -->
<div class="modal fade" id="createVoucherModal" tabindex="-1" aria-labelledby="createVoucherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-lg);">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="createVoucherModalLabel">Tambah Voucher Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('vouchers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Voucher <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="code" required placeholder="Contoh: PROMO2024" style="text-transform: uppercase;">
                        <div class="form-text">Gunakan huruf kapital dan angka tanpa spasi.</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipe Diskon <span class="text-danger">*</span></label>
                            <select class="form-select" name="discount_type" required>
                                <option value="" disabled selected>Pilih Tipe</option>
                                <option value="percentage">Persentase (%)</option>
                                <option value="fixed">Nominal (Rp)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label fw-bold">Jumlah Diskon <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="discount_amount" required min="0" placeholder="Contoh: 10">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Batas Penggunaan</label>
                            <input type="number" class="form-control" name="usage_limit" min="1" placeholder="Kosong = tak terbatas">
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label fw-bold">Berlaku Hingga</label>
                            <input type="datetime-local" class="form-control" name="valid_until">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked style="cursor: pointer;">
                            <label class="form-check-label fw-bold" style="cursor: pointer;">Status Aktif</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-brand">Simpan Voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Create Modal -->

<!-- Edit Modals -->
@foreach($vouchers as $voucher)
<div class="modal fade" id="editVoucherModal{{ $voucher->id }}" tabindex="-1" aria-labelledby="editVoucherModalLabel{{ $voucher->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-lg);">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="editVoucherModalLabel{{ $voucher->id }}">Edit Voucher: {{ $voucher->code }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Voucher <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="code" value="{{ $voucher->code }}" required placeholder="Contoh: PROMO2024" style="text-transform: uppercase;">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipe Diskon <span class="text-danger">*</span></label>
                            <select class="form-select" name="discount_type" required>
                                <option value="percentage" {{ $voucher->discount_type == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                <option value="fixed" {{ $voucher->discount_type == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label fw-bold">Jumlah Diskon <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="discount_amount" value="{{ $voucher->discount_amount }}" required min="0">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Batas Penggunaan</label>
                            <input type="number" class="form-control" name="usage_limit" value="{{ $voucher->usage_limit }}" min="0" placeholder="Kosong = tak terbatas">
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label fw-bold">Berlaku Hingga</label>
                            <input type="datetime-local" class="form-control" name="valid_until" value="{{ $voucher->valid_until ? $voucher->valid_until->format('Y-m-d\TH:i') : '' }}">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $voucher->is_active ? 'checked' : '' }} style="cursor: pointer;">
                            <label class="form-check-label fw-bold" style="cursor: pointer;">Status Aktif</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-brand">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- End Edit Modals -->

@endsection
