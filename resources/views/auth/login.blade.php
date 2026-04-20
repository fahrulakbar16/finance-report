@extends('layouts.app')

@section('content')
<div class="container" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-pilled" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-dark text-white text-center py-4 border-0">
                    <h3 class="mb-0 fw-bold">Villa Finance</h3>
                    <p class="mb-0 mt-1 text-white-50 small">Sistem Manajemen Laporan Keuangan</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <h5 class="text-center mb-4 fw-semibold text-muted">Silakan Login ke Akun Anda</h5>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label text-muted fw-bold small">{{ __('Alamat Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 ps-0 bg-light @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@villa.com">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label mb-0 text-muted fw-bold small">{{ __('Password') }}</label>
                                @if (Route::has('password.request'))
                                    <a class="small text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Lupa Password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                <input id="password" type="password" class="form-control border-start-0 ps-0 bg-light @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted small" for="remember">
                                    {{ __('Simpan Sesi Login (Remember Me)') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-2">
                            <button type="submit" class="btn btn-dark btn-lg py-2 fw-semibold">
                                {{ __('Masuk ke Dashboard') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4 text-muted small">
                &copy; {{ date('Y') }} Villa Finance Management. All rights reserved.
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f0f2f5; }
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
        background-color: #fff !important;
    }
    .input-group-text { padding-right: 0.5rem; }
</style>
@endsection
