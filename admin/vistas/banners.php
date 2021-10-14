<link rel="stylesheet" href="css/banners.css">

<div class="principal-section">
    <!-- Seccion de cabecera -->
    <header class="header-box text-white text-center">Cambiar imágenes de banners</header>
    <!-- Seccion principal -->
    <main class="docs-pictures mb-3">

        <!-- Seccion de imagen -->
        <section class="image-box">
            <div class="image-header text-white text-right">
                <span class="image-title">Imagen #001 (1024x384) </span>
                <input type="file" id="upload-one" accept=".png" hidden />
                <label class="btn-upload-image" for="upload-one"><i class="fas fa-pen"></i>&nbsp;Cambiar</label>
            </div>
            <div class="bg-transparent h-100">
                <img id="img-upload-one" data-original="img/banners/001.png?time=<?php echo date('H:i:s'); ?>" class="image" src="img/banners/001.png?time=<?php echo date('H:i:s'); ?>" alt="">
            </div>
        </section>

        <!-- Seccion de imagen -->
        <section class="image-box">
            <div class="image-header text-white text-right">
                <span class="image-title">Imagen #002 (1024x384)</span>
                <input type="file" id="upload-two" accept=".png" hidden />
                <label class="btn-upload-image" for="upload-two"><i class="fas fa-pen"></i>&nbsp;Cambiar</label>
            </div>
            <div class="bg-transparent h-100">
                <img id="img-upload-two" data-original="img/banners/002.png?time=<?php echo date('H:i:s'); ?>" class="image" src="img/banners/002.png?time=<?php echo date('H:i:s'); ?>" alt="">
            </div>
        </section>

        <!-- Seccion de imagen -->
        <section class="image-box">
            <div class="image-header text-white text-right">
                <span class="image-title">Imagen #003 (1024x384)</span>
                <input type="file" id="upload-three" accept=".png" hidden />
                <label class="btn-upload-image" for="upload-three"><i class="fas fa-pen"></i>&nbsp;Cambiar</label>
            </div>
            <div class="bg-transparent h-100">
                <img id="img-upload-three" data-original="img/banners/003.png?time=<?php echo date('H:i:s'); ?>" class="image" src="img/banners/003.png?time=<?php echo date('H:i:s'); ?>" alt="">
            </div>
        </section>

        <!-- Seccion de imagen -->
        <section class="image-box">
            <div class="image-header text-white text-right">
                <span class="image-title">Imagen #004 (1024x384)</span>
                <input type="file" id="upload-four" accept=".png" hidden />
                <label class="btn-upload-image" for="upload-four"><i class="fas fa-pen"></i>&nbsp;Cambiar</label>
            </div>
            <div class="bg-transparent h-100">
                <img id="img-upload-four" data-original="img/banners/004.png?time=<?php echo date('H:i:s'); ?>" class="image" src="img/banners/004.png?time=<?php echo date('H:i:s'); ?>" alt="">
            </div>
        </section>
    </main>
    <!-- Seccion de botones -->
    <div class="d-flex justify-content-center">
        <button id="btn-update-banners" class="btn btn-primary btn-sm" disabled>Actualizar</button>
    </div>
    <!-- Seccion de pie de pagina -->
    <footer></footer>
    <!-- Scripts -->
    <script type="text/javascript" src="js/ajax/banners.js"></script>
</div>