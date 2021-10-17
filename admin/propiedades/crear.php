<?php
require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

estaAutenticado();

$db = conectarDB();

$propiedad = new Propiedad;

//Consultar para obtener los vendedores
$consultar = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consultar);

//Arreglo con mensajes de errores
$errores = Propiedad::getErrores();


// Ejecutar el código después que el usuario envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    /**Crea una nueva instancia */

    $propiedad = new Propiedad($_POST['propiedad']);

            /**Subida de Archivos */

        //Craer carpeta // Esto no lo tiene Juan
        $carpetaImagenes = '../../imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        } //Hasta aquí no está en el código de Juan
        //Generar un nombre único
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        //Setear la imagen
        //Realiza un resize a la imagen con intervention

        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
            $propiedad->setImagen($nombreImagen);
        } 
        //Validar
    $errores = $propiedad->validar();

    if (empty($errores)) {

        //Crear la carpeta para subir imagenes
        if(!is_dir(CARPETA_IMAGENES)){
            mkdir(CARPETA_IMAGENES);
        }

        // Guardar la imagen el servidor
            
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        //Guardar en la base de datos
        $resultado = $propiedad->guardar();

        //Mensaje de exito o error

        if ($resultado) {
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

    <?php foreach ($errores as $error) : ?>
    <section class="alerta error">
        <?php echo $error; ?>
    </section>
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplates('footer');
?>