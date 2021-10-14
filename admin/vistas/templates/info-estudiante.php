<?php
try {
    // Obtengo el id del estudiante desde la peticion get
    $id = $_REQUEST['info'] ?? '';

    // Inclusion de clases modelos, controladoras y de conexion
    include_once('../Utilidades/conexion.php');
    include_once('../Utilidades/confiDev.php');
    include_once('../Controladores/StudentController.php');
    include_once('../Modelos/StudentModel.php');

    // Instancia de la clase contralodora StudentController
    $studentController = new StudentController();

    // Obtencion de los datos de estudiante
    $data = $studentController->getInfoStudentById($id) ?? '';
    //echo $data[0]['Seminario'];

    $dataTurno = $studentController->getDisponibilidadByCodigo('V_MARTES');
    $disponibilidad = $dataTurno[0]['Disponibilidad'];

    // echo $disponibilidad;


    // Verifico si el estudiante esta habilitado y verificado al mismo tiempo
    if ($data[0]['Estado'] == 'Habilitado' && $data[0]['Verificacion'] == 'Habilitado') {
        //Obtencion de la modalidades de la semana segun turno vespertino o matutino
        $modalities = $studentController->getWeekModalities($data[0]['Turno'])  ?? '';

        $levels = $studentController->getCourseLevels();
    }
} catch (Throwable $th) {
    // Mensaje de error
    echo "<script>alert('" . $th->getMessage() . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Plataforma en linea, escuela de manejo century" content="">
    <meta name="century creativa" content="">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/font-awesome.min.css" rel="stylesheet">
    <link href="../../css/aos.css" rel="stylesheet">
    <link href="../css/modal.css" rel="stylesheet">
    <link href="../css/info-estudiante.css" rel="stylesheet">

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/fontawesome.js"></script>

    <title>Escuela de Manejo Century</title>
</head>

<body background="../img/backgrounds/info-min.png">
    <!-- Contenedor de la ventana Modal -->
    <div class="modal show" id="estudiante-modal" tabindex="-1" role="dialog">
        <!-- Ventana Modal -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="/admin/?modulo=estudiantes" id="btn-back" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h4 class="modal-title m-auto font-weight-bold" style="text-align: center;">Información estudiante</h4>
                </div>
                <div class="modal-body principal">
                    <!-- Ejemplo de como moverse entre directorios a partir de aquí ../Ajax/StudentAjax.php -->
                    <form id="form-info-estudiante" method="post" enctype="multipart/form-data" autocomplete="off">

                        <input type="hidden" id="hidden-data-estado" name="estado" value="<?php echo $data[0]['Estado']; ?>">
                        <input type="hidden" id="hidden-data-verificacion" name="verificacion" value="<?php echo $data[0]['Verificacion']; ?>">
                        <input id="id-estudiante" type="hidden" name="id-estudiante" value="<?php echo $id; ?>">

                        <?php if ($data[0]['Estado'] == 'Habilitado' && $data[0]['Verificacion'] == 'Habilitado') : ?>
                            <input id="codigo-turno" type="hidden" name="codigo-turno" value="<?php echo $data[0]['CodigoTurno']; ?>">
                            <input type="hidden" id="Codigo" value="">

                        <?php endif; ?>


                        <!-- <input type="hidden"  id="Codigo" value=""> -->

                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Información básica</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-form-label col text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Foto</label>
                                <div class="p-0 text-right col" style="width: 100%;">
                                    <input type="file" id="input-profile-photo" name="input-profile-photo" accept=".jpg, .jpeg, .png" hidden />
                                    <label class="btn-upload-image" for="input-profile-photo">
                                        <?php if ($data[0]['Estado'] == 'Habilitado' && $data[0]['Verificacion'] == 'Habilitado') : ?>
                                            <img id="profile-photo" src="<?php echo "../../" . $data[0]['Foto']; ?>" alt="Foto de perfil">
                                        <?php elseif ($data[0]['Foto'] != '' || $data[0]['Estado'] == 'Deshabilitado' && $data[0]['Verificacion'] == 'Deshabilitado') : ?>
                                            <img id="profile-photo" src="<?php echo "../../" . $data[0]['Foto']; ?>" alt="Foto de perfil">
                                        <?php elseif ($data[0]['Foto'] == '' || $data[0]['Estado'] == 'Deshabilitado' && $data[0]['Verificacion'] == 'Deshabilitado') : ?>
                                            <img id="profile-photo" src="/admin/img/profile/00001_TEMPLATE.svg" alt="Foto de perfil">
                                        <?php endif; ?>
                                    </label>
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Nombres</label>
                                <div class="col">
                                    <input type="text" readonly required class="form-control-plaintext form-control-sm" id="txt-nombre" placeholder="Nombres" value="<?php echo $data[0]['Nombre']; ?>">
                                </div>
                                <span>
                                    <button id="btn-one" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Apellidos</label>
                                <div class="col">
                                    <input type="text" readonly required class="form-control-plaintext form-control-sm" id="txt-apellido" placeholder="Apellidos" value="<?php echo $data[0]['Apellido']; ?>">
                                </div>
                                <span>
                                    <button id="btn-two" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Fecha de nacimiento</label>
                                <div class="col">
                                    <input type="date" readonly class="form-control-plaintext form-control-sm" id="txt-fecha-nacimiento" value="<?php echo $data[0]['FechaNacimiento']; ?>">
                                </div>
                                <span>
                                    <button id="btn-three" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Sexo</label>
                                <div class="col">
                                    <select id="select-sexo" class="form-control-plaintext form-control-sm" readonly>
                                        <option value="Femenino" <?php echo $data[0]['Sexo'] == 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                                        <option value="Masculino" <?php echo $data[0]['Sexo'] == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Cédula</label>
                                <div class="col">
                                    <input type="text" readonly required class="form-control-plaintext form-control-sm" id="txt-cedula" placeholder="Número de cédula" value="<?php echo $data[0]['Cedula']; ?>">
                                </div>
                                <span>
                                    <button id="btn-five" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">N° Pasaporte</label>
                                <div class="col">
                                    <input type="text" readonly class="form-control-plaintext form-control-sm" id="txt-pasaporte" placeholder="Número de pasaporte" value="<?php echo $data[0]['Pasaporte']; ?>">
                                </div>
                                <span>
                                    <button id="btn-six" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Información de contacto</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Correo Electrónico</label>
                                <div class="col">
                                    <input type="email" readonly required class="form-control-plaintext form-control-sm" id="txt-email" placeholder="Email" value="<?php echo $data[0]['Email']; ?>">
                                </div>
                                <span>
                                    <button id="btn-seven" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Teléfono / Celular</label>
                                <div class="col">
                                    <input type="tel" readonly required class="form-control-plaintext form-control-sm" id="txt-telefono" placeholder="Teléfono o Celular" value="<?php echo $data[0]['Telefono']; ?>">
                                </div>
                                <span>
                                    <button id="btn-eight" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Dirección</label>
                                <div class="col">
                                    <input type="text" readonly class="form-control-plaintext form-control-sm" id="txt-direccion" placeholder="Dirección" value="<?php echo $data[0]['Direccion']; ?>">
                                </div>
                                <span>
                                    <button id="btn-nine" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Seguridad</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Contraseña</label>
                                <div class="col">
                                    <input type="password" readonly required class="form-control-plaintext form-control-sm" id="txt-password" placeholder="Contraseña" value="<?php echo openssl_decrypt($data[0]['Password'], COD, KEY); ?>">
                                </div>
                                <span>
                                    <button id="btn-show-password" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center mr-2" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img id="img-show-password" src="../img/icons/notsee.svg" alt="Ver">
                                    </button>
                                </span>
                                <span>
                                    <button id="btn-ten" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>

                            <?php if ($data[0]['Estado'] == 'Habilitado' && $data[0]['Verificacion'] == 'Habilitado') : ?>

                                <!-- Division de entrada de datos -->
                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Estado</label>
                                    <div class="col">
                                        <select id="select-estado" class="form-control-plaintext form-control-sm" readonly>
                                            <option value=1 <?php echo $data[0]['Estado'] == 'Habilitado' ? 'selected' : ''; ?>>Habilitado</option>
                                            <option value=0 <?php echo $data[0]['Estado'] == 'Deshabilitado' ? 'selected' : ''; ?>>Deshabilitado</option>
                                        </select>
                                    </div>
                                </div>

                            <?php endif; ?>

                        </div>

                        <?php if ($data[0]['Estado'] == 'Habilitado' && $data[0]['Verificacion'] == 'Habilitado') : ?>

                            <!-- Division de informacion -->
                            <div style="margin-bottom: 50px;">
                                <h5 class="pr-4 pl-4 font-weight-bold">Información de experiencia</h5>
                                <!-- Division de entrada de datos -->
                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom" style="padding-top: 14px; padding-bottom: 14px;">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Principiante</label>
                                    <div class="col">
                                        <div class="form-check d-inline form-control-sm">
                                            <input class="form-check-input" type="radio" name="radio-principiante" id="radio-principiante-si" value="Si" <?php echo $data[0]['Principiante'] == 1 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="radio-principiante-si">
                                                Si
                                            </label>
                                        </div>
                                        <div class="form-check d-inline form-control-sm">
                                            <input class="form-check-input" type="radio" name="radio-principiante" id="radio-principiante-no" value="No" <?php echo $data[0]['Principiante'] == 0 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="radio-principiante-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Division de entrada de datos -->
                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom" style="padding-top: 14px; padding-bottom: 14px;">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Licencia de conducir</label>
                                    <div class="col">
                                        <div class="form-check d-inline form-control-sm">
                                            <input class="form-check-input" type="radio" name="radio-licencia" id="radio-licencia-si" value="Si" <?php echo $data[0]['LicenciadeConducir'] == 1 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="radio-licencia-si">
                                                Si
                                            </label>
                                        </div>
                                        <div class="form-check d-inline form-control-sm">
                                            <input class="form-check-input" type="radio" name="radio-licencia" id="radio-licencia-no" value="No" <?php echo $data[0]['LicenciadeConducir'] == 0 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="radio-licencia-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Division de entrada de datos -->
                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Categoría</label>
                                    <div class="col">
                                        <input type="text" readonly class="form-control-plaintext form-control-sm" id="txt-categoria" placeholder="Categoría de licencia" value="<?php echo $data[0]['Categoria']; ?>">
                                    </div>
                                    <span>
                                        <button id="btn-eleven" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                            <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <!-- Division de informacion -->

                            <div>
                                <h5 class="pr-4 pl-4 font-weight-bold">Información del curso</h5>
                                <!-- Division de entrada de datos -->
                                <!-- SEMINARIO -->
                                <!-- SEMINARIO -->
                                <!-- SEMINARIO -->

                                <?php if ($data[0]['Seminario'] == '1') : ?>
                                    <!--Caso en el que el estudiante haya realizado ya el seminario -->

                                    <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                        <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Turno</label>
                                        <div class="col">
                                            <select id="select-turno" class="form-control-plaintext form-control-sm" disabled readonly>
                                                <option value="Matutino" <?php echo $data[0]['Turno'] == 'Matutino' ? 'selected' : ''; ?>>Matutino</option>
                                                <option value="Vespertino" <?php echo $data[0]['Turno'] == 'Vespertino' ? 'selected' : ''; ?>>Vespertino</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select id="select-modalidades" class="form-control-plaintext form-control-sm" disabled readonly>
                                                <?php foreach ($modalities as $item) : ?>
                                                    <option value="<?php echo $item['CodigoTurno']; ?>" <?php echo $data[0]['Modalidad'] == $item['Descripcion'] ? 'selected' : ''; ?>><?php echo $item['Descripcion']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                        <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">¿Seminario Finalizado?</label>
                                        <input class="ml-3 mr-2" type="checkbox" disabled checked name="seminario">
                                        <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Si</label>

                                    </div>
                                <?php elseif ($data[0]['Seminario'] == '') : ?>
                                    <!--Caso en el que el estudiante haya NO realizado ya el seminario -->

                                    <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                        <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Turno</label>
                                        <div class="col">
                                            <select id="select-turno" class="form-control-plaintext form-control-sm" readonly>
                                                <option value="Matutino" <?php echo $data[0]['Turno'] == 'Matutino' ? 'selected' : ''; ?>>Matutino</option>
                                                <option value="Vespertino" <?php echo $data[0]['Turno'] == 'Vespertino' ? 'selected' : ''; ?>>Vespertino</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select id="select-modalidades" class="form-control-plaintext form-control-sm" readonly>
                                                <?php foreach ($modalities as $item) : ?>
                                                    <option value="<?php echo $item['CodigoTurno']; ?>" <?php echo $data[0]['Modalidad'] == $item['Descripcion'] ? 'selected' : ''; ?>><?php echo $item['Descripcion']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                        <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">¿Seminario Finalizado?</label>
                                        <input class="ml-3" type="checkbox" name="seminario">
                                    </div>
                                <?php endif; ?>



                                <!-- Division de entrada de datos -->
                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Nivel curso / Horas prácticas</label>
                                    <div class="col">
                                        <select id="select-levels" class="form-control-plaintext form-control-sm" readonly>
                                            <?php foreach ($levels as $item) : ?>
                                                <option value="<?php echo $item['IdNivel']; ?>" <?php echo $data[0]['NivelCurso'] == $item['NivelCurso'] ? 'selected' : ''; ?>><?php echo $item['NivelCurso']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Fecha de examen teorico y examen pracico con la escuela de manejo -->

                                <!-- Division de entrada de datos -->
                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Fecha de examen teórico escuela de manejo</label>
                                    <div class="col">
                                        <input type="date" readonly class="form-control-plaintext form-control-sm" id="txt-fecha-examen" value="<?php echo $data[0]['FechaExamen']; ?>" min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <span>
                                        <button id="btn-twelve" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                            <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                        </button>
                                    </span>
                                </div>

                                <!-- Division de entrada de datos -->
                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 ">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Fecha de examen practico escuela de manejo</label>
                                    <div class="col">
                                        <input type="date" readonly class="form-control-plaintext form-control-sm" id="txt-fecha-practica" value="<?php echo $data[0]['FechaPractica']; ?>" min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <span>
                                        <button id="btn-thirteen" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                            <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                        </button>
                                    </span>
                                </div>

                                <!-- Fecha de examen teorico y examen pracico con transito -->
                                <!-- Division de entrada de datos -->

                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom" style="border-top: 4px solid #dee2e6 !important;">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Fecha de examen teórico en transito</label>
                                    <div class="col">
                                        <input type="date" readonly class="form-control-plaintext form-control-sm" id="txt-fecha-examen-transito" value="<?php echo $data[0]['FechaETeoricoTransito'] ?>" ;min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <span>
                                        <button id="btn-fourteen" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                            <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                        </button>
                                    </span>
                                </div>

                                <!-- Division de entrada de datos -->
                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Fecha de examen practico en transito</label>
                                    <div class="col">
                                        <input type="date" readonly class="form-control-plaintext form-control-sm" id="txt-fecha-practica-transito" value="<?php echo $data[0]['FechaEPracticaTransito'] ?>" ; min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <span>
                                        <button id="btn-fifteen" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                            <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                        </button>
                                    </span>
                                </div>

                                <!-- Ingresar Comprobante de inscripcion -->
                                <!-- Division de entrada de datos -->
                                <!-- Comprobante de inscripcion ET-->

                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Comprobante de Inscripcion Examen teórico</label>
                                    <div class="col" style="width: 100%;">
                                        <input id="comprobanteET" name="comprobanteET" type="file" name="comprobanteET" accept=".pdf" hidden>
                                        <label class="mt-2 ml-1 p-1 btn btn-success" id="label-comprobanteET" style="font-size: 12px; padding: 0;" for="comprobanteET">Adjuntar archivo</label>
                                        <?php if ($data[0]['ComprobanteET'] != "") : ?>
                                            <!-- <iframe id="profile-photo"  alt="Comprobante"> -->
                                            <br>
                                            <embed class="ml-1" id="view-1" src="<?php echo '../../../' .  $data[0]['ComprobanteET']; ?>" type="application/pdf" width="100px" height="100px" />
                                            <br>
                                            <a class="ml-1" href="<?php echo '../../../' .  $data[0]['ComprobanteET']; ?>" target="_blank" style="font-size: 14px; padding: 0;">Ver archivo</a>


                                        <?php elseif ($data[0]['ComprobanteET'] == "") : ?>

                                            <br>
                                            <iframe id="template-comprobante" src="/admin/img/template-comprobante/template-comprobante.pdf" width="100px" height="100px" alt="template-comprobante" frameborder="0"> </iframe>
                                            <!-- <img id="template-comprobante" src="/admin/img/template-comprobante/template-comprobante.png" width="100px" height="100px" alt="template-comprobante">-->
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- <-->

                                <!-- Division de entrada de datos -->
                                <!-- Comprobante de inscripcion EP-->
                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                    <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Comprobante de Inscripcion Examen practico</label>
                                    <div class="col" style="width: 100%;">
                                        <input id="comprobanteEP" name="comprobanteEP" type="file" name="comprobanteEP" accept=".pdf" hidden>
                                        <label id="label-comprobanteEP" class="mt-2 p-1 btn btn-success" style="font-size: 12px; padding: 0;" for="comprobanteEP">Adjuntar archivo</label>

                                        <!-- <label class="btn-upload-image" for="comprobanteEP">Subir archivo</label>-->
                                        <?php if ($data[0]['ComprobanteEP'] != "") : ?>
                                            <!-- <iframe id="profile-photo"  alt="Comprobante"> -->
                                            <br>
                                            <embed class="ml-1" id="view-2" src="<?php echo '../../../' .  $data[0]['ComprobanteEP']; ?>" type="application/pdf" width="100px" height="100px" />
                                            <br>
                                            <a class="ml-1" href="<?php echo '../../../' .  $data[0]['ComprobanteEP']; ?>" target="_blank" style="font-size: 14px; padding: 0;">Ver archivo</a>
                                        <?php elseif ($data[0]['ComprobanteEP'] == "") : ?>
                                            <br>
                                            <iframe id="template-comprobante-2" src="/admin/img/template-comprobante/template-comprobante.pdf" width="100px" height="100px" alt="template-comprobante-2" frameborder="0"> </iframe>
                                            <!-- <img id="template-comprobante-2" src="/admin/img/template-comprobante/template-comprobante.png" width="100px" height="100px" alt="template-comprobante-2">-->
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>

                            <!-- Seccion de link para mas informacion -->
                            <div class="mt-4 pr-4 text-right">
                                <a target="_blank" href="/admin/vistas/mas-info-estudiante.php?additional=<?php echo $id; ?>" class="btn btn-outline-light btn-sm text-primary">&#8594;&nbsp;Ver más información</a>
                            </div>



                        <?php endif; ?>
                        <?php if ($data[0]['Estado'] == 'Deshabilitado' && $data[0]['Verificacion'] == 'Habilitado') : ?>
                            <div class="mt-4 pr-4 text-right">
                                <a target="_blank" href="/admin/vistas/info-inscripcion.php?additional=<?php echo $id; ?>" class="btn btn-outline-light btn-sm text-primary">&#8594;&nbsp;Habilitar estuddiante</a>
                            </div>
                        <?php endif; ?>

                        <!-- Botones del formulario -->
                        <div class="modal-footer border-0 d-flex justify-content-center">
                            <a href="/admin/?modulo=estudiantes" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</a>
                            <button id="btn-submit" type="submit" class="btn btn-primary btn-sm" value="Actualizar" disabled>Actualizar</button>
                        </div>
                    </form>

                    <!-- Generar Hoja de inscripcion -->
                    <div class="pr-2 text-right">
                        <form id="frm-reportes" action="/admin/Utilidades/HojaInscripcion.php?id=<?php echo $id; ?>" target="_blank" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="nombreReporte" value="reporte1">
                            <input type="hidden" name="id-er" value="<?php echo $id; ?>" >
                            <button type="submit" class="btn-success btn-generar-report">
                                <i class="fas fa-print"></i> &nbsp;Generar
                            </button>
                        </form>
                    </div>
                    <!-- Fin generador de Hoja de inscripcion -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="../js/info-estudiante.js"></script>
</body>

</html>