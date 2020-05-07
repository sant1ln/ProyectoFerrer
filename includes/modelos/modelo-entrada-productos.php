<?php 

if($_POST [Accion] == 'ingresar'){

    //creara un nuevo registro en la base de datos

    require_once('../funciones/bd_conexion.php');

    //validar las entradas
    $Cantidad = filter_var($_POST['Cantidad'], FILTER_SANITIZE_NUMBER_INT);
    $CodProducto = filter_var($_POST['CodProducto'], FILTER_SANITIZE_STRING);
    $CedProveedor = filter_var($_POST['CedProveedor'], FILTER_SANITIZE_NUMBER_INT);
    $Nombre_u = ($_POST['Nombre_u']);

    try {
        $stmt = $conn->prepare("INSERT INTO entradas_de_producto (Cantidad_Producto, Id_Productoo, Cedula_Proveedor,Nombre_Usuarioo) VALUES (?,?,?,?)");
        $stmt->bind_param("isis", $Cantidad, $CodProducto, $CedProveedor,$Nombre_u);
        $stmt->execute();
        
        if($stmt->affected_rows == 1){

            $respuesta = array(
                'respuesta'=> 'correcto',
                'datos' => array(
                    'cantidad' => $Cantidad,
                    'codProducto' => $CodProducto,
                    'cedProveedir' => $CedProveedor,
                    'nombre_usuario' => $Nombre_u,
                    'id'=> $stmt->insert_id

                )               
            );

        }
             
        $stmt->close();
        $conn->close();
    } catch(Exception $e) {
        $respuesta = array(
             'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);


}


if($_GET ['Accion'] == 'borrar'){

    require_once('../funciones/bd_conexion.php');

    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
    try{
        $stmt = $conn->prepare("DELETE FROM entradas_de_producto WHERE 	Id_Productoo = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

       
            $respuesta = array(
                'respuesta' => 'correcto',

            );
        

    }catch(Exception $e){
        $respuesta = array(
            'error'=> $e->getMessage()
        );
    }
    echo json_encode($respuesta);
}





?>