<?php

require 'includes/config/database.php';
$db = conectarDB();

//Arreglo con mensajes de errores
$errores = [];

$email = '';
$password = '';

// Autenticar el usuario

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $email = mysqli_real_escape_string( $db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)); 

    $password = mysqli_real_escape_string( $db, $_POST['password']);
}
if (!$email){
    $errores[]= "El Email es obligatorio o no es valido";
}
if (!$password){
    $errores[]= "El Password es obligatorio";
    
}

//Revisar que el arreglo de errores esté vacío
if( empty($errores)){
    //Revisar si el usuario existe

$query = "SELECT * FROM usuarios WHERE email = '${email}'";
$resultado = mysqli_query($db, $query);


if($resultado->num_rows){

    // Revisar si el password es correcto
    $usuario = mysqli_fetch_assoc($resultado);

    //Verificar si el password es correcto o no

    $auth = password_verify($password, $usuario['password']);

    if($auth){
        // El usuario está autenticado
        session_start();

        //LLenar el arreglo de la session
        $_SESSION['usuario'] = $usuario['email'];
        $_SESSION['login'] = true;

        
            header('Location: /admin');

    }else {
        $errores[] = 'El password es incorrecto';
    }

}else{
    $errores[] = "El usuario no existe";
}
}




// Incluye el header

require 'includes/funciones.php';
incluirTemplates('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Seción</h1>

    <?php foreach($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>
    <?php endforeach; ?>

    <form method="POST" action="" class="formulario" novalidate>
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email" value="<?php echo $email; ?>">

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Tu Password" id="password"
                value="<?php echo $password; ?>">
        </fieldset>
        <input type="submit" value="Iniciar Sesión" class=" boton boton-verde">

    </form>
</main>
<?php
incluirTemplates('footer');
?>