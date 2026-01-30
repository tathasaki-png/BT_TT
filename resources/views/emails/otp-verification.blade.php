<x-mail::message>
# Xác thực đăng ký tài khoản

Chào bạn,

Cảm ơn bạn đã đăng ký tài khoản trên hệ thống của chúng tôi. Để hoàn tất quá trình đăng ký, vui lòng sử dụng mã OTP dưới đây để xác thực email:

<x-mail::panel>
# {{ $otp }}
</x-mail::panel>

Mã này sẽ hết hạn sau 10 phút. Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>
