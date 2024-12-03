@extends('layouts.master')

@section('content')

<div class="main-wrapper">
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

            <livewire:parent.add-parent />

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection
@section('js')
@livewireScripts
@endsection