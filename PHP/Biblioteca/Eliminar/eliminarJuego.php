<?php
session_start();
if (!isset($_SESSION["emailLogin"])) {
    header("Location: ../../Login/Login.php");
    exit;
}

require '../leerJuegos_DB.php';
if ($result === false) {
    header("Location: ../Pagina.php");
    exit;
}
if ($_SESSION["emailLogin"] !== $result["propietario"]) {
    header("Location: ../Pagina.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar | LevelUp Library</title>
</head>
<body>
    Estas Seguro de Borrarlo?
    <?php
    echo "<a href=\"../Juego.php?id=" . $_GET["id"] . "\">Cancelar</a>";
    echo "<a href=\"eliminarJuego_DB.php?id=" . $_GET["id"] . "\">BORRAR</a>";
    ?>
</body>
</html>