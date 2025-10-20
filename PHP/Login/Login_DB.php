<?php
session_start();
require '../Conexion_DB.php';

$email = $_POST["email"];
$passwd = $_POST["passwd"];

if (datosCorrectos($email, $passwd)) {
    try {
        $sentencia = $conn->prepare("SELECT email, passwd, nombre, foto FROM usuarios WHERE email like(:email)");
        $sentencia->bindParam(":email", $email);
        $sentencia->execute();

        $result = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($result !== false) {
            if (password_verify($passwd, $result["passwd"])) {
                session_destroy();
                session_start();
                $_SESSION["nombreLogin"] = $result["nombre"];
                $_SESSION["emailLogin"] = $result["email"];
                $_SESSION["fotoLogin"] = $result["foto"];

                if (isset($_POST["guardarSesion"])) {
                    guardarCokkie($conn);
                }

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
        $_SESSION["err"] = "<p> Operación Fallida </p>";
    }
} else {
    header("Location: Login.php");
    exit;
}

function datosCorrectos($email, $passwd) {
    $correcto = true;
    $err = "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email)) {
        $correcto = false;
        $_SESSION["email"] = "";

        if (empty($email)) {
            $err = "El Campo esta Vacio";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err = "No Cumple con un formato correcto de Correo";
        }

        $_SESSION["err_Email"] = "<p>! " . $err . " !</p>";
    } else {
        $_SESSION["email"] = $email;
        $_SESSION["err_Email"] = "";
    }

    if (empty($passwd)) { 
        $correcto = false;
        $_SESSION["err_Passwd"] = "<p>! Debes intoducir una Contraseña !</p>";
    } else {
        $_SESSION["err_Passwd"] = "";
    }

    return $correcto;
}

function guardarCokkie($conn) {
    $cookie = bin2hex(random_bytes(32));
    $correcto = false;

    try {
        $sentencia = $conn->prepare("INSERT INTO cookies(cookie, usuario, fecha_exp) VALUE (:cookie, :usuario, NOW() + INTERVAL 30 DAY)");
        $sentencia->bindParam(":cookie", $cookie);
        $sentencia->bindParam(":usuario", $_SESSION["emailLogin"]);
        $correcto = $sentencia->execute();
    } catch (PDOException $ex) {
        echo "Operación Fallida";
    }

    if ($correcto) {
        setcookie("cookieSesion", $cookie, [
            'expires' => time() + (30 * 24 * 60 * 60),
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    } else {
        echo "Operación Fallida";
    }
}
?>