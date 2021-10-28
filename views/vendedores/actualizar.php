<main class="contenedor seccion">
    <h1>Actualizar Vendedor</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
    <section class="alerta error">
        <?php echo $error; ?>
    </section>
    <?php endforeach; ?>

    <form class="formulario" method="POST">

        <?php include __DIR__ . '/formulario.php'; ?>


        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>
</main>