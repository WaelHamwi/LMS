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
                            <li class="breadcrumb-item active">SEO Settings</li>
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
                                    <h5 class="card-title">SEO Settings</h5>
                                </div>
                                <div class="card-body pt-0">
                                    <form method="POST" action="{{ route('settings.update', 'seo') }}">
                                        @csrf
                                        @method('put')
                                        <div class="settings-form">
                                            <div class="form-group form-placeholder">
                                                <label>Meta Title <span class="star-red">*</span></label>
                                                <input type="text" class="form-control" name="meta_title" value="{{ $settings['meta_title'] ?? '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Keywords <span class="star-red">*</span></label>
                                                <input type="text" data-role="tagsinput" class="input-tags form-control" placeholder="Meta Keywords" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? 'Lorem,Ipsum' }}" id="meta_keywords">
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Description <span class="star-red">*</span></label>
                                                <textarea class="form-control" name="meta_description">{{ $settings['meta_description'] ?? '' }}</textarea>
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
