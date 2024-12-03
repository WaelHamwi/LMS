<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Preskool - Login</title>
    <link rel="shortcut icon" href="assets/img/favicon.png">
   
    <!-- Including CSS assets -->
    @stack('css')

</head>

<body>

    <!-- Main Content -->
    <div class="main-wrapper login-body">
        @yield('content')
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Including JS assets -->
    @stack('scripts')
</body>

</html>