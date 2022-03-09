<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Master</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.gritter.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">

</head>
<body>
        <header id="header" class="header"style="background-color:#2E323A;">
          <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
          </div>
          <!--logo start-->
          <a href="#" class="logo"><b><span>Gestion de vente des Unites</span></b></a>
          <!--logo end-->
          <div class="mt-3">
            <div class="top-menu">
              <ul class="nav pull-right top-menu">
                <li><a class="logout" href="#">Logout</a></li>
              </ul>
            </div>
          </div>
          
        </header>
        <!--header end-->
        <!-- **********************************************************************************************************************************************************
            MAIN SIDEBAR MENU
            *********************************************************************************************************************************************************** -->
        <!--sidebar start-->
        <aside>
          <div id="sidebar" class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
              <p class="centered"><a href="#"><img src="{{ asset('img/logo.PNG') }}" class="img-circle" width="80"></a></p>
              <hr>
              <li class="mt">
                <a class="active" href="{{ route('dashboard.index') }}">
                  <i class="fa fa-dashboard"></i>
                  <span>Dashboard</span>
                  </a>
              </li>
              <li class="sub-menu">
                <a href="javascript:;">
                  <i class="fa fa-desktop"></i>
                  <span>Reception</span>
                  </a>
                <ul class="sub">
                  <li><a href="{{ route('client.index') }}">Client</a></li>
                  <li><a href="{{ route('fournisseur.index') }}">Fournisseur</a></li>
                  <li><a href="#">Comptabilite</a></li>
                </ul>
              </li>
              <li class="sub-menu">
                <a href="javascript:;">
                  <i class="fa fa-cogs"></i>
                  <span>Articles</span>
                  </a>
                <ul class="sub">
                  <li><a href="{{ route('products.index') }}">Nos produits</a></li>
                  <li><a href="{{ route('sale.index') }}">Vente</a></li>
                  <li><a href="{{ route('alert.index') }}">Paramettre</a></li>
                </ul>
              </li>
            <!-- sidebar menu end-->
          </div>
        </aside>
        <div id="main-content">
          <div class="wrapper">
            <div id="BodyContainer" class="container-fluid anyClass">
              @yield('contenu')
              @yield('modal')
              @yield('monscript')
            </div>
          </div>
        </div>
        
        
        
        <footer class="site-footer">
          <div class="text-center">
            <p>
              &copy; Copyrights <strong>Winner</strong>. All Rights Reserved
            </p>
            <a href="#" class="go-top">
              <i class="fa fa-angle-up"></i>
              </a>
          </div>
        </footer>
        
    {{-- </section> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script class="include" type="text/javascript" src="{{ asset('lib/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('lib/jquery.scrollTo.min.js') }} "></script>
    <script src="{{ asset('lib/jquery.nicescroll.js') }} " type="text/javascript"></script>
    <script src="{{ asset('lib/jquery.sparkline.js') }} "></script>
    <script src=" {{ asset('lib/common-scripts.js') }} "></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
</html>