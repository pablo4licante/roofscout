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

    <p>¿Qué buscas?</p>
    <div>
    <label for="tipo_anuncio">Tipo de Anuncio:</label>
    <select id="tipo_anuncio" name="tipo_anuncio"  required>
        <?php foreach ($tipos_anuncio as $tipo_anuncio): ?>
            <option value="<?php echo $tipo_anuncio['id']; ?>" <?php echo ($anuncio['tipo_anuncio'] == $tipos_anuncio['id']) ? 'selected' : ''; ?>><?php echo $tipos_anuncio['anuncio']; ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="tipo_vivienda">Tipo de Vivienda:</label>
    <select id="tipo_vivienda" name="tipo_vivienda"   required>
        <option value="<?php echo $anuncio['tipo_vivienda']?>">Seleccione un tipo de vivienda</option>
        <?php foreach ($tipos_vivienda as $tipo_vivienda): ?>
            <option value="<?php echo $tipo_vivienda['id']; ?>" <?php echo ($anuncio['tipo_vivienda'] == $tipo_vivienda['id']) ? 'selected' : ''; ?>><?php echo $tipo_vivienda['nombre']; ?></option>
        <?php endforeach; ?>
        <br><br>
    </div>

    <div>
        <p>Localización</p>
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad"> <!-- TODO AQUI -->
        <br><br>

        <label for="pais">País:</label>
        <select name="pais" id="pais">
            <?php foreach ($paises as $pais): ?>
                <option value="<?php echo $pais; ?>" <?php if (getPostValue("pais") == $pais) echo 'selected'; ?>><?php echo $pais; ?></option>
            <?php endforeach; ?>
        </select><br><br>
    </div>

    <div>
        <p>Precio entre</p>
        <label for="precio_min">Mínimo:</label>
        <input value="<?= getPostValue("precio_min")?>" type="number" name="precio_min" id="precio_min" placeholder="Precio Mínimo"><br><br>

        <label for="precio_max">Máximo:</label>
        <input value="<?= getPostValue("precio_max")?>" type="number" name="precio_max" id="precio_max" placeholder="Precio Máximo"><br><br>
    </div>

    <div>
        <p>Fecha de publicacion</p>
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