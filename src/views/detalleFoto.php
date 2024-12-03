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
    <div>
        <button style="background-color:red;" onclick="if(confirm('¿Estás seguro de que deseas eliminar esta foto?')) { window.location.href='/eliminar-foto/<?php echo $foto['id']; ?>'; }">Eliminar foto</button>
    </div>
</div>

<?php endif; ?>