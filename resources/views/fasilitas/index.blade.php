@extends('layouts.admin')

@section('page_title', 'Manajemen Fasilitas')

@section('content')
<div class="container-fluid px-0">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div class="page-header-fi">
            <h4>Manajemen Fasilitas</h4>
            <p>Kelola data fasilitas villa</p>
        </div>
        <a href="{{ route('fasilitas.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm rounded-3 px-3 py-2">
            <i class="bi bi-plus-lg fs-5"></i>
            <span class="fw-medium">Tambah Fasilitas</span>
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
        <h5 class="fw-bold text-dark mb-0">Daftar Fasilitas</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-fi mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-4 py-3">Ikon</th>
                    <th class="py-3">Nama Fasilitas</th>
                    <th class="text-end pe-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fasilitas as $item)
                <tr>
                    <td class="ps-4 py-3">
                        @if($item->ikon)
                        <i class="{{ $item->ikon }} fs-4 text-primary"></i>
                        @else
                        -
                        @endif
                    </td>
                    <td class="py-3">
                        <span class="fw-medium text-dark">{{ $item->nama }}</span>
                    </td>
                    <td class="text-end pe-4 py-3">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('fasilitas.edit', $item->id) }}" class="btn btn-sm btn-light text-primary border rounded-3" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn btn-sm btn-light text-danger border rounded-3" data-bs-toggle="modal" data-bs-target="#deleteFasilitasModal{{ $item->id }}" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>



                <!-- Delete Modal -->
                <div class="modal fade" id="deleteFasilitasModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content border-0 shadow" style="border-radius: var(--fi-radius);">
                            <div class="modal-body p-4 text-center">
                                <div class="text-danger mb-3">
                                    <i class="bi bi-exclamation-circle" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Hapus Fasilitas?</h5>
                                <p class="text-muted mb-4">Fasilitas <strong>{{ $item->nama }}</strong> akan dihapus permanen.</p>
                                <form action="{{ route('fasilitas.destroy', $item->id) }}" method="POST" class="d-flex gap-2 w-100">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-light flex-fill" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger flex-fill">Ya, Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-5">
                        <div class="text-muted mb-2">
                            <i class="bi bi-inbox fs-1"></i>
                        </div>
                        <p class="mb-0">Belum ada data fasilitas</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($fasilitas->hasPages())
    <div class="card-footer bg-white border-top-0 p-4">
        {{ $fasilitas->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

</div>

@endsection
