<?php
require '../../Conexion_DB.php';

try {
    $sentencia = $conn->prepare("SELECT titulo, visualizaciones FROM juegos WHERE propietario LIKE(:email) ORDER BY visualizaciones DESC LIMIT 3");
    $sentencia->bindParam(":email", $_SESSION["emailLogin"]);
    $sentencia->execute();

    $resultTop = $sentencia->fetchAll();

    $conn = null;
} catch (PDOException $ex) {
    $conn = null;
}
?>