<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Por favor, introduce un correo electrónico válido.";
    }

    if (empty($_POST['nombre']) || !preg_match('/^[a-zA-Z][a-zA-Z0-9]{2,14}$/', $_POST['nombre'])) {
        $errors['nombre'] = "El nombre de usuario debe tener entre 3 y 15 caracteres, solo contener letras y números, y no puede comenzar con un número.";
    }

    if (empty($_POST['password']) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d_-]{6,15}$/', $_POST['password'])) {
        $errors['password'] = "La contraseña debe tener entre 6 y 15 caracteres, contener al menos una letra mayúscula, una letra minúscula y un número, y solo puede contener letras, números, guiones y guiones bajos.";
    }

    if (empty($_POST['confirm_password']) || $_POST['confirm_password'] !== $_POST['password']) {
        $errors['confirm_password'] = "Las contraseñas no coinciden.";
    }

    if (empty($_POST['fecha_nacimiento']) || !validateFechaNacimiento($_POST['fecha_nacimiento'])) {
        $errors['fecha_nacimiento'] = "La fecha de nacimiento es obligatoria y debes tener al menos 18 años.";
    }

    if (empty($_POST['sexo'])) {
        $errors['sexo'] = "El sexo es obligatorio.";
    }

    if (empty($_POST['ciudad'])) {
        $errors['ciudad'] = "La ciudad es obligatoria.";
    }
    if (empty($_POST['pais'])) {
        $errors['pais'] = "El país es obligatorio.";
    }

    if (empty($errors)) {
        header('Location: /auth-registro', true, 307);
        exit;
    }
}

function validateFechaNacimiento($fecha_nacimiento) {
    $fecha_nacimientoDate = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimientoDate)->y;
    return $edad >= 18;
}

function getPostValue($field) {
    return isset($_POST[$field]) ? htmlspecialchars($_POST[$field]) : '';
}
?>


<h2>Registro</h2>
<form action="" method="post">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" placeholder="Email" value="<?= getPostValue('email') ?>">
    <br>
    <span style="color:red;"><?= $errors['email'] ?? '' ?></span><br><br>

    <label for="nombre">Nombre de usuario:</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre de usuario" value="<?= getPostValue('nombre') ?>">
    <br>
    <span style="color:red;"><?= $errors['nombre'] ?? '' ?></span><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" placeholder="Contraseña" value="<?= getPostValue('password') ?>">
    <br>
    <span style="color:red;"><?= $errors['password'] ?? '' ?></span><br><br>

    <label for="confirm_password">Repetir contraseña:</label>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Repetir contraseña" value="<?= getPostValue('confirm_password') ?>">
    <br>
    <span style="color:red;"><?= $errors['confirm_password'] ?? '' ?></span><br><br>

    <label for="sexo">Sexo:</label>
    <select id="sexo" name="sexo">
        <option value="" disabled <?= empty($_POST['sexo']) ? 'selected' : '' ?>>Seleccione su sexo</option>
        <option value="hombre" <?= isset($_POST['sexo']) && $_POST['sexo'] === 'hombre' ? 'selected' : '' ?>>Hombre</option>
        <option value="mujer" <?= isset($_POST['sexo']) && $_POST['sexo'] === 'mujer' ? 'selected' : '' ?>>Mujer</option>
        <option value="otros" <?= isset($_POST['sexo']) && $_POST['sexo'] === 'otros' ? 'selected' : '' ?>>Otros</option>
    </select>
    <br>
    <span style="color:red;"><?= $errors['sexo'] ?? '' ?></span><br><br>

    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $_POST['fecha_nacimiento'] ?? '' ?>">
    <br>
    <span style="color:red;"><?= $errors['fecha_nacimiento'] ?? '' ?></span><br><br>

    <label for="ciudad">Ciudad:</label>
    <select name="ciudad" id="ciudad">
        <option value="" disabled <?= empty($_POST['ciudad']) ? 'selected' : '' ?>>Seleccione su ciudad</option>
        <option value="madrid" <?= isset($_POST['ciudad']) && $_POST['ciudad'] === 'madrid' ? 'selected' : '' ?>>Madrid</option>
        <option value="barcelona" <?= isset($_POST['ciudad']) && $_POST['ciudad'] === 'barcelona' ? 'selected' : '' ?>>Barcelona</option>
        <option value="valencia" <?= isset($_POST['ciudad']) && $_POST['ciudad'] === 'valencia' ? 'selected' : '' ?>>Valencia</option>
        <option value="sevilla" <?= isset($_POST['ciudad']) && $_POST['ciudad'] === 'sevilla' ? 'selected' : '' ?>>Sevilla</option>
        <option value="zaragoza" <?= isset($_POST['ciudad']) && $_POST['ciudad'] === 'zaragoza' ? 'selected' : '' ?>>Zaragoza</option>
        <option value="malaga" <?= isset($_POST['ciudad']) && $_POST['ciudad'] === 'malaga' ? 'selected' : '' ?>>Málaga</option>
        <option value="murcia" <?= isset($_POST['ciudad']) && $_POST['ciudad'] === 'murcia' ? 'selected' : '' ?>>Murcia</option>
        <option value="palma" <?= isset($_POST['ciudad']) && $_POST['ciudad'] === 'palma' ? 'selected' : '' ?>>Palma</option>
        <option value="bilbao" <?= isset($_POST['ciudad']) && $_POST['ciudad'] === 'bilbao' ? 'selected' : '' ?>>Bilbao</option>
        <option value="alicante" <?= isset($_POST['ciudad']) && $_POST['ciudad'] === 'alicante' ? 'selected' : '' ?>>Alicante</option>
    </select>
    <br>
    <span style="color:red;"><?= $errors['ciudad'] ?? '' ?></span><br><br>

    <label for="pais">País:</label>
    <select name="pais" id="pais">
        <option value="" disabled <?= empty($_POST['pais']) ? 'selected' : '' ?>>Seleccione su país</option>
        <option value="espana" <?= isset($_POST['pais']) && $_POST['pais'] === 'espana' ? 'selected' : '' ?>>España</option>
        <option value="francia" <?= isset($_POST['pais']) && $_POST['pais'] === 'francia' ? 'selected' : '' ?>>Francia</option>
        <option value="alemania" <?= isset($_POST['pais']) && $_POST['pais'] === 'alemania' ? 'selected' : '' ?>>Alemania</option>
        <option value="italia" <?= isset($_POST['pais']) && $_POST['pais'] === 'italia' ? 'selected' : '' ?>>Italia</option>
        <option value="portugal" <?= isset($_POST['pais']) && $_POST['pais'] === 'portugal' ? 'selected' : '' ?>>Portugal</option>
        <option value="reino_unido" <?= isset($_POST['pais']) && $_POST['pais'] === 'reino_unido' ? 'selected' : '' ?>>Reino Unido</option>
        <option value="estados_unidos" <?= isset($_POST['pais']) && $_POST['pais'] === 'estados_unidos' ? 'selected' : '' ?>>Estados Unidos</option>
        <option value="canada" <?= isset($_POST['pais']) && $_POST['pais'] === 'canada' ? 'selected' : '' ?>>Canadá</option>
        <option value="mexico" <?= isset($_POST['pais']) && $_POST['pais'] === 'mexico' ? 'selected' : '' ?>>México</option>
        <option value="argentina" <?= isset($_POST['pais']) && $_POST['pais'] === 'argentina' ? 'selected' : '' ?>>Argentina</option>
    </select>
    <br>
    <span style="color:red;"><?= $errors['pais'] ?? '' ?></span><br><br>
    
    <label for="foto_perfil">Foto de perfil:</label>
    <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">
    <br>
    <span style="color:red;"><?= $errors['foto_perfil'] ?? '' ?></span><br><br>
    
    <button type="submit">Crear cuenta</button>
</form>