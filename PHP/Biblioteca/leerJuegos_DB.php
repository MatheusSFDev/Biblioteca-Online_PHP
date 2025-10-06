<?php 
require '../Conexion_DB.php';

if (isset($_GET["id"])) {
    try {
        $sentencia = $conn->prepare("SELECT * FROM juegos WHERE id like(:id)");
        $sentencia->bindParam(":id", $_GET["id"]);
        $sentencia->execute();

        $result = $sentencia->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo "Operación Fallida";
    }
} else {
    try {
        $sentencia = $conn->prepare("SELECT id, titulo, descripcion, autor, caratula, categoria, enlace, ano FROM juegos");
        $sentencia->execute();

        $result = $sentencia->fetchAll();
    } catch (PDOException $ex) {
        echo "Operación Fallida";
    }
}

?>