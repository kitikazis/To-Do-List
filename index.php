<?php
// index.php - CÓDIGO REFACTORIZADO
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: pages/login.php");
    exit();
}

// AGREGAR ESTAS LÍNEAS
require_once 'src/classes/ActivityManager.php';
require_once 'src/classes/ProgressCalculator.php';

// REEMPLAZAR lógica directa
$activityManager = new ActivityManager('JSON/actividades.json');
$progressCalculator = new ProgressCalculator();

$actividades = $activityManager->obtenerTodas();
$resumen = $progressCalculator->calcularResumen($actividades);
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>To Do List</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
Tu HTML actual, pero usando las variables del resumen
<div class="resumen-actual">
    <h2>Resumen actual</h2>
    <div class="contador-item">
        <span class="punto verde"></span>
        <span>Realizadas: <span class="contador" data-estado="realizadas"><?= $resumen['realizadas'] ?></span></span>
    </div>
    <div class="contador-item">
        <span class="punto amarillo"></span>
        <span>En proceso: <span class="contador" data-estado="en_proceso"><?= $resumen['en_proceso'] ?></span></span>
    </div>
    <div class="contador-item">
        <span class="punto rojo"></span>
        <span>No realizadas: <span class="contador" data-estado="no_realizadas"><?= $resumen['no_realizadas'] ?></span></span>
    </div>
    <div class="contador-item">
        <span class="punto gris"></span>
        <span>Pendientes: <span class="contador" data-estado="pendientes"><?= $resumen['pendientes'] ?></span></span>
    </div>
</div>

<script src="JS/index.js"></script>
</body>
</html>