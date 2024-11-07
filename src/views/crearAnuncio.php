<?php
// TODO: Coger de la DB
$ciudades = ["Madrid", "Barcelona", "Valencia", "Sevilla", "Zaragoza", "Málaga", "Murcia", "Palma", "Las Palmas", "Bilbao"];
$paises = ["España"];
$tipos = ["alquiler" => "Alquiler", "venta" => "Venta"];
$tipos_vivienda = [
    "vivienda" => "Vivienda",
    "obra_nueva" => "Obra Nueva",
    "oficina" => "Oficina",
    "local" => "Local",
    "garaje" => "Garaje"
];
?>

<h1>Nuevo Anuncio</h1>
<form action="/mandar-nuevo-anuncio" method="post" enctype="multipart/form-data">
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" required>
    <br>

    <label for="tipo_anuncio">Tipo de Anuncio:</label>
    <select id="tipo_anuncio" name="tipo_anuncio" required>
        <option value="">Seleccione un tipo</option>
        <?php foreach ($tipos as $valor => $nombre): ?>
            <option value="<?php echo $valor; ?>"><?php echo $nombre; ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="tipo_vivienda">Tipo de Vivienda:</label>
    <select id="tipo_vivienda" name="tipo_vivienda" required>
        <option value="">Seleccione un tipo de vivienda</option>
        <?php foreach ($tipos_vivienda as $valor => $nombre): ?>
            <option value="<?php echo $valor; ?>"><?php echo $nombre; ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
    <br>

    <label for="foto-principal">Foto Principal:</label>
    <input type="file" id="foto-principal" name="foto-principal" accept="image/*" required>
    <br>

    <label for="galeria-fotos">Galería de Fotos:</label>
    <input type="file" id="galeria-fotos" name="galeria-fotos[]" accept="image/*" multiple>
    <br>

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" required>
    <br>

    <label for="ciudad">Ciudad:</label>
    <select id="ciudad" name="ciudad" required>
        <option value="">Seleccione una ciudad</option>
        <?php foreach ($ciudades as $ciudad): ?>
            <option value="<?php echo $ciudad; ?>"><?php echo $ciudad; ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="pais">País:</label>
    <select id="pais" name="pais" required>
        <option value="">Seleccione un país</option>
        <?php foreach ($paises as $pais): ?>
            <option value="<?php echo $pais; ?>"><?php echo $pais; ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="superficie">Superficie (m²):</label>
    <input type="number" id="superficie" name="superficie" required>
    <br>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="habitaciones" required>
    <br>

    <label for="aseos">Aseos:</label>
    <input type="number" id="aseos" name="aseos" required>
    <br>

    <label for="planta">Planta:</label>
    <input type="number" id="planta" name="planta" required>
    <br>

    <label for="anyo_construccion">Año de Construcción:</label>
    <input type="number" id="anyo_construccion" name="anyo_construccion" required>
    <br>

    <button type="submit">Enviar</button>
</form>