<?php 


if($_POST['accion'] == 'editar'){
    /* echo json_encode($_POST); */
    require_once('../funciones/bd_conexion.php');
    $cargo     = filter_var($_POST['cargo'], FILTER_SANITIZE_STRING);
    $nombre    = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $cedula    = filter_var($_POST['cedula'], FILTER_SANITIZE_STRING);
    $celular   = filter_var($_POST['celular'], FILTER_SANITIZE_STRING);
    $direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
    $pass      = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $idempleado = ($_POST['id_empleado']);


    $opciones = array(
        'cost' => 12
    );

    $hash_password = password_hash($pass, PASSWORD_BCRYPT, $opciones);
    
    try{
        $stmt = $conn->prepare("UPDATE empleado SET Cargo = ?, Nombra = ?, Cedula = ?, Celular = ?, Direccion = ?, passwd = ? WHERE id_empleado = ?");
        $stmt->bind_param("sssssss",$cargo, $nombre, $cedula, $celular, $direccion, $hash_password, $idempleado);
        $stmt->execute();
        $respuesta = array(
            'respuesta' => $stmt->error_list,
            'error' => $stmt->error
        ); 
        if($stmt->affected_rows == 1){
            $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => $nombre
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Expetion $e){
        $respuesta = array(
            'error' => $e->getMessage()
        );
        
    }
    echo json_encode($respuesta);
}








?>