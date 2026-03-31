@extends('user-front.layout')

@section('pageHeading')
    {{ $keywords['Login'] ?? __('Login') }}
@endsection

@section('style')
    @includeIf('user-front.sushi.include.sushi_css')
<style>
    :root {
        --sushi-primary: #0f5156;
        --sushi-accent: #ffa726;
        --sushi-bg: #f4f6f9;
        --sushi-card: #ffffff;
        --sushi-text: #333333;
    }

    body {
        background-color: var(--sushi-bg);
        color: var(--sushi-text);
        margin: 0;
        padding: 0;
    }

    .login-page-wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    /* Standard Sushi Header (matching Screenshot 17) */
    .sushi-header {
        background: var(--sushi-primary);
        color: #fff;
        padding: 12px 0;
        text-align: center;
        position: relative;
    }
    .sushi-header .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .sushi-header .logo {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.4rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .sushi-header .logo i { font-size: 1.2rem; }

    /* Center Section */
    .login-content-center {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .login-container {
        width: 100%;
        max-width: 420px;
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

    .guest-checkout-btn {
        background: #28a745;
        color: #fff;
        width: 100%;
        padding: 14px;
        border-radius: 8px;
        font-weight: 600;
        text-align: center;
        display: block;
        margin-bottom: 25px;
        text-decoration: none;
        transition: background 0.2s;
        border: none;
    }
    .guest-checkout-btn:hover {
        background: #218838;
        color: #fff;
    }

    .or-divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }
    .or-divider::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 1px;
        background: #eee;
    }
    .or-divider span {
        background: var(--sushi-card);
        padding: 0 15px;
        position: relative;
        color: #999;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
    }

    .social-btns {
        display: flex;
        gap: 12px;
        margin-bottom: 25px;
    }
    .social-btn {
        flex: 1;
        padding: 10px;
        border-radius: 8px;
        color: #fff;
        font-weight: 600;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 0.85rem;
        text-decoration: none;
    }
    .btn-facebook { background: #3b5998; }
    .btn-google { background: #db4437; }
    
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

@section('content')
<div class="login-page-wrapper">
  

    <!-- Main Content -->
    <div class="login-content-center">
        <div class="login-container">
            <div class="login-form-card">
                <div class="login-branding">
                    <i class="fas fa-user-circle"></i>
                    <h2>{{ $keywords['Login'] ?? __('Login') }}</h2>
                </div>

                <!-- Guest Checkout -->
                <!-- <a href="{{ route('user.product.front.checkout', [getParam(), 'type' => 'guest']) }}" class="guest-checkout-btn">
                    {{ $keywords['Checkout_As_Guest'] ?? __('Checkout As Guest') }}
                </a> -->

                <!-- <div class="or-divider">
                    <span>{{ $keywords['OR'] ?? __('OR') }}</span>
                </div> -->

                <!-- Social Login Btns -->
                <div class="social-btns">
                    @php
                        $be = App\Models\User\BasicExtended::where('user_id', getUser()->id)->first();
                    @endphp
                    @if ($be->facebook_app_id && $be->facebook_app_secret)
                        <a href="{{ route('user.client.facebook.login', getParam()) }}" class="social-btn btn-facebook">
                            <i class="fab fa-facebook-f"></i> {{ __('Facebook') }}
                        </a>
                    @endif
                    @if ($be->google_client_id && $be->google_client_secret)
                        <a href="{{ route('user.client.google.login', getParam()) }}" class="social-btn btn-google">
                            <i class="fab fa-google"></i> {{ __('Google') }}
                        </a>
                    @endif
                </div>

                <!-- Form -->
                <form action="{{ route('user.client.login.submit', getParam()) }}" method="POST">
                    @csrf
                    @if(Session::has('err'))
                        <div class="alert alert-danger p-2 small mb-3">
                            {{ Session::get('err') }}
                            @if(Session::has('resend_email'))
                                <br>
                                <a href="{{ route('user.client.register.resend', ['email' => Session::get('resend_email'), getParam()]) }}" style="color: #ed2121; text-decoration: underline; font-weight: bold; margin-top: 5px; display: inline-block;">
                                    {{ __('Resend Verification Email') }}
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="sushi-input-group">
                        <label class="sushi-label">{{ $keywords['Email_Address'] ?? __('Email Address') }}</label>
                        <input type="email" name="email" class="sushi-input" placeholder="email@example.com" required>
                    </div>

                    <div class="sushi-input-group">
                        <label class="sushi-label">{{ $keywords['Password'] ?? __('Password') }}</label>
                        <input type="password" name="password" class="sushi-input" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="login-submit-btn">
                        {{ $keywords['LOG_IN'] ?? __('LOG IN') }}
                    </button>
                </form>

                <div class="form-footer-links">
                <a href="{{ route('user.client.forgot', getParam()) }}">{{ $keywords['Lost_your_password'] ?? __('Forgot Password?') }}</a>
                    <a href="{{ route('user.client.register', getParam()) }}">{{ $keywords['Register'] ?? __('Register') }}</a>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
