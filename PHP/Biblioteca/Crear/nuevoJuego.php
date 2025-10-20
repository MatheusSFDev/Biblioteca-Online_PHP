<?php
session_start();
if (!isset($_SESSION["emailLogin"])) {
    header("Location: ../../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Añadir Juego | LevelUp Library</title>
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
            <a href="nuevoJuego.php" class="btn-juego">Añadir Juego</a>
            <a href="../Perfil.php"><img src="<?php echo "../" . $_SESSION["fotoLogin"]; ?>" style="width:64px; border-radius:64px;"></a>
        </header>

        <div id="caja">
            <h1>Añadir Nuevo Juego</h1>
            <div id="linea"></div>
            <?php echo (isset($_SESSION["err"]) ? $_SESSION["err"] : ""); $_SESSION["err"] = ""; ?>

            <form action="nuevoJuego_DB.php" method="post" enctype="multipart/form-data">
                <div class="campo">
                    <input type="text" name="titulo" placeholder="Titulo" maxlength="200" value="<?php echo (isset($_SESSION["titulo"]) ? $_SESSION["titulo"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_titulo"]) ? $_SESSION["err_titulo"] : "") ?>
                </div>

                <div class="campo">
                    <textarea name="descripcion" placeholder="Descripción" maxlength="65535"><?php echo (isset($_SESSION["descripcion"]) ? $_SESSION["descripcion"] : "") ?></textarea>
                    <br/>
                </div>
                
                <div class="campo">
                    <input type="text" name="autor" placeholder="Autor" maxlength="100" value="<?php echo (isset($_SESSION["autor"]) ? $_SESSION["autor"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_autor"]) ? $_SESSION["err_autor"] : "") ?>
                </div>

                <div class="campo">
                    <input type="file" name="caratula">
                    <br/>
                    <?php echo (isset($_SESSION["err_caratula"]) ? $_SESSION["err_caratula"] : "") ?>
                </div>

                <div class="campo">
                    <input type="text" name="categoria" placeholder="Categoria" maxlength="50" value="<?php echo (isset($_SESSION["categoria"]) ? $_SESSION["categoria"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_categoria"]) ? $_SESSION["err_categoria"] : "") ?>
                </div>

                <div class="campo">
                    <input type="text" name="enlace" placeholder="Enlace" maxlength="500" value="<?php echo (isset($_SESSION["enlace"]) ? $_SESSION["enlace"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_enlace"]) ? $_SESSION["err_enlace"] : "") ?>
                </div>

                <div class="campo">
                    <input type="number" name="ano" placeholder="Año" min="1950" value="<?php echo (isset($_SESSION["ano"]) ? $_SESSION["ano"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_ano"]) ? $_SESSION["err_ano"] : "") ?>
                </div>

                <input type="submit">
            </form>
        </div>
    </body>
</html>

<?php
unset($_SESSION["err"]);
unset($_SESSION["titulo"]);
unset($_SESSION["err_titulo"]);
unset($_SESSION["descripcion"]);
unset($_SESSION["autor"]);
unset($_SESSION["err_autor"]);
unset($_SESSION["err_caratula"]);
unset($_SESSION["categoria"]);
unset($_SESSION["err_categoria"]);
unset($_SESSION["enlace"]);
unset($_SESSION["err_enlace"]);
unset($_SESSION["ano"]);
unset($_SESSION["err_ano"]);
?>