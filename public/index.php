<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;

$router = new Router();

$router->get('/nosotros', 'funcion_nosotros');
$router->get('/tienda_virtual', 'funcion_tienda');
$router->get('/contacto', 'funcion_contacto');
$router->get('/admin', 'funcion_admin');


$router->comprobarRutas();

?>