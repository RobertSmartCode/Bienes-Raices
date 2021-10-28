<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController{
    public static function crear(Router $router){

        $errores = Vendedor::getErrores();
        $vendedor= new Vendedor;

        // Ejecutar el código después que el usuario envíe el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);
            // Validar que no haya campos vacíos

            $errores = $vendedor->validar();

            //No hay errores
            if(empty($errores)){
                $vendedor->guardar();
            }

            // debuguear($vendedor);
            
        }
        $router->render('vendedores/crear',[
            'errores' => $errores, 
            'vendedor' => $vendedor 
        ]);
    }
    public static function Actualizar(Router $router){
        
        $errores = Vendedor::getErrores();
        $id = validarOredireccionar('/admin');
        $vendedor =  Vendedor::find($id);
        //Ejecutar el código después que el usuario envíe el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar valores
            $args = $_POST['vendedor'];
            //Sincronizar objeto en memoria con lo que el usuario escribió
            $vendedor->sincronizar($args);

            // Validar que no haya campos vacíos

            $errores = $vendedor->validar();

            //No hay errores
            if(empty($errores)){
                $vendedor->guardar();
            }
            
        }
        
        $router->render('vendedores/actualizar',[
            'errores' => $errores, 
            'vendedor' => $vendedor 
        ]);
    }
    public static function eliminar(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
        
            if ($id) {
                //Validar tipo
                $tipo = $_POST['tipo'];
                if( validarTipoContenido($tipo)){
                        $vendedor = Vendedor::find($id);
                        $vendedor->eliminar();
                    
                }         
            }
        }
    }
}