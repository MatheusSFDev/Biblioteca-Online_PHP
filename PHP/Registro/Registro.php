<?php
session_start();
?>

<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro | LevelUp Library</title>
        <link rel="stylesheet" href="../../CSS/style_Form_Registro_Login.css">

        <script>
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

                xmlhttp.open("GET", "../condiciones.php?p=" + encodeURIComponent(passwd), true);
                xmlhttp.send();
            }
        </script>
    </head>

    <body>
        <div id="caja">
            <h1>Registro</h1>
            <div id="linea"></div>
            <?php echo (isset($_SESSION["err"]) ? $_SESSION["err"] : ""); $_SESSION["err"] = ""; ?>

            <form action="Registro_DB.php" method="post" enctype="multipart/form-data">
                <div class="campo">
                    <input type="text" name="nombre" placeholder="Nombre" maxlength="100" value="<?php echo (isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "") ?>">
                    <br/>
                    <?php echo (isset($_SESSION["err_Nombre"]) ? $_SESSION["err_Nombre"] : "") ?>
                </div>

                <div class="campo">
                    <input type="text" name="email" placeholder="Email" maxlength="255" value="<?php echo (isset($_SESSION["email"]) ? $_SESSION["email"] : "") ?>"> 
                    <br/>
                    <?php echo (isset($_SESSION["err_Email"]) ? $_SESSION["err_Email"] : "") ?>
                </div>

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

                <div class="campo">
                    <input type="file" name="foto">
                    <br/>
                    <?php echo (isset($_SESSION["err_Foto"]) ? $_SESSION["err_Foto"] : "") ?>
                </div>

                <input type="submit">
            </form>

            <p> Ya tienes Cuenta? <a href="../Login/Login.php" target="_self"> Logueate </a> </p>
        </div>
    </body>
</html>

<?php
unset($_SESSION["err"]);
unset($_SESSION["nombre"]);
unset($_SESSION["err_Nombre"]);
unset($_SESSION["email"]);
unset($_SESSION["err_Email"]);
unset($_SESSION["passwd"]);
unset($_SESSION["err_Passwd"]);
unset($_SESSION["err_Foto"]);
?>