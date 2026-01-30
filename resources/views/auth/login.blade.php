@extends('layouts.app')

@section('content')
@push('styles')
<style>
    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background-color: #0b0f1a;
        position: relative;
        overflow: hidden;
    }

    .auth-page::before {
        content: "";
        position: absolute;
        top: -10%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
        opacity: 0.15;
        filter: blur(80px);
    }

    .login-card {
        width: 100%;
        max-width: 440px;
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    .auth-header {
        padding: 48px 40px 32px;
        text-align: center;
    }

    .auth-header .brand-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid var(--primary-glow);
        border-radius: 18px;
        color: var(--primary-color);
        font-size: 24px;
    }

    .auth-header h3 {
        font-family: 'Outfit';
        font-weight: 800;
        color: white;
        margin-bottom: 8px;
        font-size: 28px;
    }

    .auth-header p {
        color: var(--text-muted);
        font-size: 15px;
    }

    .auth-body {
        padding: 0 40px 48px;
    }

    .auth-page .form-group {
        margin-bottom: 24px;
    }

    .auth-page .input-with-icon {
        position: relative;
    }

    .auth-page .input-with-icon .icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .auth-page .form-control {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        color: white;
        height: 56px;
        padding-left: 56px;
        border-radius: 16px;
        transition: all 0.3s;
    }

    .auth-page .form-control:focus {
        background: rgba(255, 255, 255, 0.06);
        border-color: var(--primary-color);
        box-shadow: 0 0 15px var(--primary-glow);
    }

    .btn-gradient {
        background: linear-gradient(90deg, var(--primary-color), #8b5cf6);
        color: white;
        border: none;
        border-radius: 16px;
        padding: 16px;
        font-weight: 700;
        font-family: 'Outfit';
        letter-spacing: 0.5px;
        transition: all 0.3s;
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(99, 102, 241, 0.4);
    }

    .auth-footer {
        margin-top: 32px;
        text-align: center;
        color: var(--text-muted);
    }

    .auth-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s;
    }

    .auth-link:hover {
        color: white;
    }
</style>

<div class="auth-page fade-in">
    <div class="login-card">
        <div class="auth-header">
            <div class="brand-icon"><i class="fas fa-atom"></i></div>
            <h3>Khám Phá Aura</h3>
            <p>Đăng nhập để bắt đầu hành trình từ hôm nay</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group input-with-icon">
                    <span class="icon"><i class="fas fa-user-astronaut"></i></span>
                    <input type="text" name="name" value="{{ old('name', 'admin') }}" class="form-control"
                        placeholder="Email hoặc Tên đăng nhập" required>
                    @error('name')<div class="text-danger small mt-2" style="font-size: 12px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group input-with-icon">
                    <span class="icon"><i class="fas fa-fingerprint"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                    @error('password')<div class="text-danger small mt-2" style="font-size: 12px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4 px-1">
                    <div class="form-check custom-checkbox">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember"
                            style="background-color: rgba(255,255,255,0.05); border-color: var(--glass-border);">
                        <label class="form-check-label small text-muted" for="remember">Lưu phiên đăng nhập</label>
                    </div>
                    <a href="#" class="auth-link small">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn-gradient w-100">ĐĂNG NHẬP NGAY</button>

                <div class="auth-footer">
                    <div class="small">Chưa có tài khoản? <a href="{{ route('register.form') }}" class="auth-link">Đăng
                            ký tham gia</a></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection