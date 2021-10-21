<?php

namespace MVC;

class Router{

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn ){
        $this->rutasGET[$url] = $fn;

    }


    public function comprobarRutas(){
        $urlActual = $_SERVER['REQUEST_URI'] ?? '/';
        $metodo  = $_SERVER['REQUEST_METHOD'];

        if($metodo=== 'GET'){
            $fn = $this->rutasGET[ $urlActual] ?? null;
           
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
    public function render($view){
        ob_start(); //Almacena en memoria
        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean();

        include __DIR__ . "/views/layout.php";
    }
}

?>