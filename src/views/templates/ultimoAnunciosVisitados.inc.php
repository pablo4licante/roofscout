<h3>Ultimos anuncios visitados:</h3>
<div class="galeria">
<?php if (!empty($anunciosVisitados)): ?>
    <?php foreach ($anunciosVisitados as $anuncio): ?>
        <?php include './src/views/templates/card.inc.php'; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>No hay anuncios visitados recientemente.</p>
<?php endif; ?>
</div>