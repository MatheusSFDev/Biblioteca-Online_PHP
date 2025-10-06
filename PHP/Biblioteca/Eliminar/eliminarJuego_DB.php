<?php
session_start();
require '../leerJuegos_DB.php';
require '../../Conexion_DB.php';

if ($result === false) {
    header("Location: ../Pagina.php");
    exit;
}
if ($_SESSION["emailLogin"] !== $result["propietario"]) {
    header("Location: ../Pagina.php");
    exit;
}

$id = $_GET["id"];

try {
    $sentencia = $conn->prepare("DELETE FROM juegos WHERE id like(:id)");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
} catch (PDOException $ex) {
    echo "Operación Fallida";
}

header("Location: ../Pagina.php");
exit;
?>