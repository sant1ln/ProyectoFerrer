<?php

$Accion = $_POST['Accion'];
$contrasena = $_POST['contrasena'];
$usuario = $_POST['usuario'];

 if ($Accion == 'login'){

    //escribir ocdigo que logueee a los admin
    include '../funciones/bd_conexion.php';

    try{
        $stm = $conn->prepare("SELECT Nombre, id_empleado, passwd, cargo FROM empleado WHERE Nombre= ?");
        $stm->bind_param('s', $usuario);
        $stm->execute();
         //loguear el usuario
         $stm->bind_result($Nombre, $id_empleado, $passwd, $cargo);
         $stm->fetch();
         if($Nombre){
             //el usuario existe, verificar el passwrod
             if(password_verify($contrasena, $passwd )){
                 //inicar la seccion
                 session_start();
                 $_SESSION['nombre'] = $usuario;
                 $_SESSION['id'] = $id_empleado;
                 $_SESSION['login'] = true;

                 //login correcto
                 $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => $Nombre,
                    'Accion' => $Accion,
                    'tipo_empleado'=> $cargo
                );
             }else{
                 //login incorrecto
                 $respuesta = array(
                     'resultado' => 'contraseña incorrecta'

                 );

             }
           
         }else{
             $respuesta = array(
                 'error'=> ' el usuario no existe'

             );
         }
       
        $stm->close();
        $conn->close();

    }catch(Exception $e) {
        // En caso de un error, tomar la exepcion
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }
    echo json_encode($respuesta); 

}




?>