<?php
$enviarMensaje = $_GET['enviarMensaje'] ?? false;
?>

<?php
if (isset($_SESSION['flashdata'])) {
    echo '<div class="mensaje-ok">' . htmlspecialchars($_SESSION['flashdata']) . '</div>';
    unset($_SESSION['flashdata']);
}
?>

<div id="photo_banner">
    <h2><?php echo $anuncio['titulo'] ?></h2>
    <p><?php  
    foreach ($tipos_vivienda as $tipo_vivienda) {
        if ($anuncio['tipo_vivienda'] == $tipo_vivienda['id']) {
            echo htmlspecialchars($tipo_vivienda['nombre']);
            break;
        }
    }?></p>
    <h3><?php echo $anuncio['ciudad'] ?>, <?php echo htmlspecialchars($anuncio['pais']) ?></h3>
    <?php if ($fotos): ?>
        <?php foreach ($fotos as $foto): ?>
            <?php if ($foto['principal']): ?>
                <img src="<?php echo $foto['url']; ?>" onclick="location.href='/foto/<?php echo $foto['id'] ?>'" alt="<?php echo $foto['alt']; ?>" class="publisher_img">
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="mensaje-error">
            <p>No hay foto principal.</p>
        </div>
    <?php endif; ?>
    <p><?php echo $anuncio['descripcion'] ?></p>

    <!-- Formateo de la fecha de YYYY-MM-DD a DD MM YYYY -->
    <p><?php echo date('d M Y', strtotime($anuncio['fecha_publi'])); ?></p>

    <?php foreach ($tipos_anuncio as $tipo_anuncio): ?>
                <?php if ($anuncio['tipo_anuncio'] == $tipo_anuncio['id']): ?>
                    <?php if ($tipo_anuncio['nombre'] == 'Alquiler'): ?>
                        <h3><?php echo number_format(htmlspecialchars($anuncio['precio']), 0, '', '.'); ?> &euro;/mes</h3>
                    <?php else: ?>
                        <h3><?php echo number_format(htmlspecialchars($anuncio['precio']), 0, '', '.'); ?> &euro;</h3>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>

    <p><?php echo $anuncio['habitaciones'] ?> Hab. | <?php echo $anuncio['aseos'] ?> Aseos | <?php echo $anuncio['superficie'] ?>m<sup>2</sup></p>

</div>

<div id="publisher_info">
    <img src="<?php echo $publicador['foto_perfil'] ?>" onclick="location.href='/perfil/<?php echo $publicador['email'] ?>'"
        class="publisher_img">
    <p><?php echo $publicador['nombre'] ?></p>

    <?php if ($publicador['email'] == $_SESSION['user']): ?>
        <button onclick="window.location.href='/agregar-foto/<?php echo $anuncio['id'] ?>'">Agregar Fotos</button>
        <button onclick="window.location.href='/mensajes-anuncio/<?php echo $anuncio['id'] ?>'">Ver mensajes de este anuncio</button>
        
        <button style="background-color:red; color:black;" onclick="window.location.href='/eliminar-anuncio/<?php echo $anuncio['id'] ?>'">Eliminar Anuncio</button>
    <?php else: ?>
        <div id="enviar-mensaje">
            <?php if ($enviarMensaje == false): ?>
                <button onclick="location.href='?enviarMensaje=true'">Enviar Mensaje</button>
            <?php else: ?>
                <form method="post" action="/enviar-mensaje">
                    <label for="tipo_mensaje">Tipo de Mensaje: </label>
                    <select name="tipo_mensaje" id="tipo_mensaje">
                        <?php foreach ($tipos_mensaje as $tipo_mensaje): ?>
                            <option value="<?php echo $tipo_mensaje['id']; ?>"><?php echo $tipo_mensaje['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select><br><br>
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" rows="4" cols="50" required></textarea>
                    <input type="hidden" name="anuncio_id" value="<?php echo $anuncio['id']; ?>">
                    <br>
                    <button type="submit">Enviar Mensaje</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>


<?php if ($fotos && count($fotos) > 0): ?>
    <div id="galeria_fotos">
        <h2>Galería de Fotos (<?php echo sizeof($fotos)?>)</h2>
        <div class="thumbnails">
            <?php foreach ($fotos as $foto): ?>
                <a href="/foto/<?php echo $foto['id']; ?>">
                    <img src="<?php echo $foto['url']; ?>" alt="<?php echo $foto['alt']; ?>" class="thumbnail">
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="photo-info-panel">
        <p>No hay mas fotos disponibles.</p>
    </div>
<?php endif; ?>