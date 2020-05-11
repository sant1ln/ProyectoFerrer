<?php  

if($_POST['accion'] == 'editar'){
        require_once('../funciones/bd_conexion.php');
        $cedula    = filter_var($_POST['cedulaP'], FILTER_SANITIZE_STRING);
        $nombre    = filter_var($_POST['nombreP'], FILTER_SANITIZE_STRING);
        $Telefono  = filter_var($_POST['telefonoP'], FILTER_SANITIZE_STRING);
        $direccion = filter_var($_POST['direccionP'], FILTER_SANITIZE_STRING);
        $creador   = filter_var($_POST['creador'], FILTER_SANITIZE_STRING);
        $creador   = ($_POST['creador']);
        $cedulaUP  = ($_POST['cedula']);

        try{
            $stmt = $conn->prepare("UPDATE proveedor SET  Cedula_Proveedor = ?, Nombre_proveedor = ?, Telefono_proveedor = ?, Ciudad_proveedor = ?, creador = '$creador'   WHERE Cedula_Proveedor = ?");
            $stmt->bind_param("sssss",$cedula, $nombre, $Telefono,$direccion, $cedulaUP  );
            $stmt->execute();
            
            if($stmt->affected_rows == 1){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => $nombre
                );
            }else{
                $respuesta = array(
                       
                
                    'respuesta' => 'error',
                    'cedula' => $cedula,
                    'nombre' => $nombre,
                    'telefono' => $Telefono,
                    'direccion' => $direccion,
                    'cedN' => $cedulaUP,
                    'resp' => $creador
                    /* 'id_insertado' => $stmt->insert_id */
                    
                 
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
    }

    ?>