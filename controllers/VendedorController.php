<?php

namespace Controllers;

use MVC\Router;

class VendedorController{
    public static function crear(Router $router){
        $router->render('vendedores/crear',[

        ]);
    }
    public static function Actualizar(){
        echo "Actualizar Vendedor";
    }
    public static function eliminar(){
        echo "Eliminar Vendedor";
    }
}