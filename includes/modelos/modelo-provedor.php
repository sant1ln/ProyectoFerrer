<?php 

    if($_POST['accion'] == 'crear'){

        require_once('../funciones/bd_conexion.php');

        $cedula    = filter_var($_POST['cedulaP'], FILTER_SANITIZE_STRING);
        $nombre    = filter_var($_POST['nombreP'], FILTER_SANITIZE_STRING);
        $Telefono  = filter_var($_POST['telefonoP'], FILTER_SANITIZE_STRING);
        $direccion = filter_var($_POST['direccionP'], FILTER_SANITIZE_STRING);

        try{
            $stmt = $conn->prepare("INSERT INTO proveedor (Cedula_Proveedor, Nombre_proveedor, Telefono_proveedor, Ciudad_proveedor) VALUES (?,?,?,?) ");
            $stmt->bind_param("ssss",$cedula, $nombre, $Telefono,$direccion );
            $stmt->execute();
          /*   $respuesta = array(
                'respuesta' => $stmt->error_list,
                'error' => $stmt->error
            ); */
            if($stmt->affected_rows == 1){
                
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'cedula' => $cedula,
                    'nombre' => $nombre,
                    'telefono' => $Telefono,
                    'direccion' => $direccion,
                    'id_insertado' => $stmt->insert_id
                    
                ); 
            
            }else{
                $respuesta = array(
                    'respuesta' => 'error',
                    'nombre' => $nombre
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
        $id = filter_var($_GET['id'],  FILTER_SANITIZE_NUMBER_INT);
        try{
            $stmt = $conn->prepare("DELETE FROM proveedor WHERE Cedula_Proveedor = ? ");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            if($stmt->affected_rows == 1){
                $resultado = array(
                    'resultado'=>'correcto'
                );
            }
        }catch(Exception $e){
        $resultado = array(
            'error'=> $e->getMessage()
        );
        }
        echo json_encode($resultado);

    }

 /*    if($_POST['accion'] == 'editar'){
        require_once('../funciones/bd_conexion.php');
        $cedula    = filter_var($_POST['cedulaP'], FILTER_SANITIZE_STRING);
        $nombre    = filter_var($_POST['nombreP'], FILTER_SANITIZE_STRING);
        $Telefono  = filter_var($_POST['telefonoP'], FILTER_SANITIZE_STRING);
        $direccion = filter_var($_POST['direccionP'], FILTER_SANITIZE_STRING);
        $cedulaUP  = ($_POST['cedula']);

        try{
            $stmt = $conn->prepare("UPDATE proveedor SET  Cedula_Proveedor = ?, Nombre_proveedor = ?, Telefono_proveedor = ?, Ciudad_proveedor = ? WHERE Cedula_Proveedor = ?");
            $stmt->bind_param("sssss",$cedula, $nombre, $Telefono,$direccion, $cedulaUP);
            $stmt->execute();
            $respuesta = array(
                'respuesta' => $stmt->error_list,
                'error' => $stmt->error
            );
            if($stmt->affected_rows == 1){
                $respuesta = array(
                    'respuesta' => 'correcto'
                );
            }else{
                $respuesta = array(
                    'respuesta' => 'incorrecto'
                );
            }
            $stmt->close();
            $conn->close();
        }catch(Excepetion $e){
            $respuesta = array(
                'error' =>  $e->getMessage()
            );
       }
       echo json_encode($respuesta);
    } */
    
?>