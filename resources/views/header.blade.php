<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title>Admin | @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('public/assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/bower_components/bootstrap/css/bootstrap.min.css') }}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/waves.min.css') }}" type="text/css" media="all">
    <link rel="stylesheet" href="{{ asset('public/assets/css/dropzone.min.css') }}" type="text/css" media="all">
    <!-- feather icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/icon/feather/css/feather.css') }}">
    <!-- font-awesome-n -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/font-awesome-n.min.css') }}">
    <!-- Chartlist chart css -->
    <link rel="stylesheet" href="{{ asset('public/assets/bower_components/chartist/css/chartist.css') }}" type="text/css" media="all">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" type="text/css" media="all">

    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/data-table/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/loader.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/toast.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/widget.css') }}">

    <link rel="stylesheet" href="{{ asset('public/assets/sweetalert/dist/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/star_rate/jquery.raty.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/duration_picker/dist/bootstrap-duration-picker.css') }}">
  
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet"> -->
  
    <style type="text/css">
        input[type="file"] {
            display: none;
        }
       
        img {
            cursor: pointer;
        }
    </style>  
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-bar"></div>
    </div>
    <!-- [ Pre-loader ] end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <!-- [ Header ] start -->
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a href="{{url('/welcome')}}">
                            <b><h4>FoodCulture<br>Admin</h4></b>
                        </a>
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu icon-toggle-right"></i>
                        </a>
                        <a class="mobile-options waves-effect waves-light">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>
                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                    <i class="full-screen feather icon-maximize"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="{{ asset('public/assets/images/admin.jpg') }}" class="img-radius" alt="User-Profile-Image">
                                        <span>FoodCulture Admin</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="{{ url('change_password') }}">
                                                <i class="feather icon-lock"></i> Change Password
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('logout') }}">
                                                <i class="feather icon-log-out"></i> Logout
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <!-- [ navigation menu ] start -->
                    <nav class="pcoded-navbar">
                        <div class="nav-list">
                            <div class="pcoded-inner-navbar main-menu">
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="{{ $menu_name == 'welcome' ? 'active' : '' }}">
                                        <a href="{{url('/welcome')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                            <span class="pcoded-mtext">Dashboard</span>
                                        </a>
                                    </li>
                                    

                                    <li class="{{ $menu_name == 'user' ? 'active' : '' }}">
                                        <a href="{{url('/user')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fa fa-users"></i></span>
                                            <span class="pcoded-mtext">Users</span>
                                        </a>
                                    </li>

                                    <li class="{{ $menu_name == 'premium' ? 'active' : '' }}">
                                        <a href="{{url('/Premium_Members')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fa fa-user-plus"></i></span>
                                            <span class="pcoded-mtext">Premium Members</span>
                                        </a>
                                    </li>

                                    <li class="{{ $menu_name == 'category' ? 'active' : '' }}">
                                        <a href="{{url('/Category')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fa fa-list-ul"></i></span>
                                            <span class="pcoded-mtext">Categories</span>
                                        </a>
                                    </li>

                                    <li class="{{ $menu_name == 'recipe' ? 'active' : '' }}">
                                        <a class="waves-effect waves-dark" onclick="recipe_reload('{{url('/Recipe')}}')">
                                            <span class="pcoded-micon"><i class="fa fa-utensils"></i></span>
                                            <span class="pcoded-mtext">Recipes</span>
                                        </a>
                                    </li>
                                    
                                   
                                    
                                </ul>
                            </div>
                        </div>
                    </nav>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    

    <!-- <footer class="main-footer">
        Copyright &copy; {{-- {{date("Y")}} --}} All rights reserved By Admin.
    </footer> -->

    <script src="{{ asset('public/assets/sweetalert/dist/sweetalert.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('public/assets/bower_components/jquery/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/bower_components/popper.js/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- waves js -->
    <script src="{{ asset('public/assets/js/waves.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('public/assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
    <!-- Chartlist charts -->
    <script src="{{ asset('public/assets/bower_components/chartist/js/chartist.js') }}"></script>
    
    <!-- Custom js -->
    <script src="{{ asset('public/assets/js/pcoded.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/js/script.min.js') }}"></script>
    <script src="{{ asset('public/assets/duration_picker/dist/bootstrap-duration-picker-debug.js') }}"></script>
    <script src="{{ asset('public/assets/js/data-table/data-table-custom.js') }}"></script>
    <script src="{{ asset('public/assets/js/vertical/vertical-layout.min.js') }}"></script>

    <!-- data-table js -->
    <script src="{{ asset('public/assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/assets/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/data-table/jszip.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/data-table/pdfmake.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('public/assets/bower_components/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('public/assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('public/assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/assets/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/assets/star_rate/jquery.raty.js') }}"></script>
    <!--  <script src="{{ asset('public/assets/bower_components/dropzone/dropzone.js') }}"></script> -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
<script>
    
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
  
  function recipe_reload($url){
     
      window.location = $url;
  }
  
  
  
</script>
@yield('script')
</body>


<!-- Mirrored from colorlib.com//polygon/admindek/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Nov 2018 06:08:22 GMT -->
</html>
