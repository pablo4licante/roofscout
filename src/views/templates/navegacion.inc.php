<header>
  <a class="titulo" href="/">
    <h1>RoofScout.</h1>
  </a>
  <nav>
    <ul>
      <li><a href="/" class="fa fa-home"> <span class="sr-only">Inicio</span></a></li>
      <li><a href="/busqueda" class="fa fa-search"> <span class="sr-only">Busqueda Avanzada</span></a></li>
      <?php
      if (isset($_SESSION['user'])) {
        echo '<li><a href="/mensajes" class="fa fa-envelope"> <span class="sr-only">Mensajes</span></a></li>
          <li><a href="/perfil/' . $_SESSION['user'] . '" class="fa fa-user"> <span class="sr-only">Perfil Usuario</span></a></li>';
      } else {
        echo '<li><a href="/login" class="fa fa-sign-in"> <span class="sr-only">Iniciar Sesion</span></a></li>
          <li><a href="/registro" class="fa fa-user-plus"> <span class="sr-only">Registrarse</span></a></li>';
      } ?>
    </ul>
  </nav>
</header>