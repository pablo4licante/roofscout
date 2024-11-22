<h2>Mensajes recibidos para <?php echo $anuncio['titulo']?> (<?php echo sizeof($mensajes)?>)</h2>
<div class="galeria">
<?php foreach ($mensajes as $mensaje): ?>
    <?php include './src/views/templates/mensaje.inc.php'; ?>
<?php endforeach; ?>
<?php if (sizeof($mensajes) == 0): ?>
    <div class="mensaje-ok">No hay mensajes</div>
<?php endif; ?>
</div>

<button onclick="window.location.href='/anuncio/<?php echo $idAnuncio; ?>'">Volver</button>