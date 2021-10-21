<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadController;

$router = new Router();

//debuguear(PropiedadController::class);

$router->get('/admin', [PropiedadController::class, 'index']);
$router->get('/propiedad/crear', [PropiedadController::class, 'crear']);
$router->get('/propiedad/actualizar', [PropiedadController::class, 'actualizar']);


$router->comprobarRutas();

?>