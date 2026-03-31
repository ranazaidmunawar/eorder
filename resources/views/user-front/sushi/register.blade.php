@extends('user-front.layout')

@section('pageHeading')
    {{ $keywords['Register'] ?? __('Register') }}
@endsection

@section('style')
    @includeIf('user-front.sushi.include.sushi_css')
<style>
    :root {
        --sushi-primary: #0f5156;
        --sushi-bg: #f4f6f9;
        --sushi-card: #ffffff;
    }

    body {
        background-color: var(--sushi-bg);
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
        background: var(--sushi-card);
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
        color: var(--sushi-primary);
        margin-bottom: 10px;
    }
    .login-branding h2 {
        font-weight: 700;
        font-size: 1.5rem;
        color: #333;
        margin: 0;
    }

    .sushi-input-group {
        text-align: left;
        margin-bottom: 15px;
    }
    .sushi-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 6px;
    }
    .sushi-input {
        width: 100%;
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: #fff;
        transition: border-color 0.2s;
    }
    .sushi-input:focus {
        border-color: var(--sushi-primary);
        outline: none;
    }

    .login-submit-btn {
        background: var(--sushi-primary);
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
                    <i class="fas fa-user-plus"></i>
                    <h2>{{ $keywords['Register'] ?? __('Register') }}</h2>
                </div>

                @if(Session::has('sendmail'))
                    <div class="alert alert-success mb-4 p-2 small text-center">
                        {{ Session::get('sendmail') }}
                    </div>
                @endif

                <form action="{{ route('user.client.register.submit', getParam()) }}" method="POST">
                    @csrf
                    <div class="sushi-input-group">
                        <label class="sushi-label">{{ $keywords['Username'] ?? __('Username') }} *</label>
                        <input type="text" name="username" class="sushi-input" value="{{ Request::old('username') }}" required>
                        @error('username')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sushi-input-group">
                        <label class="sushi-label">{{ $keywords['Email_Address'] ?? __('Email Address') }} *</label>
                        <input type="email" name="email" class="sushi-input" value="{{ Request::old('email') }}" required>
                        @error('email')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sushi-input-group">
                        <label class="sushi-label">{{ $keywords['Password'] ?? __('Password') }} *</label>
                        <input type="password" name="password" class="sushi-input" required>
                        @error('password')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sushi-input-group">
                        <label class="sushi-label">{{ $keywords['Confirmation_Password'] ?? __('Confirmation Password') }} *</label>
                        <input type="password" name="password_confirmation" class="sushi-input" required>
                        @error('password_confirmation')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($userBs->is_recaptcha == 1)
                        <div class="d-block mb-3 text-center">
                            <div id="g-recaptcha" class="d-inline-block"></div>
                            @error('g-recaptcha-response')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <button type="submit" class="login-submit-btn">
                        {{ $keywords['Register'] ?? __('Register') }}
                    </button>
                </form>

                <div class="form-footer-links">
                    <p>{{ $keywords['Already_have_an_account_?'] ?? __('Already have an account ?') }} 
                        <a href="{{ route('user.client.login', getParam()) }}">{{ $keywords['Login'] ?? __('Login') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
