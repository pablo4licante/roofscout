<div class="cool-quote">
    <div class="cool-quote-text">
    <h4>Nuestros expertos recomiendan:</h4>
    <blockquote>
        <p>"<?php echo htmlspecialchars($anuncio_favorito['comentario']); ?>"</p>
        - <?php echo htmlspecialchars($anuncio_favorito['nombre']); ?>
    </blockquote>
    </div>
<article class="card">
    <a href="/anuncio/<?php echo $anuncio_favorito['id']; ?>">

        <img class="card-img" src="<?php echo htmlspecialchars($anuncio_favorito['url']); ?>"
            alt="<?php echo htmlspecialchars($anuncio_favorito['alt']); ?>">

        <div class="card-content">
            <h3><?php echo htmlspecialchars($anuncio_favorito['titulo']); ?></h3>
            <p><?php echo htmlspecialchars($anuncio_favorito['ciudad']); ?>, <?php echo htmlspecialchars($anuncio_favorito['pais']); ?>
            </p>
            <?php foreach ($tipos_anuncio as $tipo_anuncio): ?>
                <?php if ($anuncio_favorito['tipo_anuncio'] == $tipo_anuncio['id']): ?>
                    <?php if ($tipo_anuncio['nombre'] == 'Alquiler'): ?>
                        <h3><?php echo number_format(htmlspecialchars($anuncio_favorito['precio']), 0, '', '.'); ?> &euro;/mes</h3>
                    <?php else: ?>
                        <h3><?php echo number_format(htmlspecialchars($anuncio_favorito['precio']), 0, '', '.'); ?> &euro;</h3>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>

            <p><?php echo date('d M Y', strtotime($anuncio_favorito['fecha_publi'])); ?></p>
        </div>
    </a>
</article>
</div>