<article class="card">
    <a href="html/anuncio/<?php echo htmlspecialchars($anuncio['id']); ?>">
            <img alt="Card Image" class="card-img" src="./src/assets/images/<?php echo rand(1, 11); ?>.jpg">
        <div class="card-content">
            <h3><?php echo htmlspecialchars($anuncio['titulo']); ?></h3>
            <p><?php echo htmlspecialchars($anuncio['ciudad']); ?>, <?php echo htmlspecialchars($anuncio['pais']); ?>
            </p>
            <?php if ($anuncio['tipo_anuncio'] == 'Alquiler'): ?>
                <h2><?php echo number_format(htmlspecialchars($anuncio['precio']), 0, '', '.'); ?> &euro;/mes</h2>
            <?php else: ?>
                <h2><?php echo number_format(htmlspecialchars($anuncio['precio']), 0, '', '.'); ?> &euro;</h2>
            <?php endif; ?>
            <p><?php echo htmlspecialchars($anuncio['fecha_publi']); ?></p>
        </div>
    </a>
</article>