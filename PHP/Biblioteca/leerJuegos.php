<?php 
require '../Conexion_DB.php';

try {
    $sentencia = $conn->prepare("SELECT id, titulo, descripcion, autor, caratula, categoria, enlace, ano FROM juegos");
    $sentencia->execute();

    $result = $sentencia->fetchAll();
} catch (PDOException $ex) {
    echo "Operación Fallida";
}

?>