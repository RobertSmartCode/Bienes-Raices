<?php
require '../../includes/app.php';

use App\Propiedad;

estaAutenticado();

$db = conectarDB();

//Consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$res = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = Propiedad::getErrores();

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';

// Ejecutar el código después que el usuario envíe el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $propiedad = new Propiedad($_POST);

   $errores = $propiedad->validar();

   
    if( empty($errores)){

           
   $propiedad->guardar();

   //Asignar files hacia una variable
   $imagen = $_FILES['imagen'];

   //Revisar que el arreglo de errores esté vacío


        /**Subida de Archivos */ 

        //Craer carpeta
        $carpetaImagenes = '../../imagenes/';
        
        if(!is_dir($carpetaImagenes)){
            mkdir($carpetaImagenes);
        }

        //Generar un nombre único
        $nombreImagen = md5(uniqid(rand(),true)). ".jpg";

        //Subir la imagen

        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

            
    
    //echo $query;
    $resultado = mysqli_query($db, $query);

    if($resultado){
        //Redireccionar al Usuario
        header('Location: /admin?resultado=1');
    }
}

}

incluirTemplates('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
    <section class="alerta error">
        <?php echo $error; ?>
    </section>
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Título Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad"
                value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="imagen/jpeg, imagen/png" name="imagen">

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
            <select name="vendedorId" id="vendedor">
                <option value="">--Seleccione--</option>
                <?php while ($vendedor = mysqli_fetch_assoc($res)): ?>
                <option <?php echo $vendedorId === $vendedor['id']? 'selected' : ''; ?>
                    value="<?php echo $vendedor['id']; ?>">
                    <?php echo $vendedor['nombre'] . " " . $vendedor['apellido'] ?></option>
                <?php  endwhile; ?>
            </select>
        </fieldset>
        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplates('footer');
?>