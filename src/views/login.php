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
if (isset($_SESSION['flashdata'])) {
  echo '<div class="mensaje-ok">' . htmlspecialchars($_SESSION['flashdata']) . '</div>';
  unset($_SESSION['flashdata']);
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
  
<label for="remember">Recuérdame:</label>
<input type="checkbox" id="remember" name="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>><br><br>

  <button type="submit">Acceder</button>
  </form>

  <p class="enlace-registro enlace-login">&#191;A&#250;n no tienes cuenta? <br> <a href="./registro.html">Reg&#237;strate aqu&#237;</a></p>
</div></form>