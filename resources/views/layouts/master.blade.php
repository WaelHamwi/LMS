<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="{{ $settings['meta_title'] }}">
    <title>{{ $settings['meta_title'] }}</title>
    @include('layouts.head')

    <!-- Add Livewire styles -->
    @livewireStyles
</head>

<body>
    <div class="main-wrapper">

        @include('layouts.header')
        @include('layouts.sideBar')
        @yield('content')
        

    </div>

    @include('layouts.footer-scripts')
    

    <!-- Add Livewire scripts -->
    @livewireScripts
   
</body>

</html>