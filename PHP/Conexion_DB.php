<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=bibliotecaOnline", "adminPHP", "qwerty-1234");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo "Conexión Fallida";
    exit;
}
?>