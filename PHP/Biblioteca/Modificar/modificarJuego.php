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

$_SESSION["titulo"] = $result["titulo"];
$_SESSION["descripcion"] = $result["descripcion"];
$_SESSION["autor"] = $result["autor"];
$_SESSION["categoria"] = $result["categoria"];
$_SESSION["enlace"] = $result["enlace"];
$_SESSION["ano"] = $result["ano"] != 0 ? $result["ano"] : "";
$ruta = $result["caratula"];
$propietario = $result["propietario"];

$conn = null;
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Juego | LevelUp Library</title>
        <link rel="stylesheet" href="../../../CSS/style_Form_Juego.css">
        <link rel="stylesheet" href="../../../CSS/style_Header.css">
    </head>

    <body>
        <header>
            <a href="../Pagina.php">
                <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.336 2.253a1 1 0 0 1 1.328 0l9 8a1 1 0 0 1-1.328 1.494L20 11.45V19a2 2 0 0 1-2 2H6a2 2 0 0 
                    1-2-2v-7.55l-.336.297a1 1 0 0 1-1.328-1.494l9-8zM6 9.67V19h3v-5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 
                    1v5h3V9.671l-6-5.333-6 5.333zM13 19v-4h-2v4h2z" fill="#ffffffff"/>
                </svg>
            </a>
            <p class="welcome-user">Hola <?php echo $_SESSION["nombreLogin"]; ?>!</p>
            <a href="../Crear/nuevoJuego.php" class="btn-juego">Añadir Juego</a>
            <a href="../../LogOut.php" class="btn-logout">Cerrar Sesión</a>
        </header>

        <div id="caja">
            <h1>Editar Juego</h1>
            <div id="linea"></div>
            <?php echo (isset($_SESSION["err_Try"]) ? $_SESSION["err_Try"] : ""); $_SESSION["err_Try"] = ""; ?>

            <form action="modificarJuego_DB.php" method="post" enctype="multipart/form-data">
                <div class="campo">
                    <input type="text" name="titulo" placeholder="Titulo" maxlength="200" value="<?php echo (isset($_SESSION["titulo"]) ? $_SESSION["titulo"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Titulo"]) ? $_SESSION["err_Titulo"] : "") ?>
                </div>

                <div class="campo">
                    <textarea name="descripcion" placeholder="Descripción" maxlength="65535"><?php echo (isset($_SESSION["descripcion"]) ? $_SESSION["descripcion"] : "") ?></textarea>
                    <br/>
                </div>
                
                <div class="campo">
                    <input type="text" name="autor" placeholder="Autor" maxlength="100" value="<?php echo (isset($_SESSION["autor"]) ? $_SESSION["autor"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Autor"]) ? $_SESSION["err_Autor"] : "") ?>
                </div>

                <div class="campo">
                    <input type="file" name="caratula">
                    <br/>
                    <?php echo (isset($_SESSION["err_Caratula"]) ? $_SESSION["err_Caratula"] : "") ?>
                </div>

                <div class="campo">
                    <input type="text" name="categoria" placeholder="Categoria" maxlength="50" value="<?php echo (isset($_SESSION["categoria"]) ? $_SESSION["categoria"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Categoria"]) ? $_SESSION["err_Categoria"] : "") ?>
                </div>

                <div class="campo">
                    <input type="text" name="enlace" placeholder="Enlace" maxlength="500" value="<?php echo (isset($_SESSION["enlace"]) ? $_SESSION["enlace"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_enlace"]) ? $_SESSION["err_enlace"] : "") ?>
                </div>

                <div class="campo">
                    <input type="number" name="ano" placeholder="Año" min="1950" value="<?php echo (isset($_SESSION["ano"]) ? $_SESSION["ano"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Año"]) ? $_SESSION["err_ano"] : "") ?>
                </div>

                <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
                <input type="hidden" name="ruta" value="<?php echo $ruta; ?>">
                <input type="hidden" name="propietario" value="<?php echo $propietario; ?>">
                <input type="submit">
            </form>
        </div>
    </body>
</html>