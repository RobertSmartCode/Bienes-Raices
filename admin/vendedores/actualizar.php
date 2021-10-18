<?php
require '../../includes/app.php';
use App\Vendedor;

estaAutenticado();

// Validar que sea un ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location: /admin');
}

//Obtener el arreglo del vendedor desde la base de datos

$vendedor = Vendedor::find($id);

//Arreglo con mensajes de errores
$errores = Vendedor::getErrores();

// Ejecutar el código después que el usuario envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Asignar valores
    $args = $_POST['vendedor'];
    //Sincronizar objeto en memoria con lo que el usuario escribió
    $vendedor->sincronizar($args);

     // Validar que no haya campos vacíos

    $errores = $vendedor->validar();

    //No hay errores
    if(empty($errores)){
        $vendedor->guardar();
    }
    
}

incluirTemplates('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedor</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
    <section class="alerta error">
        <?php echo $error; ?>
    </section>
    <?php endforeach; ?>

    <form class="formulario" method="POST">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplates('footer');
?>