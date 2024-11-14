<?php if(!$foto): ?>
    <div class="photo-info-panel">
        <p>No hay foto disponible.</p>
        <button onclick="location.href='/'">Volver al incio</button>
    </div>
<?php else:?>
  
<div class="photo-info-panel">
    <a href="<?php echo htmlspecialchars($foto['url']); ?>" target="_blank">
        <img src="<?php echo htmlspecialchars($foto['url']); ?>" alt="<?php echo htmlspecialchars($foto['alt']); ?>">
    </a>
    <div class="info">
        <p><?php echo htmlspecialchars($foto['alt']); ?></p>
        <button onclick="window.location.href='/anuncio/<?php echo $foto['anuncio']?>'">Volver al anuncio</button>
    </div>
</div>

<?php endif; ?>