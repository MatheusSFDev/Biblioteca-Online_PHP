<?php
session_start();
if (!isset($_SESSION["emailLogin"])) {
    header("Location: ../../Login/Login.php");
    exit;
}

if (!isset($_SESSION["nombre"])) $_SESSION["nombre"] = $_SESSION["nombreLogin"];

$style1 = "display: block;";
$style2 = "display: none;";

if (isset($_GET["tipo"])) {
    if ($_GET["tipo"] == "2") {
        $style1 = "display: none;";
        $style2 = "display: block;";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Perfil | LevelUp Library</title>
        <link rel="stylesheet" href="../../../CSS/style_Header.css">
        <link rel="stylesheet" href="../../../CSS/style_Form_Registro_Login.css">
        
        <script>
            function switchCajaPasswd() {
                if (document.getElementById("caja").style["display"] == "block") {
                    document.getElementById("caja").style["display"] = "none";
                    document.getElementById("caja_Passwd").style["display"] = "block";
                } else {
                    document.getElementById("caja_Passwd").style["display"] = "none";
                    document.getElementById("caja").style["display"] = "block";
                }
            }

            function actualizarCondiciones(passwd) {
                let xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let verificaciones = JSON.parse(this.responseText);
                        
                        if (verificaciones["minCaract"]) {
                            document.getElementById("minCaract").style["color"] = "#48bb78";
                        } else {
                            document.getElementById("minCaract").style["color"] = "#fc8181";
                        }

                        if (verificaciones["mayusMins"]) {
                            document.getElementById("mayusMins").style["color"] = "#48bb78";
                        } else {
                            document.getElementById("mayusMins").style["color"] = "#fc8181";
                        }

                        if (verificaciones["numsOblig"]) {
                            document.getElementById("numsOblig").style["color"] = "#48bb78";
                        } else {
                            document.getElementById("numsOblig").style["color"] = "#fc8181";
                        }

                        if (verificaciones["espcCarac"]) {
                            document.getElementById("espcCarac").style["color"] = "#48bb78";
                        } else {
                            document.getElementById("espcCarac").style["color"] = "#fc8181";
                        }

                        if (document.getElementById("condicionesPasswd").style["display"] == "none") {
                            document.getElementById("condicionesPasswd").style["display"] = "block";
                        }
                    }
                };

                xmlhttp.open("GET", "../../condiciones.php?p=" + encodeURIComponent(passwd), true);
                xmlhttp.send();
            }
        </script>
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

        <div id="caja" style="<?php echo $style1; ?>">
            <h1>Editar Perfil</h1>
            <div id="linea"></div>
            <?php echo (isset($_SESSION["err"]) ? $_SESSION["err"] : ""); ?>

            <form action="modificarPerfil_DB.php" method="post" enctype="multipart/form-data">
                <div class="campo">
                    <input type="text" name="nombre" placeholder="Nombre" maxlength="100" value="<?php echo (isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Nombre"]) ? $_SESSION["err_Nombre"] : "") ?>
                </div>

                <div class="campo">
                    <input type="file" name="foto">
                    <br/>
                    <?php echo (isset($_SESSION["err_Foto"]) ? $_SESSION["err_Foto"] : "") ?>
                </div>

                <input type="hidden" name="tipo" value="1">
                <input type="submit">
            </form>

            <button onclick="switchCajaPasswd()">Cambiar la Contraseña</button>
        </div>

        <div id="caja_Passwd" style="<?php echo $style2; ?>">
            <h1>Cambiar la Contraseña</h1>
            <div id="linea"></div>
            <?php echo (isset($_SESSION["err"]) ? $_SESSION["err"] : ""); ?>

            <form action="modificarPerfil_DB.php" method="post">
                <div class="campo">
                    <input type="password" name="passwd" placeholder="Contraseña" onkeyup="actualizarCondiciones(this.value)" value="<?php echo (isset($_SESSION["passwd"]) ? $_SESSION["passwd"] : "") ?>"> 
                    <br/>
                    <?php echo (isset($_SESSION["err_Passwd"]) ? $_SESSION["err_Passwd"] : "") ?>

                    <ul id="condicionesPasswd" style="display : none;">
                        <li id="minCaract" style="color : #fc8181;">Debe tener Minimo 8 Caracteres</li>
                        <li id="mayusMins" style="color : #fc8181;">Debe terner Mayusculas y Minusculas</li>
                        <li id="numsOblig" style="color : #fc8181;">Debe contener Numeros</li>
                        <li id="espcCarac" style="color : #fc8181;">Debe contener Caracteres Especiales</li>
                    </ul>
                </div>

                <div class="campo">
                    <input type="password" name="passwd_R" placeholder="Repita la Contraseña"> 
                    <br/>
                </div>

                <input type="hidden" name="tipo" value="2">
                <input type="submit">
            </form>

            <button onclick="switchCajaPasswd()">Editar el Perfil</button>
        </div>
    </body>
</html>

<?php
unset($_SESSION["err"]);
unset($_SESSION["nombre"]);
unset($_SESSION["err_Nombre"]);
unset($_SESSION["err_Foto"]);
unset($_SESSION["passwd"]);
unset($_SESSION["err_Passwd"]);
?>