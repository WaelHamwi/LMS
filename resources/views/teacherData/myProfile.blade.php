@extends('layouts.master')

@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-4 custom-alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>

    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">teacher Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">teacher</a></li>
                            <li class="breadcrumb-item">teacher Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header">
                    <h5 class="card-title">Rounded justified</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab1" data-bs-toggle="tab">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab2" data-bs-toggle="tab">Attachments</a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab3" data-bs-toggle="tab">Messages</a></li>
                    </ul>
                    <div class="tab-content">
                        @include('components.tab-teacher1')
                        @include('components.tab-teacher2')
                        @include('components.tab-teacher3')
                       
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
    <!-- Additional sections like "Skills", "About Me", and "Education" go here, also using dynamic data as needed -->


    <footer>
        <p>&copy; 2024 Dreamguys.</p>
    </footer>
</div>

@endsection