<?php
session_start();
if (!isset($_SESSION["emailLogin"])) {
    header("Location: ../Login/Login.php");
    exit;
}

require 'leerJuegos_DB.php';
if ($result === false) {
    header("Location: Pagina.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Juego | LevelUp Library</title>
        <link rel="stylesheet" href="../../CSS/style_Header.css">
    </head>

    <body>
        <header>
            <a href="Pagina.php">
                <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.336 2.253a1 1 0 0 1 1.328 0l9 8a1 1 0 0 1-1.328 1.494L20 11.45V19a2 2 0 0 1-2 2H6a2 2 0 0 
                    1-2-2v-7.55l-.336.297a1 1 0 0 1-1.328-1.494l9-8zM6 9.67V19h3v-5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 
                    1v5h3V9.671l-6-5.333-6 5.333zM13 19v-4h-2v4h2z" fill="#ffffffff"/>
                </svg>
            </a>
            <p class="welcome-user">Hola <?php echo $_SESSION["nombreLogin"]; ?>!</p>
            <a href="Crear/nuevoJuego.php" class="btn-juego">Añadir Juego</a>
            <a href="../LogOut.php" class="btn-logout">Cerrar Sesión</a>
        </header>

        <h1> <?php echo $result["titulo"]; ?> </h1>
        <h2> <?php echo $result["autor"]; ?> </h2>

        <p> <?php echo $result["descripcion"]; ?> </p>
        
        <p> <?php echo $result["categoria"]; ?> </p>
        <p> <?php echo $result["ano"]; ?> </p>

        <a href="<?php echo $result["enlace"]; ?>"> <?php echo $result["enlace"]; ?> </a>

        <br>
        <img src="<?php echo $result["caratula"]; ?>">

        <br>

        <?php
        if ($_SESSION["emailLogin"] === $result["propietario"]) {
            echo "<a href=\"Modificar/modificarJuego.php?id=" . $result["id"] . "\">Editar</a>";
            echo "<br>";
            echo "<a href=\"Eliminar/eliminarJuego.php?id=" . $result["id"] . "\">BORRAR</a>";
        }
        ?>
    </body>
</html>