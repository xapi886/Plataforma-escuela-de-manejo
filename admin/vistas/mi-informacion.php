<link rel="stylesheet" href="css/mi-informacion.css">

<div class="principal-section">
    <!-- Seccion de cabecera -->
    <header class="header-box text-white text-center">Información de Usuario Administrador</header>
    <!-- Seccion principal -->
    <main class="container mt-4 mb-4" style="width: 65%;">
        <!-- Seccion de formulario -->
        <section id="info-section" class="bg-light">
            <h3 class="p-4 text-center">Mi Información</h3>
            <form id="frmMiInformacion" class="" action="" method="post" enctype="multipart/form-data">
                <!-- Seccion de informacion -->
                <?php $userModel = new UserModel();
                $query = $userModel->getallUser();
                foreach ($query as $user) {
                    $nombre = $user['Nombre'];
                    $apellido = $user['Apellido'];
                    $password = $user['Password'];
                    $idUser = $user['IdUsuario'];
                    $foto = $user['Foto'];
                }
                ?>
                <div class="" style="margin-bottom: 50px;">
                    <h5 class="pr-4 pl-4">Información básica</h5>
                    <div class="form-group row pr-4 pl-4 mr-0 ml-0 border-bottom">
                        <label for="staticEmail" class="col col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Foto</label>
                        <div class="p-0 text-right" style="width: 81%;">
                            <input type="file" id="input-profile-photo" name="input-profile-photo" id="upload-one" accept=".jpg, .jpeg, .png" hidden />
                            <label class="btn-upload-image" for="input-profile-photo">
                                <img id="profile-photo" src="<?php echo $foto ?>" alt="Foto de perfil">
                            </label>
                        </div>
                    </div>
                    <div class="form-group row pr-4 pl-4 mr-0 ml-0 border-bottom">
                        <label for="staticEmail" class="col-sm-2 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Nombres</label>
                        <div class="col">
                            <input type="text" id="txt-nombre-user" value=<?php echo $nombre ?> readonly class="form-control-plaintext form-control-sm" id="" placeholder="Nombres">
                        </div>
                        <span class="">
                            <button id="btn-edit-1" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                <i class="fas fa-pen"></i>
                            </button>
                        </span>
                    </div>
                    <div class="form-group row pr-4 pl-4 mr-0 ml-0 border-bottom">
                        <label for="inputPassword" class="col-sm-2 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Apellidos</label>
                        <div class="col">
                            <input type="text" id="txt-apellido-user" value=<?php echo $apellido ?> readonly class="form-control-plaintext form-control-sm" id="" placeholder="Apellidos">
                        </div>
                        <span>
                            <button id="btn-edit-2" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                <i class="fas fa-pen"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <!-- Seccion de informacion -->
                <div>
                    <h5 class="pr-4 pl-4">Seguridad</h5>
                    <div class="form-group row pr-4 pl-4 mr-0 ml-0 border-bottom">
                        <label for="staticEmail" class="col-sm-2 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Contraseña</label>
                        <div class="col">
                            <input type="password" id="txt-password-user" value=<?php echo openssl_decrypt($password, COD, KEY) ?> readonly class="form-control-plaintext form-control-sm" id="inputPassword" placeholder="Password">
                        </div>
                        <span>
                            <button id="btn-show-password" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center mr-2" style="width: 33px; height: 33px; border-radius: 100%;">
                                <img id="img-show-password" src="img/icons/notsee.svg" alt="Ver">
                            </button>
                        </span>
                        <span>
                            <button id="btn-edit-3" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                <i class="fas fa-pen"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <!-- Boton del formulario -->
                <div class="text-center p-4">
                    <button id ="btn-submit-user" class="btn btn-primary btn-sm" type="submit">Actualizar</button>
                </div>
                <input id="id-user" name="id-user" type="hidden" value=<?php echo $idUser ?>>
            </form>
        </section>
    </main>
    <!-- Seccion de pie de pagina -->
    <footer></footer>
</div>