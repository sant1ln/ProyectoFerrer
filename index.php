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
<body>
   
    <div class="login" id="login">
        <img src="./img/logo.png" alt="Logo">
        <form  action="" method="POST">
            <label for="usuario">Usuario</label>
            <input class="Login-input" type="text" value="" id="usuario">
            <label for="Contraseña">Contraseña</label>
            <input class="Login-input" type="password" name="Contraseña" id="Contrasena">
            <select class="Tipo" name="Tipo" id="Tipo">
                <option id="selecionar" value="0">Seleciona Tipo</option>
                <option id="Administrador" value="1">Administrador</option>
                <option id="Cajero" value="2">Cajero</option>
            </select>
    
            <input type="button" value="Ingresar" id="Ingreso" class="boton btn-aceptar">
        </form>
    
    </div>
    <script src="./Scripts/login.js"></script>
</body>
</html>




