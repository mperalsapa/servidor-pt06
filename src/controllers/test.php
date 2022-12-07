<?php
include_once("src/internal/viewFunctions/form-error.php");
include_once("src/internal/db/mysql.php");

// use chillerlan\QRCode\QRCode;

// $qrData = "serial-number";
// quick and simple:
// $qr =  '<img class="w-100" src="' . (new QRCode)->render($qrData) . '" alt="QR Code" />';

$viewData = getProduct("samsung-stv554k");

include_once("src/views/product_data.view.php");
