<?php
require '../../includes/config/database.php';
$db = conectarDB();

//Consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$res = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';

// Ejecutar el código después que el usuario envíe el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedorId = $_POST['vendedor'];
    $creado = date('Y/m/d');


    if (!$titulo){
        $errores[]= "Debes añadir un Título";
    }
    if (!$precio){
        $errores[]= "El Precio es Obligatorio";
    }
    if (strlen($descripcion) < 10){
        $errores[]= "La Descripción es Obligatoria y debe tener al menos 10 Caracteres";
    }
    if (!$habitaciones){
        $errores[]= "El número de las habitaciones debe ser Obligatorio";
    }
    if (!$habitaciones){
        $errores[]= "El número de las habitaciones debe ser Obligatorio";
    }
    if (!$wc){
        $errores[]= "El número de los Baños debe ser Obligatorio";
    }
    if (!$estacionamiento){
        $errores[]= "El número de lugares de Estacionamiento debe ser Obligatorio";
    }
    if (!$vendedorId){
        $errores[]= "Elige a un vendedor";
    }
   

    //Revisar que el arreglo de errores esté vacío
    if( empty($errores)){

            //Insertar en la base de datos
    $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId)
    VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId')";
    
    //echo $query;
    $resultado = mysqli_query($db, $query);

    if($resultado){
        //Redireccionar al Usuario
        header('Location: /admin');
    }
}

}

require '../../includes/funciones.php';
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

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php">
        <fieldset>
            <legend>Información General</legend>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Título Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad"
                value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="imagen/jpeg, imagen/png">

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
            <select name="vendedor" id="vendedor">
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