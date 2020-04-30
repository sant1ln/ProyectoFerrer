<?php 

if($_POST['accion'] == 'crear'){
    //crea un nuevo registro en BD

    require_once('../funciones/bd_conexion.php');

    // validar las entradas
    $cargo     = filter_var($_POST['cargo'], FILTER_SANITIZE_STRING);
    $nombre    = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $cedula    = filter_var($_POST['cedula'], FILTER_SANITIZE_STRING);
    $celular   = filter_var($_POST['celular'], FILTER_SANITIZE_STRING);
    $direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
    $pass      = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);


    $opciones = array(
        'cost' => 12
    );

    $hash_password = password_hash($pass, PASSWORD_BCRYPT, $opciones);

    try{
         $stmt = $conn->prepare("INSERT INTO empleado (Cargo, Nombre, Cedula, Celular, Direccion,passwd)  VALUES (?, ?, ?, ?, ?, ?) ");
        //  los ? se usan para evitar Inyeccion SQL y los sss son tipo de datos.
         $stmt->bind_param("ssssss",$cargo, $nombre, $cedula, $celular, $direccion, $hash_password);
         $stmt->execute();
            if($stmt->affected_rows == 1){

                $respuesta = array(
                    'respuesta' => 'correcto',
                    'datos' => array(
                        'cargo' => $cargo,
                        'nombre' => $nombre,
                        'cedula' => $cedula,
                        'celular' => $celular,
                        'direccion' => $direccion,
                        'id_insertado' => $stmt->insert_id
                    )
                ); 
            
            }
         $stmt->close();
         $conn->close();

        }catch(Expetion $e){
        $respuesta = array(
            'error' => 'algo salió mal'
        );
        
    }

    
    echo json_encode($respuesta);
                    

}




if($_GET['accion'] == 'borrar'){
    require_once('../funciones/bd_conexion.php');
    // echo json_encode($_GET);
   $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
   

   
   try{
       $stmt = $conn->prepare("DELETE FROM empleado WHERE id_empleado = ? ");
       $stmt->bind_param("i", $id);
       $stmt->execute();
       if($stmt->affected_rows == 1){
            $respuesta = array(
                'respuesta' =>  'correcto'
            );
        }
       $stmt->close();
       $conn->close();

   }catch(Excepetion $e){
        $respuesta = array(
            'error' =>  $e->getMessage(),
            'sms' => 'llegue aqui'

        );
   }
   echo json_encode($respuesta);
} 
   


?> 