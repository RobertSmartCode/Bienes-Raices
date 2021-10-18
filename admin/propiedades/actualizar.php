<?php

require '../../includes/app.php';
use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;
estaAutenticado();

//Validar URL por ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}

//Consulta para obtener los datos de la propiedad
$propiedad = Propiedad::find($id);

//Consultar para obtener los vendedores
$vendedores = Vendedor::all();


//Arreglo con mensajes de errores
$errores = Propiedad::getErrores();

// Ejecutar el código después que el usuario envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    //Asignar atributos
    $args = $_POST['propiedad']; 

    $propiedad->sincronizar($args);
    
    //Validación
    $errores= $propiedad->validar();

    //Subida de archivos

      //Generar un nombre único
      $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    
    if($_FILES['propiedad']['tmp_name']['imagen']){
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    } 
    if (empty($errores)) {
        if($_FILES['propiedad']['tmp_name']['imagen']){
        //Almacenar imagen
        $image->save(CARPETA_IMAGENES . $nombreImagen);
        }//Podría faltar un else

        $propiedad->guardar();
    }
}
incluirTemplates('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
    <section class="alerta error">
        <?php echo $error; ?>
    </section>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>
        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplates('footer');
?>