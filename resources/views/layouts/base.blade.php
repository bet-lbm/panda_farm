<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  <!-- bootstrap-progressbar -->
  <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
  <!-- bootstrap-daterangepicker -->
  <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('/') }}" class="site_title"><i class="fa fa-plus"></i> {{ config('app.name', 'Laravel') }}</a>
          </div>

          <div class="clearfix"></div>
          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>Mantenimientos</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-users"></i> Clientes <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href={{ route('clients.list') }}>Lista</a></li>
                    <li><a href={{ route('clients.create') }}>Nuevo</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-ambulance"></i> Distribuidores <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href={{ route('dealers.list') }}>Lista</a></li>
                    <li><a href={{ route('dealers.create') }}>Nuevo</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-flask"></i> Laboratorios<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href={{ route('laboratories.list') }}>Lista</a></li>
                    <li><a href={{ route('laboratories.create') }}>Nuevo</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-medkit"></i> Medicamentos <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href={{ route('medicines.list') }}>Lista</a></li>
                    <li><a href={{ route('medicines.create') }}>Nuevo</a></li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="menu_section">
              <h3>PROCESOS</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-shopping-cart"></i> Compras <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href={{ route('purchases.list') }}>Lista de Compras</a></li>
                    <li><a href={{ route('purchases.create') }}>Realizar Compra</a></li>
                    <li><a href="#">Reportes de Compras</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-money"></i> Ventas <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                      <li><a href="#">Lista de Ventas</a></li>
                      <li><a href="#">Realizar Ventas</a></li>
                      <li><a href="#">Consultar Ventas</a></li>
                      <li><a href="#">Reporte de Ventas</a></li>
                  </ul>
                </li>
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small ">
              <a class="pull-right" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <!-- Authentication Links -->
              @if (Auth::guest())
                  <li><a href="{{ route('login') }}">Login</a></li>
                  <li><a href="{{ route('register') }}">Register</a></li>
              @else
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          {{ Auth::user()->name }} <span class="fa fa-angle-down"></span>
                      </a>

                      <ul class="dropdown-menu" role="menu">
                          <li>
                              <a href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                  Logout
                              </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                              </form>
                          </li>
                      </ul>
                  </li>
              @endif
          </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div id="app">
        <div class="right_col" role="main">
          @yield('content')
        </div>
      </div>
      <!-- /page content -->
      
      <!-- footer content -->
      <footer>
        <div class="pull-right">
          <a href="https://ilinktic.com">iLink - TIC</a>
        </div>
        <div class="clearfix"></div>
      </footer>
       <!-- /footer content -->
    </div>
  </div>
  
  <script src="{{asset('js/app.js')}}"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script>
  <!-- jQuery -->
  <script src="../vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="../vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="../vendors/nprogress/nprogress.js"></script>
  <!-- Chart.js -->
  <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
  <!-- gauge.js -->
  <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="../vendors/iCheck/icheck.min.js"></script>
  <!-- Skycons -->
  <script src="../vendors/skycons/skycons.js"></script>
  <!-- Flot -->
  <script src="../vendors/Flot/jquery.flot.js"></script>
  <script src="../vendors/Flot/jquery.flot.pie.js"></script>
  <script src="../vendors/Flot/jquery.flot.time.js"></script>
  <script src="../vendors/Flot/jquery.flot.stack.js"></script>
  <script src="../vendors/Flot/jquery.flot.resize.js"></script>
  <!-- Flot plugins -->
  <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
  <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
  <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
  <!-- DateJS -->
  <script src="../vendors/DateJS/build/date.js"></script>
  <!-- JQVMap -->
  <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
  <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="../vendors/moment/min/moment.min.js"></script>
  <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="../build/js/custom.min.js"></script>



</body>
</html>