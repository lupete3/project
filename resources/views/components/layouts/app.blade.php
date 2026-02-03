<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Freelance Manager') }}</title>

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


  <!-- Start Sidebar Area -->
  @include('layouts.partials.sidebar')
  <!-- End Sidebar Area -->

  <!-- Start Main Content Area -->
  <div class="container-fluid">
    <div class="main-content d-flex flex-column">
      <!-- Start Header Area -->
      @include('layouts.partials.header')
      <!-- End Header Area -->

      <!-- Flash Messages -->
      @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
          <i class="ri-checkbox-circle-line me-2"></i>
          {{ session('message') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
          <i class="ri-error-warning-line me-2"></i>
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
          <i class="ri-checkbox-circle-line me-2"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
          <i class="ri-information-line me-2"></i>
          {{ session('info') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
          <i class="ri-alert-line me-2"></i>
          {{ session('warning') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <!-- End Flash Messages -->

      <main class="main-content-container overflow-hidden">
        {{ $slot ?? '' }}
        @yield('content')
      </main>

      <div class="flex-grow-1"></div>

      <!-- Start Footer Area -->
      @include('layouts.partials.footer')
      <!-- End Footer Area -->
    </div>
  </div>
  <!-- End Main Content Area -->

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