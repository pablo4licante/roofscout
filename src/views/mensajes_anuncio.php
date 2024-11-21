<h2>Mensajes recibidos para <?php echo $anuncio['titulo']?></h2>
<?php foreach ($mensajes as $mensaje): ?>
    <?php include './src/views/templates/mensaje.inc.php'; ?>
<?php endforeach; ?>

<button onclick="window.location.href='/anuncio/<?php echo $idAnuncio; ?>'">Volver</button>