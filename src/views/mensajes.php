    <h2>Mensajes recibidos</h2>
    <?php foreach ($mensajes_recibidos as $mensaje): ?>
        <?php include './src/views/templates/mensaje.inc.php'; ?>
    <?php endforeach; ?>

    <h2>Mensajes enviados</h2>
    <?php foreach ($mensajes_enviados as $mensaje): ?>
        <?php include './src/views/templates/mensaje.inc.php'; ?>
    <?php endforeach; ?>
