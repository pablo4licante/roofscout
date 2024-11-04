<h2>B&uacute;squeda</h2>
<?php
// Opciones para los selectores tambien se pueden cargar desde una base de datos
$tipos_anuncio = ["Alquiler", "Venta"];
$tipos_vivienda = ["Vivienda", "Obra Nueva", "Oficina", "Local", "Garaje"];
$ciudades = ["Madrid", "Barcelona", "Valencia", "Sevilla", "Zaragoza", "Málaga", "Murcia", "Palma", "Bilbao", "Alicante"];
$paises = ["España", "Francia", "Alemania", "Italia", "Portugal", "Reino Unido", "Estados Unidos", "Canadá", "México", "Argentina"];
?>

<form action="#resultado-busqueda" method="get">
    <label for="query">Titulo del Anuncio</label>
    <input type="text" name="query" placeholder="Titulo de Anuncio"><br><br>

    <p>¿Qué buscas?</p>
    <div>
        <label for="tipo">Tipo de Anuncio</label>
        <select name="tipo" id="tipo">
            <?php foreach ($tipos_anuncio as $value => $label): ?>
                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="tipo_vivienda">Tipo de Vivienda:</label>
        <select name="tipo_vivienda" id="tipo_vivienda">
            <?php foreach ($tipos_vivienda as $value => $label): ?>
                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select><br><br>
    </div>

    <div>
        <p>Localización</p>
        <label for="ciudad">Ciudad:</label>
        <select name="ciudad" id="ciudad">
            <?php foreach ($ciudades as $value => $label): ?>
                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="pais">País:</label>
        <select name="pais" id="pais">
            <?php foreach ($paises as $value => $label): ?>
                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select><br><br>
    </div>

    <div>
        <p>Precio entre</p>
        <label for="precio_min">Mínimo:</label>
        <input type="number" name="precio_min" id="precio_min" placeholder="Precio Mínimo"><br><br>

        <label for="precio_max">Máximo:</label>
        <input type="number" name="precio_max" id="precio_max" placeholder="Precio Máximo"><br><br>
    </div>

    <div>
        <p>Fecha de publicacion</p>
        <label for="fecha_inicio">Fecha Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio"><br><br>

        <label for="fecha_fin">Fecha Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin"><br><br>
    </div>

    <button type="submit">Buscar</button>
</form>


<div id="resultados-busqueda">
    <h3>Mostrando <?php echo sizeof($anuncios); ?></h3>
    <?php foreach ($anuncios as $anuncio): ?>
        <?php include('./src/views/templates/card.inc.php'); ?>
    <?php endforeach; ?>
</div>