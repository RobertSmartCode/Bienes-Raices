<?php
// echo '<pre>';
// var_dump($_GET);
// echo'</pre>';
// exit;

$resultado = $_GET['resultado'] ?? null;
require '../includes/funciones.php';
incluirTemplates('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raíces</h1>
    <?php if(intval($resultado) === 1): ?>
    <p class="alerta exito">Anuncio Creado Correctamente</p>
    <?php endif; ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
</main>
<?php
incluirTemplates('footer');
?>