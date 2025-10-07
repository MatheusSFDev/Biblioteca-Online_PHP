<?php
session_start();
if (!isset($_SESSION["emailLogin"])) {
    header("Location: ../../Login/Login.php");
    exit;
}

require '../../Conexion_DB.php';
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
        <link rel="stylesheet" href="../../../CSS/style_Eliminar_Juego.css">
    </head>

    <body>
        <div class="eliminar-container">
            <div class="icono-advertencia"></div>
            <h1>¿Estás Seguro?</h1>
            <div class="linea-divisor"></div>
            
            <p class="eliminar-mensaje">
                Esta acción <strong>no se puede deshacer</strong>. 
                El juego será eliminado permanentemente de la biblioteca.
            </p>

            <div class="advertencia-texto">
                <p>⚠️ Se eliminarán todos los datos asociados a este juego.</p>
            </div>

            <div class="botones-accion">
                <a href="../Juego.php?id=<?php echo $_GET["id"]; ?>" class="btn btn-cancelar">
                    ← Cancelar
                </a>
                <a href="eliminarJuego_DB.php?id=<?php echo $_GET["id"]; ?>" class="btn btn-confirmar">
                    🗑️ Confirmar Eliminación
                </a>
            </div>
        </div>
    </body>
</html>