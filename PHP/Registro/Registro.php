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
                            document.getElementById("minCaract").style["color"] = "green";
                        } else {
                            document.getElementById("minCaract").style["color"] = "red";
                        }

                        if (verificaciones["mayusMins"]) {
                            document.getElementById("mayusMins").style["color"] = "green";
                        } else {
                            document.getElementById("mayusMins").style["color"] = "red";
                        }

                        if (verificaciones["numsOblig"]) {
                            document.getElementById("numsOblig").style["color"] = "green";
                        } else {
                            document.getElementById("numsOblig").style["color"] = "red";
                        }

                        if (verificaciones["espcCarac"]) {
                            document.getElementById("espcCarac").style["color"] = "green";
                        } else {
                            document.getElementById("espcCarac").style["color"] = "red";
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
            <?php echo (isset($_SESSION["err_Try"]) ? $_SESSION["err_Try"] : ""); $_SESSION["err_Try"] = ""; ?>

            <form action="Registro_DB.php" method="post">
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

                    <ul id="condicionesPasswd">
                        <li id="minCaract" style="color : red;">Debe tener Minimo 8 Caracteres</li>
                        <li id="mayusMins" style="color : red;">Debe terner Mayusculas y Minusculas</li>
                        <li id="numsOblig" style="color : red;">Debe contener Numeros</li>
                        <li id="espcCarac" style="color : red;">Debe contener Caracteres Especiales</li>
                    </ul>
                </div>

                <div class="campo">
                    <input type="password" name="passwd_R" placeholder="Repita la Contraseña"> 
                    <br/>
                </div>

                <input type="submit">
            </form>

            <p> Ya tienes Cuenta? <a href="../Login/Login.php" target="_self"> Logueate </a> </p>
        </div>
    </body>
</html>