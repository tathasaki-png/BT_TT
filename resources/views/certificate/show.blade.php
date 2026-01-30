@extends('layouts.app')

@section('content')
<style>
    .certificate-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .certificate {
        background: linear-gradient(135deg, #f9fafb 0%, white 100%);
        border: 3px solid #d4af37;
        border-radius: 20px;
        padding: 60px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        position: relative;
        overflow: hidden;
    }

    .certificate::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(211, 175, 55, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .certificate::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(211, 175, 55, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .certificate-content {
        position: relative;
        z-index: 1;
    }

    .certificate-header {
        font-size: 14px;
        letter-spacing: 2px;
        color: #64748b;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .certificate-title {
        font-size: 48px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 40px;
        font-style: italic;
    }

    .certificate-text {
        font-size: 16px;
        color: #334155;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .certificate-name {
        font-size: 32px;
        font-weight: 700;
        color: #6366f1;
        margin: 30px 0;
        text-decoration: underline;
        text-decoration-color: #d4af37;
        text-decoration-thickness: 2px;
        text-underline-offset: 8px;
    }

    .certificate-course {
        font-size: 24px;
        font-weight: 600;
        color: #0f172a;
        margin: 20px 0;
    }

    .certificate-footer {
        display: flex;
        justify-content: space-around;
        margin-top: 60px;
        padding-top: 40px;
        border-top: 2px solid #d4af37;
    }

    .signature-block {
        text-align: center;
        min-width: 150px;
    }

    .signature-line {
        border-top: 2px solid #0f172a;
        margin-bottom: 5px;
        height: 40px;
    }

    .signature-title {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    .certificate-number {
        position: absolute;
        bottom: 20px;
        right: 40px;
        font-size: 12px;
        color: #94a3b8;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .btn-certificate {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-download {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
    }

    .btn-back {
        background: white;
        color: #6366f1;
        border: 2px solid #6366f1;
    }

    .btn-back:hover {
        background: #6366f1;
        color: white;
    }

    .badge-success {
        display: inline-block;
        background: #d1fae5;
        color: #065f46;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 20px;
    }
</style>

<div class="certificate-container">
    <div class="badge-success">
        <i class="fas fa-check-circle me-2"></i> Chứng Chỉ Hoàn Thành
    </div>

    <div class="certificate">
        <div class="certificate-content">
            <div class="certificate-header">
                {{ config('app.name') }}
            </div>

            <h1 class="certificate-title">Certificate of Completion</h1>

            <p class="certificate-text">
                This is to certify that
            </p>

            <div class="certificate-name">
                {{ $certificate->user->name }}
            </div>

            <p class="certificate-text">
                has successfully completed the course
            </p>

            <div class="certificate-course">
                {{ $certificate->course->title }}
            </div>

            <p class="certificate-text">
                with a comprehensive understanding of all the course material and has demonstrated the ability to apply the knowledge and skills in practical scenarios.
            </p>

            <div class="certificate-footer">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-title">Course Instructor</div>
                </div>

                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-title">Date</div>
                    <small style="color: #94a3b8;">{{ $certificate->issued_at->format('d/m/Y') }}</small>
                </div>

                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-title">{{ config('app.name') }}<br>Director</div>
                </div>
            </div>

            <div class="certificate-number">
                Certificate No: {{ $certificate->certificate_number }}
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="javascript:window.print()" class="btn-certificate btn-download">
            <i class="fas fa-download me-2"></i> Tải xuống PDF
        </a>
        <a href="{{ route('profile.show') }}" class="btn-certificate btn-back">
            <i class="fas fa-arrow-left me-2"></i> Quay lại hồ sơ
        </a>
    </div>

    <div style="margin-top: 40px; padding: 20px; background: #f8fafc; border-radius: 12px; text-align: center; color: #64748b; font-size: 14px;">
        <i class="fas fa-info-circle me-2"></i>
        Chứng chỉ này được cấp để chứng minh bạn đã hoàn thành khóa học. Bạn có thể lưu hoặc in chứng chỉ này để sử dụng trong mục đích học tập hoặc công việc.
    </div>
</div>

<script>
// Auto-format for printing
window.addEventListener('beforeprint', function() {
    // Adjust for print layout
    document.body.style.background = 'white';
});
</script>
@endsection
