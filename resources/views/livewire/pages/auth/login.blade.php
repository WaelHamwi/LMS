@extends('livewire.layout.app')
@section('content')
<div>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="assets/img/login.png" alt="Logo">
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Welcome to Preskool</h1>
                            <p class="account-subtitle">Need an account? <a href="{{ route('register') }}">Sign Up</a></p>
                            <h2>Sign in</h2>


                            <!-- Livewire login form -->
                            <form wire:submit.prevent="login">
                                @csrf
                                <div class="form-group">
                                    <label>Username <span class="login-danger">*</span></label>
                                    <input wire:model="form.email" type="email" class="form-control @error('form.email') is-invalid @enderror">
                                    @error('form.email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password <span class="login-danger">*</span></label>
                                    <input wire:model="form.password" type="password" class="form-control @error('form.password') is-invalid @enderror">
                                    @error('form.password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="forgotpass">
                                    <div class="remember-me">
                                        <label class="custom_check mr-2 mb-0 d-inline-flex remember-me">
                                            Remember me
                                            <input wire:model="form.remember" type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                                </div>
                            </form>

                            <div class="login-or">
                                <span class="or-line"></span>
                                <span class="span-or">or</span>
                            </div>

                            <div class="social-login">
                                <a href="#"><i class="fab fa-google-plus-g"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                            @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                                <strong>error happened!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            @if (session('verificationMessage'))
                            <div class="alert alert-success alert-dismissible fade show mt-4 custom-alert">
                                {{ session('verificationMessage') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <!-- Resend Verification Button -->
                            <div class="form-group mt-3">
                                <button class="btn btn-secondary btn-block" wire:click="resendVerificationEmail">Resend Verification Email</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<!-- Add your CSS files here -->
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/plugins/feather/feather.css" rel="stylesheet">
<link href="assets/plugins/icons/flags/flags.css" rel="stylesheet">
<link href="assets/plugins/fontawesome/css/fontawesome.min.css" rel="stylesheet">
<link href="assets/plugins/fontawesome/css/all.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link href="assets/css/custom.css" rel="stylesheet">
@endpush

@push('scripts')
<!-- Add your JS files here -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/script.js"></script>
@endpush