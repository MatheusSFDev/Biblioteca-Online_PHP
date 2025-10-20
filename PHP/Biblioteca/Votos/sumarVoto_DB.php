<?php
session_start();
require '../../Conexion_DB.php';

$voto = $_GET["voto"];
$email = $_SESSION["emailLogin"];
$id = $_GET["id"];
$votado = $_GET["votado"];

if ($votado === "false") {
    try {
        $sentencia = $conn->prepare("INSERT INTO votos VALUE (:voto, :email, :id)");
        $sentencia->bindParam(":voto", $voto);
        $sentencia->bindParam(":email", $email);
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
    } catch (PDOException $ex) {
        echo $ex;
    }   
}

try {
    $sentencia = $conn->prepare("SELECT voto, count(voto) as 'Suma' FROM votos WHERE id = :id GROUP BY voto ORDER BY voto DESC");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();

    $result = $sentencia->fetch(PDO::FETCH_ASSOC);
    $likes = ($result["voto"] == 1) ? $result["Suma"] : 0;
    $nolikes = ($result["voto"] == 0) ? $result["Suma"] : 0;
    
    $result = $sentencia->fetch(PDO::FETCH_ASSOC);
    $nolikes = ($result !== false) ? $result["Suma"] : $nolikes;
} catch (PDOException $ex) {
    echo $ex;
}

$total = $likes + $nolikes;
$porcntLikes = round($likes / ($total / 100));
$porcntNolikes = round($nolikes / ($total / 100));

$anchoTotalBarra = 150; 
$anchoLikes = ($anchoTotalBarra * ($porcntLikes / 100));
$anchoNolikes = ($anchoTotalBarra * ($porcntNolikes / 100));

if ($anchoLikes == 0 && $anchoNolikes > 0) $anchoNolikes = $anchoTotalBarra;
if ($anchoNolikes == 0 && $anchoLikes > 0) $anchoLikes = $anchoTotalBarra;
?>

<div class="votar-iconos">
    <?php if ($voto == 1): ?>
        <img src="../../Imgs/Like_Elegido.png" width="48px">
        <img src="../../Imgs/Dislike.png" width="48px">
    <?php else: ?>
        <img src="../../Imgs/Like.png" width="48px">
        <img src="../../Imgs/Dislike_Elegido.png" width="48px">
    <?php endif; ?>
</div>

<div class="votar-barra" style="display: flex;">
    <?php echo $porcntLikes; ?>% 
    <div style="width: <?php echo $anchoLikes; ?>px; height: 24px; background-color: blue;"></div>
    <div style="width: <?php echo $anchoNolikes; ?>px; height: 24px; background-color: red;"></div> 
    <?php echo $porcntNolikes; ?>%
</div>