<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Por favor, introduce un correo electrónico válido.";
  }

  if (empty($_POST['password'])) {
    $errors['password'] = "La contraseña es obligatoria.";
  }

  if (empty($errors)) {
    // Aquí puedes agregar la lógica para autenticar al usuario
    header('Location: /auth-login', true, 307);
    exit;
  }
}
?>


<h2>Inicio de Sesión</h2>

<?php
if (isset($_GET['registered']) && $_GET['registered'] === 'true') {
  echo '<div class="mensaje-ok">Registro exitoso. Ahora puedes iniciar sesión.</div>';
}
?>

<?php
if (isset($_GET['error']) && $_GET['error'] === 'true') {
  echo '<div class="mensaje-error">Usuario o contrase&ntilde;a incorrectos.</div>';
}
?>

<div class="login-container">
  <form action="" method="post">
  <label for="email">Email:</label>
  <input type="text" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br>
  <span style="color:red;"><?= $errors['email'] ?? '' ?></span><br><br>
  
  <label for="password">Contrase&ntilde;a:</label>
  <input type="password" id="password" name="password" placeholder="Contrase&ntilde;a" value="<?= htmlspecialchars($_POST['password'] ?? '') ?>"><br>
  <span style="color:red;"><?= $errors['password'] ?? '' ?></span><br><br>
  
  <button type="submit">Acceder</button>
  </form>

  <p class="enlace-registro enlace-login">&#191;A&#250;n no tienes cuenta? <br> <a href="./registro.html">Reg&#237;strate aqu&#237;</a></p>
</div></form>