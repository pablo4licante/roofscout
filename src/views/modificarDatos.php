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
        header('Location: /auth-modificar', true, 307);
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


<h2>Mis datos</h2>
<form action="" method="post" enctype="multipart/form-data">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" placeholder="Email" value="<?= getPostValue('email') ?? htmlspecialchars($usuario['email'] ?? '') ?>">
    <br>
    <span style="color:red;"><?= $errors['email'] ?? '' ?></span><br><br>

    <label for="nombre">Nombre de usuario:</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre de usuario" value="<?= getPostValue('nombre') ?? htmlspecialchars($usuario['nombre'] ?? '') ?>">
    <br>
    <span style="color:red;"><?= $errors['nombre'] ?? '' ?></span><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" placeholder="Contraseña">
    <br>
    <span style="color:red;"><?= $errors['password'] ?? '' ?></span><br><br>

    <label for="confirm_password">Repetir contraseña:</label>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Repetir contraseña">
    <br>
    <span style="color:red;"><?= $errors['confirm_password'] ?? '' ?></span><br><br>

    <label for="sexo">Sexo:</label>
    <select id="sexo" name="sexo">
        <option value="" disabled <?= empty(getPostValue('sexo')) && empty($usuario['sexo']) ? 'selected' : '' ?>>Seleccione su sexo</option>
        <option value="hombre" <?= getPostValue('sexo') === 'hombre' || ($usuario['sexo'] ?? '') === 'hombre' ? 'selected' : '' ?>>Hombre</option>
        <option value="mujer" <?= getPostValue('sexo') === 'mujer' || ($usuario['sexo'] ?? '') === 'mujer' ? 'selected' : '' ?>>Mujer</option>
        <option value="otros" <?= getPostValue('sexo') === 'otros' || ($usuario['sexo'] ?? '') === 'otros' ? 'selected' : '' ?>>Otros</option>
    </select>
    <br>
    <span style="color:red;"><?= $errors['sexo'] ?? '' ?></span><br><br>

    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= getPostValue('fecha_nacimiento') ?? htmlspecialchars($usuario['fecha_nacimiento'] ?? '') ?>">
    <br>
    <span style="color:red;"><?= $errors['fecha_nacimiento'] ?? '' ?></span><br><br>

    <label for="pais">País:</label>
    <select name="pais" id="pais">
        <option value="" disabled <?= empty(getPostValue('pais')) && empty($usuario['pais']) ? 'selected' : '' ?>>Seleccione su país</option>
        <?php foreach ($paises as $pais): ?>
            <option value="<?= htmlspecialchars($pais['nombre']) ?>" <?= getPostValue('pais') === $pais['nombre'] || ($usuario['pais'] ?? '') === $pais['nombre'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($pais['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>
    <span style="color:red;"><?= $errors['pais'] ?? '' ?></span><br><br>

    <label for="ciudad">Ciudad:</label>
    <input type="text" name="ciudad" id="ciudad" value="<?= getPostValue('ciudad') ?? htmlspecialchars($usuario['ciudad'] ?? '') ?>">
    <br>
    <span style="color:red;"><?= $errors['ciudad'] ?? '' ?></span><br><br>

    <label for="foto_perfil">Foto de perfil:</label>
    <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">
    <br>
    <span style="color:red;"><?= $errors['foto_perfil'] ?? '' ?></span><br><br>

    <button type="submit">Actualizar datos</button>
</form>
