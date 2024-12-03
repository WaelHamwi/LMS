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
                            <li class="breadcrumb-item active">Localization</li>
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
                                <div class="card-header">
                                    <h5 class="card-title">Localization Details</h5>
                                </div>
                                <div class="card-body pt-0">
                                    <form method="POST" action="{{ route('settings.update') }}">
                                        @csrf
                                        @method('put')
                                        <div class="settings-form">
                                            <div class="form-group">
                                                <label>Time Zone</label>
                                                <select class="select form-control" name="timezone">

                                                    @php

                                                    $timezones = [
                                                    '(UTC+05:30) India Standard Time' => 'Asia/Kolkata',
                                                    '(UTC) Greenwich Mean Time' => 'UTC',
                                                    '(UTC+01:00) Central European Time' => 'Europe/Berlin',
                                                    '(UTC+02:00) Eastern European Time' => 'Europe/Helsinki',
                                                    '(UTC-05:00) Eastern Standard Time' => 'America/New_York',
                                                    '(UTC+09:00) Japan Standard Time' => 'Asia/Tokyo',
                                                    '(UTC-08:00) Pacific Standard Time' => 'America/Los_Angeles',
                                                    '(UTC+10:00) Australian Eastern Standard Time' => 'Australia/Sydney',
                                                    '(UTC+03:00) Arabian Standard Time' => 'Asia/Riyadh',
                                                    '(UTC+04:00) Azerbaijan Time' => 'Asia/Baku',
                                                    '(UTC+08:00) China Standard Time' => 'Asia/Shanghai',
                                                    '(UTC-03:00) Argentina Time' => 'America/Argentina/Buenos_Aires',
                                                    '(UTC+07:00) Indochina Time' => 'Asia/Bangkok',
                                                    '(UTC+11:00) Solomon Islands Time' => 'Pacific/Guadalcanal',
                                                    '(UTC-06:00) Central Standard Time' => 'America/Chicago',
                                                    '(UTC+06:00) Almaty Time' => 'Asia/Almaty',
                                                    '(UTC-07:00) Mountain Standard Time' => 'America/Denver',
                                                    '(UTC-04:00) Atlantic Standard Time' => 'America/Halifax',
                                                    '(UTC+12:00) Fiji Time' => 'Pacific/Fiji',
                                                    '(UTC+05:00) Pakistan Standard Time' => 'Asia/Karachi',
                                                    '(UTC+06:30) Cocos Islands Time' => 'Indian/Cocos',
                                                    ];
                                                    @endphp



                                                    @foreach($timezones as $label => $value)
                                                    <option value="{{ $value }}" {{ (isset($settings['timezone']) && $settings['timezone'] === $value) ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                    @endforeach


                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Date Format</label>
                                                <select class="select form-control" name="date_format">
                                                    <option {{ (isset($settings['date_format']) && $settings['date_format'] == '15 May 2016') ? 'selected' : '' }}>15 May 2016</option>
                                                    <option {{ (isset($settings['date_format']) && $settings['date_format'] == '15/05/2016') ? 'selected' : '' }}>15/05/2016</option>
                                                    <option {{ (isset($settings['date_format']) && $settings['date_format'] == '15.05.2016') ? 'selected' : '' }}>15.05.2016</option>
                                                    <option {{ (isset($settings['date_format']) && $settings['date_format'] == '15-05-2016') ? 'selected' : '' }}>15-05-2016</option>
                                                    <option {{ (isset($settings['date_format']) && $settings['date_format'] == '05/15/2016') ? 'selected' : '' }}>05/15/2016</option>
                                                    <option {{ (isset($settings['date_format']) && $settings['date_format'] == '2016/05/15') ? 'selected' : '' }}>2016/05/15</option>
                                                    <option {{ (isset($settings['date_format']) && $settings['date_format'] == '2016-05-15') ? 'selected' : '' }}>2016-05-15</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Time Format</label>
                                                <select class="select form-control" name="time_format">
                                                    <option {{ (isset($settings['time_format']) && $settings['time_format'] == '12 Hours') ? 'selected' : '' }}>12 Hours</option>
                                                    <option {{ (isset($settings['time_format']) && $settings['time_format'] == '24 Hours') ? 'selected' : '' }}>24 Hours</option>
                                                    <option {{ (isset($settings['time_format']) && $settings['time_format'] == '36 Hours') ? 'selected' : '' }}>36 Hours</option>
                                                    <option {{ (isset($settings['time_format']) && $settings['time_format'] == '48 Hours') ? 'selected' : '' }}>48 Hours</option>
                                                    <option {{ (isset($settings['time_format']) && $settings['time_format'] == '60 Hours') ? 'selected' : '' }}>60 Hours</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Currency Symbol</label>
                                                <select class="select form-control" name="currency_symbol">
                                                    <option {{ (isset($settings['currency_symbol']) && $settings['currency_symbol'] == '$') ? 'selected' : '' }}>$</option>
                                                    <option {{ (isset($settings['currency_symbol']) && $settings['currency_symbol'] == '₹') ? 'selected' : '' }}>₹</option>
                                                    <option {{ (isset($settings['currency_symbol']) && $settings['currency_symbol'] == '£') ? 'selected' : '' }}>£</option>
                                                    <option {{ (isset($settings['currency_symbol']) && $settings['currency_symbol'] == '€') ? 'selected' : '' }}>€</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-0">
                                                <div class="settings-btns">
                                                    <button type="submit" class="btn btn-orange">Update</button>
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