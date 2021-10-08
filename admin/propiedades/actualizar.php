<?php

    //Validar URL por ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location: /admin');
}

   //Base de datos
require '../../includes/config/database.php';
$db = conectarDB();

//Consulta para obtener los datos de la propiedad
$consulta = "SELECT * FROM propiedades WHERE id = ${id}";
$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);
// echo "<pre)";
// var_dump($propiedad);
// echo "</pre)";

//Consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$res = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedorId = $propiedad['vendedorId'];
$imagenPropiedad= $propiedad['imagen'];

// Ejecutar el código después que el usuario envíe el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $titulo = mysqli_real_escape_string( $db, $_POST['titulo']);
    $precio = mysqli_real_escape_string( $db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string( $db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string( $db, $_POST['vendedor']);
    $creado = date('Y/m/d');

    //Asignar files hacia una variable
    $imagen = $_FILES['imagen'];

    if (!$titulo){
        $errores[]= "Debes añadir un Título";
    }
    if (!$precio){
        $errores[]= "El Precio es Obligatorio";
    }
    if (strlen($descripcion) < 10){
        $errores[]= "La Descripción es Obligatoria y debe tener al menos 10 Caracteres";
    }
    if (!$habitaciones){
        $errores[]= "El número de las habitaciones debe ser Obligatorio";
    }
    if (!$habitaciones){
        $errores[]= "El número de las habitaciones debe ser Obligatorio";
    }
    if (!$wc){
        $errores[]= "El número de los Baños debe ser Obligatorio";
    }
    if (!$estacionamiento){
        $errores[]= "El número de lugares de Estacionamiento debe ser Obligatorio";
    }
    if (!$vendedorId){
        $errores[]= "Elige a un vendedor";
    }

    //Validar por tamaño (1MB máximo)
    $medida = 1000*1000;

    if($imagen['size'] > $medida){
        $errores[]="La Imagen es muy pesada";
    }


    //Revisar que el arreglo de errores esté vacío
    if( empty($errores)){

         //Craer carpeta
         $carpetaImagenes = '../../imagenes/';
        
         if(!is_dir($carpetaImagenes)){
             mkdir($carpetaImagenes);
         }

            $nombreImagen ='';


        /**Subida de Archivos */ 

        if($imagen['name']){
            //Eliminar la imagen previa
            unlink($carpetaImagenes . $propiedad['imagen']);
            
              //Generar un nombre único
        $nombreImagen = md5(uniqid(rand(),true)). ".jpg";

        //Subir la imagen

        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        } else{
            $nombreImagen =$propiedad['imagen'];
        }
        

      

            //Insertar en la base de datos
    $query = "UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento} , vendedorId = ${vendedorId} WHERE id= ${id} ";
    
    // echo $query;
    $resultado = mysqli_query($db, $query);

    if($resultado){
        //Redireccionar al Usuario
        header('Location: /admin?resultado=2');
    }
}

}

require '../../includes/funciones.php';
incluirTemplates('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
    <section class="alerta error">
        <?php echo $error; ?>
    </section>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Título Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad"
                value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="imagen/jpeg, imagen/png" name="imagen">
            <img src="/imagenes/<?php echo $imagenPropiedad?>" class="imagen-small">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>
            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9"
                value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9"
                value="<?php echo $estacionamiento; ?>">
        </fieldset>
        <fieldset>
            <legend>Vendedor</legend>
            <select name="vendedor" id="vendedor">
                <option value="">--Seleccione--</option>
                <?php while ($vendedor = mysqli_fetch_assoc($res)): ?>
                <option <?php echo $vendedorId === $vendedor['id']? 'selected' : ''; ?>
                    value="<?php echo $vendedor['id']; ?>">
                    <?php echo $vendedor['nombre'] . " " . $vendedor['apellido'] ?></option>
                <?php  endwhile; ?>
            </select>
        </fieldset>
        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplates('footer');
?>