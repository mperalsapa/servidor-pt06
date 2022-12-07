<?php
include_once("src/internal/viewFunctions/form-error.php");
include_once("src/internal/db/mysql.php");

use chillerlan\QRCode\{QRCode, QROptions};

// redimensiona una imatge amb el maxim que se l'indica, mantenint la relacio d'aspecte
// funcio copiada de internet :P
function image_resize($file_name, $width, $height, $crop = FALSE)
{
    list($wid, $ht) = getimagesize($file_name);
    $r = $wid / $ht;
    if ($crop) {
        if ($wid > $ht) {
            $wid = ceil($wid - ($width * abs($r - $width / $height)));
        } else {
            $ht = ceil($ht - ($ht * abs($r - $width / $height)));
        }
        $new_width = $width;
        $new_height = $height;
    } else {
        if ($width / $height > $r) {
            $new_width = $height * $r;
            $new_height = $height;
        } else {
            $new_height = $width / $r;
            $new_width = $width;
        }
    }
    $source = imagecreatefromjpeg($file_name);
    $dst = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($dst, $source, 0, 0, 0, 0, $new_width, $new_height, $wid, $ht);
    return $dst;
}

function resizeImage(): bool
{
    // redimensionem la imatge, ja que si es massa gran, el servidor demana massa recursos o no funciona be el lector
    $fileName = $_FILES['imageFile']["name"];
    $img_to_resize = image_resize($_FILES['imageFile']["tmp_name"], 1000, 1000);

    // si no existeix el directory temp i no el podem crear, retornem false, ja que no podem fer res
    if (!file_exists("./temp/") && !mkdir("./temp/")) {
        return false;
    }

    // si tenim directori on guardar, guardem la imatge
    imagepng($img_to_resize, "./temp/" . $fileName);

    // comprovem que la imatge s'ha guardat correctament
    if (file_exists("./temp/" . $fileName)) {
        return true;
    } else {
        return false;
    }
}

function deleteImage($fileName)
{
    // esborrem la imatge si existeix
    if (file_exists("./temp/" . $fileName)) {
        unlink("./temp/" . $fileName);
    }
}

// comprovem si la sol·licitut es GET mostrem la pagina per pujar la imatge
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include("src/views/scan_product.view.php");
}

// comprovem si la sol·licitut es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // comprovacions basiques de que el contingut del post es de la nostra pagina, es una imatge, i que no hi ha error
    if (isset($_POST["submit"]) && $_FILES["imageFile"]["size"] != 0 && $_FILES["imageFile"]["error"] == 0) {
        $checkImg = getimagesize($_FILES["imageFile"]["tmp_name"]);
        $checkSvg = 'image/svg+xml' === mime_content_type($_FILES["imageFile"]["tmp_name"]);
        if ($checkImg == false && $checkSvg == false) {
            returnAlert("El fixter que s'ha introduit no es una imatge.", "danger", "src/views/scan_product.view.php", null);
        }
    } else {
        returnAlert("S'ha produit un error carregant la imatge. Torna a provar. Si el problema persisteix contacta amb un administrador.", "danger", "src/views/scan_product.view.php", null);
    }

    try {
        // configurem les opcions del lector de QR
        $options = new QROptions;
        $options->readerUseImagickIfAvailable = false;
        $options->readerGrayscale = true;
        $options->readerIncreaseContrast = true;

        // intentem redimensionar la imatge que s'ha pujat
        if (!resizeImage()) {
            returnAlert("S'ha produit un error intern. Si el problema persisteix, contacta amb un administrador.", "danger", "src/views/scan_product.view.php", null);
        }

        // llegim el contingut del codi qr
        $result = (new QRCode($options))->readFromFile("./temp/" . $_FILES['imageFile']["name"]);
        $content = $result->data;

        // comprovem si el qr pertany a la nostra aplicacio
        if (strpos($content, "mperalQr:") !== false) {
            // si tenim el string de control, l'esborrem del contingut
            $serialNumber = str_replace("mperalQr:", "", $content);
            $viewData = getProduct($serialNumber);
            // esborrem el fitxer de la carpeta temporal
            deleteImage($_FILES['imageFile']["name"]);
            // mostrem la vista de les dades del producte
            include_once("src/views/product_data.view.php");
        } else {
            // en cas de no contenir el string de control "mperalQr:", informem a l'usuari que s'ha produit un problema
            deleteImage($_FILES['imageFile']["name"]);
            returnAlert("S'ha produit un error a l'hora de llegir el codi, pot ser el codi esta corrupte o no es compatible amb aquesta aplicacio. Torna a provar un altre cop.", "danger", "src/views/scan_product.view.php", null);
        }
    } catch (Throwable $e) {
        deleteImage($_FILES['imageFile']["name"]);

        // es molt ptobable que el error es degui a que s'ha fet la foto massa prop.
        returnAlert("S'ha produit un error a l'hora de llegir el codi, pot ser el codi esta corrupte o la imatge no es prou clara. Torna a provar un altre cop allunyant la camara.", "danger", "src/views/scan_product.view.php", null);
        include_once("src/views/scan_product.view.php");
        echo $e->getMessage();
    }
}
