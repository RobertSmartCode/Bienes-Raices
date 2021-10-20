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
            //debuguear($fn);

            call_user_func($fn, $this);

        }else{
            //Redirecionar a una página 404
            echo "Página No Encontrada";
        }

        
    }
}

?>