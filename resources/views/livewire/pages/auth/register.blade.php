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
                            <p class="account-subtitle">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                            <h2>Register</h2>

                            <form wire:submit.prevent="register">
                                <div class="form-group">
                                    <label>Name <span class="login-danger">*</span></label>
                                    <input wire:model="form.name" type="text" class="form-control"
                                        :class="{'is-invalid': $errors->has('form.name')}">
                                    @error('form.name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Email <span class="login-danger">*</span></label>
                                    <input wire:model="form.email" type="email" class="form-control"
                                        :class="{'is-invalid': $errors->has('form.email')}">
                                    @error('form.email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password <span class="login-danger">*</span></label>
                                    <input wire:model="form.password" type="password" class="form-control pass-input"
                                        :class="{'is-invalid': $errors->has('form.password')}">
                                    @error('form.password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password <span class="login-danger">*</span></label>
                                    <input wire:model="form.password_confirmation" type="password" class="form-control pass-input"
                                        :class="{'is-invalid': $errors->has('form.password_confirmation')}">
                                    @error('form.password_confirmation')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Register</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('css')
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/plugins/feather/feather.css" rel="stylesheet">
<link href="assets/plugins/icons/flags/flags.css" rel="stylesheet">
<link href="assets/plugins/fontawesome/css/fontawesome.min.css" rel="stylesheet">
<link href="assets/plugins/fontawesome/css/all.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/script.js"></script>
@endpush