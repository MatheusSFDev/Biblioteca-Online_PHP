<?php
session_start();
if (!isset($_SESSION["emailLogin"])) {
    header("Location: ../Login/Login.php");
    exit;
}

require '../Conexion_DB.php';
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
        <link rel="stylesheet" href="../../CSS/style_Juego.css">
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
            <a href="Perfil.php"><img src="<?php echo $_SESSION["fotoLogin"]; ?>" style="width:64px; border-radius:64px;"></a>
        </header>

        <div class="juego-detalle">
            <div class="juego-header">
                <h1><?php echo $result["titulo"]; ?></h1>
                <h2>Por <?php echo $result["autor"]; ?></h2>
            </div>

            <div class="juego-contenido">
                <div class="juego-info">
                    <h3>Descripción</h3>
                    <p class="descripcion"><?php echo $result["descripcion"]; ?></p>

                    <div class="juego-detalles">
                        <div class="detalle-item">
                            <span class="detalle-label">Categoría:</span>
                            <span class="detalle-valor"><?php echo $result["categoria"]; ?></span>
                        </div>

                        <?php if ($result["ano"] != 0): ?>
                        <div class="detalle-item">
                            <span class="detalle-label">Año:</span>
                            <span class="detalle-valor"><?php echo $result["ano"]; ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if ($result["enlace"] != ""): ?>
                        <div class="detalle-item">
                            <span class="detalle-label">Enlace:</span>
                            <span class="detalle-valor">
                                <a href="<?php echo $result["enlace"]; ?>" target="_blank">
                                    Visitar sitio web
                                </a>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="juego-caratula">
                    <h3>Carátula</h3>
                    <img src="<?php echo $result["caratula"]; ?>" alt="<?php echo $result["titulo"]; ?>" class="caratula-imagen">
                </div>
            </div>

            <?php if ($_SESSION["emailLogin"] === $result["propietario"]): ?>
            <div class="juego-acciones">
                <a href="Modificar/modificarJuego.php?id=<?php echo $result["id"]; ?>" class="btn-accion btn-editar">
                    ✏️ Editar Juego
                </a>
                <a href="Eliminar/eliminarJuego.php?id=<?php echo $result["id"]; ?>" class="btn-accion btn-eliminar">
                    🗑️ Eliminar
                </a>
            </div>
            <?php endif; ?>
        </div>
    </body>
</html>