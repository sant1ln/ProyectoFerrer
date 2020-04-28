<?php 

if($_POST [Accion] == 'ingresar'){

    //creara un nuevo registro en la base de datos

    require_once('../funciones/bd_conexion.php'); 

    //validar las entradas
    $Codigo = filter_var($_POST['Codigo'], FILTER_SANITIZE_NUMBER_INT);
    $Nombre = filter_var($_POST['Nombre'], FILTER_SANITIZE_STRING);
    $Tipo = filter_var($_POST['Tipo'], FILTER_SANITIZE_STRING);
    $Precio = filter_var($_POST['Precio'], FILTER_SANITIZE_NUMBER_INT);

    try {
        $stmt = $conn->prepare("INSERT INTO producto (Id_Producto, Nombre_Producto, Id_Tipo_Producto, Precio_Venta) VALUES (?,?,?,?)");
        $stmt->bind_param("issi", $Codigo, $Nombre, $Tipo, $Precio);
        $stmt->execute();
        
        if($stmt->affected_rows == 1){

            $respuesta = array(
                'respuesta'=> 'correcto',
                'datos'=> array(
                    'Codigo'=>$Codigo,
                    'Nombre'=>$Nombre,
                    'Tipo'=>$Tipo,
                    'Precio'=>$Precio,
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
//echo json_encode($_POST['Accion']);

if($_GET[Accion] == 'borrar'){
    //echo json_encode($_GET);

    require_once('../funciones/bd_conexion.php');//abrimos la conexion

    $id = filter_var($_GET['id'],  FILTER_SANITIZE_NUMBER_INT);

    try{
        $stmt = $conn->prepare("DELETE FROM producto WHERE Id_Producto = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($stmt->affected_rows == 1){
            $respuesta = array(
                'respuesta'=> 'correcto'
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e){
        $respuesta = array(
            'error'=> $e->getMessage()
        );
    }
    echo json_encode($respuesta);

}

if($_POST [Accion] == 'editar'){  
    require_once('../funciones/bd_conexion.php');//abrimos la conexion
    //echo json_encode($_POST); //ver que estoy

    $Codigo = filter_var($_POST['Codigo'], FILTER_SANITIZE_NUMBER_INT);
    $Nombre = filter_var($_POST['Nombre'], FILTER_SANITIZE_STRING);
    $Tipo = filter_var($_POST['Tipo'], FILTER_SANITIZE_STRING);
    $Precio = filter_var($_POST['Precio'], FILTER_SANITIZE_NUMBER_INT);
   
    try{
     $stmt =  $conn->prepare("UPDATE producto SET Nombre_Producto = ?, Id_Tipo_Producto = ?, Precio_Venta = ? WHERE Id_Producto = ?");
    $stmt->bind_param("ssii", $Nombre, $Tipo,  $Precio, $Codigo);
  
   
   
        $stmt->execute();
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
}
    






?>