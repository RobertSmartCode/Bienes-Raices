<?php
require '../includes/app.php';
estaAutenticado();

use App\Propiedad;

//Implementar un método para obtener todas las propiedades 

$propiedades = Propiedad::all();

//Mostrar mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id) {

        //Elinimar el archivos
        $query = "SELECT imagen FROM propiedades WHERE id = ${id}";

        $resultado = mysqli_query($db, $query);
        $propiedad = mysqli_fetch_assoc($resultado);
        unlink('../imagenes/' . $propiedad['imagen']);

        //Elimina la propiedad
        $query = "DELETE FROM propiedades WHERE id= ${id}";
        echo $query;
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            header('Location: /admin?resultado=3');
        }
    }
}

//Incluye un template
incluirTemplates('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raíces</h1>
    <?php if (intval($resultado) === 1) : ?>
    <p class="alerta exito">Anuncio Creado Correctamente</p>
    <?php elseif (intval($resultado) === 2) : ?>
    <p class="alerta exito">Anuncio Actualizado Correctamente</p>
    <?php elseif (intval($resultado) === 3) : ?>
    <p class="alerta exito">Anuncio Eliminado Correctamente</p>
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
            <?php foreach ($propiedades as $propiedad) : ?>
            <tr>
                <td><?php echo $propiedad->id; ?></td>
                <td><?php echo $propiedad->titulo; ?></td>
                <td> <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"> </td>
                <td>$<?php echo $propiedad->precio; ?></td>
                <td>
                    <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>"
                        class="boton-amarillo-block">Actualizar</a>
                    <form method="POST" class="w-100P">

                        <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">

                        <input type="submit" class="boton-rojo-block" value="Eliminar">

                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</main>

<?php
//Cerrar la conexión
mysqli_close($db);
incluirTemplates('footer');
?>