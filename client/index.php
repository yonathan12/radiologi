<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Radiologi Bethesda</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    /* Center the loader */
    .loader {
      position: absolute;
      left: 50%;
      top: 50%;
      z-index: 1;
      width: 150px;
      height: 150px;
      margin: -75px 0 0 -75px;
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
    }
    
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    /* Add animation to "page content" */
    .animate-bottom {
      position: relative;
      -webkit-animation-name: animatebottom;
      -webkit-animation-duration: 1s;
      animation-name: animatebottom;
      animation-duration: 1s
    }
    
    @-webkit-keyframes animatebottom {
      from { bottom:-100px; opacity:0 } 
      to { bottom:0px; opacity:1 }
    }
    
    @keyframes animatebottom { 
      from{ bottom:-100px; opacity:0 } 
      to{ bottom:0; opacity:1 }
    }
    </style>
    <div class="loader" id="loader"></div>
    <!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  url = "http://localhost/bethesda/api/";
  $.widget.bridge('uibutton', $.ui.button)
  $("#loader").hide();
</script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../plugins/chart.js/Chart.min.js"></script>
<script src="../plugins/sparklines/sparkline.js"></script>
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../dist/js/adminlte.js"></script>
<script src="../dist/js/demo.js"></script>

<script src="../plugins/jquery/sweetalert2.all.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">Radiologi</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block" id="user">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link klik_menu" id="dashboard">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dosis
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link klik_menu" id="add_data">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Data</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link klik_menu" id="all_data">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Data</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link klik_menu" id="dashboard">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Reject
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link klik_menu" id="add_data_reject">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Data</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link klik_menu" id="all_data_reject">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Data</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link klik_menu" id="logout">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="body content">
     <div class="container">
       <p id="puser"></p>
     </div>
    </div>
  </div>
  <footer class="main-footer">Copyright &copy; 2019 - Present. Jon Dev,
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      Template By <a href="http://adminlte.io">AdminLTE.io</a>
    </div>
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
<script>
  token = localStorage.getItem('token');
  document.getElementById("user").innerHTML = localStorage.getItem('fullnm');
  document.getElementById("puser").innerHTML = 'Selamat Datang '+localStorage.getItem('fullnm');
  $(document).ready(function(){
    
      if(!token){
        window.location = "http://localhost/bethesda/client/login.php";
      }
      $('.klik_menu').click(function(){
        var menu = $(this).attr('id');
        
        if(menu == "add_data"){
          $('.body').load('add_data.php');	
        }else if(menu == "logout"){
          localStorage.removeItem("token");
          localStorage.removeItem("fullnm");
          window.location = "http://localhost/bethesda/client/login.php";	
        }else if(menu == "all_data"){
          $("#loader").show();
          $('.body').load('all_data.php');
          getDataPasien();
        }else if(menu == "add_data_reject"){
          $('.body').load('add_data_reject.php');	
        }else if(menu == "all_data_reject"){
          $("#loader").show();
          $('.body').load('all_data_reject.php');
          getDataReject();
        }

      });
    });
</script>
<script type="text/javascript" src="pasien.js"></script>
<script type="text/javascript" src="reject.js"></script>
</body>
</html>
