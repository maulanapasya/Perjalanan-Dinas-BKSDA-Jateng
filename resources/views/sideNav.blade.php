<link href="<?php echo asset('css/sideNav.css') ?>" rel="stylesheet">

<body>
    <div class="side-nav">
      <div class="user">
        <img src="img/user.png" class="user-img" alt="user" />
        <div>
          <h2>Admin</h2>
        </div>
      </div>
      <ul>
        <a href="{{ route('dashboard') }}"><li><img src="<?php echo asset('img/dashboard.png') ?>" alt="dashboard logo" /><p>Dashboard</p></li></a>
        <a href="{{ route('monitoringDinas') }}"><li><img src="<?php echo asset('img/list.png') ?>" alt="list logo" /><p>Daftar Perjalanan Dinas</p></li></a>
        <a href="{{ route('formInputDinas') }}"><li><img src="<?php echo asset('img/insert.png') ?>" alt="insert logo" /><p>Input Perjalanan Dinas</p></li></a>
      </ul>
      <ul>
        <div class="logout-section">
          <li><img src="<?php echo asset('img/logout.png') ?>" alt="logout logo" /><p>Logout</p></li>
        </div>
      </ul>
    </div>
  </body>