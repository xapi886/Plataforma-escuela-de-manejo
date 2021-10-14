<?php

$modulo = $_REQUEST['modulo'] ?? '';
if ($modulo == "cerrarSesion") {
  include_once "Plataforma/Utilidades/logout.php";
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="gb18030">
  <!--  Plugin for Sweet Alert -->
  <link rel="apple-touch-icon" sizes="76x76" href="Plataforma/img/apple-icon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <title>Escuela de Manejo Century</title>
  <!-- Scripts -->
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/kit-fontawesome.js"></script>
  <script src="js/fontawesome.js"></script>
  <script src="Plataforma/js/estudiante.js"></script>
  <link href="../../admin/css/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
  <!-- CSS Files -->
  <link href="Plataforma/css/viewer.css" rel="stylesheet"/>
  <link href="Plataforma/css/sidebar.css" rel="stylesheet">
  <link href="../../css/aos.css" rel="stylesheet">
  <link href="Plataforma/css/bootstrap.min.css" rel="stylesheet" />
  <link href="Plataforma/css/home.css" rel="stylesheet" />
  <link href="Plataforma/css/estudiante.css" rel="stylesheet" />
  <link href="Plataforma/css/inicio.css" rel="stylesheet" />
  <link href="Plataforma/css/examen.css" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!--    CSS Just for demo purpose, don't include it in your project -->
</head>

<body class="row m-0 justify-content-center align-items-center vh-100">
  <!-- Sidebar -->
  <div class="wrapper d-flex align-items-stretch" id="content-wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
      <div id="container-button" class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
      </div>
      <div class="side-heading my-auto" id="side-heading">
        <div class="side-wrapper" id="sidebar-wrapper">
          <div class="sidebar-heading text-center pl-4 pr-4 pt-2 font-weight-bold ">
            <div class="w-100"><img src="Plataforma/Imagenes/Logo.png" class="logo"></div>
          </div>
        </div>
        <div class="menu w-100 mx-auto pl-4 pr-4 pt-2" id="menu">
          <div class="list-unstyled">
            <a href="index.php?modulo=uLVrzh21VIwZUSlWFHUCoo" class=" border-0 <?php echo ($modulo == "uLVrzh21VIwZUSlWFHUCoo" || $modulo == "") ? "active" : " "; ?>"><i class="fas fa-home mr-2"></i></i>Inicio</a>
            <a href="index.php?modulo=estudiante" class="  border-0  <?php echo ($modulo == "estudiante") ? " active " : " "; ?>"><i class="fas fa-user-graduate mr-2"></i>Estudiante</a>
            <a href="index.php?modulo=horario" class="  border-0 <?php echo ($modulo == "horario") ? " active " : " "; ?>"><i class="fas fa-calendar-alt mr-2"></i>Horario</a>
            <a href="index.php?modulo=verExamen" class="  border-0 <?php echo ($modulo == "verExamen") ? " active " : " "; ?>"><i class="fas fa-file-alt mr-2"></i>Examen</a>
            <a href="index.php?modulo=cerrarSesion" class="  border-0 <?php echo ($modulo == "cerrarSesion") ? "active" : " "; ?>"><i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sessión</a>
          </div>
        </div>
      </div>
    </nav>
    <!-- /#page-content-wrapper -->
    <div id="main-container" class="w-100">
      <?php
      if ($modulo == "uLVrzh21VIwZUSlWFHUCoo" || $modulo == "") {
        include_once "./Plataforma/Vistas/inicio.php";
      }
     if ($modulo == "estudiante") {
        include_once "./Plataforma/Vistas/estudiante.php";
      }
      if ($modulo == "horario") {
        include_once "./Plataforma/Vistas/horario.php";
      }
      if ($modulo == "verExamen") {
        include_once "./Plataforma/Vistas/verExamen.php";
      }
      if ($modulo ==  1) {
        include_once "./Plataforma/Vistas/examen.php";
      }
      if ($modulo == 2) {
        include_once "./Plataforma/Vistas/examen.php";
      }
      if ($modulo == 3) {
        include_once "./Plataforma/Vistas/examen.php";
      }
      if ($modulo == 4) {
        include_once "./Plataforma/Vistas/examen.php";
      }
      if ($modulo == 5) {
        include_once "./Plataforma/Vistas/examen.php";
      }
      if ($modulo ==  "resultadoExamen=1") {
        include_once "./Plataforma/Vistas/resultadoExamen.php";
      }
      if ($modulo ==  "resultadoExamen=2") {
        include_once "./Plataforma/Vistas/resultadoExamen.php";
      }
      if ($modulo ==  "resultadoExamen=3") {
        include_once "./Plataforma/Vistas/resultadoExamen.php";
      }
      if ($modulo ==  "resultadoExamen=4") {
        include_once "./Plataforma/Vistas/resultadoExamen.php";
      }
      if ($modulo ==  "resultadoExamen=5") {
        include_once "./Plataforma/Vistas/resultadoExamen.php";
      }
      if ($modulo == "cerrarSesion") {
        header('Location: /');
      }
      ?>
    </div>
  </div>
  <script type="text/javascript" src="Plataforma/js/adjust-container.js"></script>
  <script type="text/javascript" src="Plataforma/js/perfect-scrollbar.min.js"></script>
  <script type="text/javascript" src="Plataforma/js/scripts.js"></script>
  <script type="text/javascript" src="Plataforma/js/main-viewer.js"></script>
  <script type="text/javascript" src="Plataforma/js/viewer.js"></script>
  <script type="text/javascript" src="../../admin/js/datatables.min.js"></script>
</body>
</html>