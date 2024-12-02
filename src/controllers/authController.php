<?php

require_once('./src/models/usuarioModel.php');
require_once('./src/models/paisModel.php');
require_once('./src/models/temaModel.php');

class AuthController
{

    public function login()
    {
        include_once './src/views/login.php';
    }

    public function register()
    {
        $paises = Paises::getPaises();
        include_once './src/views/registro.php';
    }

    public function controlAcceso()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $remember = $_POST['remember'];

        if (Usuario::checkCredentials($email, $password)) {

            $_SESSION['user'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['tema'] = Temas::getTema()['fichero'];

            if ($remember == 'on') {
                setcookie('user', $email, time() + (86400 * 90), "/");
                setcookie('password', $password, time() + (86400 * 90), "/");
                setcookie('tema', Temas::getTema()['fichero'], time() + (86400 * 90), "/");
      
            }

            $_SESSION["ultimaConexion"] = Usuario::getUltimaConexion();
            header('Location: /perfil/' . $email);
        } else {
            $_SESSION['flashdata'] = 'No se ha podido inciar sesion. Comprueba tus credenciales.';
            header('Location: /login');
        }
    }

    public function controlDeCookies()
    {
        if (isset($_SESSION['user']) && isset($_SESSION['password'])) {
            if (!Usuario::checkCredentials($_SESSION['user'], $_SESSION['password'])) {
                session_destroy();
                $_SESSION['flashdata'] = 'Sesión expirada. Por favor, inicie sesión nuevamente.';
                header('Location: /login');
                exit();
            }
            return true;
        }

        if (isset($_COOKIE['user']) && isset($_COOKIE['password'])) {
            if (!Usuario::checkCredentials($_COOKIE['user'], $_COOKIE['password'])) {
                setcookie('user', '', time() - 3600, '/');
                setcookie('password', '', time() - 3600, '/');
                $_SESSION['flashdata'] = 'Sesión expirada. Por favor, inicie sesión nuevamente.';
                header('Location: /login');
                exit();
            }
            $_SESSION['user'] = $_COOKIE['user'];
            $_SESSION['password'] = $_COOKIE['password'];
            $_SESSION['tema'] = Temas::getTema()['id'];
            return true;
        }

        return false;
    }


    public function controlRegistro()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $nombre = $_POST['nombre'];
        $sexo = $_POST['sexo'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $ciudad = $_POST['ciudad'];
        $pais = $_POST['pais'];
        $foto_perfil = isset($_POST['foto_perfil']) ? $_POST['foto_perfil'] : null;


        // COMPROBACION DE ERRORES
        $errores = [];

        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]{2,14}$/', $nombre)) {
            $errores[] = 'El nombre debe tener entre 3 y 15 caracteres, solo letras y números, y no puede comenzar con un número.';
        }

        if (empty($fecha_nacimiento)) {
            $errores[] = 'La fecha de nacimiento no puede estar vacía.';
        } else {
            $fecha_nacimiento_dt = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
            if (!$fecha_nacimiento_dt || $fecha_nacimiento_dt->format('Y-m-d') !== $fecha_nacimiento) {
            $errores[] = 'La fecha de nacimiento no es válida.';
            } else {
            $hoy = new DateTime();
            $edad = $hoy->diff($fecha_nacimiento_dt)->y;
            if ($edad < 18) {
                $errores[] = 'Debes tener al menos 18 años para registrarte.';
            }
            }
        }

        if (empty($sexo)) {
            $errores[] = 'El campo sexo no puede estar vacío.';
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d_-]{6,15}$/', $password)) {
            $errores[] = 'La contraseña debe tener entre 6 y 15 caracteres, contener al menos una letra mayúscula, una letra minúscula y un número. Solo se permiten letras, números, guiones y guiones bajos.';
        }

        if (empty($email)) {
            $errores[] = 'El email no puede estar vacío.';
        } else {
            if (strlen($email) > 254) {
            $errores[] = 'El email no puede tener más de 254 caracteres.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El email no es válido.';
            } else {
            list($local, $domain) = explode('@', $email);

            if (strlen($local) > 64) {
                $errores[] = 'La parte local del email no puede tener más de 64 caracteres.';
            }

            if (strlen($domain) > 255) {
                $errores[] = 'El dominio del email no puede tener más de 255 caracteres.';
            }

            if (preg_match('/^\.|\.\.|\.@|@\.|\.$/', $local)) {
                $errores[] = 'La parte local del email no puede comenzar o terminar con un punto, ni tener dos puntos seguidos.';
            }

            $subdomains = explode('.', $domain);
            foreach ($subdomains as $subdomain) {
                if (strlen($subdomain) > 63) {
                $errores[] = 'Cada subdominio del email no puede tener más de 63 caracteres.';
                }
                if (preg_match('/^-|-$|[^a-zA-Z0-9-]/', $subdomain)) {
                $errores[] = 'Cada subdominio del email solo puede contener letras, números y guiones, y no puede comenzar o terminar con un guion.';
                }
            }
            }
        }

        if (!empty($errores)) {
            $_SESSION['flashdata'] = implode('<br>', $errores);
            header('Location: /registro');
            exit();
        }


        if (Usuario::nuevoUsuario($email, $password, $nombre, $sexo, $fecha_nacimiento, $ciudad, $pais, $foto_perfil)) {
            $_SESSION['flashdata'] = $nombre . ', hemos creado tu cuenta con exito!';
            header('Location: /login');
        } else {
            $_SESSION['flashdata'] = 'Error de credenciales.';
            header('Location: /registro');
        }
    }

    public function controlModificar()
    {
        $email = $_SESSION['user'];
        $password = $_POST['password'];
        $new_password = $_POST['new_password'];
        $nombre = $_POST['nombre'];
        $sexo = $_POST['sexo'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $ciudad = $_POST['ciudad'];
        $pais = $_POST['pais'];
        $foto_perfil = isset($_POST['foto_perfil']) ? $_POST['foto_perfil'] : null;

         // COMPROBACION DE ERRORES
         $errores = [];

         if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]{2,14}$/', $nombre)) {
             $errores[] = 'El nombre debe tener entre 3 y 15 caracteres, solo letras y números, y no puede comenzar con un número.';
         }
 
         if (empty($fecha_nacimiento)) {
             $errores[] = 'La fecha de nacimiento no puede estar vacía.';
         } else {
             $fecha_nacimiento_dt = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
             if (!$fecha_nacimiento_dt || $fecha_nacimiento_dt->format('Y-m-d') !== $fecha_nacimiento) {
             $errores[] = 'La fecha de nacimiento no es válida.';
             } else {
             $hoy = new DateTime();
             $edad = $hoy->diff($fecha_nacimiento_dt)->y;
             if ($edad < 18) {
                 $errores[] = 'Debes tener al menos 18 años para registrarte.';
             }
             }
         }
 
         if (empty($sexo)) {
             $errores[] = 'El campo sexo no puede estar vacío.';
         }
 
         if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d_-]{6,15}$/', $password)) {
             $errores[] = 'La contraseña debe tener entre 6 y 15 caracteres, contener al menos una letra mayúscula, una letra minúscula y un número. Solo se permiten letras, números, guiones y guiones bajos.';
         }
 
         if (empty($email)) {
             $errores[] = 'El email no puede estar vacío.';
         } else {
             if (strlen($email) > 254) {
             $errores[] = 'El email no puede tener más de 254 caracteres.';
             }
 
             if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             $errores[] = 'El email no es válido.';
             } else {
             list($local, $domain) = explode('@', $email);
 
             if (strlen($local) > 64) {
                 $errores[] = 'La parte local del email no puede tener más de 64 caracteres.';
             }
 
             if (strlen($domain) > 255) {
                 $errores[] = 'El dominio del email no puede tener más de 255 caracteres.';
             }
 
             if (preg_match('/^\.|\.\.|\.@|@\.|\.$/', $local)) {
                 $errores[] = 'La parte local del email no puede comenzar o terminar con un punto, ni tener dos puntos seguidos.';
             }
 
             $subdomains = explode('.', $domain);
             foreach ($subdomains as $subdomain) {
                 if (strlen($subdomain) > 63) {
                 $errores[] = 'Cada subdominio del email no puede tener más de 63 caracteres.';
                 }
                 if (preg_match('/^-|-$|[^a-zA-Z0-9-]/', $subdomain)) {
                 $errores[] = 'Cada subdominio del email solo puede contener letras, números y guiones, y no puede comenzar o terminar con un guion.';
                 }
             }
             }
         }
 
         if (!empty($errores)) {
             $_SESSION['flashdata'] = implode('<br>', $errores);
             header('Location: /perfil/' . $_SESSION['user']);
             exit();
         }

        if (Usuario::checkCredentials($_SESSION['user'], $password)) {
            if (Usuario::modificarUsuario($email, $new_password, $nombre, $sexo, $fecha_nacimiento, $ciudad, $pais, $foto_perfil)) {
                
                if (isset($_COOKIE['user'])) {
                    setcookie('user', '', time() - 3600, '/');
                }
                if (isset($_COOKIE['password'])) {
                    setcookie('password', '', time() - 3600, '/');
                }
                
                if (isset($_SESSION['user'])) {
                    unset($_SESSION['user']);
                }
                session_destroy();
                
                setcookie('user', $email, time() + (86400 * 90), "/");
                setcookie('password', $new_password, time() + (86400 * 90), "/");
                
                session_start();
                $_SESSION['user'] = $email;
                $_SESSION['password'] = $new_password;
                
                $_SESSION['flashdata'] = '¡' . $nombre . ', hemos realizado los cambios con éxito!';
                
                header('Location: /perfil/' . $email);
                exit;
            } else {
                $_SESSION['flashdata'] = 'Error en los datos introducidos. Puede que el email ya esté en uso.';
                header('Location: /perfil/' . $_SESSION['user']);
                exit;
            }
        }
    }

    public function cerrarSesion()
    {
        setcookie('user', '', time() - 3600, '/');
        setcookie('password', '', time() - 3600, '/');

        unset($_SESSION['user']);
        session_destroy();
        header('Location: /');
    }

    public function darseDeBaja() {

        $password = $_POST['password'];
        
        if (Usuario::checkCredentials($_SESSION['user'], $password)) {
            if (Usuario::eliminarUsuario()) {
                setcookie('user', '', time() - 3600, '/');
                setcookie('password', '', time() - 3600, '/');
                unset($_SESSION['user']);
                session_destroy();
                $_SESSION['flashdata'] = '¡Hasta siempre!';
                header('Location: /');
            } else {
                $_SESSION['flashdata'] = 'Error al darse de baja.';
                header('Location: /perfil/' . $_SESSION['user']);
            }
        } else {
            $_SESSION['flashdata'] = 'La contraseña no es correcta.';
            header('Location: /perfil/' . $_SESSION['user']);
        }
    }

    public function confirmarBaja() {
        include_once('./src/views/darseBaja.php');
    }

}