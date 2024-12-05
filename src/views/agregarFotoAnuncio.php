<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valid = true;
    $errors = [];

    foreach ($_FILES['new_images']['name'] as $index => $name) {
        $title = trim($_POST['new_image_titles'][$index]);
        $alt = trim($_POST['new_image_alts'][$index]);

        if ($_FILES['new_images']['error'][$index] !== UPLOAD_ERR_OK) {
            $errors[] = "Error al subir la imagen en la tarjeta " . ($index + 1) . ".";
            $valid = false;
        } elseif (empty($name)) {
            $errors[] = "La imagen en la tarjeta " . ($index + 1) . " es obligatoria.";
            $valid = false;
        } elseif (empty($title)) {
            $errors[] = "El título en la tarjeta " . ($index + 1) . " es obligatorio.";
            $valid = false;
        } elseif (empty($alt) || strlen($alt) < 10 || preg_match('/^(foto|imagen)/i', $alt)) {
            $errors[] = "El texto alternativo en la tarjeta " . ($index + 1) . " es obligatorio, debe tener al menos 10 caracteres y no puede comenzar con 'foto' o 'imagen'.";
            $valid = false;
        }
    }

    if ($valid) {
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
            foreach ($_FILES['new_images']['tmp_name'] as $index => $tmpName) {
                if (!file_exists($tmpName) || !is_readable($tmpName)) {
                    $errors[] = "El archivo temporal no existe o no es legible para la imagen " . ($index + 1) . ".";
                    continue;
                }
        
                $destination = '/roofscout.one/htdocs/images/' . basename($_FILES['new_images']['name'][$index]);
                $fileHandle = fopen($tmpName, 'rb');
        
                if ($fileHandle === false) {
                    $errors[] = "No se pudo abrir el archivo temporal para la imagen " . ($index + 1) . ".";
                    continue;
                }
        
                if (ftp_fput($ftp_conn, $destination, $fileHandle, FTP_BINARY)) {
                    echo "<script>console.log('File " . basename($_FILES['new_images']['name'][$index]) . " uploaded correctly!');</script>";

                    $controller = new AnuncioController();
                    $controller->agregarFotoDB($anuncio['id'], $title, $alt, "https://roofscout.one/images/" . basename($_FILES['new_images']['name'][$index]));
                } else {
                    $errors[] = "Error al subir la imagen " . ($index + 1) . " al servidor FTP.";
                }
        
                fclose($fileHandle);
            }
            ftp_close($ftp_conn);
        }
        
        if (empty($errors)) {
            $_SESSION['flashdata'] = 'Imágenes subidas correctamente.';
            header('Location: /anuncio/' . $anuncio['id']);
            exit;
        }
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="mensaje-error">' . htmlspecialchars($error) . '</div>';
        }
    }
}

if (isset($_SESSION['flashdata'])) {
    echo '<div class="mensaje-ok">' . htmlspecialchars($_SESSION['flashdata']) . '</div>';
    unset($_SESSION['flashdata']);
}
?>

<h3>Agregar Fotos</h3>

<div id="agregar-fotos-panels">
    <div class="login-container">
        <form>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo $anuncio['titulo'] ?>" disabled>
            <br>

            <label for="tipo_anuncio">Tipo de Anuncio:</label>
            <select id="tipo_anuncio" name="tipo_anuncio" required disabled>
                <?php foreach ($tipos_anuncio as $tipo_anuncio): ?>
                    <option value="<?php echo $tipo_anuncio['id']; ?>" <?php echo ($anuncio['tipo_anuncio'] == $tipo_anuncio['id']) ? 'selected' : ''; ?>>
                        <?php echo $tipo_anuncio['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <label for="tipo_vivienda">Tipo de Vivienda:</label>
            <select id="tipo_vivienda" name="tipo_vivienda" required disabled>
                <option value="<?php echo $anuncio['tipo_vivienda'] ?>">Seleccione un tipo de vivienda</option>
                <?php foreach ($tipos_vivienda as $tipo_vivienda): ?>
                    <option value="<?php echo $tipo_vivienda['id']; ?>" <?php echo ($anuncio['tipo_vivienda'] == $tipo_vivienda['id']) ? 'selected' : ''; ?>>
                        <?php echo $tipo_vivienda['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required
                disabled><?php echo $anuncio['descripcion'] ?></textarea>
            <br>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" value="<?php echo $anuncio['precio'] ?>" required disabled>
            <br>

            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" value="<?php echo $anuncio['ciudad'] ?>" required disabled>
            <br>

            <label for="pais">País:</label>
            <select id="pais" name="pais" required disabled>
                <option value="">Seleccione un país</option>
                <?php foreach ($paises as $pais): ?>
                    <option value="<?php echo $pais['pais']; ?>" <?php echo ($anuncio['pais'] == $pais['pais']) ? 'selected' : ''; ?>><?php echo $pais['pais']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <label for="superficie">Superficie (m²):</label>
            <input type="number" id="superficie" name="superficie" value="<?php echo $anuncio['superficie'] ?>" required
                disabled>
            <br>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" value="<?php echo $anuncio['habitaciones'] ?>"
                required disabled>
            <br>

            <label for="aseos">Aseos:</label>
            <input type="number" id="aseos" name="aseos" value="<?php echo $anuncio['aseos'] ?>" required disabled>
            <br>

            <label for="planta">Planta:</label>
            <input type="number" id="planta" name="planta" value="<?php echo $anuncio['planta'] ?>" required disabled>
            <br>

            <label for="anyo_construccion">Año de Construcción:</label>
            <input type="number" id="anyo_construccion" name="anyo_construccion"
                value="<?php echo $anuncio['anyo_construccion'] ?>" required disabled>
            <br>
        </form>
    </div>

    <div class="login-container">
        <form method="POST" id="formulario-de-fotos" enctype="multipart/form-data">
            <h4>Nuevas Imágenes</h4>
            <div id="image-cards-container">
            </div>
            <button type="button" id="add-image-card">Agregar Imagen</button>
            <button type="submit" form="formulario-de-fotos" id="post-image-card">Subir Imágenes</button>

        </form>
    </div>
</div>
<script>
    document.getElementById('add-image-card').addEventListener('click', function () {
        const container = document.getElementById('image-cards-container');
        const cardCount = container.children.length;
        const newCard = document.createElement('div');
        newCard.classList.add('image-card');
        newCard.innerHTML = `
        <div>
        <label for="new-image-${cardCount}">Nueva Imagen:</label>
        <button type="button" class="delete-image-card-button">X</button>
        </div>
        <input type="file" id="new-image-${cardCount}" name="new_images[]" accept="image/*" required onchange="displayImage(event, ${cardCount})">
        <img id="image-preview-${cardCount}" src="#" alt="Image Preview" style="display:none; max-width: 200px; max-height: 200px;"/>
        <label for="new-image-title-${cardCount}">Título:</label>
        <input type="text" id="new-image-title-${cardCount}" name="new_image_titles[]" required>
        <label for="new-image-alt-${cardCount}">Texto Alternativo:</label>
        <input type="text" id="new-image-alt-${cardCount}" name="new_image_alts[]" required>
        `;
        const deleteButton = newCard.querySelector('.delete-image-card-button');
        deleteButton.addEventListener('click', function () {
            container.removeChild(newCard);
            updateImageCardIds();
        });
        newCard.querySelector('input[type="file"]').setAttribute('accept', 'image/png, image/jpeg, image/jpg, image/webp');
        container.appendChild(newCard);
    });

    function displayImage(event, cardCount) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById(`image-preview-${cardCount}`);
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function updateImageCardIds() {
        const container = document.getElementById('image-cards-container');
        const cards = container.children;
        for (let i = 0; i < cards.length; i++) {
            const card = cards[i];
            card.querySelector('label[for^="new-image-"]').setAttribute('for', `new-image-${i}`);
            card.querySelector('input[type="file"]').setAttribute('id', `new-image-${i}`);
            card.querySelector('input[type="file"]').setAttribute('onchange', `displayImage(event, ${i})`);
            card.querySelector('img').setAttribute('id', `image-preview-${i}`);
            card.querySelector('label[for^="new-image-title-"]').setAttribute('for', `new-image-title-${i}`);
            card.querySelector('input[name="new_image_titles[]"]').setAttribute('id', `new-image-title-${i}`);
            card.querySelector('label[for^="new-image-alt-"]').setAttribute('for', `new-image-alt-${i}`);
            card.querySelector('input[name="new_image_alts[]"]').setAttribute('id', `new-image-alt-${i}`);
        }
    }
</script>