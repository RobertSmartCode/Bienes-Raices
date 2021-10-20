<?php

namespace App;

class Propiedad extends ActiveRecord {
    
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id','titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento','creado','vendedorId'];

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

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';

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
        
        if (!$this->imagen){
            self::$errores[]= "La imagen de la Propiedad es Obligatoria";
        }
        

        return self::$errores;
     
    }
} 