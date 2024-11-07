<?php
// TODO cambiar datos por datos de la DB
$localidades = ["Alicante", "Elche", "Benidorm", "Torrevieja", "Orihuela"];
$provincias = ["Alicante", "Valencia", "Castellón"];
$anuncios = ["anuncio1" => "Anuncio 1", "anuncio2" => "Anuncio 2"];

$mostrarTabla = isset($_GET['mostrarTabla']) && $_GET['mostrarTabla'] === 'true';

// Función para generar la tabla de costos
function generarTablaCostos() {
    $numPaginas = range(1, 15);
    $numFotos = range(3, 45, 3);

    $html = '<table><thead><tr>';
    $columnas = ["Número de páginas", "Número de fotos", "B/N 150-300 dpi", "B/N 450-900 dpi", "Color 150-300 dpi", "Color 450-900 dpi"];
    foreach ($columnas as $columna) {
        $html .= "<th>$columna</th>";
    }
    $html .= '</tr></thead><tbody>';

    foreach ($numPaginas as $index => $paginas) {
        $fotos = $numFotos[$index];
        $precio = 10.0;

        // Cálculo de precios según el número de páginas
        for ($numeroDeLaPagina = 1; $numeroDeLaPagina <= $paginas; $numeroDeLaPagina++) {
            if ($numeroDeLaPagina < 5) {
                $precio += 2.0;
            } elseif ($numeroDeLaPagina <= 10) {
                $precio += 1.8;
            } else {
                $precio += 1.6;
            }
        }

        $precio_fotos_high_dpi = $fotos * 0.2;
        $precio_fotos_color = $fotos * 0.5;

        $html .= "<tr>";
        $html .= "<td>$paginas</td>";
        $html .= "<td>$fotos</td>";
        $html .= "<td>" . number_format($precio, 2) . " €</td>";
        $html .= "<td>" . number_format($precio + $precio_fotos_high_dpi, 2) . " €</td>";
        $html .= "<td>" . number_format($precio + $precio_fotos_color, 2) . " €</td>";
        $html .= "<td>" . number_format($precio + $precio_fotos_color + $precio_fotos_high_dpi, 2) . " €</td>";
        $html .= "</tr>";
    }
    $html .= '</tbody></table>';
    return $html;
}

function calcularCostos($numPaginas, $numFotos, $resolucion, $impresionColor) {
    $precio = 10.0;

    // Cálculo de precios según el número de páginas
    for ($numeroDeLaPagina = 1; $numeroDeLaPagina <= $numPaginas; $numeroDeLaPagina++) {
        if ($numeroDeLaPagina < 5) {
            $precio += 2.0;
        } elseif ($numeroDeLaPagina <= 10) {
            $precio += 1.8;
        } else {
            $precio += 1.6;
        }
    }

    $precio_fotos_high_dpi = $resolucion > 300 ? $numFotos * 0.2 : 0;
    $precio_fotos_color = $impresionColor === 'color' ? $numFotos * 0.5 : 0;

    $costo_total = $precio + $precio_fotos_high_dpi + $precio_fotos_color;

    return number_format($costo_total, 2) . " €";
}
// Checks del formulario
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nombre']) || strlen($_POST['nombre']) > 200) {
        $errors['nombre'] = "El nombre y apellidos son obligatorios y no deben exceder los 200 caracteres.";
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || strlen($_POST['email']) > 200) {
        $errors['email'] = "Por favor, introduce un correo electrónico válido y que no exceda los 200 caracteres.";
    }

    if (empty($_POST['calle'])) {
        $errors['calle'] = "La calle es obligatoria.";
    }

    if (empty($_POST['numero'])) {
        $errors['numero'] = "El número es obligatorio.";
    }

    if (empty($_POST['codigo-postal'])) {
        $errors['codigo-postal'] = "El código postal es obligatorio.";
    }

    if (empty($_POST['localidad'])) {
        $errors['localidad'] = "La localidad es obligatoria.";
    }

    if (empty($_POST['provincia'])) {
        $errors['provincia'] = "La provincia es obligatoria.";
    }

    if (empty($_POST['pais'])) {
        $errors['pais'] = "El país es obligatorio.";
    }

    if (empty($_POST['num-copias']) || $_POST['num-copias'] < 1 || $_POST['num-copias'] > 99) {
        $errors['num-copias'] = "El número de copias debe estar entre 1 y 99.";
    }

    if (empty($_POST['resolucion']) || $_POST['resolucion'] < 150 || $_POST['resolucion'] > 900) {
        $errors['resolucion'] = "La resolución debe estar entre 150 y 900 DPI.";
    }

    if (empty($_POST['anuncio'])) {
        $errors['anuncio'] = "El anuncio es obligatorio.";
    }

    if (empty($_POST['impresion-color'])) {
        $errors['impresion-color'] = "La impresión a color es obligatoria.";
    }

    if (empty($_POST['impresion-precio'])) {
        $errors['impresion-precio'] = "La impresión del precio es obligatoria.";
    }

    if (empty($errors)) {
        header('Location: /mandar-solicitud-folleto', true, 307);
        exit;
    }
}

function getPostValue($field) {
    return isset($_POST[$field]) ? htmlspecialchars($_POST[$field]) : '';
}
?>

<h2>Solicitud de Folleto Publicitario</h2>
<p id="info-formulario-folleto">Complete el siguiente formulario para solicitar su folleto publicitario impreso con las opciones disponibles.</p>

<div id="grid">
    
    <form action="/mandar-solicitud-folleto" method="post">
        <label for="nombre">Nombre y Apellidos:</label>
        <input type="text" id="nombre" name="nombre" class="form-control" maxlength="200" required>
        <br>
        <span style="color:red;"><?= $errors['nombre'] ?? '' ?></span><br><br>

        <br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" class="form-control" maxlength="200" required>
        <br>
        <span style="color:red;"><?= $errors['email'] ?? '' ?></span><br><br>
        <br>

        <label for="texto-adicional">Texto Adicional (Opcional):</label>
        <textarea id="texto-adicional" name="texto-adicional" class="form-control" maxlength="4000" rows="4"></textarea>

        <br>

        <h3>Dirección Postal</h3>
        <label for="calle">Calle:</label>
        <input type="text" id="calle" name="calle" class="form-control" required>
        <br>
        <span style="color:red;"><?= $errors['calle'] ?? '' ?></span><br><br>
        <br>

        <label for="numero">Número:</label>
        <input type="number" id="numero" name="numero" class="form-control" required>
        <br>
        <span style="color:red;"><?= $errors['numero'] ?? '' ?></span><br><br>
        <br>

        <label for="piso">Piso:</label>
        <input type="text" id="piso" name="piso" class="form-control">
        <br>
        <span style="color:red;"><?= $errors['piso'] ?? '' ?></span><br><br>
        <br>

        <label for="codigo-postal">Código Postal:</label>
        <input type="number" id="codigo-postal" name="codigo-postal" class="form-control" required>
        <br>
        <span style="color:red;"><?= $errors['codigo-postal'] ?? '' ?></span><br><br>
        <br>

        <label for="localidad">Localidad:</label>
        <select id="localidad" name="localidad" class="form-control" required>
            <?php foreach ($localidades as $localidad): ?>
                <option value="<?= $localidad ?>"><?= $localidad ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <span style="color:red;"><?= $errors['localidad'] ?? '' ?></span><br><br>
        <br>

        <label for="provincia">Provincia:</label>
        <select id="provincia" name="provincia" class="form-control" required>
            <?php foreach ($provincias as $provincia): ?>
                <option value="<?= $provincia ?>"><?= $provincia ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <span style="color:red;"><?= $errors['provincia'] ?? '' ?></span><br><br>
        <br>

        <label for="pais">País:</label>
        <select id="pais" name="pais" class="form-control" required>
            <option value="España">España</option>
        </select>
        <br>
        <span style="color:red;"><?= $errors['pais'] ?? '' ?></span><br><br>
        <br>

        <label for="telefono">Teléfono (Opcional):</label>
        <input type="number" id="telefono" name="telefono" class="form-control">
        
        <br>

        <label for="color-portada">Color de la Portada:</label>
        <input type="color" id="color-portada" name="color-portada" class="form-control" value="#000000">
        
        <br>

        <label for="num-copias">Número de Copias:</label>
        <input type="number" id="num-copias" name="num-copias" class="form-control" min="1" max="99" value="1" required>
        <br>

        <label for="resolucion">Resolución de las fotos (DPI):</label>
        <input type="range" id="resolucion" name="resolucion" class="form-control" min="150" max="900" step="150" value="150" oninput="document.getElementById('resolucion-valor').textContent = this.value + ' DPI'" required>
        <span id="resolucion-valor">150 DPI</span>
        <br>
        <span style="color:red;"><?= $errors['resolucion'] ?? '' ?></span><br><br>
        <br>

        <label for="anuncio">Anuncio del Usuario (Obligatorio):</label>
        <select id="anuncio" name="anuncio" class="form-control" required>
            <?php foreach ($anuncios as $key => $value): ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <span style="color:red;"><?= $errors['anuncio'] ?? '' ?></span><br><br>
        <br>

        <label for="fecha-recepcion">Fecha de Recepción (Opcional):</label>
        <input type="date" id="fecha-recepcion" name="fecha-recepcion" class="form-control">

        <br>

        <label for="impresion-color">Impresión a Color:</label>
        <select id="impresion-color" name="impresion-color" class="form-control" required>
            <option value="blanco-negro">Blanco y Negro</option>
            <option value="color">A Todo Color</option>
        </select>

        <br>

        <label for="impresion-precio">¿Imprimir Precio del Anuncio?:</label>
        <select id="impresion-precio" name="impresion-precio" class="form-control" required>
            <option value="con-precio">Con Precio</option>
            <option value="sin-precio">Sin Precio</option>
        </select>

        <input type="hidden" id="precio" name="precio" value="<?= calcularCostos($_POST['num-copias'] ?? 1, $_POST['resolucion'] ?? 150, $_POST['impresion-color'] ?? 'blanco-negro', $_POST['impresion-precio'] ?? 'sin-precio') ?>">

        <button type="submit">Enviar Solicitud</button>
    </form>

    <div id="tarifas">
        <h2>Tarifas</h2>
        <table>
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Tarifa</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Coste procesamiento y envío</td><td>10 &euro;</td></tr>
                <tr><td>&lt; 5 p&aacute;ginas</td><td>2 &euro; por p&aacute;g.</td></tr>
                <tr><td>entre 5 y 10 p&aacute;ginas</td><td>1.8 &euro; por p&aacute;g.</td></tr>
                <tr><td>&gt; 10 p&aacute;ginas</td><td>1.6 &euro; por p&aacute;g.</td></tr>
                <tr><td>Blanco y negro</td><td>0 &euro;</td></tr>
                <tr><td>Color</td><td>0.5 &euro; por foto</td></tr>
                <tr><td>Resoluci&oacute;n &le; 300 dpi</td><td>0 &euro; por foto</td></tr>
                <tr><td>Resoluci&oacute;n &gt; 300 dpi</td><td>0.2 &euro; por foto</td></tr>
            </tbody>
        </table>

    <?php if ($mostrarTabla == true): ?>
        <button onclick="location.href='?mostrarTabla=false'">Ocultar Tabla</button>
        <div id="albumTableContainer">
            <?php echo generarTablaCostos(); ?>
        </div>
    <?php else: ?>
        <button onclick="location.href='?mostrarTabla=true'">Mostrar Tabla</button>
    <?php endif; ?>
    </div>
</div>