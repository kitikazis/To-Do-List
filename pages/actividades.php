<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$userId = $_SESSION['id'] ?? null;

define('ACTIVIDADES_FILE', __DIR__ . '/../JSON/actividades.json');
if (!file_exists(ACTIVIDADES_FILE)) {
    file_put_contents(ACTIVIDADES_FILE, json_encode([]));
}

$actividades = json_decode(file_get_contents(ACTIVIDADES_FILE), true) ?? [];

if (isset($_POST['guardar']) && $loggedIn) {
    $actividad = [
        'id'          => uniqid(),
        'user_id'     => $userId,
        'titulo'      => $_POST['titulo'],
        'fecha'       => $_POST['fecha'],
        'descripcion' => $_POST['descripcion'],
        'estado'      => 'pendiente',
        'foto'        => null
    ];

    if (!empty($_FILES['imagen']['tmp_name'])) {
        $ext  = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $ruta = '../IMG/' . $actividad['id'] . '.' . $ext;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
        $actividad['foto'] = $ruta;
    }

    $actividades[] = $actividad;
    file_put_contents(ACTIVIDADES_FILE, json_encode($actividades, JSON_PRETTY_PRINT));
    header('Location: actividades.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Actividades</title>
  <link rel="stylesheet" href="../CSS/actividades.css">
  <script defer src="../JS/animaciones.js"></script>
</head>
<body class="actividades-page">
  <header class="site-header">
    <div class="header-left"><h1>Mis Actividades</h1></div>
    <div class="header-right">
      <a href="../index.php" class="nav-link">Volver</a>
    </div>
  </header>

  <?php if ($loggedIn): ?>
  <section class="form-section animated fade-in">
    <h2>Registrar nueva actividad</h2>
    <form method="POST" enctype="multipart/form-data" class="actividad-form">
      <input type="text" name="titulo" placeholder="Título de la actividad" required>
      <input type="date" name="fecha" required>
      <textarea name="descripcion" placeholder="Descripción" required></textarea>
      <input type="file" name="imagen" accept="image/*">
      <button type="submit" name="guardar">Guardar actividad</button>
    </form>
  </section>

  <section class="listado-section animated slide-up">
    <h2>Mis actividades registradas</h2>
    <div class="actividades-list">
      <?php foreach ($actividades as $act): ?>
        <?php if ($act['user_id'] === $userId): ?>
        <?php
          $fechaHoy = date('Y-m-d');
          $estado = $act['estado'];

          if ($estado === 'pendiente' && $act['fecha'] < $fechaHoy) {
              $estado = 'no_realizado';
          }

          $colores = [
              'pendiente'     => '#ccc',
              'realizado'     => '#4CAF50',
              'en_proceso'    => '#FFEB3B',
              'no_realizado'  => '#F44336'
          ];
        ?>
        <div class="actividad-item" style="border-left: 6px solid <?= $colores[$estado] ?>;">
          <div class="actividad-resumen" onclick="toggleDetalle(this)">
            <h3><?= htmlspecialchars($act['titulo']) ?></h3>
            <p><?= htmlspecialchars($act['fecha']) ?></p>
            <?php if ($act['foto']): ?>
              <img src="<?= $act['foto'] ?>" class="actividad-foto" alt="Imagen">
            <?php endif; ?>
          </div>
          <div class="actividad-detalle">
            <p><strong>Descripción:</strong> <?= htmlspecialchars($act['descripcion']) ?></p>
            <p><strong>Estado:</strong> <?= ucfirst($estado) ?></p>
          </div>
        </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </section>
  <?php else: ?>
    <p class="mensaje-login">Inicia sesión para registrar y ver tus actividades.</p>
  <?php endif; ?>
</body>
</html>