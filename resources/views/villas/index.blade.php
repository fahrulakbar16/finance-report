@extends('layouts.admin')

@section('page_title', 'Manajemen Villa')

@section('content')
<div class="container-fluid px-0">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div class="page-header-fi">
            <h4>Manajemen Villa</h4>
            <p>Kelola data villa beserta persentase bagi hasil</p>
        </div>
        <a href="{{ route('villas.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm rounded-3 px-3 py-2">
            <i class="bi bi-plus-lg fs-5"></i>
            <span class="fw-medium">Tambah Villa</span>
        </a>
    </div>

@if(session('success'))
    <div class="alert alert-success alert-fi alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-fi alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
        <div>Terdapat kesalahan input form. Silakan periksa kembali isian Anda.</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card card-fi overflow-hidden">
    <div class="card-header d-flex justify-content-between align-items-center pt-4 pb-3 px-4">
        <h5 class="fw-bold text-dark mb-0">Daftar Villa</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-fi mb-0 align-middle">
            <thead>
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
                                <a href="{{ route('villas.show', $villa) }}" class="btn btn-sm btn-light border" title="Detail">
                                    <i class="bi bi-eye text-primary"></i>
                                </a>
                                <a href="{{ route('villas.edit', $villa) }}" class="btn btn-sm btn-light border" title="Edit">
                                    <i class="bi bi-pencil text-muted"></i>
                                </a>
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
                        <td colspan="4" class="empty-state">
                            <i class="bi bi-inbox d-block"></i>
                            Belum ada data villa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($villas->hasPages())
    <div class="pagination-fi">
        {{ $villas->links() }}
    </div>
    @endif
</div>

</div>
@endsection
