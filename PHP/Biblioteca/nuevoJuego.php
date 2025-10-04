<?php
session_start();
if (!isset($_SESSION["emailLogin"])) {
    header("Location: ../Login/Login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Añadir Juego | LevelUp Library</title>
        <link rel="stylesheet" href="../../CSS/style_Form_Juego.css">
    </head>

    <body>
        <div id="caja">
            <h1>Añadir Nuevo Juego</h1>
            <div id="linea"></div>
            <?php echo (isset($_SESSION["err_Try"]) ? $_SESSION["err_Try"] : ""); $_SESSION["err_Try"] = ""; ?>

            <form action="nuevoJuego_DB.php" method="post" enctype="multipart/form-data">
                <div class="campo">
                    <input type="text" name="titulo" placeholder="Titulo" maxlength="200" value="<?php echo (isset($_SESSION["titulo"]) ? $_SESSION["titulo"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Titulo"]) ? $_SESSION["err_Titulo"] : "") ?>
                </div>

                <div class="campo">
                    <input type="text" name="descripcion" placeholder="Descripción" maxlength="65535" value="<?php echo (isset($_SESSION["descripcion"]) ? $_SESSION["descripcion"] : "") ?>">
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

                <input type="submit">
            </form>
        </div>
    </body>
</html>