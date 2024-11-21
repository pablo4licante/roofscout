<?php
    $anuncio = Anuncio::getAnuncio($mensaje['anuncio']);
    $titulo_anuncio = $anuncio ? htmlspecialchars($anuncio['titulo']) : 'Anuncio no encontrado';
?>

<div class="mensaje">
    <img src="https://picsum.photos/50" alt="Foto del Usuario" class="user-img">
    <div class="mensaje-info">
        <p><strong><?= $titulo_anuncio ?></strong></p>
        <p><strong>Emisor:</strong> <?= htmlspecialchars($mensaje['emisor']) ?></p>
        <p><strong>Fecha del mensaje:</strong> <?= htmlspecialchars($mensaje['fecha_hora']) ?></p>
        <?php foreach ($tipos_mensaje as $tipo_mensaje): ?>
            <?php if ($tipo_mensaje['id'] == $mensaje['tipo_mensaje']): ?>
                <p><strong>Tipo de Mensaje:</strong> <?= htmlspecialchars($tipo_mensaje['nombre']) ?></p>
                <?php endif; ?>
                <?php endforeach; ?>
        <p><strong>Mensaje:</strong> <?= htmlspecialchars($mensaje['mensaje']) ?></p>
        <?php if($mensaje['emisor'] == $_SESSION['user']):?>
        <button onclick="window.location.href='/anuncio/<?php echo $mensaje['anuncio'] ?>'">Ver Anuncio</button>
        <?php else:?>
        <button onclick="window.location.href='/ver-anuncio/<?php echo $mensaje['anuncio'] ?>'">Ver Anuncio</button>
        <?php endif;?>
    </div>
</div>