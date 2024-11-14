<div class="mensaje-ok">
    <h2>Mis datos</h2>
    <img src="https://picsum.photos/200" class="publisher_img">
    <p><strong>Nombre:</strong> <?php echo $usuario['nombre']; ?></p>
    <p><strong>Email:</strong> <?php echo $usuario['email']; ?></p>
    <p><strong>Sexo:</strong> <?php echo $usuario['sexo']; ?></p>
    <p><strong>Fecha de Nacimiento:</strong> <?php echo $usuario['fecha_nacimiento']; ?></p>
    <p><strong>País:</strong> <?php echo $usuario['pais']; ?></p>
    <p><strong>Ciudad:</strong> <?php echo $usuario['ciudad']; ?></p>
</div>

    <div class="botones-perfil">
        <button onclick="location.href='/'">Cerrar Sesión</button>
        <button onclick="location.href='/perfil'">Editar Perfil</button>
        <button onclick="location.href='/'">Darse de Baja</button>
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