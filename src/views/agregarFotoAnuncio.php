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

<h1>Agregar Fotos</h1>
<form action="/anuncio/<?php echo $anuncio['id']?>" method="post" enctype="multipart/form-data">
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" value="<?php echo $anuncio['titulo']?>"  disabled>
    <br>

    <label for="tipo_anuncio">Tipo de Anuncio:</label>
    <select id="tipo_anuncio" name="tipo_anuncio"  required disabled>
        <?php foreach ($tipos as $valor => $nombre): ?>
            <option value="<?php echo $valor; ?>" <?php echo ($anuncio['tipo_anuncio'] == $valor) ? 'selected' : ''; ?>><?php echo $nombre; ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="tipo_vivienda">Tipo de Vivienda:</label>
    <select id="tipo_vivienda" name="tipo_vivienda"   required disabled>
        <option value="<?php echo $anuncio['tipo_vivienda']?>">Seleccione un tipo de vivienda</option>
        <?php foreach ($tipos_vivienda as $valor => $nombre): ?>
            <option value="<?php echo $valor; ?>" <?php echo ($anuncio['tipo_vivienda'] == $valor) ? 'selected' : ''; ?>><?php echo $nombre; ?></option>
        <?php endforeach; ?>
    <br>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" rows="4" required disabled><?php echo $anuncio['descripcion']?></textarea>
    <br>

    <label for="foto-principal">Foto Principal:</label>
    <input type="file" id="foto-principal" name="foto-principal" accept="image/*" required>
    <br>

    <label for="galeria-fotos">Galería de Fotos:</label>
    <input type="file" id="galeria-fotos" name="galeria-fotos[]" accept="image/*" multiple>
    <br>

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" value="<?php echo $anuncio['precio']?>"  required disabled>
    <br>

    <label for="ciudad">Ciudad:</label>
    <select id="ciudad" name="ciudad"  required disabled>
        <option value="<?php echo $anuncio['ciudad']?>">Seleccione una ciudad</option>
        <?php foreach ($ciudades as $ciudad): ?>
            <option value="<?php echo $ciudad; ?>" <?php echo ($anuncio['ciudad'] == $ciudad) ? 'selected' : ''; ?>><?php echo $ciudad; ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="pais">País:</label>
    <select id="pais" name="pais"  required disabled>
        <option value="<?php echo $anuncio['pais']?>">Seleccione un país</option>
        <?php foreach ($paises as $pais): ?>
            <option value="<?php echo $pais; ?>"><?php echo $pais; ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="superficie">Superficie (m²):</label>
    <input type="number" id="superficie" name="superficie" value="<?php echo $anuncio['superficie']?>"  required disabled>
    <br>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="habitaciones" value="<?php echo $anuncio['habitaciones']?>"  required disabled>
    <br>

    <label for="aseos">Aseos:</label>
    <input type="number" id="aseos" name="aseos" value="<?php echo $anuncio['aseos']?>"  required disabled>
    <br>

    <label for="planta">Planta:</label>
    <input type="number" id="planta" name="planta" value="<?php echo $anuncio['planta']?>"  required disabled>
    <br>

    <label for="anyo_construccion">Año de Construcción:</label>
    <input type="number" id="anyo_construccion" name="anyo_construccion" value="<?php echo $anuncio['anyo_construccion']?>" required disabled>
    <br>

    <button type="submit">Enviar</button>
</form>