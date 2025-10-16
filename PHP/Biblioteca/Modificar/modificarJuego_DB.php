<?php
session_start();

if ($_SESSION["emailLogin"] !== $_POST["propietario"]) {
    header("Location: ../Pagina.php");
    exit;
}

$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"];
$autor = $_POST["autor"];
$categoria = $_POST["categoria"];
$enlace = $_POST["enlace"];
$ano = $_POST["ano"];
$id = $_POST["id"];

$_SESSION["descripcion_ModificarJuego"] = $descripcion;

if (datosValidos($titulo, $autor, $categoria, $enlace, $ano)) {
    $caratula = guardarFoto();
} else {
    $caratula = "false";
}

if ($caratula != "false") {
    require '../../Conexion_DB.php';

    try {
        $sentencia = $conn->prepare("UPDATE juegos SET 
                                                    titulo = :titulo,
                                                    descripcion = :descripcion,
                                                    autor = :autor,
                                                    caratula = :caratula,
                                                    categoria = :categoria,
                                                    enlace = :enlace,
                                                    ano = :ano
                                    WHERE id = :id");

        $sentencia->bindParam(":titulo", $titulo);
        $sentencia->bindParam(":descripcion", $descripcion);
        $sentencia->bindParam(":autor", $autor);
        $sentencia->bindParam(":caratula", $caratula);
        $sentencia->bindParam(":categoria", $categoria);
        $sentencia->bindParam(":enlace", $enlace);
        $sentencia->bindParam(":ano", $ano);
        $sentencia->bindParam(":id", $id);

        $sentencia->execute();

        $conn = null;

        $nombreLogin = $_SESSION["nombreLogin"];
        $emailLogin = $_SESSION["emailLogin"];
        $fotoLogin = $_SESSION["fotoLogin"];
        session_destroy();
        session_start();
        $_SESSION["nombreLogin"] = $nombreLogin;
        $_SESSION["emailLogin"] = $emailLogin;
        $_SESSION["fotoLogin"] = $fotoLogin;

        header("Location: ../Juego.php?id=" . $id);
        exit;
    } catch (PDOException $ex) {
        $_SESSION["err_Try_ModificarJuego"] = "<p>Operación Fallida</p>";

        $conn = null;
        header("Location: modificarJuego.php?id=" . $id);
        exit;
    }
} else {
    $conn = null;
    header("Location: modificarJuego.php?id=" . $id);
    exit;
}

function datosValidos($titulo, $autor, $categoria, $enlace, $ano) {
    $correcto = true;

    if (empty($titulo)) {
        $correcto = false;
        $_SESSION["titulo_ModificarJuego"] = "";
        $_SESSION["err_Titulo_ModificarJuego"] = "<p>! Debes introducir un Titulo !</p>";
    } else {
        $_SESSION["titulo_ModificarJuego"] = $titulo;
        $_SESSION["err_Titulo_ModificarJuego"] = "";
    }

    if (empty($autor)) {
        $correcto = false;
        $_SESSION["autor_ModificarJuego"] = "";
        $_SESSION["err_Autor_ModificarJuego"] = "<p>! Debes introducir un Autor !</p>";
    } else {
        $_SESSION["autor_ModificarJuego"] = $autor;
        $_SESSION["err_Autor_ModificarJuego"] = "";
    }

    if (empty($categoria)) {
        $correcto = false;
        $_SESSION["categoria_ModificarJuego"] = "";
        $_SESSION["err_Categoria_ModificarJuego"] = "<p>! Debes introducir una Categoria !</p>";
    } else {
        $_SESSION["categoria_ModificarJuego"] = $categoria;
        $_SESSION["err_Categoria_ModificarJuego"] = "";
    }

    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $enlace) && $enlace != "") {
        $correcto = false;
        $_SESSION["enlace_ModificarJuego"] = "";
        $_SESSION["err_enlace_ModificarJuego"] = "<p>! Debes introducir una enlace Valida !</p>";
    } else {
        $_SESSION["enlace_ModificarJuego"] = $enlace;
        $_SESSION["err_enlace_ModificarJuego"] = "";
    }

    if ((int) $ano < 1950 && $ano != "") {
        $correcto = false;
        $_SESSION["ano_ModificarJuego"] = "";
        $_SESSION["err_ano_ModificarJuego"] = "<p>! El ano debe ser posterior o igual a 1950 !</p>";
    } else {
        $_SESSION["ano_ModificarJuego"] = $ano;
        $_SESSION["err_ano_ModificarJuego"] = "";
    }

    return $correcto;
}

function guardarFoto() {
    if ($_FILES["caratula"]["error"] === UPLOAD_ERR_OK) {
        $nombreNuevo = md5(basename($_FILES["caratula"]["name"]) . $_SESSION["emailLogin"] . uniqid('', true));
        $extencion = strtolower(pathinfo(basename($_FILES["caratula"]["name"]))['extension']);
        $rutaGuardado = "../../../Imgs/Caratulas/" . $nombreNuevo . "." . $extencion;
        $rutaBiblioteca = "../../Imgs/Caratulas/" . $nombreNuevo . "." . $extencion;

        if (file_exists($rutaGuardado)) {
            $_SESSION["err_Caratula_ModificarJuego"] = "<p>! La Foto no se pudo Guardar !</p>";
            return "false";
        }

        if ($_FILES["caratula"]["size"] > 524288) { // 512 KB
            $_SESSION["err_Caratula_ModificarJuego"] = "<p>! La Imagen supera el limite de 512 KB !</p>";
            return "false";
        }

        if($extencion != "jpg" && $extencion != "png" && $extencion != "jpeg") {
            $_SESSION["err_Caratula_ModificarJuego"] = "<p>! El Fichero no es una Imagen (JPG / PNG / JPEG) !</p>";
            return "false";
        }
        
        if (move_uploaded_file($_FILES["caratula"]["tmp_name"], $rutaGuardado)) {
            $_SESSION["err_Caratula_ModificarJuego"] = "";

            if ($_POST["ruta"] != "../../Imgs/Caratulas/Caratula_Base.png") {
                unlink("../" . $_POST["ruta"]);
            }
            
            return $rutaBiblioteca;
        } else {
            $_SESSION["err_Caratula_ModificarJuego"] = "<p>! La Foto no se pudo Guardar !</p>";
            return "false";
        }
    } else {
        return $_POST["ruta"];
    }
}
?>