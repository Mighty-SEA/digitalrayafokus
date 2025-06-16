<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PT Digital Raya Fokus') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('asset/logo.png') }}" type="image/png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    @include('layouts.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.footer')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    @stack('scripts')
</body>
</html> 