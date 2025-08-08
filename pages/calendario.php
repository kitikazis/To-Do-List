<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$userId = $_SESSION['id'] ?? null;

define('ACTIVIDADES_FILE', __DIR__ . '/../JSON/actividades.json');
if (!file_exists(ACTIVIDADES_FILE)) {
    file_put_contents(ACTIVIDADES_FILE, json_encode([]));
}
$actividades = json_decode(file_get_contents(ACTIVIDADES_FILE), true) ?? [];


$vista = $_GET['vista'] ?? 'mes';
$hoy = new DateTime();
$diasMostrar = $vista === 'semana' ? 7 : 30;
$base = clone $hoy;
if (isset($_GET['inicio'])) {
    $base = new DateTime($_GET['inicio']);
}

function obtenerActividadesPorDia($dia, $actividades, $userId) {
    $formato = $dia->format('Y-m-d');
    return array_filter($actividades, function($a) use ($formato, $userId) {
        return $a['user_id'] === $userId && $a['fecha'] === $formato;
    });
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Calendario</title>
  <link rel="stylesheet" href="../CSS/calendario.css">
  <script defer src="../JS/animaciones.js"></script>
</head>
<body class="calendario-page">
  <header class="site-header">
    <div class="header-left"><h1>Mi Calendario</h1></div>
    <div class="header-right">
      <a href="../index.php" class="nav-link">Volver</a>
    </div>
  </header>

  <?php if ($loggedIn): ?>
  <section class="calendario-controles animated">
    <form method="GET">
      <label>Vista:
        <select name="vista">
          <option value="semana" <?= $vista === 'semana' ? 'selected' : '' ?>>Semana</option>
          <option value="mes" <?= $vista === 'mes' ? 'selected' : '' ?>>Mes</option>
        </select>
      </label>
      <label>Desde:
        <input type="date" name="inicio" value="<?= $base->format('Y-m-d') ?>">
      </label>
      <button type="submit">Aplicar</button>
    </form>
  </section>

  <section class="calendario-grid animated">
    <?php
    $diaActual = clone $base;
    for ($i = 0; $i < $diasMostrar; $i++) {
      $actividadesDia = obtenerActividadesPorDia($diaActual, $actividades, $userId);
      echo '<div class="dia-celda" onclick="expandirCelda(this)">';
      echo '<div class="dia-header">' . $diaActual->format('d/m/Y') . '</div>';
      foreach ($actividadesDia as $act) {
        $color = match ($act['estado']) {
          'realizado' => '#4CAF50',
          'en_proceso' => '#FFEB3B',
          'no_realizado' => '#F44336',
          default => '#ccc',
        };
        echo '<div class="actividad-mini">';
        echo '<div class="titulo">' . htmlspecialchars($act['titulo']) . '</div>';
        echo '<div class="estado" style="background-color:' . $color . '"></div>';
        echo '</div>';
        echo '<div class="detalle-expandido">';
        echo '<div class="titulo-grande">' . htmlspecialchars($act['titulo']) . '</div>';
        echo '<div class="estado-grande" style="background-color:' . $color . '"></div>';
        if ($act['foto']) {
          echo '<img src="' . $act['foto'] . '" alt="Imagen" class="foto-actividad">';
        }
        echo '</div>';
      }
      echo '</div>';
      $diaActual->modify('+1 day');
    }
    ?>
  </section>

  <section class="resumen-actividades animated">
    <button onclick="mostrarResumen()">Resumen de actividades</button>
  </section>
  <?php else: ?>
    <p class="mensaje-login">Inicia sesión para ver tu calendario de actividades.</p>
  <?php endif; ?>
</body>
</html>