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
                            <li class="breadcrumb-item active">General Settings</li>
                        </ul>
                    </div>
                </div>
            </div>
            @include('settings.settings-menuLinks')
           

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Website Basic Details</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Use PUT method for updating -->
                                <div class="settings-form">

                                    <!-- Website Name -->
                                    <div class="form-group">
                                        <label for="website_name">Website Name <span class="star-red">*</span></label>
                                        <input type="text" name="website_name" id="website_name" class="form-control" placeholder="Enter Website Name"
                                            value="{{ old('website_name', \DB::table('settings')->where('key', 'website_name')->value('value') ?? '') }}" required>
                                    </div>


                                    <!-- Logo -->
                                    <div class="form-group">
                                        <p class="settings-label">Logo <span class="star-red">*</span></p>
                                        <div class="settings-btn">
                                            <input type="file" accept="image/*" name="logo" id="file-logo" class="hide-input" onchange="loadLogoFile(event)">
                                            <label for="file-logo" class="upload">
                                                <i class="feather-upload"></i>
                                            </label>
                                        </div>
                                        <h6 class="settings-size">Recommended image size is <span>150px x 150px</span></h6>

                                        @php
                                        $logo = \DB::table('settings')->where('key', 'logo')->value('value');
                                        @endphp

                                        @if(!empty($logo))
                                        <div class="upload-images">
                                            <img src="{{ asset('attachments/logo/' . $logo) }}" alt="Logo" style="max-width: 250px;">
                                            <a href="javascript:void(0);" class="btn-icon logo-hide-btn">
                                                <i class="feather-x-circle"></i>
                                            </a>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Favicon -->
                                    <div class="form-group">
                                        <p class="settings-label">Favicon <span class="star-red">*</span></p>
                                        <div class="settings-btn">
                                            <input type="file" accept="image/*" name="favicon" id="file-favicon" class="hide-input" onchange="loadFaviconFile(event)">
                                            <label for="file-favicon" class="upload">
                                                <i class="feather-upload"></i>
                                            </label>
                                        </div>
                                        <h6 class="settings-size">Recommended image size is <span>16px x 16px or 32px x 32px</span></h6>
                                        <h6 class="settings-size mt-1">Accepted formats: only png and ico</h6>

                                        @php
                                        $favicon = \DB::table('settings')->where('key', 'favicon')->value('value');
                                        @endphp

                                        @if(!empty($favicon))
                                        <div class="upload-favicon-container">
                                            <img src="{{ asset('attachments/favicon/' . $favicon) }}" alt="Favicon" class="upload-favicon">
                                            <a href="javascript:void(0);" class="btn-icon favicon-hide-btn">
                                                <i class="feather-x-circle"></i>
                                            </a>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Buttons -->
                                    <div class="form-group mb-0">
                                        <div class="settings-btns">
                                            <button type="submit" class="btn btn-orange">Update</button>
                                            <a href="{{ route('settings.index') }}" class="btn btn-grey">Cancel</a>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Address Details</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form action="{{ route('settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="settings-form">
                                    <div class="form-group">
                                        <label>Address Line 1 <span class="star-red">*</span></label>
                                        <input type="text" class="form-control" name="address_line1"
                                            value="{{ old('address_line1', $settings['address_line1'] ?? '') }}"
                                            placeholder="Enter Address Line 1">
                                    </div>
                                    <div class="form-group">
                                        <label>Address Line 2 <span class="star-red">*</span></label>
                                        <input type="text" class="form-control" name="address_line2"
                                            value="{{ old('address_line2', $settings['address_line2'] ?? '') }}"
                                            placeholder="Enter Address Line 2">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City <span class="star-red">*</span></label>
                                                <input type="text" class="form-control" name="city"
                                                    value="{{ old('city', $settings['city'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>State/Province <span class="star-red">*</span></label>
                                                <select class="select form-control" name="state">
                                                    <option value="California" {{ (old('state', $settings['state'] ?? '') == 'California') ? 'selected' : '' }}>California</option>
                                                    <option value="Tasmania" {{ (old('state', $settings['state'] ?? '') == 'Tasmania') ? 'selected' : '' }}>Tasmania</option>
                                                    <option value="Auckland" {{ (old('state', $settings['state'] ?? '') == 'Auckland') ? 'selected' : '' }}>Auckland</option>
                                                    <option value="Marlborough" {{ (old('state', $settings['state'] ?? '') == 'Marlborough') ? 'selected' : '' }}>Marlborough</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Zip/Postal Code <span class="star-red">*</span></label>
                                                <input type="text" class="form-control" name="zip_code"
                                                    value="{{ old('zip_code', $settings['zip_code'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country <span class="star-red">*</span></label>
                                                <select class="select form-control" name="country">
                                                    <option value="India" {{ (old('country', $settings['country'] ?? '') == 'India') ? 'selected' : '' }}>India</option>
                                                    <option value="London" {{ (old('country', $settings['country'] ?? '') == 'London') ? 'selected' : '' }}>London</option>
                                                    <option value="France" {{ (old('country', $settings['country'] ?? '') == 'France') ? 'selected' : '' }}>France</option>
                                                    <option value="USA" {{ (old('country', $settings['country'] ?? '') == 'USA') ? 'selected' : '' }}>USA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <div class="settings-btns">
                                            <button type="submit" class="btn btn-orange">Update</button>
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
@endsection