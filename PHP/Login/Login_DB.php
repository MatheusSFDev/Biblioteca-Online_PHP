<?php
session_start();
require '../Conexion_DB.php';

$email = $_POST["email"];
$passwd = $_POST["passwd"];

$correct = true;

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email)) {
    $correct = false;
    $_SESSION["email"] = "";

    if (empty($email)) {
        $_SESSION["err_Email"] = "<p>! El Campo esta Vacio !</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["err_Email"] = "<p>! No Cumple con un formato correcto de Correo !</p>";
    }
} else {
    $_SESSION["email"] = $email;
    $_SESSION["err_Email"] = "";
}

if (empty($passwd)) { 
    $correct = false;

    if (empty($passwd)) {
        $_SESSION["err_Passwd"] = "<p>! Debes intoducir una Contraseña !</p>";
    }
} else {
    $_SESSION["err_Passwd"] = "";
}

if ($correct) {
    try {
        $sentencia = $conn->prepare("SELECT email, passwd, nombre FROM usuarios WHERE email like(:email)");

        $sentencia->bindParam(":email", $email);

        $sentencia->execute();

        $result = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($result !== false) {
            if ($result["email"] == $email && password_verify($passwd, $result["passwd"])) {
                $_SESSION["nombreLogin"] = $result["nombre"];
                $conn = null;
                header("Location: ../Biblioteca/Pagina.php");
                exit;
            } else {
                $_SESSION["err_Passwd"] = "<p>! La contraseña esta Incorrecta !</p>";
                $conn = null;
                header("Location: Login.php");
                exit;
            }
        } else {
            $_SESSION["email"] = "";
            $_SESSION["err_Email"] = "<p>! El Correo no Existe !</p>";
            $conn = null;
            header("Location: Login.php");
            exit;
        }
        
    } catch (PDOException $ex) {
        echo "Operación Fallida";
    }
} else {
    header("Location: Login.php");
    exit;
}
?>