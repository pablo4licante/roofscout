<?php

if (Usuario::nuevoUsuario($email, $password, $nombre, $sexo, $fecha_nacimiento, $ciudad, $pais, $foto_perfil)) {
    
    header('Location: /login');
} else {
    echo 'Error en las credenciales';
    header('Location: /registro');
}
