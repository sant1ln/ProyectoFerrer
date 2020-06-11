<?php 
$hoy = date("Y-m-j");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    
    <title>Ferrer</title>
</head>
<body>
    
    <header>
    <div class="Home">
    <nav class="TengoEstilos">
        <img src="./img/logo.png" alt="Logo">
        <h1><?php /* echo($_SESSION['nombre']); */ ?> </h1>
        <div>
        <p class="header-session"><i class="icon fas fa-user"></i><?php echo $_SESSION['nombre']; ?></p>
        <p class="header-session"><i class="icon fas fa-calendar-alt"></i> <?php echo $hoy; ?></p>
        </div>
        
        <ul class="enlace-navegacion">
            <li><a id="vender" class="encalce" href="Venta.php">Vender</a></li>
            <li><a id="admin"  class="encalce" href="Admin.php">Administrador</a></li>
            <li><a href="index.php?cerrar_session=true" class="salir"><i class="fas fa-sign-out-alt Singout"></i></a></li>
        </ul>
       
    </nav>
   </header>