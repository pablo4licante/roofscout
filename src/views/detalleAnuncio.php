<?php
    $tipo_mensaje = ["Mas informacion", "Solicitar cita", "Hacer oferta"];

    if(isset($_POST['botonMostrar'])) {
        $enviarMensaje = true;
    }
?>

<div id="photo_banner">
    <h2><?php echo $anuncio['titulo'] ?></h2>
    <p><?php echo $anuncio['tipo_vivienda'] ?></p>
    <h3><?php echo $anuncio['ciudad'] ?>, <?php echo htmlspecialchars($anuncio['pais'])?></h3>
    <img src="/src/assets/images/11.jpg" alt="Foto principal">
    <p><?php echo $anuncio['descripcion'] ?></p>
    
    <!-- Formateo de la fecha de YYYY-MM-DD a DD MM YYYY -->
    <p><?php echo date('d M Y', strtotime($anuncio['fecha_publi'])); ?></p>


    <?php if ($anuncio['tipo_anuncio'] == 'Alquiler'): ?>
        <h3><?php echo number_format(htmlspecialchars($anuncio['precio']), 0, '', '.'); ?> &euro;/mes</h3>
    <?php else: ?>
        <h3><?php echo number_format(htmlspecialchars($anuncio['precio']), 0, '', '.'); ?> &euro;</h3>
    <?php endif; ?>


    <p><?php echo $anuncio['habitaciones'] ?> Hab. | <?php echo $anuncio['aseos'] ?> Aseos | <?php echo $anuncio['superficie'] ?>m<sup>2</sup></p>

</div>

<div id="publisher_info">
    <img src="https://picsum.photos/200" onclick="location.href='./perfil.html'" alt="Foto del Publicador"
        class="publisher_img">
    <p><?php echo $publicador['nombre'] ?></p>
    <div id="enviar-mensaje">
        <?php
        if ($enviarMensaje == false): ?>
            <input type="submit" name="botonMostrar" value="Enviar mensaje"/>
        <?php else: ?>
            <form method="post">
                <label for="tipo_mensaje">Tipo de Mensaje: </label>
                <select name="tipo_mensaje" id="tipo_mensaje">
                    <?php foreach ($tipo_mensaje as $label): ?>
                        <option value="<?php echo $label; ?>"><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                <label for="message">Mensaje:</label>
                <textarea id="message" name="message" rows="4" cols="50" required></textarea>
                <br>
                <input type="submit" value="Enviar Mensaje"/>
            </form>
        <?php endif; ?>  
    </div>
</div>


<div id="galeria_fotos">
    <h3>Galería de Fotos</h3>
    <div class="thumbnails">
        <img src="/src/assets/images/1.jpg" alt="Thumbnail 1" class="thumbnail">
        <img src="/src/assets/images/2.jpg" alt="Thumbnail 2" class="thumbnail">
        <img src="/src/assets/images/3.jpg" alt="Thumbnail 3" class="thumbnail">
        <img src="/src/assets/images/5.jpg" alt="Thumbnail 4" class="thumbnail">
    </div>
</div>