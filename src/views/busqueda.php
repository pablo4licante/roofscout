<h2>B&uacute;squeda</h2>
<?php
// Opciones para los selectores tambien se pueden cargar desde una base de datos

use function PHPSTORM_META\type;

function getPostValue($field) {
    return isset($_GET[$field]) ? htmlspecialchars($_GET[$field]) : '';
}
?>
<div class="busqueda-form">
<form method="get">
    <label for="query">Titulo del Anuncio</label>
    <input  value="<?= getPostValue("query")?>" type="text" name="query" placeholder="Titulo de Anuncio"><br><br>

    <h3>¿Qué buscas?</h3>

    <div>
    <label for="tipo_anuncio">Tipo de Anuncio:</label>
    <select id="tipo_anuncio" name="tipo_anuncio">
        <option value="">Seleccione un tipo de anuncio</option>
        <?php foreach ($tipos_anuncio as $tipo_anuncio): ?>
            <option value="<?php echo $tipo_anuncio['id']; ?>" <?php if (getPostValue("tipo_anuncio") == $tipo_anuncio['id']) echo 'selected'; ?>><?php echo $tipo_anuncio['nombre']; ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="tipo_vivienda">Tipo de Vivienda:</label>
    <select id="tipo_vivienda" name="tipo_vivienda">
        <option value="">Seleccione un tipo de vivienda</option>
        <?php foreach ($tipos_vivienda as $tipo_vivienda): ?>
            <option value="<?php echo $tipo_vivienda['id']; ?>" <?php if (getPostValue("tipo_vivienda") == $tipo_vivienda['id']) echo 'selected'; ?>><?php echo $tipo_vivienda['nombre']; ?></option>
        <?php endforeach; ?>
    </select>
        <br><br>
    </div>

    <div>
        <h3>Localización</h3>
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" value="<?= getPostValue("ciudad") ?>">
        <br><br>

        <label for="pais">País:</label>
        <select name="pais" id="pais">
            <option value="">Seleccione un Pais</option>
            <?php foreach ($paises as $pais): ?>
                <option value="<?php echo $pais['pais']; ?>" <?php if (getPostValue("pais") == $pais['pais']) echo 'selected'; ?>><?php echo $pais['pais']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
    </div>

    <div>
        <h3>Precio entre</h3>
        <label for="precio_min">Mínimo:</label>
        <input value="<?= getPostValue("precio_min")?>" type="number" name="precio_min" id="precio_min" placeholder="Precio Mínimo"><br><br>

        <label for="precio_max">Máximo:</label>
        <input value="<?= getPostValue("precio_max")?>" type="number" name="precio_max" id="precio_max" placeholder="Precio Máximo"><br><br>
    </div>

    <div>
        <h3>Fecha de publicacion</h3>
        <label for="fecha_inicio">Fecha Inicio:</label>
        <input value="<?= getPostValue("fecha_inicio")?>" type="date" name="fecha_inicio" id="fecha_inicio"><br><br>

        <label for="fecha_fin">Fecha Fin:</label>
        <input value="<?= getPostValue("fecha_fin")?>" type="date" name="fecha_fin" id="fecha_fin"><br><br>
    </div>

    <button type="submit">Buscar</button>
</form>
</div>


<h3>Mostrando <?php echo sizeof($anuncios); ?> resultados</h3>
<div id="galeria">
    <?php foreach ($anuncios as $anuncio): ?>
        <?php include './src/views/templates/card.inc.php'; ?>
    <?php endforeach; ?>
</div>