<?php

namespace App;

class Propiedad {

    //Base de DATOS
    protected static $db;
    protected static $columnasDB = ['id','titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento','creado','vendedorId'];

    //Errores

    protected static $errores = [];

    public $id;
    public $titulo;
    public  $precio;
    public  $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

     //Definir la conexión a la Base de Datos
     public static function setDB($database){
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';

    }

    public function guardar(){

        // Sanitizar los Datos
        $atributos = $this->sanitizarAtributos();

        $string = join(', ', array_values($atributos));

        //Insertar en la base de datos
    $query = "INSERT INTO propiedades ( ";
    $query .= join(', ', array_keys($atributos));
    $query .= " ) VALUES (' "; 
    $query .= join("', '", array_values($atributos));
    $query .= " ')";

    $resultado = self::$db->query($query);


    }
    // Identificar y unir los atributos de la BD
    public function atributos(){
        $atributos = [];
        foreach(self::$columnasDB as $columna) {
            if ($columna==='id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
        
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        
        foreach($atributos as $key => $value ) {
            $sanitizado[$key]= self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    //Validación
   
    public static function getErrores(){
        return self::$errores;

    }

    public function validar(){
        
        if (!$this->titulo){
            self::$errores[]= "Debes añadir un Título";
        }
        if (!$this->precio){
            self::$errores[]= "El Precio es Obligatorio";
        }
        if (strlen($this->descripcion) < 10){
            self::$errores[]= "La Descripción es Obligatoria y debe tener al menos 10 Caracteres";
        }
        if (!$this->habitaciones){
            self::$errores[]= "El número de las habitaciones debe ser Obligatorio";
        }
        if (!$this->wc){
            self::$errores[]= "El número de los Baños debe ser Obligatorio";
        }
        if (!$this->estacionamiento){
            self::$errores[]= "El número de lugares de Estacionamiento debe ser Obligatorio";
        }
        if (!$this->vendedorId){
            self::$errores[]= "Elige a un vendedor";
        }
        
        // if (!$this->imagen['name'] || $$this->imagen['error']){
        //     self::$errores[]= "La imagen es Obligatoria";
        // }
        
        // //Validar por tamaño (1MB máximo)
        // $medida = 1000*1000;
        
        // if($this->imagen['size'] > $medida){
        //     $errores[]="La Imagen es muy pesada";
        // }

        return self::$errores;
     
    }


}