<?php
date_default_timezone_set('Europe/Madrid');

if (isset($_SESSION['ultimaConexion'])) {
    $ultimaConexion = date('d M Y, H:i:s', strtotime($_SESSION['ultimaConexion']));
    echo '<div style="display:block;">
                    <div class="modal-content">
                        <form method="post">
                        <p>Última conexión: ' . $ultimaConexion . '</p>
                        </form>
                    </div>
                </div>';
}

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

<?php
if (isset($_SESSION['flashdata'])) {
  echo '<div class="mensaje-ok">' . htmlspecialchars($_SESSION['flashdata']) . '</div>';
  unset($_SESSION['flashdata']);
}
?>


<div class="mensaje-ok">
    
    <?php if($email === $_SESSION['user']):?>
    <h2><?php echo $saludo; ?> <?php echo $usuario['nombre']; ?>!</h2>
    <?php endif;?>

    <img src="<?php echo $usuario['foto']?>" class="publisher_img">
    <h3>Mis datos</h3>
    
    <h3><strong></strong> <?php echo $usuario['nombre']; ?></h3>
    <p><strong></strong> <?php echo $usuario['email']; ?></p>
    <p><strong>Usuario desde </strong> <?php echo date('d M Y', strtotime($usuario['fecha_incorporacion'])); ?></p>
</div>

<?php if($email === $_SESSION['user']):?>
    <div class="botones-perfil">
        <button onclick="location.href='/mis-datos'">Mis Datos</button>
        <button onclick="location.href='/mensajes'">Mis Mensajes</button>
        <button onclick="location.href='/cerrar-sesion'">Cerrar Sesión</button>
        <button onclick="location.href='/perfil'">Editar Perfil</button>
        <button onclick="location.href='/'">Darse de Baja</button>
        <button onclick="location.href='/seleccion-tema'">Seleccionar Tema</button>
    </div>
<?php endif;?>

<h2 class="titulo-anuncios-perfil">Mis anuncios</h2>


<?php if($email === $_SESSION['user']):?>
    <div class="botones-perfil">
        <button onclick="location.href='/nuevo-anuncio'">Crear anuncio</button>
        <button onclick="location.href='/solicitar-folleto'">Solicitar folleto</button>
    </div>
<?php endif;?>

<h3>Mostrando <?php echo sizeof($anuncios) ?> anuncios</h3>
<div id="galeria">
    <?php foreach ($anuncios as $anuncio): ?>
        <?php include('./src/views/templates/card.inc.php'); ?>
    <?php endforeach; ?>
</div>