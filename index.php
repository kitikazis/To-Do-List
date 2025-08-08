<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$userId = $_SESSION['id'] ?? null;

if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: index.php');
  exit;
}

define('ACTIVIDADES_FILE', __DIR__ . '/JSON/actividades.json');
if (!file_exists(ACTIVIDADES_FILE)) {
  file_put_contents(ACTIVIDADES_FILE, json_encode([]));
}
$actividades = json_decode(file_get_contents(ACTIVIDADES_FILE), true) ?? [];

$estadoConteo = [
  'pendiente' => 0,
  'realizado' => 0,
  'en_proceso' => 0,
  'no_realizado' => 0
];

foreach ($actividades as $act) {
  if ($loggedIn && $act['user_id'] === $userId) {
    $estado = $act['estado'] ?? 'pendiente';
    if (isset($estadoConteo[$estado])) {
      $estadoConteo[$estado]++;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>To Do List</title>
  <link rel="stylesheet" href="CSS/index.css">
  <script defer src="JS/index.js"></script>
</head>
<body class="index-page">
  <header class="site-header">
    <div class="header-left"><h1>To Do List</h1></div>
    <div class="header-right">
      <?php if (!$loggedIn): ?>
        <a href="pages/login.php" class="nav-link">Iniciar sesión o registrarse</a>
      <?php else: ?>
        <a href="pages/actividades.php" class="nav-link">Mis Actividades</a>
        <a href="pages/calendario.php" class="nav-link">Mi Calendario</a>
        <a href="pages/progreso.php" class="nav-link">Editar</a>
        <form method="POST" class="logout-form">
          <button type="submit" name="logout">Cerrar sesión</button>
        </form>
      <?php endif; ?>
    </div>
  </header>

  <main class="main-content">
    <?php if (!$loggedIn): ?>
      <section class="animated-section fade-in">
        <h2>¿Quieres mejorar tu productividad?</h2>
        <p>Regístrate ahora y empieza a organizar tu vida de forma visual y eficiente. To Do List te acompaña cada día.</p>
        <a href="pages/login.php" class="btn-agregar">Comenzar ahora</a>
        <img src="IMG/calendario.jpg" alt="Motivación">
      </section>
    <?php else: ?>
      <section class="user-banner animated fade-in">
        <img src="<?= htmlspecialchars($_SESSION['photo'] ?? 'IMG/default.jpg') ?>" alt="Foto de perfil">
        <h2>Hola, <?= htmlspecialchars($_SESSION['user']) ?></h2>
      </section>

      <section class="animated-section slide-up">
        <h2>Bienvenido a tu panel</h2>
        <p>Aquí podrás registrar tus actividades y ver tu progreso.</p>
        <a href="pages/actividades.php" class="btn-agregar">+ Registrar nueva actividad</a>
      </section>

      <section class="estado-resumen animated-section">
        <h2>Resumen actual</h2>
        <ul>
          <li><span class="estado-circulo realizado"></span> Realizadas: <?= $estadoConteo['realizado'] ?></li>
          <li><span class="estado-circulo en-proceso"></span> En proceso: <?= $estadoConteo['en_proceso'] ?></li>
          <li><span class="estado-circulo no-realizado"></span> No realizadas: <?= $estadoConteo['no_realizado'] ?></li>
          <li><span class="estado-circulo pendiente"></span> Pendientes: <?= $estadoConteo['pendiente'] ?></li>
        </ul>
      </section>
    <?php endif; ?>
  </main>
</body>
</html>