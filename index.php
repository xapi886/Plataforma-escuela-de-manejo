<?php
date_default_timezone_set("America/Costa_Rica");

include_once 'Plataforma/Utilidades/main.php';
$resultMessage = $_REQUEST['result']  ?? '';

if (isset($_SESSION['idUser'])) {
    session_regenerate_id(true);
    include_once 'Plataforma/Vistas/home.php';
} else if (isset($_POST['btn-login']) && isset($_POST['username']) && isset($_POST['password'])) {

    $txtEmail = $_POST['username'];
    $txtPassword = $_POST['password'];
    $userRegistrado = $controladorEstudiante->UsuarioRegistrado($txtEmail);//usuarioRegistrado;
    if ($userRegistrado){
        if ($activeUser->login($txtEmail, $txtPassword)){ //Usuario Registrado y activo
            try {
                $resultEstudiante = $activeUser->getEstudianteByEmail($txtEmail);

                $session->setCurrentId($resultEstudiante->getIdEstudiante());
                $session->setCurrentEmail($resultEstudiante->getEmail());
                $session->setCurrentName($resultEstudiante->getNombre(), $resultEstudiante->getApellido());
                $session->setCurrentPhoto($resultEstudiante->getFoto());

                header("Location: index.php?result=SuccesLogin");
                include_once 'Plataforma/Vistas/home.php';
            } catch (Exception $e) {
                header("Location: index.php?result=ErrorLogin");
                include_once 'Plataforma/Vistas/principal.php';
            }
        } else {
            header("Location: index.php?result=DatosIncorrectos");
            include_once 'Plataforma/Vistas/principal.php';
        }
    } else {
        header("Location: index.php?result=NoRegistrado");
        include_once 'Plataforma/Vistas/principal.php';
    }
} else {
    include_once 'Plataforma/Vistas/principal.php';
}

if ($resultMessage === "ErrorLogin") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Lo sentimos, algo salio mal, intentelo de nuevo
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("#idresultMessage").modal("show");
        </script>';
} else if ($resultMessage === "DatosIncorrectos") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                 Usuario o Contraseña Incorrecta
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
} else if ($resultMessage === "NoRegistrado") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     Lo sentimos,No hay ninguna cuenta registrada y activa con este correo. 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
} else if ($resultMessage === "SuccesLogin") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bienvenido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        Usuario y Contraseñas Correctos
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
}else if ($resultMessage === "CamposVacios") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        Usuario y Contraseñas Correctos;
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
}else if ($resultMessage === "inscripcionExitosa") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        Felicidades usted se ha inscrito correctamente, ya puede iniciar session con su usuario y contraseña registrados
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
}else if ($resultMessage === "recuperacionCorrecta") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                    Tu contraseña se ha actualizado correctamente.
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
}else if ($resultMessage === "recuperacionIncorrecta") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                    Lo sentimos, a ocurrido un error al actualizar tu contraseña, por favor ponte en contacto con nosotros para ayudarte a solucionarlo.   
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
}
?>
