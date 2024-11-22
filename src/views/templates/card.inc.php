<article class="card">
    <a href="/anuncio/<?php echo $anuncio['id']; ?>">

        <img class="card-img" src="<?php echo htmlspecialchars($anuncio['url']); ?>"
            alt="<?php echo htmlspecialchars($anuncio['alt']); ?>">

        <div class="card-content">
            <h3><?php echo htmlspecialchars($anuncio['titulo']); ?></h3>
            <p><?php echo htmlspecialchars($anuncio['ciudad']); ?>, <?php echo htmlspecialchars($anuncio['pais']); ?>
            </p>
            <?php foreach ($tipos_anuncio as $tipo_anuncio): ?>
                <?php if ($anuncio['tipo_anuncio'] == $tipo_anuncio['id']): ?>
                    <?php if ($tipo_anuncio['nombre'] == 'Alquiler'): ?>
                        <h3><?php echo number_format(htmlspecialchars($anuncio['precio']), 0, '', '.'); ?> &euro;/mes</h3>
                    <?php else: ?>
                        <h3><?php echo number_format(htmlspecialchars($anuncio['precio']), 0, '', '.'); ?> &euro;</h3>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>

            <p><?php echo date('d M Y', strtotime($anuncio['fecha_publi'])); ?></p>
        </div>
    </a>
</article>