<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIAD</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/ionicons.min.css')}}">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('/dist/css/skins/skin-blue-light.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/plugins/iCheck/flat/blue.css')}}">
    <script>
    window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token(),
    ]); ?>
    </script>
  </head>
  <body class="hold-transition skin-blue-light fixed">
    <div class="wrapper">
      <header class="main-header">
        <a href="#" class="logo">
          <span class="logo-mini"><b>S</b>IAD</span>
          <span class="logo-lg"><b>Sistem</b> Administrasi</span>
        </a>
        <nav class="navbar navbar-static-top">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li>
                <a><span class="fa fa-fw fa-user"></span> {{ Auth::user()->name }}</a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <ul class="sidebar-menu">
            @include('layouts.sidebar')
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
          SMA Muhammadiyah Suradadi
          </h1>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          @include('layouts._flash')
          @yield('content')
        </div>
      </section>
    </div>
    {{-- <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
      </div>
      <strong>Copyright &copy; 2013-2017 <a href="http://projectxid.blogspot.com" target="_blank">Project X</a>.</strong> All rights
      reserved.
    </footer> --}}
  </div>
  <script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  {{-- <script src="{{ asset('/dist/js/jquery-ui.min.js')}}"></script> --}}
  <!-- Bootstrap 3.3.6 -->
  <script src="{{ asset('/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{ asset('/plugins/fastclick/fastclick.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('/dist/js/app.js')}}"></script>
</body>
</html>
