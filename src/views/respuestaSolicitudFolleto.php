
<div class="mensaje-ok">
    <h2>Solicitud de Folleto Recibida</h2>
    <p>Nombre: <?php echo htmlspecialchars($_GET['nombre']); ?></p>
    <p>Email: <?php echo htmlspecialchars($_GET['email']); ?></p>
    <p>Calle: <?php echo htmlspecialchars($_GET['calle']); ?></p>
    <p>Número: <?php echo htmlspecialchars($_GET['numero']); ?></p>
    <p>Piso: <?php echo htmlspecialchars($_GET['piso']); ?></p>
    <p>Código Postal: <?php echo htmlspecialchars($_GET['codigo-postal']); ?></p>
    <p>Localidad: <?php echo htmlspecialchars($_GET['localidad']); ?></p>
    <p>Provincia: <?php echo htmlspecialchars($_GET['provincia']); ?></p>
    <p>País: <?php echo htmlspecialchars($_GET['pais']); ?></p>
    <p>Teléfono: <?php echo htmlspecialchars($_GET['telefono']); ?></p>
    <p>Color de Portada:</p>
    <div style="width: 50px; height: 50px; background-color: <?php echo htmlspecialchars($_GET['color-portada']); ?>;"></div>
    <p>Número de Copias: <?php echo htmlspecialchars($_GET['num-copias']); ?></p>
    <p>Resolución: <?php echo htmlspecialchars($_GET['resolucion']); ?></p>
    <p>Anuncio: <?php echo htmlspecialchars($_GET['anuncio']); ?></p>
    <p>Fecha de Recepción: <?php echo htmlspecialchars($_GET['fecha-recepcion']); ?></p>
    <p>Impresión a Color: <?php echo htmlspecialchars($_GET['impresion-color']); ?></p>
    <p>Precio de Impresión: <?php echo htmlspecialchars($_GET['impresion-precio']); ?></p>
    <p>Texto Adicional: <?php echo htmlspecialchars($_GET['texto-adicional']); ?></p>
    <b>Precio: <?php echo htmlspecialchars($_GET['precio']); ?></b>
    <br><br>
    <button onclick="window.location.href='/perfil/<?php echo $_SESSION['user']; ?>'">Volver</button>
</div>