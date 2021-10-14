// Variables de gestion de estudiante

// Boton de actualizacion de banners
let btnUpdateBanners;

// Inputs files de cada banners
let inputFileOne, inputFileTwo, inputFileThree, inputFileFour;

// Estados de cambio de cada uno de los banners
let isChangedFileOne = false,
    isChangedFileTwo = false,
    isChangedFileThree = false,
    isChangedFileFour = false;

/**
 * Metodo inicializacion de comportamiento
 */
function init() {
    /*
     *    1. Inicializacion de variables.
     */
    btnUpdateBanners = $('#btn-update-banners');
    inputFileOne = $('#upload-one');
    inputFileTwo = $('#upload-two');
    inputFileThree = $('#upload-three');
    inputFileFour = $('#upload-four');

    /*
     *    2. Comportamiento de componentes.
     */

    /*
     *    3. Eventos de componentes.
     */
    btnUpdateBanners.on('click', btnUpdateBannersEventClick);
    inputFileChangeEvent(inputFileOne);
    inputFileChangeEvent(inputFileTwo);
    inputFileChangeEvent(inputFileThree);
    inputFileChangeEvent(inputFileFour);
}

/**
 * Metodo que desencadena el evento click del 
 * boton btnUpdateBanners
 * @param {*} evt 
 */
function btnUpdateBannersEventClick(evt) {
    let fd = new FormData();
    if (isChangedFileOne) fd.append('banner_one', inputFileOne[0].files[0]);
    if (isChangedFileTwo) fd.append('banner_two', inputFileTwo[0].files[0]);
    if (isChangedFileThree) fd.append('banner_three', inputFileThree[0].files[0]);
    if (isChangedFileFour) fd.append('banner_four', inputFileFour[0].files[0]);

    $.ajax({
        type: 'POST',
        url: "Ajax/BannersAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(data) {
            if (data.state == 0) alert(data.message);
            if (data.state == 1) {
                alert(data.message);
                location.reload();
            }
            if (data.state == 2) alert(data.message);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + '\r\n' +
                xhr.statusText + '\r\n' +
                xhr.responseText + '\r\n' +
                ajaxOptions);
        }
    });
}

function inputFileChangeEvent(element) {
    element.on('change', (evt) => {
        switch (element.attr('id')) {
            case 'upload-one':
                setImageBanner(element, $('#img-upload-one'));
                isChangedFileOne = true;
                break;
            case 'upload-two':
                setImageBanner(element, $('#img-upload-two'));
                isChangedFileTwo = true;
                break;
            case 'upload-three':
                setImageBanner(element, $('#img-upload-three'));
                isChangedFileThree = true;
                break;
            case 'upload-four':
                setImageBanner(element, $('#img-upload-four'));
                isChangedFileFour = true;
                break;
            default:
                break;
        }
        btnUpdateBanners.attr({ disabled: false });
    });
}

/**
 * Metodo que establece la imagen del banner para cada etiqueta img
 * @param {*} input Elemento <input /> Input File 
 * @param {*} img Elemento <img /> Img tag
 */
function setImageBanner(input, img) {
    const fileReader = new FileReader();
    const files = input[0].files[0];

    fileReader.onload = (evt) => {
        let myPromise = new Promise((resolve, reject) => {
            const image = new Image();

            image.onload = (evt) => {
                resolve({ width: image.width, height: image.height });
            }

            image.onerror = (evt) => {
                reject('Ha ocurrido algún problema con la imagen');
            }

            image.src = fileReader.result;
        });

        myPromise.then((dimensions) => {
            if (dimensions.width == 1024 && dimensions.height == 384) {
                img.attr({
                    src: evt.target.result,
                    "data-original": evt.target.result
                });
            } else {
                alert(`Dimensiones del banner deben ser: 1024x384 pixeles`);
            }
        });
    }
    try { fileReader.readAsDataURL(files); } catch (error) {}
}

/**
 * Eventos cuando la aplicacion inicia.
 */

/**
 * Arranque del codigo
 */
$(document).ready(init);