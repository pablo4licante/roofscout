<?php

if (Usuario::checkCredentials($email, $password)) {
    
    //TODO
    //session_start();
    //$_SESSION['email'] = $email;

    header('Location: /');
} else {
    header('Location: /login');
    echo 'Error en las credenciales';
}
