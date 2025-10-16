<?php
$fragmento = $_GET["b"];
$todos = [];
$buscados = [];

require '../Conexion_DB.php';
require 'leerJuegos_DB.php';

foreach ($result as $juego) {
    $todos[] = $juego["id"];
}

try {
    $sentencia = $conn->prepare("SELECT id FROM juegos WHERE titulo LIKE(:fragmento)");
    $sentencia->bindParam(":fragmento", $fragmento);
    $sentencia->execute();

    $result = $sentencia->fetchAll();
} catch (PDOException $ex) {
    echo "Operación Fallida";
}

foreach ($result as $juego) {
    $buscados[] = $juego["id"];
}

$res = array(
    "todos" => $todos,
    "buscados" => $buscados
);

echo json_encode($res);
?>