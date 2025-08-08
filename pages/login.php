<?php
session_start();
define('USERS_FILE', __DIR__ . '/../JSON/login.json');


if (!file_exists(USERS_FILE)) {
    file_put_contents(USERS_FILE, json_encode([]));
}

$users = json_decode(file_get_contents(USERS_FILE), true) ?? [];
$error = "";
$success = "";


if (isset($_POST['register'])) {
    $id       = time();
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $pass     = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fotoPath = 'IMG/default.jpg'; 

    if (!empty($_FILES['photo']['tmp_name'])) {
        $ext      = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $fotoPath = 'IMG/' . $id . '.' . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . '/../' . $fotoPath);
    }

    $users[] = [
        'id'       => $id,
        'user'     => $username,
        'mail'     => $email,
        'password' => $pass,
        'photo'    => $fotoPath
    ];
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
    $success = '¡Registro exitoso!';
}


if (isset($_POST['login'])) {
    $inputUser = trim($_POST['username']);
    $inputPass = $_POST['password'];
    foreach ($users as $u) {
        if (($u['user'] === $inputUser || $u['mail'] === $inputUser)
            && password_verify($inputPass, $u['password'])) {
            $_SESSION['user']  = $u['user'];
            $_SESSION['photo'] = $u['photo'];
            $_SESSION['id']    = $u['id'];
            header('Location: ../index.php');
            exit;
        }
    }
    $error = 'Usuario o contraseña incorrectos';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>To Do List | Login</title>
  <link rel="stylesheet" href="../CSS/login.css">
  <script defer src="../JS/index.js"></script>
</head>
<body class="login-page">
  <header class="login-header">
    <h1>To Do List</h1>
  </header>

  <?php if ($error): ?>
    <div class="alert error-alert"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert success-alert"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <div class="form-container">
    <form id="registerForm" method="POST" enctype="multipart/form-data" class="card slide-in">
      <h2>Registrarse</h2>
      <input type="text" name="username" placeholder="Usuario" required>
      <input type="email" name="email" placeholder="Correo" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <input type="file" name="photo" accept="image/*">
      <button type="submit" name="register">Crear cuenta</button>
    </form>

    <form id="loginForm" method="POST" class="card slide-in delay">
      <h2>Iniciar sesión</h2>
      <input type="text" name="username" placeholder="Usuario o correo" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button type="submit" name="login">Login</button>
    </form>
  </div>
</body>
</html>