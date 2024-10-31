<!--
  Archivo: index.php
  Descripccion: ...
  Creado por: Pablo Alicante y Leyre Wollstein el 27/10/2024
--> 


<?php

    require_once './src/controllers/anuncioController.php';

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $queryParams = $_GET;

    $routes = [
        '/' => function() {
            $controller = new AnuncioController();
            $controller->inicio();
        },
        '/about' => function() {
            echo "<h1>This is the About page!</h1>";
            echo "<p>Bienvenido a la página de About.</p>";
        },
        '/user/(\d+)' => function($id) {
            echo "User ID: $id";
        },
        '/busqueda' => function($queryParams) {

            $pais = $queryParams['pais'] ?? 'Todos los países';
            $ciudad = $queryParams['ciudad'] ?? 'Todas las ciudades';
            
            echo "Resultados de búsqueda para: ";
            echo "País: $pais, Ciudad: $ciudad";
        }
    ];
    
    include_once('./src/views/templates/cabecera.inc.php');
    include_once('./src/views/templates/navegacion.inc.php');
    
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
        echo "404 - Page not found";
    }

    include_once('./src/views/templates/footer.inc.php');
?>

