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


// busca en la base de dades si existeix un producte amb un numero de serie demanat
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

// afegeix un producte a la base de dades, el cual ha sigut introduït en el formulari de "generar" QR
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

// actualitza un producte en base al seu numero de serie
function updateProduct(string $name, string $model, string $serialNumber, string $productDate, string $input, string $description): bool
{

    $mysqlPdo = getMysqlPDO();
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
}
// agafa la informacio del producte en base al numero de serie
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
