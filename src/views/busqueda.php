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
        <label for="tipo_anuncio">Tipo de Anuncio</label>
        <select name="tipo_anuncio" id="tipo_anuncio">
            <?php foreach ($tipos_anuncio as $value => $label): ?>
                <option value="<?php echo $label; ?>" <?php if (getPostValue("tipo_anuncio") == $label) echo 'selected'; ?>><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="tipo_vivienda">Tipo de Vivienda:</label>
        <select name="tipo_vivienda" id="tipo_vivienda">
            <?php foreach ($tipos_vivienda as $value => $label): ?>
                <option value="<?php echo $label; ?>" <?php if (getPostValue("tipo_vivienda") == $label) echo 'selected'; ?>><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select><br><br>
    </div>

    <div>
        <p>Localización</p>
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad"> <!-- TODO AQUI -->
        <br><br>

        <label for="pais">País:</label>
        <select name="pais" id="pais">
            <?php foreach ($paises as $value => $label): ?>
                <option value="<?php echo $label; ?>" <?php if (getPostValue("pais") == $label) echo 'selected'; ?>><?php echo $label; ?></option>
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