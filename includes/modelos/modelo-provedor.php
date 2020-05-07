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
                    'telefono' => $telefono,
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

?>