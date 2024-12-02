<?php
function validateAnuncio($data) {
    $errors = [];

    if (strlen(trim($data['titulo'])) < 5 || strlen(trim($data['titulo'])) > 100) {
        $errors['titulo'] = 'El título debe tener entre 5 y 100 caracteres.';
    }

    if (strlen(trim($data['descripcion'])) < 10 || strlen(trim($data['descripcion'])) > 255) {
        $errors['descripcion'] = 'La descripción debe tener entre 10 y 255 caracteres.';
    }

    if ($data['precio'] <= 0) {
        $errors['precio'] = 'El precio debe ser un número positivo.';
    }

    if (empty($data['ciudad'])) {
        $errors['ciudad'] = 'La ciudad es obligatoria.';
    }

    if (empty($data['pais'])) {
        $errors['pais'] = 'El país es obligatorio.';
    }

    if ($data['superficie'] <= 0) {
        $errors['superficie'] = 'La superficie debe ser un número positivo.';
    }

    if ($data['habitaciones'] <= 0) {
        $errors['habitaciones'] = 'El número de habitaciones debe ser un número positivo.';
    }

    if ($data['aseos'] <= 0) {
        $errors['aseos'] = 'El número de aseos debe ser un número positivo.';
    }

    if ($data['planta'] < 0) {
        $errors['planta'] = 'La planta debe ser un número no negativo.';
    }

    if ($data['anyo_construccion'] <= 0) {
        $errors['anyo_construccion'] = 'El año de construcción debe ser un número positivo.';
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateAnuncio($_POST);

    if (empty($errors)) {
        $url = "/mandar-modificar-anuncio/" . $anuncio['id'];
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($_POST),
            ],
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            echo "<script>alert('Error al modificar el anuncio.');</script>";
        } else {
            header("Location: /anuncio/" . $anuncio['id']);
            exit();
        }
    } else {
        $errorMessages = implode("\\n", $errors);
        echo "<script>alert('Errores:\\n{$errorMessages}');</script>";
    }
}
?>

<h2>Modificar Anuncio</h2>
<div class="login-container">
<form action="/mandar-modificar-anuncio/<?php echo $anuncio['id']; ?>" method="post" enctype="multipart/form-data">
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($anuncio['titulo']); ?>" required>
    <br>
    <span style="color:red;"><?php echo $errors['titulo'] ?? '' ?></span><br><br>

    <label for="tipo_anuncio">Tipo de Anuncio:</label>
    <select id="tipo_anuncio" name="tipo_anuncio" required>
        <?php foreach ($tipos_anuncio as $tipo_anuncio): ?>
            <option value="<?php echo $tipo_anuncio['id']; ?>" <?php echo $tipo_anuncio['id'] == $anuncio['tipo_anuncio'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($tipo_anuncio['nombre']); ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="tipo_vivienda">Tipo de Vivienda:</label>
    <select id="tipo_vivienda" name="tipo_vivienda" required>
        <?php foreach ($tipos_vivienda as $tipo_vivienda): ?>
            <option value="<?php echo $tipo_vivienda['id']; ?>" <?php echo $tipo_vivienda['id'] == $anuncio['tipo_vivienda'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($tipo_vivienda['nombre']); ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    
    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" rows="4" minlength="10" maxlength="255" required><?php echo htmlspecialchars($anuncio['descripcion']); ?></textarea>
    <br>
    <span style="color:red;"><?php echo $errors['descripcion'] ?? '' ?></span><br><br>

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($anuncio['precio']); ?>" required>
    <br>
    <span style="color:red;"><?php echo $errors['precio'] ?? '' ?></span><br><br>

    <label for="ciudad">Ciudad:</label>
    <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($anuncio['ciudad']); ?>" required>
    <br>
    <span style="color:red;"><?php echo $errors['ciudad'] ?? '' ?></span><br><br>

    <label for="pais">País:</label>
    <select id="pais" name="pais" required>
        <?php foreach ($paises as $pais): ?>
            <option value="<?php echo htmlspecialchars($pais['pais']); ?>" <?php echo $pais['pais'] == $anuncio['pais'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($pais['pais']); ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <span style="color:red;"><?php echo $errors['pais'] ?? '' ?></span><br><br>

    <label for="superficie">Superficie (m²):</label>
    <input type="number" id="superficie" name="superficie" value="<?php echo htmlspecialchars($anuncio['superficie']); ?>" required>
    <br>
    <span style="color:red;"><?php echo $errors['superficie'] ?? '' ?></span><br><br>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="habitaciones" value="<?php echo htmlspecialchars($anuncio['habitaciones']); ?>" required>
    <br>
    <span style="color:red;"><?php echo $errors['habitaciones'] ?? '' ?></span><br><br>

    <label for="aseos">Aseos:</label>
    <input type="number" id="aseos" name="aseos" value="<?php echo htmlspecialchars($anuncio['aseos']); ?>" required>
    <br>
    <span style="color:red;"><?php echo $errors['aseos'] ?? '' ?></span><br><br>

    <label for="planta">Planta:</label>
    <input type="number" id="planta" name="planta" value="<?php echo htmlspecialchars($anuncio['planta']); ?>" required>
    <br>
    <span style="color:red;"><?php echo $errors['planta'] ?? '' ?></span><br><br>

    <label for="anyo_construccion">Año de Construcción:</label>
    <input type="number" id="anyo_construccion" name="anyo_construccion" value="<?php echo htmlspecialchars($anuncio['anyo_construccion']); ?>" required>
    <br>
    <span style="color:red;"><?php echo $errors['anyo_construccion'] ?? '' ?></span><br><br>

    <button type="submit">Modificar</button>
</form>
</div>