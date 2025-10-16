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

if (!isset($_SESSION["titulo_ModificarJuego"])) $_SESSION["titulo_ModificarJuego"] = $result["titulo"];
if (!isset($_SESSION["descripcion_ModificarJuego"])) $_SESSION["descripcion_ModificarJuego"] = $result["descripcion"];
if (!isset($_SESSION["autor_ModificarJuego"])) $_SESSION["autor_ModificarJuego"] = $result["autor"];
if (!isset($_SESSION["categoria_ModificarJuego"])) $_SESSION["categoria_ModificarJuego"] = $result["categoria"];
if (!isset($_SESSION["enlace_ModificarJuego"])) $_SESSION["enlace_ModificarJuego"] = $result["enlace"];
if (!isset($_SESSION["ano_ModificarJuego"])) $_SESSION["ano_ModificarJuego"] = $result["ano"] != 0 ? $result["ano"] : "";
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
            <a href="../Perfil.php"><img src="<?php echo "../" . $_SESSION["fotoLogin"]; ?>" style="width:64px; border-radius:64px;"></a>
        </header>

        <div id="caja">
            <h1>Editar Juego</h1>
            <div id="linea"></div>
            <?php echo (isset($_SESSION["err_Try_ModificarJuego"]) ? $_SESSION["err_Try_ModificarJuego"] : ""); $_SESSION["err_Try_ModificarJuego"] = ""; ?>

            <form action="modificarJuego_DB.php" method="post" enctype="multipart/form-data">
                <div class="campo">
                    <input type="text" name="titulo" placeholder="Titulo" maxlength="200" value="<?php echo (isset($_SESSION["titulo_ModificarJuego"]) ? $_SESSION["titulo_ModificarJuego"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Titulo_ModificarJuego"]) ? $_SESSION["err_Titulo_ModificarJuego"] : "") ?>
                </div>

                <div class="campo">
                    <textarea name="descripcion" placeholder="Descripción" maxlength="65535"><?php echo (isset($_SESSION["descripcion_ModificarJuego"]) ? $_SESSION["descripcion_ModificarJuego"] : "") ?></textarea>
                    <br/>
                </div>
                
                <div class="campo">
                    <input type="text" name="autor" placeholder="Autor" maxlength="100" value="<?php echo (isset($_SESSION["autor_ModificarJuego"]) ? $_SESSION["autor_ModificarJuego"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Autor_ModificarJuego"]) ? $_SESSION["err_Autor_ModificarJuego"] : "") ?>
                </div>

                <div class="campo">
                    <input type="file" name="caratula">
                    <br/>
                    <?php echo (isset($_SESSION["err_Caratula_ModificarJuego"]) ? $_SESSION["err_Caratula_ModificarJuego"] : "") ?>
                </div>

                <div class="campo">
                    <input type="text" name="categoria" placeholder="Categoria" maxlength="50" value="<?php echo (isset($_SESSION["categoria_ModificarJuego"]) ? $_SESSION["categoria_ModificarJuego"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Categoria_ModificarJuego"]) ? $_SESSION["err_Categoria_ModificarJuego"] : "") ?>
                </div>

                <div class="campo">
                    <input type="text" name="enlace" placeholder="Enlace" maxlength="500" value="<?php echo (isset($_SESSION["enlace_ModificarJuego"]) ? $_SESSION["enlace_ModificarJuego"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_enlace_ModificarJuego"]) ? $_SESSION["err_enlace_ModificarJuego"] : "") ?>
                </div>

                <div class="campo">
                    <input type="number" name="ano" placeholder="Año" min="1950" value="<?php echo (isset($_SESSION["ano_ModificarJuego"]) ? $_SESSION["ano_ModificarJuego"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Año"]) ? $_SESSION["err_ano_ModificarJuego"] : "") ?>
                </div>

                <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
                <input type="hidden" name="ruta" value="<?php echo $ruta; ?>">
                <input type="hidden" name="propietario" value="<?php echo $propietario; ?>">
                <input type="submit">
            </form>
        </div>
    </body>
</html>

<?php
unset($_SESSION["titulo_ModificarJuego"]);
unset($_SESSION["descripcion_ModificarJuego"]);
unset($_SESSION["autor_ModificarJuego"]);
unset($_SESSION["categoria_ModificarJuego"]);
unset($_SESSION["enlace_ModificarJuego"]);
unset($_SESSION["ano_ModificarJuego"]);
?>