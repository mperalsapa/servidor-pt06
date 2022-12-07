<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once("src/internal/viewFunctions/header.php"); ?>
    <title>Dades del producte</title>
</head>

<body class="m-0 p-0 bg-dark" style="background-color:#212529">
    <?php
    include_once("src/internal/viewFunctions/navbar.php");
    ?>
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="bg-white rounded col-10 col-md-8 col-lg-6 col-xxl-4 mb-4">
            <div class="align-middle m-4" action="generate" method="POST">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Inici</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dades del Producte</li>
                    </ol>
                </nav>

                <div class="border  rounded-md d-flex flex-column px-3">

                    <p class="fs-4 mt-3">
                        Nom
                    </p>
                    <div class=" border round-md p-3">
                        <?= $viewData["nom"] ?>
                    </div>
                    <hr class="hr" />
                    <p class="fs-4 ">
                        Model
                    </p>
                    <div class=" border round-md p-3">
                        <?= $viewData["model"] ?>
                    </div>
                    <hr class="hr" />
                    <p class="fs-4 ">
                        Numero de Serie
                    </p>
                    <div class=" border round-md p-3">
                        <?= $viewData["sn"] ?>
                    </div>
                    <hr class="hr" />
                    <p class="fs-4 ">
                        Data
                    </p>
                    <div class=" border round-md p-3">
                        <?= $viewData["data"] ?>
                    </div>
                    <hr class="hr" />
                    <p class="fs-4 ">
                        Input
                    </p>
                    <div class=" border round-md p-3">
                        <?= $viewData["input"] ?>
                    </div>
                    <hr class="hr" />
                    <p class="fs-4 ">
                        Descripcio
                    </p>
                    <div class=" border round-md p-3 mb-3">
                        <?= $viewData["descripcio"] ?>
                    </div>

                </div>

                <?php

                if (!empty($alertMessage)) {
                    echo "<div class=\"mt-3 d-flex justify-content align-items-center alert alert-$alertType alert-dismissible\" role=\"alert\"><span class=\"me-3\">$alertIcon</span> $alertMessage <button type=\"button\" class=\"btn-close\" aria-label=\"Close\" data-bs-dismiss=\"alert\" ></button></div>";
                }
                ?>
            </div>
        </div>

    </div>

    <?php include_once("src/internal/viewFunctions/body-end.php"); ?>
</body>

</html>