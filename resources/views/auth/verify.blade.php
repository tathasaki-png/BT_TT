@extends('layouts.app')

@section('title', 'Xác thực OTP')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-envelope-open-text fa-2x"></i>
                        </div>
                        <h2 class="fw-bold">Xác thực Email</h2>
                        <p class="text-muted">Chúng tôi đã gửi mã xác thực gồm 6 chữ số đến email: <br><strong>{{ $email }}</strong></p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('verify.otp') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        
                        <div class="mb-4">
                            <label for="otp" class="form-label fw-semibold">Mã OTP</label>
                            <input type="text" 
                                   name="otp" 
                                   class="form-control form-control-lg text-center fw-bold @error('otp') is-invalid @enderror" 
                                   id="otp" 
                                   placeholder="000000" 
                                   maxlength="6" 
                                   autofocus
                                   required>
                            @error('otp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-2 text-center">
                                Vui lòng nhập mã OTP để hoàn tất đăng ký.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                                Xác thực tài khoản
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-2 text-muted">Bạn không nhận được mã?</p>
                        <form action="{{ route('resend.otp') }}" method="POST">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <button type="submit" class="btn btn-link link-primary p-0 text-decoration-none">
                                Gửi lại mã OTP
                            </button>
                        </form>
                    </div>

                    <div class="text-center mt-4 text-muted small">
                        <a href="{{ route('register.form') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại trang đăng ký
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #otp {
        letter-spacing: 0.5rem;
        font-size: 2rem;
    }
    #otp::placeholder {
        letter-spacing: normal;
        font-size: 1.25rem;
        opacity: 0.3;
    }
</style>
@endsection
