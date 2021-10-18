<?php
require '../../includes/app.php';
use App\Vendedor;

estaAutenticado();

$vendedor = new Vendedor;

//Arreglo con mensajes de errores
$errores = Vendedor::getErrores();

// Ejecutar el código después que el usuario envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Crear una nueva instancia
    $vendedor = new Vendedor($_POST['vendedor']);
    // Validar que no haya campos vacíos

    $errores = $vendedor->validar();

    //No hay errores
    if(empty($errores)){
        $vendedor->guardar();
    }

    // debuguear($vendedor);
    
}

incluirTemplates('header');
?>

<main class="contenedor seccion">
    <h1>Registrar Vendedor</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
    <section class="alerta error">
        <?php echo $error; ?>
    </section>
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/admin/vendedores/crear.php">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplates('footer');
?>