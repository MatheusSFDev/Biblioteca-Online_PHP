<?php 
$id = $_GET["id"];

try {
    $sentencia = $conn->prepare("UPDATE juegos SET visualizaciones = visualizaciones + 1 WHERE id = :id");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();

    $conn = null;
} catch (PDOException $ex) {
    $conn = null;
}
?>