@extends('layouts.master')

@section('content')
<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Settings</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="settings.html">Settings</a></li>
                            <li class="breadcrumb-item active">Social Links</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    @include('settings.settings-menuLinks')

                    <div class="row">
                        <div class="col-lg-6 col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Social Link Settings</h5>
                                </div>
                                <div class="card-body pt-0">
                                    <form method="POST" action="{{ route('settings.update', 'social-links') }}">
                                        @csrf
                                        @method('put')
                                        <div class="settings-form">
                                            <div class="links-info">
                                                <div class="row form-row links-cont">
                                                    <div class="form-group form-placeholder d-flex">
                                                        <button class="btn social-icon">
                                                            <i class="feather-facebook"></i>
                                                        </button>
                                                        <input type="text" name="facebook" class="form-control" value="{{ $settings['facebook'] ?? 'https://www.facebook.com' }}">
                                                        <div>
                                                            <a href="#" class="btn trash">
                                                                <i class="feather-trash-2"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="links-info">
                                                <div class="row form-row links-cont">
                                                    <div class="form-group form-placeholder d-flex">
                                                        <button class="btn social-icon">
                                                            <i class="feather-twitter"></i>
                                                        </button>
                                                        <input type="text" name="twitter" class="form-control" value="{{ $settings['twitter'] ?? 'https://www.twitter.com' }}">
                                                        <div>
                                                            <a href="#" class="btn trash">
                                                                <i class="feather-trash-2"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="links-info">
                                                <div class="row form-row links-cont">
                                                    <div class="form-group form-placeholder d-flex">
                                                        <button class="btn social-icon">
                                                            <i class="feather-youtube"></i>
                                                        </button>
                                                        <input type="text" name="youtube" class="form-control" value="{{ $settings['youtube'] ?? 'https://www.youtube.com' }}">
                                                        <div>
                                                            <a href="#" class="btn trash">
                                                                <i class="feather-trash-2"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="links-info">
                                                <div class="row form-row links-cont">
                                                    <div class="form-group form-placeholder d-flex">
                                                        <button class="btn social-icon">
                                                            <i class="feather-linkedin"></i>
                                                        </button>
                                                        <input type="text" name="linkedin" class="form-control" value="{{ $settings['linkedin'] ?? 'https://www.linkedin.com' }}">
                                                        <div>
                                                            <a href="#" class="btn trash">
                                                                <i class="feather-trash-2"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="links-info">
                                                <div class="row form-row links-cont">
                                                    <div class="form-group form-placeholder d-flex">
                                                        <button class="btn social-icon">
                                                            <i class="feather-github"></i>
                                                        </button>
                                                        <input type="text" name="github" class="form-control" value="{{ $settings['github'] ?? 'https://www.github.com' }}">
                                                        <div>
                                                            <a href="#" class="btn trash">
                                                                <i class="feather-trash-2"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="btn add-links">
                                                <i class="fas fa-plus me-1"></i> Add More
                                            </a>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="settings-btns">
                                                <button type="submit" class="btn btn-orange">Submit</button>
                                                <button type="button" class="btn btn-grey">Cancel</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection