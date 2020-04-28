<?php 

if($_POST [Accion] == 'ingresar'){

    //creara un nuevo registro en la base de datos

    require_once('../funciones/bd_conexion.php');

    //validar las entradas
    $Cantidad = filter_var($_POST['Cantidad'], FILTER_SANITIZE_NUMBER_INT);
    $CodProducto = filter_var($_POST['CodProducto'], FILTER_SANITIZE_STRING);
    $CedProveedor = filter_var($_POST['CedProveedor'], FILTER_SANITIZE_NUMBER_INT);

    try {
        $stmt = $conn->prepare("INSERT INTO entradas_de_producto (Cantidad_Producto, Id_Productoo, Cedula_Proveedor) VALUES (?,?,?)");
        $stmt->bind_param("isi", $Cantidad, $CodProducto, $CedProveedor);
        $stmt->execute();
        
        if($stmt->affected_rows == 1){

            $respuesta = array(
                'respuesta'=> 'correcto',
                'id'=> $stmt->insert_Id_entrada_produc
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
//echo json_encode($_POST['Accion']);




?>