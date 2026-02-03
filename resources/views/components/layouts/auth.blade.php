<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title') | {{ config('app.name', 'Freelance Manager') }}</title>

  <!-- Links Of CSS File -->
  <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/simplebar.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/prism.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/jsvectormap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

  <!-- Material Symbols Outlined -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- Favicon -->
  <link href="{{ asset('assets/images/favicon.png') }}" rel="icon" type="image/png">

  @livewireStyles
</head>

<body class="bg-body-bg">


  <div class="container-fluid">
    <div class="main-content d-flex flex-column p-0">
      <div class="m-lg-auto my-auto w-930 py-4">
        <div class="card bg-white border rounded-10 border-white py-100 px-130">
          <div class="p-md-5 p-4 p-lg-0">
            {{ $slot }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Links Of JS File -->
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
  <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/js/prism.js') }}"></script>
  <script src="{{ asset('assets/js/custom/custom.js') }}"></script>

  @livewireScripts
</body>

</html>