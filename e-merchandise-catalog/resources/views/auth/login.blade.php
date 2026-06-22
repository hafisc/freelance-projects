@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container" style="max-width: 500px;">
    <div class="card">
        <div class="card-body" style="text-align: center;">
            <h1 style="margin-bottom: 2rem; color: var(--primary);">Login</h1>
            
            <form id="loginForm">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; text-align: left;">Nomor HP</label>
                    <input type="text" id="phone" class="form-control" placeholder="08xxxxxxxxxx" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                
                <button type="button" onclick="sendOtp()" class="btn btn-primary" style="width: 100%; margin-bottom: 1rem;" id="sendOtpBtn">Kirim OTP</button>
            </form>

            <form id="otpForm" style="display: none;">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; text-align: left;">Kode OTP</label>
                    <input type="text" id="otp" class="form-control" placeholder="000000" maxlength="6" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; text-align: center; font-size: 1.5rem; letter-spacing: 0.5rem;">
                </div>
                
                <button type="button" onclick="verifyOtp()" class="btn btn-secondary" style="width: 100%;">Verifikasi OTP</button>
                <p style="margin-top: 1rem; color: #666; font-size: 0.875rem;">
                    Tidak menerima OTP? <a href="#" onclick="sendOtp(); return false;" style="color: var(--primary);">Kirim ulang</a>
                </p>
            </form>

            <p style="margin-top: 2rem; color: #666;">
                Admin/Panitia? <a href="{{ route('admin.login') }}" style="color: var(--primary);">Login disini</a>
            </p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let userId = null;

    async function sendOtp() {
        const phone = document.getElementById('phone').value;
        if (!phone) {
            alert('Masukkan nomor HP!');
            return;
        }

        showLoading();
        
        const response = await fetch('{{ route('send.otp') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ phone })
        });

        const data = await response.json();
        hideLoading();

        if (data.success) {
            userId = data.user_id;
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('otpForm').style.display = 'block';
            alert('OTP telah dikirim! (Demo: OTP adalah 123456)');
        }
    }

    async function verifyOtp() {
        const otp = document.getElementById('otp').value;
        if (!otp) {
            alert('Masukkan kode OTP!');
            return;
        }

        showLoading();
        
        const response = await fetch('{{ route('verify.otp') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ user_id: userId, otp })
        });

        const data = await response.json();
        hideLoading();

        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert(data.message || 'OTP tidak valid!');
        }
    }
</script>
@endsection
