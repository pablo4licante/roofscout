
<h3><i class="fa fa-paint-brush"></i> Elige un tema:</h3>
<form action="/aplicar-seleccion-tema" class="busqueda-form" method="post">
    <select name="temaId">
        <?php foreach ($temas as $tema): ?>
            <option value="<?= htmlspecialchars($tema['id']) ?>">
                <?= htmlspecialchars($tema['nombre']) ?> - <?= htmlspecialchars($tema['descripcion']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Aplicar tema</button>
</form>

