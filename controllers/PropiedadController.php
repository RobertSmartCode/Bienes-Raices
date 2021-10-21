<?php

namespace Controllers;
use MVC\Router;

class PropiedadController{

    public static function index(Router $router){
        //debuguear($router);
        $router->render('propiedades/admin');
    }
    public static function crear(){
        echo "Crear Propiedad";
    }
    public static function actualizar(){
        echo "Actualizar Propiedad";
    }

}




?>