<?php
require '../Conexion_DB.php';

try {
    $sentencia = $conn->prepare("SELECT sum(visualizaciones) AS 'Views' FROM juegos GROUP BY propietario HAVING propietario LIKE(:email)");
    $sentencia->bindParam(":email", $_SESSION["emailLogin"]);
    $sentencia->execute();

    $result = $sentencia->fetch(PDO::FETCH_ASSOC);

    $viewsTotales = ($result !== false) ? $result["Views"] : 0;
    $conn = null;
} catch (PDOException $ex) {
    $conn = null;
}
?>