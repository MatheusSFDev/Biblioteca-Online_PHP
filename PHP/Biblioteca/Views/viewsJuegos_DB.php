<?php
require '../Conexion_DB.php';

try {
    $sentencia = $conn->prepare("SELECT titulo, visualizaciones FROM juegos WHERE propietario LIKE(:email) ORDER BY visualizaciones DESC");
    $sentencia->bindParam(":email", $_SESSION["emailLogin"]);
    $sentencia->execute();

    $resultTodos = $sentencia->fetchAll();

    $conn = null;
} catch (PDOException $ex) {
    $conn = null;
}
?>