<?php

require '../../includes/app.php';
use App\Propiedad;
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
$consulta = "SELECT * FROM vendedores";
$res = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];


// Ejecutar el código después que el usuario envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    //Asignar atributos
    $args = $_POST['propiedad']; 

    $propiedad->sincronizar($args);

    debuguear($propiedad);

    
    //Asignar files hacia una variable
    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores[] = "Debes añadir un Título";
    }
    if (!$precio) {
        $errores[] = "El Precio es Obligatorio";
    }
    if (strlen($descripcion) < 10) {
        $errores[] = "La Descripción es Obligatoria y debe tener al menos 10 Caracteres";
    }
    if (!$habitaciones) {
        $errores[] = "El número de las habitaciones debe ser Obligatorio";
    }
    if (!$habitaciones) {
        $errores[] = "El número de las habitaciones debe ser Obligatorio";
    }
    if (!$wc) {
        $errores[] = "El número de los Baños debe ser Obligatorio";
    }
    if (!$estacionamiento) {
        $errores[] = "El número de lugares de Estacionamiento debe ser Obligatorio";
    }
    if (!$vendedorId) {
        $errores[] = "Elige a un vendedor";
    }

    //Validar por tamaño (1MB máximo)
    $medida = 1000 * 1000;

    if ($imagen['size'] > $medida) {
        $errores[] = "La Imagen es muy pesada";
    }


    //Revisar que el arreglo de errores esté vacío
    if (empty($errores)) {

        //Craer carpeta
        $carpetaImagenes = '../../imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';


        /**Subida de Archivos */

        if ($imagen['name']) {
            //Eliminar la imagen previa
            unlink($carpetaImagenes . $propiedad['imagen']);

            //Generar un nombre único
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //Subir la imagen

            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        } else {
            $nombreImagen = $propiedad['imagen'];
        }




        //Insertar en la base de datos
        $query = "UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento} , vendedorId = ${vendedorId} WHERE id= ${id} ";

        // echo $query;
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //Redireccionar al Usuario
            header('Location: /admin?resultado=2');
        }
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