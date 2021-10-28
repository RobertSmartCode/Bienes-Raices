<?php

namespace MVC;

class Router{

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn ){
        $this->rutasGET[$url] = $fn;

    }

    public function post($url, $fn ){
        $this->rutasPOST[$url] = $fn;

    }

    public function comprobarRutas(){

        session_start();
        $auth = $_SESSION['login'] ?? null;

        // Arreglos de Rutas Protegidas
        $rutas_protegidas = ['/admin','/propiedad/crear','/propiedad/actualizar', '/propiedad/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/'; 
        $metodo  = $_SERVER['REQUEST_METHOD'];

        if($metodo=== 'GET'){
            $fn = $this->rutasGET[ $urlActual] ?? null;    
        }else{
            $fn = $this->rutasPOST[ $urlActual] ?? null; 
        }

        //Proteger rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth){
            header('Location: /');
            
        }

        if($fn){
            //La URL existe y hay una función 
            //debuguear($this);

            call_user_func($fn, $this);

        }else{
            //Redirecionar a una página 404
            echo "Página No Encontrada";
        }   
    }
    //Muestra Vista
    public function render($view, $datos=[]){
        
        foreach($datos as $key => $value){
            $$key = $value;
        }

        ob_start(); //Almacena en memoria
        
        include __DIR__ . "/views/$view.php";
        
        $contenido = ob_get_clean();

        include __DIR__ . "/views/layout.php";
    }
}

?>