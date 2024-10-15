<!DOCTYPE html>
<html lang="en">
  <head>
    <link href="<?php echo asset('css/bootstrap.css') ?>" rel="stylesheet">
    <link href="<?php echo asset('css/headerMain.css') ?>" rel="stylesheet">
    <!-- Logo webpage -->
    <link href="<?php echo asset('img/bksda.jpg') ?>" rel="icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet"
    />

    <!-- Meta tag CSRF -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Vendor CSS Files -->
    <link
      href="<?php echo asset('css/bootstrap-icons.css') ?>"
      rel="stylesheet"
    />
    <link href="<?php echo asset ('css/boxicons.min.css')?>" rel="stylesheet" />
    <link href="<?php echo asset ('css/quill.snow.css')?>" rel="stylesheet"   />
    <link href="<?php echo asset ('css/quill.bubble.css')?>" rel="stylesheet" />
    <link href="<?php echo asset ('css/remixicon.css')?>" rel="stylesheet" />
    <link href="<?php echo asset ('css/style-datatables.css')?>" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="<?php echo asset ('css/mainStyle.css')?>" rel="stylesheet" />
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Logo tab -->
    <link href="img/bksda.png" rel="icon" />
  </head>


  {{-- <body id="headerBody">
    <header id="header" class="header fixed-top d-flex align-items-center">
      <div class="d-flex align-items-center justify-content-between">
        <a class="logo d-flex align-items-center">
          <!-- nanti perlu dikasi href buat direct ke dashboard -->
          <img src="<?php echo asset('img/bksda.png') ?>" alt="Balai KSDA" />
          <span class="d-none d-lg-block">BKSDA Jateng</span>
        </a>
      </div>
      <!-- End Logo -->
    </header>
  <!-- End Header -->
  </body>
  @include('sideNav') --}}

  <!-- header.blade.php -->
  <header id="header" class="header fixed-top bg-light shadow-sm">
    <div class="container d-flex align-items-center justify-content-between py-2">
        <a href="#" class="logo d-flex align-items-center">
            <img src="{{ asset('img/bksda.png') }}" alt="Balai KSDA" style="height: 40px;">
            <span class="d-none d-lg-block ms-2 fw-bold text-dark">BKSDA Jateng</span>
        </a>
    </div>
  </header>


  {{-- <body style="max-width: 1000px; margin: auto; padding-top: 70px"></body> --}}
</html>
