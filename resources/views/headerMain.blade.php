<!DOCTYPE html>
<html lang="en">
  <head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo asset('css/headerMain.css') ?>" rel="stylesheet">
    <!-- Logo webpage -->
    <link href="<?php echo asset('img/bksda.jpg') ?>" rel="icon" />

    <!-- Meta tag CSRF -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Logo tab -->
    <link href="img/bksda.png" rel="icon" />
  </head>

  <!-- header.blade.php -->
  <header id="header" class="header fixed-top bg-light shadow-sm">
    <div class="container d-flex align-items-center justify-content-between py-2">
        <div class="logo d-flex align-items-center">
            <img id="logo" src="{{ asset('img/bksda.png') }}" alt="Balai KSDA" style="height: 40px;">
            <span id="balai" class="d-none d-lg-block ms-2 fw-bold text-dark">Balai KSDA Jawa Tengah</span>
        </div>
        <nav class="nav d-flex align-items-center">
          <a href="{{ route('home') }}" class="nav-link text-dark fw-semibold">Home</a>
          <a href="{{ route('formInputDinas') }}" class="nav-link text-dark fw-semibold">Form Input</a>
          <a href="{{ route('monitoringDinas') }}" class="nav-link text-dark fw-semibold">Data Perjalanan Dinas</a>
          <a href="#" class="nav-link text-dark">
              <i class="bi bi-person-circle" style="font-size: 1.5em;"></i>
          </a>
        </nav>
    </div>
  </header>

</html>
