<h2>Mensajes recibidos (<?php echo sizeof($mensajes_recibidos)?>)</h2>
<div class="galeria">
<?php foreach ($mensajes_recibidos as $mensaje): ?>
    <?php include './src/views/templates/mensaje.inc.php'; ?>
<?php endforeach; ?>

<?php if (sizeof($mensajes_recibidos) == 0): ?>
    <div class="mensaje-ok">No hay mensajes</div>
<?php endif; ?>
</div>
<h2>Mensajes enviados (<?php echo sizeof($mensajes_enviados)?>)</h2>
<div class="galeria">
<?php foreach ($mensajes_enviados as $mensaje): ?>
    <?php include './src/views/templates/mensaje.inc.php'; ?>
<?php endforeach; ?>
<?php if (sizeof($mensajes_enviados) == 0): ?>
    <div class="mensaje-ok">No hay mensajes</div>
<?php endif; ?>
</div>
