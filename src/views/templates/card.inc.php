<article class="card">
    <a href="anuncio/<?php echo htmlspecialchars($anuncio['id']); ?>">

        <img class="card-img" src="<?php echo htmlspecialchars($anuncio['url']); ?>"  alt="<?php echo htmlspecialchars($anuncio['alt']); ?>">

        <div class="card-content">
            <h3><?php echo htmlspecialchars($anuncio['titulo']); ?></h3>
            <p><?php echo htmlspecialchars($anuncio['ciudad']); ?>, <?php echo htmlspecialchars($anuncio['pais']); ?>
            </p>
            <?php if ($anuncio['tipo_anuncio'] == 'Alquiler'): ?>
                <h2><?php echo number_format(htmlspecialchars($anuncio['precio']), 0, '', '.'); ?> &euro;/mes</h2>
            <?php else: ?>
                <h2><?php echo number_format(htmlspecialchars($anuncio['precio']), 0, '', '.'); ?> &euro;</h2>
            <?php endif; ?>
            <p><?php echo date('d M Y', strtotime($anuncio['fecha_publi'])); ?></p>
        </div>
    </a>
</article>