<?php
// pages/actividades.php - CÓDIGO REFACTORIZADO
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// AGREGAR ESTAS LÍNEAS AL INICIO
require_once '../src/classes/ActivityManager.php';
require_once '../src/utils/Validator.php';

// REEMPLAZAR la lógica directa con llamadas a clases
if ($_POST['action'] == 'crear') {
    try {
        $activityManager = new ActivityManager('../JSON/actividades.json');
        $resultado = $activityManager->crear($_POST);

        // Respuesta JSON para AJAX
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $resultado,
            'message' => 'Actividad creada exitosamente'
        ]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit();
}

if ($_POST['action'] == 'cambiar_estado') {
    try {
        $activityManager = new ActivityManager('../JSON/actividades.json');
        $resultado = $activityManager->cambiarEstado($_POST['id'], $_POST['nuevo_estado']);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $resultado]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit();
}

// Para mostrar actividades
$activityManager = new ActivityManager('../JSON/actividades.json');
$actividades = $activityManager->obtenerTodas();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Mis Actividades</title>
    <link rel="stylesheet" href="../CSS/actividades.css">
</head>
<body>
Tu HTML actual aquí
<?php foreach ($actividades as $actividad): ?>
    <div class="actividad-item" data-id="<?= $actividad['id'] ?>">
        <h3><?= htmlspecialchars($actividad['titulo']) ?></h3>
        <p><?= htmlspecialchars($actividad['descripcion']) ?></p>
        <span class="estado <?= $actividad['estado'] ?>"><?= $actividad['estado'] ?></span>
    </div>
<?php endforeach; ?>
</body>
</html>