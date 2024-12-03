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
                            <li class="breadcrumb-item active">Email Settings</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('settings.settings-menuLinks')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">PHP Mail</h5>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="status_1" class="check">
                                        <label for="status_1" class="checktoggle">checkbox</label>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <form method="POST" action="{{ route('settings.update', 'php_mail') }}">
                                        @csrf
                                        <div class="settings-form">
                                            <div class="form-group form-placeholder">
                                                <label>Email From Address <span class="star-red">*</span></label>
                                                <input type="text" name="php_mail_from_address" class="form-control" value="{{ $settings['php_mail_from_address'] ?? '' }}">
                                            </div>
                                            <div class="form-group form-placeholder">
                                                <label>Email Password <span class="star-red">*</span></label>
                                                <input type="text" name="php_mail_password" class="form-control" value="{{ $settings['php_mail_password'] ?? '' }}">
                                            </div>
                                            <div class="form-group form-placeholder">
                                                <label>Emails From Name <span class="star-red">*</span></label>
                                                <input type="text" name="php_mail_from_name" class="form-control" value="{{ $settings['php_mail_from_name'] ?? '' }}">
                                            </div>
                                            <div class="form-group mb-0">
                                                <div class="settings-btns">
                                                    <button type="submit" class="btn btn-orange">Submit</button>
                                                    <button type="button" class="btn btn-grey">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">SMTP</h5>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="status_2" class="check" checked="">
                                        <label for="status_2" class="checktoggle">checkbox</label>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <form method="POST" action="{{ route('settings.update', 'smtp') }}">
                                        @csrf
                                        @method('put')
                                        <div class="settings-form">
                                            <div class="form-group form-placeholder">
                                                <label>Email From Address <span class="star-red">*</span></label>
                                                <input type="text" name="smtp_from_address" class="form-control" value="{{ $settings['smtp_from_address'] ?? '' }}">
                                            </div>
                                            <div class="form-group form-placeholder">
                                                <label>Email Password <span class="star-red">*</span></label>
                                                <input type="text" name="smtp_password" class="form-control" value="{{ $settings['smtp_password'] ?? '' }}">
                                            </div>
                                            <div class="form-group form-placeholder">
                                                <label>Email Host <span class="star-red">*</span></label>
                                                <input type="text" name="smtp_host" class="form-control" value="{{ $settings['smtp_host'] ?? '' }}">
                                            </div>
                                            <div class="form-group form-placeholder">
                                                <label>Email Port <span class="star-red">*</span></label>
                                                <input type="text" name="smtp_port" class="form-control" value="{{ $settings['smtp_port'] ?? '' }}">
                                            </div>
                                            <div class="form-group mb-0">
                                                <div class="settings-btns">
                                                    <button type="submit" class="btn btn-orange">Submit</button>
                                                    <button type="button" class="btn btn-grey">Cancel</button>
                                                </div>
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