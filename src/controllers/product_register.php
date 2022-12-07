<?php
include_once("src/internal/viewFunctions/form-error.php");
include_once("src/internal/db/mysql.php");

use chillerlan\QRCode\{QRCode, QROptions, Output\QROutputInterface};
use chillerlan\QRCode\Common\EccLevel;

// funcio que es fa servir per validar la data introduida per l'usuari
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

// comprovem si la sol·licitut es GET mostrem la pagina per generar un QR
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include("src/views/product_register.view.php");
}

// comprovem si la sol·licitut es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // comprovem si hi ha error amb algun camp introduit
    if (empty($_POST["name"]) || strlen($_POST["name"]) > 50) {
        $alertMessage = "Has d'introduir un nom (maxim 50 caracters).";
    }
    $viewData["name"] = $_POST["name"];

    if (empty($_POST["model"]) || strlen($_POST["model"]) > 50) {
        $alertMessage = "Has d'introduir un model (maxim 50 caracters).";
    }
    $viewData["model"] = $_POST["model"];

    if (empty($_POST["serial-number"]) || strlen($_POST["serial-number"]) > 50) {
        $alertMessage = "Has d'introduir un Numero de Serie (maxim 50 caracters).";
    }
    $viewData["serial-number"] = $_POST["serial-number"];

    if (empty($_POST["product-date"]) || !validateDate($_POST["product-date"])) {
        $alertMessage = "Has d'introduir una data valida.";
    }
    $viewData["product-date"] = $_POST["product-date"];

    if (empty($_POST["input"]) || strlen($_POST["input"]) > 20) {
        $alertMessage = "Has d'introduir un input (maxim 20 caracters).";
    }
    $viewData["input"] = $_POST["input"];

    if (empty($_POST["description"]) || strlen($_POST["description"]) > 250) {
        $alertMessage = "Has d'introduir una descripcio (maxim 250 caracters).";
    }
    $viewData["description"] = $_POST["description"];

    // en cas de tenir algun error, mostrem el missatge i retornem el formulari un altre cop
    if (isset($alertMessage)) {
        returnAlert($alertMessage, "danger", "src/views/product_register.view.php", $viewData);
    }

    // si no hi ha probelmes amb el formulari, comprovem si existeix el producte en la nostra base de dades
    $productExists = existProduct($viewData["serial-number"]);
    // si existeix actualitzem les dades, si no existeix, l'inserim
    if ($productExists) {
        $insert = updateProduct($viewData["name"], $viewData["model"], $viewData["serial-number"], $viewData["product-date"], $viewData["input"], $viewData["description"]);
    } else {
        $insert = addProduct($viewData["name"], $viewData["model"], $viewData["serial-number"], $viewData["product-date"], $viewData["input"], $viewData["description"]);
    }

    // si l'insercio ha resultat existosa, generem el qr, en cas contrari, informem d'un error
    if ($insert) {
        // afegim el text de control "mperalQr:" per poder verificar a l'hora de llegir, que el codi es nostre
        $qrData = "mperalQr:" . $viewData["serial-number"];

        // configurem les opcions del generador de QR.
        // versio 4, permet 50 caracters amb correcio H
        // ecc H, permet un 30% de reconstruccio
        $options = new QROptions([
            'version'    => 4,
            'eccLevel'   => EccLevel::H,
            // 'outputType' => QROutputInterface::GDIMAGE_GIF,
        ]);
        // generem el QR
        $qr =  '<img class="w-100" src="' . (new QRCode)->render($qrData) . '" alt="QR Code" />';
        // mostrem la vista per retornar el QR
        include_once("src/views/qr_gen.view.php");
    } else {
        returnAlert("S'ha produit un error a l'hora de guardar les dades. Torna a provar un altre cop.", "danger", "src/views/product_register.view.php", $viewData);
        echo "failed insert<br>";
    }
}
