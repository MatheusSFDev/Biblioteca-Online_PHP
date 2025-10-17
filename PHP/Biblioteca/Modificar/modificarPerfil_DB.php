<?php
session_start();
if (!isset($_SESSION["emailLogin"])) {
    header("Location: ../../Login/Login.php");
    exit;
}

if ($_POST["tipo"] == "1") {
    $nombre = $_POST["nombre"];
    $email = $_SESSION["emailLogin"];
    $correcto = true;
    $err = "";

    if (!preg_match("/^[a-zA-Z-' ]*$/", $nombre) || empty($nombre)) {
        $correcto = false;
        $_SESSION["nombre_Perfil"] = $_SESSION["nombreLogin"];

        if (empty($nombre)) {
            $err = "El Campo esta Vacio";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $nombre)) {
            $err = "Solo se permiten letras, espacios y el caracter (')";
        }

        $_SESSION["err_Nombre_Perfil"] = "<p>! " . $err . " !</p>";
    } else {
        $_SESSION["nombre_Perfil"] = $nombre;
        $_SESSION["err_Nombre_Perfil"] = "";
    }

    if ($correcto) {
        $foto = guardarFoto();
    } else {
        $foto = "false";
    }

    if ($foto != "false") {
        require '../../Conexion_DB.php';

        try {
            $sentencia = $conn->prepare("UPDATE usuarios SET 
                                                        nombre = :nombre,
                                                        foto = :foto
                                        WHERE email = :email");

            $sentencia->bindParam(":nombre", $nombre);
            $sentencia->bindParam(":foto", $foto);
            $sentencia->bindParam(":email", $email);

            $sentencia->execute();

            $conn = null;

            $_SESSION["nombreLogin"] = $nombre;
            $_SESSION["fotoLogin"] = $foto;

            unset($_SESSION["nombre_Perfil"]);

            header("Location: ../Perfil.php");
            exit;
        } catch (PDOException $ex) {
            $_SESSION["err_Try_ModificarPerfil"] = "<p>Operación Fallida</p>";

            $conn = null;
            header("Location: modificarPerfil.php");
            exit;
        }
    } else {
        $conn = null;
        header("Location: modificarPerfil.php");
        exit;
    }
} else {
    $passwd = $_POST["passwd"];
    $passwd_R = $_POST["passwd_R"];
    $passwd_H = password_hash($passwd, PASSWORD_DEFAULT);
    $email = $_SESSION["emailLogin"];
    $correcto = true;
    $err = "";

    if (($passwd !== $passwd_R || empty($passwd) || !passwdValida($passwd)) && $passwd != "123") { // Borrar Luego, solo se utiliza para tests durante Desarrollo 
        $correcto = false; 
        $_SESSION["passwd_Perfil"] = "";

        if (empty($passwd)) {
            $err = "El Campo esta Vacio";
        } elseif ($passwd !== $passwd_R) {
            $err = "Las Contraseñas no coinciden";
        } elseif (!passwdValida($passwd)) {
            $err = "La Contraseña no cumple los Requisitos";
        }

        $_SESSION["err_Passwd_Perfil"] = "<p>! " . $err . " !</p>";
    } else {
        $_SESSION["passwd_Perfil"] = $passwd;
        $_SESSION["err_Passwd_Perfil"] = "";
    }

    if ($correcto) {
        require '../../Conexion_DB.php';

        try {
            $sentencia = $conn->prepare("UPDATE usuarios SET 
                                                        passwd = :passwd
                                        WHERE email like(:email)");

            $sentencia->bindParam(":passwd", $passwd_H);
            $sentencia->bindParam(":email", $email);

            $sentencia->execute();

            $conn = null;

            header("Location: ../Perfil.php");
            exit;
        } catch (PDOException $ex) {
            $_SESSION["err_Try_ModificarPerfil"] = "<p>Operación Fallida" . $ex ."/p>";

            $conn = null;
            header("Location: modificarPerfil.php");
            exit;
        }
    } else {
        $conn = null;
        header("Location: modificarPerfil.php");
        exit;
    }
}

function passwdValida($passwd) {
    if (strlen($passwd) < 8) return false;
    if (!(preg_match("/[A-Z]/", $passwd) && preg_match("/[a-z]/", $passwd))) return false;
    if (!strpbrk($passwd, "0123456789")) return false; 
    if (!preg_match("/[^a-zA-Z0-9\s]/", $passwd)) return false;

    return true;
}

function guardarFoto() {
    if ($_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
        $nombreNuevo = md5(basename($_FILES["foto"]["name"]) . $_SESSION["emailLogin"] . uniqid('', true));
        $extencion = strtolower(pathinfo(basename($_FILES["foto"]["name"]))['extension']);
        $rutaGuardado = "../../../Imgs/Fotos_Perfil/" . $nombreNuevo . "." . $extencion;
        $rutaBiblioteca = "../../Imgs/Fotos_Perfil/" . $nombreNuevo . "." . $extencion;

        if (file_exists($rutaGuardado)) {
            $_SESSION["err_Caratula_ModificarJuego"] = "<p>! La Foto no se pudo Guardar !</p>";
            return "false";
        }

        if ($_FILES["foto"]["size"] > 10000000) { // 10 MB
            $_SESSION["err_Caratula_ModificarJuego"] = "<p>! La Imagen supera el limite de 512 KB !</p>";
            return "false";
        }

        if($extencion != "jpg" && $extencion != "png" && $extencion != "jpeg") {
            $_SESSION["err_Caratula_ModificarJuego"] = "<p>! El Fichero no es una Imagen (JPG / PNG / JPEG) !</p>";
            return "false";
        }
        
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaGuardado)) {
            $_SESSION["err_Caratula_ModificarJuego"] = "";

            if ($_SESSION["fotoLogin"] != "../../Imgs/Fotos_Perfil/Foto_Base.png") {
                unlink("../" . $_SESSION["fotoLogin"]);
            }
            
            return $rutaBiblioteca;
        } else {
            $_SESSION["err_Caratula_ModificarJuego"] = "<p>! La Foto no se pudo Guardar !</p>";
            return "false";
        }
    } else {
        return $_SESSION["fotoLogin"];
    }
}
?>