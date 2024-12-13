<!--
    roofscout.one
    Tu pagina de compraventa de inmuebles de confianza
    Creado por: Pablo Alicante y Leyre Wollstein el 27/10/2024
-->

<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require_once './src/controllers/anuncioController.php';
require_once './src/controllers/authController.php';
require_once './src/controllers/mensajeController.php';
require_once './src/controllers/folletoController.php';
require_once './src/controllers/usuarioController.php';
require_once './src/controllers/fotoController.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$queryParams = $_GET;

$routes = [
    '/' => function () {
        $controller = new AnuncioController();
        $controller->inicio();
    },
    '/about' => function () {
        echo "<h1>This is the About page!</h1>";
        echo "<p>Bienvenido a la página de About.</p>"; // TODO implementar about / declaracion de accesibilidad
    },
    '/user/(\d+)' => function ($id) {
        echo "User ID: $id"; // TODO implementar pagina de usuario
    },
    '/anuncio/(\d+)' => function ($id) {
        $controller = new AnuncioController();
        $controller->detalleAnuncio($id);
    },
    '/busqueda' => function ($queryParams) {

        $controller = new AnuncioController();
        $controller->busqueda($queryParams);
    },
    '/login' => function () {
        $controller = new AuthController();
        $controller->login();
    },
    '/auth-login' => function () {
        $controller = new AuthController();
        $controller->controlAcceso();
    },
    '/registro' => function () {
        $controller = new AuthController();
        $controller->register();
    },
    '/auth-registro' => function () {
        $controller = new AuthController();
        $controller->controlRegistro();
    },
    '/enviar-mensaje' => function () {
        $controller = new MensajeController();
        $controller->escribirMensaje();
    },
    '/solicitar-folleto' => function () {
        $controller = new FolletoController();
        $controller->solicitarFolleto();
    },
    '/mandar-solicitud-folleto' => function () {
        $controller = new FolletoController();
        $controller->mandarSolicitudFolleto();
    },
    '/respuesta-solicitar-folleto' => function () { // TODO implementar respuesta solicitud folleto
        $controller = new FolletoController();
        $controller->respuestaSolicitarFolleto();
    },
    '/nuevo-anuncio' => function () {
        $controller = new AnuncioController();
        $controller->nuevoAnuncio();
    },
    '/mandar-nuevo-anuncio' => function () {
        $controller = new AnuncioController();
        $controller->mandarNuevoAnuncio();
    },
    '/agregar-foto/(\d+)' => function ($id) {
        $controller = new AnuncioController();
        $controller->agregarFoto($id);
    },
    '/perfil/([^/]+)' => function ($email) {
        $controller = new UsuarioController();
        $controller->perfil(urldecode($email));
    },
    '/mensajes' => function () {
        $controller = new MensajeController();
        $controller->misMensajes();
    },
    '/declaracion-accesibilidad' => function () {
        include_once './src/views/declaracionAccesibilidad.php';
    },
    '/foto/(\d+)' => function ($id) {
        $controller = new FotoController();
        $controller->detalleFoto($id);
    },
    '/cerrar-sesion' => function () {
        $controller = new AuthController();
        $controller->cerrarSesion();
    },
    '/seleccion-tema' => function () {
        $controller = new UsuarioController();
        $controller->paginaTemas();
    },
    '/aplicar-seleccion-tema' => function () {
        $controller = new UsuarioController();
        $controller->seleccionarTema($_POST['temaId']);
    },
    '/mis-datos' => function () {
        $controller = new UsuarioController();
        $controller->paginaMisDatos();
    },
    '/auth-modificar' => function () {
        $controller = new AuthController();
        $controller->controlModificar();
    },
    '/mensajes-anuncio/(\d+)' => function ($idAnuncio) {
        $controller = new MensajeController();
        $controller->mensajesPorAnuncio($idAnuncio);
    },
    '/darse-de-baja' => function () {
        $controller = new AuthController();
        $controller->confirmarBaja();
    },
    '/confirmar-baja' => function () {
        $controller = new AuthController();
        $controller->darseDeBaja();
    },
    '/eliminar-anuncio/(\d+)' => function ($id) {
        $controller = new AnuncioController();
        $controller->eliminarAnuncio($id);
    },
    '/confirmar-eliminar-anuncio/(\d+)' => function ($id) {
        $controller = new AnuncioController();
        $controller->confirmarEliminarAnuncio($id, $_POST['password']);
    },
    '/modificar-anuncio/(\d+)' => function ($id) {
        $controller = new AnuncioController();
        $controller->modificarAnuncio($id);
    },
    '/mandar-modificar-anuncio/(\d+)' => function ($id) {
        $controller = new AnuncioController();
        $controller->mandarModificarAnuncio($id);
    },
    '/eliminar-foto/(\d+)' => function ($id) {
        $controller = new AnuncioController();
        $controller->eliminarFoto($id);
    },
    '/images/([^/]+)' => function ($filename) {
        $filePath = __DIR__ . '/images/' . $filename;  // Using absolute path
        if (file_exists($filePath)) {
            header('Content-Type: ' . mime_content_type($filePath));
            readfile($filePath);
        } else {
            http_response_code(404);
            echo "Image not found.";
        }
    },
    '/eliminar-foto-perfil' => function () {
        $controller = new UsuarioController();
        $controller->eliminarFotoPerfil();
    },
    '/foto-principal/(\d+)' => function ($id) {
        $controller = new FotoController();
        $controller->hacerPrincipal($id);
    },
    '/feed/([^/]+)' => function ($formato) {
        $controller = new AnuncioController();
        if($formato == 'rss') {
            $controller->generarRSS();
        } else if ($formato == 'atom') {
            $controller->generarAtom();
        } else {
            http_response_code(404);
            echo "Formato no soportado.";
        }
    },
    '/user-export/([^/]+)' => function ($formato) {
        $controller = new UsuarioController();
        if($formato == 'rss') {
            $controller->exportarUsuarioRSS();
        } else if ($formato == 'atom') {
            $controller->exportarUsuarioAtom();
        } else {
            http_response_code(404);
            echo "Formato no soportado.";
        }
    },
    '/rss' => function () {
        include_once './src/views/RSS.php';
    },

];

session_start();
if (isset($_COOKIE['user'])) {
    $controller = new AuthController();
    if ($controller->controlDeCookies()) {
        $_SESSION['user'] = $_COOKIE['user'];
        $_SESSION['tema'] = Temas::getTema()['fichero'];
    }
}

$protectedRoutes = [
    '/nuevo-anuncio',
    '/mandar-nuevo-anuncio',
    '/perfil',
    '/user/(\d+)',
    '/anuncio/(\d+)',
    '/enviar-mensaje',
    '/solicitar-folleto',
    '/mandar-solicitud-folleto',
    '/respuesta-solicitar-folleto',
    '/foto/(\d+)',
    '/mensajes',
    '/agregar-foto/(\d+)',
    '/mis-datos',
    '/auth-modificar',
    '/mensajes-anuncio/(\d+)',
    '/eliminar-foto-perfil',
    '/user-export/([^/]+)',
];


$isProtected = false;
foreach ($protectedRoutes as $protectedRoute) {
    $pattern = '@^' . preg_replace('/\(\d+\)/', '(\d+)', $protectedRoute) . '$@';
    if (preg_match($pattern, $path)) {
        $isProtected = true;
        break;
    }
}
if ($isProtected) {
    if (!isset($_SESSION['user'])) {
        $_SESSION['flashdata'] = 'Para acceder debes iniciar sesion.';
        header("Location: /login");
        exit();
    }
} else {
    $controller = new AuthController();
    if ($controller->controlDeCookies()) {
        Usuario::updateUltimaConexion();
    }
}
if (!preg_match('@^/feed/[^/]+$@', $path) && !preg_match('@^/user-export/[^/]+$@', $path)) {
    include_once './src/views/templates/cabecera.inc.php';
    include_once './src/views/templates/navegacion.inc.php';
}
$matched = false;

foreach ($routes as $route => $callback) {
    $pattern = '@^' . preg_replace('/\(\d+\)/', '(\d+)', $route) . '$@';

    if (preg_match($pattern, $path, $params)) {
        array_shift($params);
        if ($route === '/busqueda') {
            $callback($queryParams);
        } else {
            $callback(...$params);
        }
        $matched = true;
        break;
    }
}

if (!$matched) {
    http_response_code(404);
    header("Location: /");
    exit();
}
if (!preg_match('@^/feed/[^/]+$@', $path) && !preg_match('@^/user-export/[^/]+$@', $path)) {

$controller = new anuncioController();
$controller->ultimosVistos();
if (!empty($anunciosVisitados)) {
    setrawcookie('ultimosVistos', json_encode($anunciosVisitados), time() + (7 * 24 * 60 * 60), "/");
}

include_once('./src/views/templates/ultimoAnunciosVisitados.inc.php');
include_once('./src/views/templates/footer.inc.php');
}
?>