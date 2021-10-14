<?php
$modulo = $_REQUEST['modulo'] ?? '';
if ($modulo == "cerrarSesion") {
    include_once "Utilidades/logout.php";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <!--  Plugin for Sweet Alert -->
    <link rel="apple-touch-icon" sizes="76x76" href="Plataforma/img/apple-icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="../../css/font-awesome.min.css" rel="stylesheet">-->
    <link href="../../css/aos.css" rel="stylesheet">
    <link href="css/sidebar.css" rel="stylesheet">
    <link href="css/viewer.css" rel="stylesheet">

    <link href="css/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="css/perfect-scrollbar.css" rel="stylesheet" type="text/css" />

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <!-- <script src="../../js/popper.min.js"></script> -->
    <script src="js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/fontawesome.js"></script>
    <title>Escuela de Manejo Century</title>
</head>

<body class="row m-0 justify-content-center align-items-center vh-100">
    <!-- Seccion de navbar -->
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div id="container-button" class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <div id="menu" class="pl-4 pr-4 pt-2">
                <div class="w-100"><img src="img/logo/logo.png" class="logo"></div>
                <ul class="list-unstyled components mb-5">
                    <li class="banners <?php echo ($modulo == "home" || $modulo == "") ? "active" : " "; ?>">
                        <a href="/admin?modulo=home"><i class="fas fa-map"></i>&nbsp; Banners</a>
                    </li>
                    <li class="estudiantes <?php echo ($modulo == "estudiantes") ? "active" : " "; ?>">
                        <a href="/admin?modulo=estudiantes"><i class="fas fa-user-graduate"></i>&nbsp; Estudiantes</a>
                    </li>
                    <li class="horarios <?php echo ($modulo == "horarios") ? "active" : " "; ?>">
                        <a href="/admin?modulo=horarios"><i class="fas fa-calendar-alt"></i>&nbsp; Horarios</a>
                    </li>
                    <li class="examenes <?php echo ($modulo == "examenes") ? "active" : " "; ?>">
                        <a href="/admin?modulo=examenes"><i class="fas fa-file-alt"></i>&nbsp; Exámenes</a>
                    </li>
                    <li class="mi-informacion <?php echo ($modulo == "info") ? "active" : " "; ?>">
                        <a href="/admin?modulo=info"><i class="fas fa-info-circle"></i>&nbsp; Mi Información</a>
                    </li>
                    <li class="cerrarsession <?php echo ($modulo == "cerrarSesion") ? "active" : " "; ?>">
                        <a href="/admin?modulo=cerrarSesion"><i class="fas fa-sign-out-alt"></i>&nbsp; Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content  -->
        <div id="main-container" class="w-100">
            <?php
            if ($modulo == "home" || $modulo == "") {
                include_once "vistas/banners.php";
            }
            if ($modulo == "estudiantes") {
                include_once "vistas/estudiantes.php";
            }
            if ($modulo == "horarios") {
                include_once "vistas/horarios.php";
            }
            if ($modulo == "examenes") {
                include_once "vistas/examenes.php";
            }
            if ($modulo == "info") {
                include_once "vistas/mi-informacion.php";
            }
            if ($modulo == "cerrarSesion") {
                header('Location: /admin');
            }
            ?>
        </div>
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript" src="js/viewer.js"></script>
    <script type="text/javascript" src="js/main-viewer.js"></script>
    <script type="text/javascript" src="js/datatables.min.js"></script>
    <script type="text/javascript" src="js/perfect-scrollbar.min.js"></script>
    <script type="text/javascript" src="js/adjust-container.js"></script>
    <script type="text/javascript" src="js/user.js"></script>

</body>

</html>