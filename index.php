<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Pacifico&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<?php

  session_start();

    if(isset($_GET['cerrar_session'])){
        $_SESSION = array(
        );
    }

?>

<body>


  
    <div class="login" id="login">
        <img src="./img/logo.png" alt="Logo">
        <form  id="login" method="POST">
            <label for="usuario">Usuario</label>
            <input class="Login-input" type="text" value="" id="usuario">
            <label for="Contraseña">Contraseña</label>
            <input class="Login-input" type="password" name="Contraseña" id="contrasena">

            <input type="hidden" id='Accion' value="login">
            <input type="submit" value="Ingresar" id="Ingreso" class="boton btn-aceptar">
        </form>
    
    </div>
    <script src="./Scripts/login.js"></script>
    <script src="./Scripts/sweetalert2.all.min.js"></script>

</body>
</html>




