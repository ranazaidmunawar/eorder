@extends('user-front.layout')

@section('pageHeading')
    {{ $keywords['Forgot_Password'] ?? __('Forgot Password') }}
@endsection

@section('style')
    @includeIf('user-front.elak.include.elak_css')
<style>
    :root {
        --elak-primary: #0f5156;
        --elak-bg: #f4f6f9;
        --elak-card: #ffffff;
    }

    body {
        background-color: var(--elak-bg);
    }

    .login-page-wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .login-content-center {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .login-container {
        width: 100%;
        max-width: 440px;
    }

    .login-form-card {
        background: var(--elak-card);
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        text-align: center;
    }
    
    .login-branding {
        margin-bottom: 25px;
    }
    .login-branding i {
        font-size: 2.5rem;
        color: var(--elak-primary);
        margin-bottom: 10px;
    }
    .login-branding h2 {
        font-weight: 700;
        font-size: 1.5rem;
        color: #333;
        margin: 0;
    }

    .elak-input-group {
        text-align: left;
        margin-bottom: 15px;
    }
    .elak-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 6px;
    }
    .elak-input {
        width: 100%;
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: #fff;
        transition: border-color 0.2s;
    }
    .elak-input:focus {
        border-color: var(--elak-primary);
        outline: none;
    }

    .login-submit-btn {
        background: var(--elak-primary);
        color: #fff;
        width: 100%;
        padding: 14px;
        border-radius: 8px;
        font-weight: 700;
        border: none;
        margin-top: 10px;
        cursor: pointer;
    }
    .login-submit-btn:hover { opacity: 0.9; }

    .form-footer-links {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
        font-size: 0.8rem;
    }
    .form-footer-links a {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="login-page-wrapper">
    <div class="login-content-center">
        <div class="login-container">
            <div class="login-form-card">
                <div class="login-branding">
                    <i class="fas fa-key"></i>
                    <h2>{{ $keywords['Forgot_Password'] ?? __('Forgot Password') }}</h2>
                </div>

                @if(Session::has('success'))
                    <div class="alert alert-success mb-4 p-2 small">
                        {{ Session::get('success') }}
                    </div>
                @endif

                <form action="{{ route('user.client.forgot.submit', getParam()) }}" method="POST">
                    @csrf
                    <div class="elak-input-group">
                        <label class="elak-label">{{ $keywords['Email_Address'] ?? __('Email Address') }} *</label>
                        <input type="email" name="email" class="elak-input" value="{{ Request::old('email') }}" required>
                        @error('email')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                        @if (Session::has('err'))
                            <p class="text-danger small mt-1">{{ Session::get('err') }}</p>
                        @endif
                    </div>

                    <button type="submit" class="login-submit-btn">
                        {{ $keywords['Send_Mail'] ?? __('Send Mail') }}
                    </button>
                </form>

                <div class="form-footer-links">
                    <a href="{{ route('user.client.login', getParam()) }}">{{ $keywords['Login_Now'] ?? __('Login Now') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
