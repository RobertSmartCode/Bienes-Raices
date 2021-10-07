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

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Casa en la Playa</td>
                <td> <img src="/imagenes/2647f79d3271387ae7c18f871939861f.jpg" class="imagen-tabla"> </td>
                <td>1200000</td>
                <td>
                    <a href="#" class="boton-rojo-block">Eliminar</a>
                    <a href="#" class="boton-amarillo-block">Actualizar</a>
                </td>
            </tr>
        </tbody>
    </table>


</main>
<?php
incluirTemplates('footer');
?>