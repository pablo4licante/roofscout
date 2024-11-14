<?php
if (isset($_GET['logged']) && $_GET['logged'] === 'true' && isset($_SESSION['ultimaConexion'])) {
    $ultimaConexion = date('d M Y, H:i:s', strtotime($_SESSION['ultimaConexion']));
    echo '<div style="display:block;">
                    <div class="modal-content">
                        <form method="post">
                        <p>Última conexión: ' . $ultimaConexion . '</p>
                        </form>
                    </div>
                </div>';
}


date_default_timezone_set('Europe/Madrid'); // TODO zona horaria personalizada?
$currentHour = date('H');

if ($currentHour >= 6 && $currentHour < 12) {
    $saludo = "Buenos días";
} elseif ($currentHour >= 12 && $currentHour < 16) {
    $saludo = "Hola";
} elseif ($currentHour >= 16 && $currentHour < 20) {
    $saludo = "Buenas tardes";
} else {
    $saludo = "Buenas noches";
}

?>


<div class="mensaje-ok">
    <h2><?php echo $saludo; ?> <?php echo $usuario['nombre']; ?>!</h2>
    <img src="https://picsum.photos/200" class="publisher_img">
    <h3>Mis datos</h3>
    <p><strong></strong> <?php echo $usuario['email']; ?></p>
    <p><strong>Sexo:</strong> <?php echo $usuario['sexo']; ?></p>
    <p><strong>Fecha de Nacimiento:</strong> <?php echo date('d M Y', strtotime($usuario['fecha_nacimiento'])); ?></p>
    <p><strong><?php echo $usuario['ciudad']; ?></strong>, <?php echo $usuario['pais']; ?></p>
</div>

<div class="botones-perfil">
    <button onclick="location.href='/cerrar-sesion'">Cerrar Sesión</button>
    <button onclick="location.href='/perfil'">Editar Perfil</button>
    <button onclick="location.href='/'">Darse de Baja</button>
    <button onclick="location.href='/seleccion-tema'">Seleccionar Tema</button>
</div>

<h2 class="titulo-anuncios-perfil">Mis anuncios</h2>
<div class="botones-perfil">
    <button onclick="location.href='/nuevo-anuncio'">Crear anuncio</button>
    <button onclick="location.href='/solicitar-folleto'">Solicitar folleto</button>
</div>

<div id="galeria">
    <?php foreach ($anuncios as $anuncio): ?>
        <?php include('./src/views/templates/card.inc.php'); ?>
    <?php endforeach; ?>
</div>