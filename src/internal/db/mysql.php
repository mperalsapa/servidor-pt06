<?php
// Marc Peral 2DAW

// aquesta funcio s'encarrega de connectar amb la base de dades
// si es produeix un error, indiquem a l'usuari que s'ha produit un error i que contacti amb l'administrador
function getMysqlPDO(): PDO
{
    include("env.php");
    $servername = $mysqlHost;
    $username = $mysqlUser;
    $password = $mysqlPassword;
    $dbname = $mysqlDB;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        echo "<p>S'ha produit un error a l'hora de connectarse amb la base de dades. Contacta amb un administrador.</p>";
        echo "<p>Error: $e</p>";
        die();
    }

    return $conn;
}


function existProduct(string $serialNumber): bool
{
    $mysqlPdo = getMysqlPDO();
    $pdo = $mysqlPdo->prepare('SELECT id FROM producte WHERE sn = :serialNumber');
    $pdo->bindParam(":serialNumber", $serialNumber);
    $pdo->execute();

    if ($pdo->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}


function addProduct(string $name, string $model, string $serialNumber, string $productDate, string $input, string $description): bool
{
    $mysqlPdo = getMysqlPDO();
    $pdo = $mysqlPdo->prepare('INSERT INTO producte (nom, model, sn, data, input, descripcio) VALUES (:name, :model, :serialNumber, :productDate, :input, :description)');
    $pdo->bindParam(":name", $name);
    $pdo->bindParam(":model", $model);
    $pdo->bindParam(":serialNumber", $serialNumber);
    $pdo->bindParam(":productDate", $productDate);
    $pdo->bindParam(":input", $input);
    $pdo->bindParam(":description", $description);

    $pdo->execute();

    if ($pdo->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function updateProduct(string $name, string $model, string $serialNumber, string $productDate, string $input, string $description): bool
{

    $mysqlPdo = getMysqlPDO();
    // $pdo = $mysqlPdo->prepare('INSERT INTO producte (nom, model, sn, data, input, descripcio) VALUES (:name, :model, :serialNumber, :productDate, :input, :description)');
    $pdo = $mysqlPdo->prepare('UPDATE producte SET nom = :name, model = :model, data = :productDate, input = :input, descripcio = :description WHERE producte.sn = :serialNumber');
    $pdo->bindParam(":name", $name);
    $pdo->bindParam(":model", $model);
    $pdo->bindParam(":serialNumber", $serialNumber);
    $pdo->bindParam(":productDate", $productDate);
    $pdo->bindParam(":input", $input);
    $pdo->bindParam(":description", $description);

    $pdo->execute();

    if ($pdo->rowCount() > 0) {
        return true;
    } else {
        return false;
    }

    // return true;
}

function getProduct(string $serialNumber): Mixed
{
    $mysqlPdo = getMysqlPDO();
    $pdo = $mysqlPdo->prepare('SELECT nom, model, sn, data, input, descripcio FROM producte WHERE sn = :serialNumber');
    $pdo->bindParam(":serialNumber", $serialNumber);
    $pdo->execute();

    if ($pdo->rowCount() > 0) {
        $row = $pdo->fetch();
        return $row;
    } else {
        return null;
    }
}
