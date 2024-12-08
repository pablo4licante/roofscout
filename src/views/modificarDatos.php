<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (empty($_POST['nombre']) || !preg_match('/^[a-zA-Z][a-zA-Z0-9]{2,14}$/', $_POST['nombre'])) {
        $errors['nombre'] = "El nombre de usuario debe tener entre 3 y 15 caracteres, solo contener letras y números, y no puede comenzar con un número.";
    }

    if (!empty($_POST['password']) && !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d_-]{6,15}$/', $_POST['password'])) {
        $errors['password'] = "La contraseña debe tener entre 6 y 15 caracteres, contener al menos una letra mayúscula, una letra minúscula y un número, y solo puede contener letras, números, guiones y guiones bajos.";
    }

    if (!empty($_POST['new_password']) && !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d_-]{6,15}$/', $_POST['new_password'])) {
        $errors['new_password'] = "La nueva contraseña debe tener entre 6 y 15 caracteres, contener al menos una letra mayúscula, una letra minúscula y un número, y solo puede contener letras, números, guiones y guiones bajos.";
    }

    if (!empty($_POST['confirm_new_password']) && $_POST['confirm_new_password'] !== $_POST['new_password']) {
        $errors['confirm_new_password'] = "Las contraseñas no coinciden.";
    }

    if (!empty($_POST['new_password']) && $_POST['confirm_new_password'] !== $_POST['new_password']) {
        $errors['new_password'] = "Las contraseñas no coinciden.";
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


    if (!empty($errors)) {
        $errorMessages = implode("\\n", $errors);
        echo "<script>alert('Errores:\\n{$errorMessages}');</script>";
    }

    
    if (empty($errors)) {
        if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
    
            $fileTmpPath = $_FILES['new_image']['tmp_name'];
    
            $ftp_server = "ftpupload.net";
            $ftp_username = "if0_37316886";
            $ftp_password = "jQFsQZWSRwmZgfj";
    
            // Conectar al servidor FTP
            $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
            ftp_set_option($ftp_conn, FTP_TIMEOUT_SEC, 300); // Set timeout to 5 minutes
    
            // Iniciar sesión
            $login = ftp_login($ftp_conn, $ftp_username, $ftp_password);
    
            if (!$login) {
                $errors[] = "Error al conectar con el servidor FTP.";
            } else {
                // Activar modo pasivo
                ftp_pasv($ftp_conn, true); // Activar el modo pasivo
                if (!file_exists($fileTmpPath) || !is_readable($fileTmpPath)) {
                    $errors[] = "El archivo temporal no existe o no es legible para la imagen.";
                } else {
    
                    $timestamp = time();
                    $user = $_SESSION['user'];
                    $originalName = pathinfo($_FILES['new_image']['name'], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES['new_image']['name'], PATHINFO_EXTENSION);
                    $newFileName = "{$originalName}_{$timestamp}_{$user}.{$extension}";
                    $destination = "/roofscout.one/htdocs/images/{$newFileName}";
                    $fileHandle = fopen($fileTmpPath, 'rb');
                    
                    if ($fileHandle === false) {
                        $errors[] = "No se pudo abrir el archivo temporal para la imagen.";
                    } else {
                        
                        if (ftp_fput($ftp_conn, $destination, $fileHandle, FTP_BINARY)) {
                            $_SESSION['foto_perfil'] = "https://roofscout.one/images/{$newFileName}";
                        } else {
                            $errors[] = "Error al subir la imagen al servidor FTP.";
                        }
                    }
                    fclose($fileHandle);
                }
            }
            ftp_close($ftp_conn);
        }
        header('Location: /auth-modificar', true, 307);
        exit;
    }
}

function validateFechaNacimiento($fecha_nacimiento)
{
    $fecha_nacimientoDate = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimientoDate)->y;
    return $edad >= 18;
}
?>

<h2>Mis datos</h2>
<div class="login-container">
    <form action="" method="post" enctype="multipart/form-data">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" placeholder="Email"
            value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" disabled>
        <br>
        <span style="color:red;"><?= $errors['email'] ?? '' ?></span><br><br>

        <label for="nombre">Nombre de usuario:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre de usuario"
            value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>">
        <br>
        <span style="color:red;"><?= $errors['nombre'] ?? '' ?></span><br><br>

        <label for="password">Contraseña actual:</label>
        <input type="password" id="password" name="password" placeholder="Contraseña actual">
        <br>
        <span style="color:red;"><?= $errors['password'] ?? '' ?></span><br><br>


        <label for="password">Nueva Contraseña:</label>
        <input type="password" id="new_password" name="new_password" placeholder="Contraseña nueva">
        <br>
        <span style="color:red;"><?= $errors['new_password'] ?? '' ?></span><br><br>

        <label for="confirm_password">Repetir nueva contraseña:</label>
        <input type="password" id="confirm_new_password" name="confirm_new_password"
            placeholder="Repetir contraseña nueva">
        <br>
        <span style="color:red;"><?= $errors['confirm_new_password'] ?? '' ?></span><br><br>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo">
            <option value="" disabled <?= empty($usuario['sexo']) ? 'selected' : '' ?>>Seleccione su sexo</option>
            <option value="hombre" <?= ($usuario['sexo'] ?? '') === 'hombre' ? 'selected' : '' ?>>Hombre</option>
            <option value="mujer" <?= ($usuario['sexo'] ?? '') === 'mujer' ? 'selected' : '' ?>>Mujer</option>
            <option value="otros" <?= ($usuario['sexo'] ?? '') === 'otros' ? 'selected' : '' ?>>Otros</option>
        </select>
        <br>
        <span style="color:red;"><?= $errors['sexo'] ?? '' ?></span><br><br>

        <label for="fecha_nacimiento">Fecha de nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
            value="<?= htmlspecialchars($usuario['fecha_nacimiento'] ?? '') ?>">
        <br>
        <span style="color:red;"><?= $errors['fecha_nacimiento'] ?? '' ?></span><br><br>

        <label for="pais">País:</label>
        <select name="pais" id="pais">
            <option value="" disabled <?= empty($usuario['pais']) ? 'selected' : '' ?>>Seleccione su país</option>
            <?php foreach ($paises as $pais): ?>
                <option value="<?php echo $pais['pais'] ?>" <?= ($usuario['pais'] ?? '') === $pais['pais'] ? 'selected' : '' ?>>
                    <?php echo $pais['pais'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <span style="color:red;"><?= $errors['pais'] ?? '' ?></span><br><br>

        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" value="<?= htmlspecialchars($usuario['ciudad'] ?? '') ?>">
        <br>
        <span style="color:red;"><?= $errors['ciudad'] ?? '' ?></span><br><br>

        <label for="foto_perfil">Foto de perfil:</label>
        <input type="file" id="new_image" name="new_image" accept="image/*" onchange="displayImage(event)">
        <input type="hidden" name="foto_perfil" value="<?= htmlspecialchars($_SESSION['foto_perfil'] ?? '') ?>">
        <img id="image-preview" src="#" alt="Image Preview"
            style="display:none; max-width: 200px; max-height: 200px;" />
        <br>
        <span style="color:red;"><?= $errors['foto_perfil'] ?? '' ?></span><br><br>
        <button style="background-color:red;" onclick="window.location.href='/eliminar-foto-perfil'; return false;">Eliminar Foto de Perfil Actual</button>

        <button type="submit">Actualizar datos</button>
    </form>

</div>

<script>
    function displayImage(event, cardCount) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById(`image-preview`);
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>