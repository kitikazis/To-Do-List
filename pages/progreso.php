<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$userId = $_SESSION['id'] ?? null;

define('ACTIVIDADES_FILE', __DIR__ . '/../JSON/actividades.json');
if (!file_exists(ACTIVIDADES_FILE)) {
    file_put_contents(ACTIVIDADES_FILE, json_encode([]));
}
$actividades = json_decode(file_get_contents(ACTIVIDADES_FILE), true) ?? [];

// Eliminar actividad
if (isset($_POST['eliminar'])) {
    $idEliminar = $_POST['eliminar'];
    $actividades = array_filter($actividades, fn($a) => $a['id'] !== $idEliminar);
    file_put_contents(ACTIVIDADES_FILE, json_encode(array_values($actividades), JSON_PRETTY_PRINT));
    header('Location: progreso.php');
    exit;
}

// Actualizar campos
if (isset($_POST['actualizar']) && $loggedIn) {
    foreach ($actividades as &$a) {
        if ($a['id'] === $_POST['actividad_id'] && $a['user_id'] === $userId) {
            $a['titulo']      = $_POST['titulo'];
            $a['descripcion'] = $_POST['descripcion'];
            $a['fecha']       = $_POST['fecha'];
            $a['estado']      = $_POST['estado'];
            $a['fijada']      = $_POST['fijada'] ?? 'no';
        }
    }
    file_put_contents(ACTIVIDADES_FILE, json_encode($actividades, JSON_PRETTY_PRINT));
    header('Location: progreso.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar</title>
  <link rel="stylesheet" href="../CSS/progreso.css">
  <script defer src="../JS/animaciones.js"></script>
</head>
<body class="progreso-page">
  <header class="site-header">
    <div class="header-left"><h1>Editar</h1></div>
    <div class="header-right">
      <a href="../index.php" class="nav-link">Volver</a>
    </div>
  </header>

  <?php if ($loggedIn): ?>
  <main class="main-content">
    <?php foreach ($actividades as $a): ?>
      <?php if ($a['user_id'] === $userId): ?>
        <form method="POST" class="actividad-card animated slide-up">
          <input type="hidden" name="actividad_id" value="<?= $a['id'] ?>">

          <div class="editable-field">
            <label>Título:</label>
            <input type="text" name="titulo" value="<?= htmlspecialchars($a['titulo']) ?>">
            <span class="edit-icon">✏️</span>
          </div>

          <div class="editable-field">
            <label>Fecha:</label>
            <input type="date" name="fecha" value="<?= $a['fecha'] ?>">
            <span class="edit-icon">✏️</span>
          </div>

          <div class="editable-field">
            <label>Descripción:</label>
            <textarea name="descripcion"><?= htmlspecialchars($a['descripcion']) ?></textarea>
            <span class="edit-icon">✏️</span>
          </div>

          <div class="editable-field">
            <label>Estado:</label>
            <select name="estado">
              <option value="pendiente"     <?= $a['estado'] === 'pendiente'     ? 'selected' : '' ?>>Gris - Pendiente</option>
              <option value="realizado"     <?= $a['estado'] === 'realizado'     ? 'selected' : '' ?>>Verde - Realizado</option>
              <option value="en_proceso"    <?= $a['estado'] === 'en_proceso'    ? 'selected' : '' ?>>Amarillo - En proceso</option>
              <option value="no_realizado"  <?= $a['estado'] === 'no_realizado'  ? 'selected' : '' ?>>Rojo - No realizado</option>
            </select>
          </div>

          <div class="editable-field">
            <label>Prioridad:</label>
            <select name="fijada">
              <option value="no"  <?= ($a['fijada'] ?? 'no') === 'no'  ? 'selected' : '' ?>>Normal</option>
              <option value="alta"<?= ($a['fijada'] ?? 'no') === 'alta' ? 'selected' : '' ?>>📌 Más importante</option>
              <option value="baja"<?= ($a['fijada'] ?? 'no') === 'baja' ? 'selected' : '' ?>>Menos importante</option>
            </select>
          </div>

          <div class="acciones">
            <button type="submit" name="actualizar">Actualizar</button>
            <button type="submit" name="eliminar" value="<?= $a['id'] ?>" class="eliminar-btn">Eliminar</button>
          </div>
        </form>
      <?php endif; ?>
    <?php endforeach; ?>
  </main>
  <?php else: ?>
    <p class="mensaje-login">Inicia sesión para ver y modificar tus actividades.</p>
  <?php endif; ?>
</body>
</html>