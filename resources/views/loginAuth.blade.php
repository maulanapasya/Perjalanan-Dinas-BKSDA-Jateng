<!DOCTYPE html>

<head>
    <link href="<?php echo asset('css/bootstrap.css') ?>" rel="stylesheet">
    <link href="<?php echo asset('css/headerMain.css') ?>" rel="stylesheet">
    <link href="<?php echo asset('css/loginAuth.css') ?>" rel="stylesheet">
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
    <!-- judul tab -->
    <title>Login</title>
  </head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="login-card">
            <div class="login-logo">
                <img src="<?php echo asset('img/bksda.png') ?>" alt="Balai KSDA" />
            </div>
            <h2 class="login-header">Login</h2>
            <form>
                <div class="form-group login-input">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username">
                </div>
                <div class="form-group login-input">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary login-btn">Login</button>
            </form>
        </div>
    </div>
</body>

</html>