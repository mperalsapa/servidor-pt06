<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once("src/internal/viewFunctions/header.php"); ?>
    <title>Registrar producte</title>
</head>

<body class="m-0 p-0 bg-dark" style="background-color:#212529">
    <?php
    include_once("src/internal/viewFunctions/navbar.php");
    ?>
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="bg-white rounded col-10 col-md-8 col-lg-6 col-xxl-4 mb-4">
            <form class="align-middle m-4" action="generate" method="POST">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Inici</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Generar</li>
                    </ol>
                </nav>
                <div class="row">
                    <label>Nom
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo isset($viewData["name"]) ? $viewData["name"] : '' ?>">
                    </label>
                </div>
                <div class="row mt-2">
                    <label>Model
                        <input type="text" class="form-control" id="model" name="model" placeholder="Model" value="<?php echo isset($viewData["model"]) ? $viewData["model"] : '' ?>">
                    </label>
                </div>

                <div class="row mt-2">
                    <label>SN
                        <input type="text" class="form-control" id="serial-number" name="serial-number" placeholder="Numero de serie" value="<?php echo isset($viewData["serial-number"]) ? $viewData["serial-number"] : '' ?>">
                    </label>
                </div>
                <div class="row mt-2">
                    <label>Data
                        <input class="form-control" name="product-date" id="product-date" type="date" value="<?php echo isset($viewData["product-date"]) ? $viewData["product-date"] : '' ?>">
                    </label>
                </div>
                <div class="row mt-2">
                    <label>Input
                        <input type="text" class="form-control" id="input" name="input" placeholder="Input" value="<?php echo isset($viewData["input"]) ? $viewData["input"] : '' ?>">
                    </label>
                </div>
                <div class="row mt-2 ">
                    <label>Descripcio
                        <textarea class="form-control" name="description" id="description" rows="10" placeholder="Descripcio"><?php echo isset($viewData["description"]) ? $viewData["description"] : '' ?></textarea>
                    </label>
                </div>
                <?php
                if (!empty($alertMessage)) {
                    echo "<div class=\"mt-3 d-flex justify-content align-items-center alert alert-$alertType alert-dismissible\" role=\"alert\"><span class=\"me-3\">$alertIcon</span> $alertMessage <button type=\"button\" class=\"btn-close\" aria-label=\"Close\" data-bs-dismiss=\"alert\" ></button></div>";
                }
                ?>
                <button type="submit" class="btn btn-primary col-12 mt-3"><i class="bi bi-pen"></i> Registrar</button>
            </form>
        </div>

    </div>

    <?php include_once("src/internal/viewFunctions/body-end.php"); ?>
</body>

</html>