@extends('layouts.landing')

@section('title', 'Pembayaran Berhasil')
@section('description', 'Status pembayaran Anda')

@section('content')
<div style="min-height: 70vh; display: flex; align-items: center; justify-content: center; background: var(--bg-main); padding: 4rem 1rem;">
    <div class="text-center" style="background: #fff; padding: 4rem 2rem; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.05); max-width: 600px; width: 100%;">
        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem; margin-bottom: 1rem; display: inline-block;"></i>
        <h2 style="font-family: 'Cormorant Garamond', serif; font-weight: 600; color: var(--primary); margin-bottom: 1rem;">Terima Kasih!</h2>
        <p style="font-size: 1.1rem; color: var(--text-muted); margin-bottom: 2rem;">Silakan selesaikan pembayaran Anda.</p>

        <div style="background: rgba(201,168,76,0.1); padding: 1.5rem; border-radius: 12px; border: 1px dashed var(--accent); margin-bottom: 2.5rem;">
            <p style="margin-bottom: 0.5rem; color: var(--primary);">Simpan Nomor Invoice Anda untuk referensi:</p>
            <h3 style="margin: 0; font-family: monospace; font-weight: bold; color: var(--primary); font-size: 1.5rem;">
                {{ $invoice ?? 'TIDAK DITEMUKAN' }}
            </h3>
        </div>

        <div>
            <a href="{{ route('landing') }}" class="btn-gold" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 500; background: var(--accent); color: #fff;">
                <i class="bi bi-house-door"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
