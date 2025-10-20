<?php
require '../Conexion_DB.php';

try {
    $sentencia = $conn->prepare("SELECT voto FROM votos WHERE id = :id and email like(:email)");
    $sentencia->bindParam(":id", $_GET["id"]);
    $sentencia->bindParam(":email", $_SESSION["emailLogin"]);
    $sentencia->execute();

    $resultVoto = $sentencia->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo $ex;
}
?>