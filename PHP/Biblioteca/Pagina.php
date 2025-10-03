<?php
session_start(); 
if (!isset($_SESSION["nombreLogin"])) {
    header("Location: ../Login/Login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Bienvenido</title>
        <link rel="stylesheet" href="../../CSS/style_Pagina.css">
    </head>

    <body>
        <div class="dashboard-container">
            <div class="main-content">
                <div class="welcome-card">
                    <h1 class="welcome-title">¡Bienvenido!</h1>
                    <p class="welcome-subtitle">Has iniciado sesión exitosamente</p>
                    <p class="welcome-user"><?php echo $_SESSION["nombreLogin"]; ?></p>
                    <p class="welcome-message">
                        Gracias por usar nuestra plataforma. Aquí podrás acceder a todas las funcionalidades disponibles.
                    </p>
                    <a href="../LogOut.php" class="btn-logout">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </body>
</html>