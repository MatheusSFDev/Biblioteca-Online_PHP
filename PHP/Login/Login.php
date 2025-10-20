<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login | LevelUp Library</title>
        <link rel="stylesheet" href="../../CSS/style_Form_Registro_Login.css">
    </head>

    <body>
        <div id="caja">
            <h1>Login</h1>
            <div id="linea"></div>
            <?php echo (isset($_SESSION["correcto"]) ? $_SESSION["correcto"] : ""); ?>
            <?php echo (isset($_SESSION["err"]) ? $_SESSION["err"] : ""); ?>

            <form action="Login_DB.php" method="post">
                <div class="campo">
                    <input type="text" name="email" placeholder="Email" maxlength="255" value="<?php echo (isset($_SESSION["email"]) ? $_SESSION["email"] : "") ?>"> 
                    <br/>
                    <?php echo (isset($_SESSION["err_Email"]) ? $_SESSION["err_Email"] : "") ?>
                </div>

                <div class="campo">
                    <input type="password" name="passwd" placeholder="Contraseña"> 
                    <br/>
                    <?php echo (isset($_SESSION["err_Passwd"]) ? $_SESSION["err_Passwd"] : "") ?>
                </div>

                <input type="submit">

                <input type="checkbox" name="guardarSesion"> Recordar-me
            </form>

            <p> Aun no tienes Cuenta? <a href="../Registro/Registro.php" target="_self"> Registrate </a> </p>
        </div>
    </body>
</html>

<?php
unset($_SESSION["correcto"]);
unset($_SESSION["err"]);
unset($_SESSION["email"]);
unset($_SESSION["err_Email"]);
unset($_SESSION["err_Passwd"]);
?>