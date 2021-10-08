<?php

// Importar la conexión

require '../includes/config/database.php';
$db = conectarDB();

//Escribir el querySelector

$query = "SELECT * FROM propiedades";


//consultar la base de Departamentos
$resultadoConsulta = mysqli_query($db, $query);


//Mostrar mensaje condicional
$resultado = $_GET['resultado'] ?? null;

//Incluye un template
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
            <!-- Mostrar los resultados-->
            <?php while ($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
            <tr>
                <td><?php echo $propiedad['id'];?></td>
                <td><?php echo $propiedad['titulo'];?></td>
                <td> <img src="/imagenes/<?php echo $propiedad['imagen'];?>" class="imagen-tabla"> </td>
                <td>$<?php echo $propiedad['precio'];?></td>
                <td>
                    <a href="#" class="boton-rojo-block">Eliminar</a>
                    <a href="#" class="boton-amarillo-block">Actualizar</a>
                </td>
            </tr>
            <?php  endwhile; ?>
        </tbody>
    </table>


</main>

<?php
//Cerrar la conexión
mysqli_close($db);
incluirTemplates('footer');
?>