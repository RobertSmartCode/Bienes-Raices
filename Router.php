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
        $urlActual = $_SERVER['PATH_INFO'] ?? '/'; 
        $metodo  = $_SERVER['REQUEST_METHOD'];

        if($metodo=== 'GET'){
            $fn = $this->rutasGET[ $urlActual] ?? null;    
        }else{
            $fn = $this->rutasPOST[ $urlActual] ?? null; 
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