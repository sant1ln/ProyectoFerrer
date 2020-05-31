<?php 
include 'includes/funciones/sessiones.php';
include "../funciones/bd_conexion.php";//abrimos la conexion


//buscar cliente

if($_POST['action'] == 'searchCliente'){
    if(!empty($_POST['cliente'])){
        $nit = $_POST['cliente'];
        $query = mysqli_query($conn,"SELECT * FROM cliente WHERE cedula_cliente LIKE '$nit' ");
        mysqli_close($conn);
        $result = mysqli_num_rows($query);

        $data = '';
        if($result > 0){
            $data = mysqli_fetch_assoc($query); //ARRAY QUE ESTAMOS CREANDO CON LA CONSULTA
        }else{
            $data = 0;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    
    exit;
}

//registrar cliente- desde ventas
if($_POST['action'] == 'addCliente'){

    $cedulaCliente = $_POST['nit_cliente'];
    $nombreCliente = $_POST['nom_cliente'];
    $telCliente = $_POST['tel_cliente'];
    $dirCliente = $_POST['dir_cliente'];

    $query_insert = mysqli_query($conn,"INSERT INTO cliente(cedula_cliente,nombre,telefono,direccion)
    VALUES('$cedulaCliente','$nombreCliente','$telCliente','$dirCliente')");
    

     if($query_insert){
         $codCliente = mysqli_insert_id($conn);
         $mensaje = $codCliente;
     }else{
         $mensaje = 'error';
     }
     mysqli_close($conn);
     echo $mensaje;
     exit ;
}

//selectionar cantidad del producto
if($_POST['action'] == 'infoProducto'){

    $producto_id = $_POST['producto'];

    $query = mysqli_query($conn,"SELECT producto.Id_Producto,producto.Nombre_Producto, entradas_de_producto.Cantidad_Producto,producto.Precio_Venta
    FROM producto,entradas_de_producto WHERE producto.Id_Producto=$producto_id and producto.Id_Producto=entradas_de_producto.Id_Productoo");

    mysqli_close($conn);
    $result = mysqli_num_rows($query);

    if($result > 0){
        $data = mysqli_fetch_assoc($query);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo 'error';
    exit;

}

//agregar detalle producto
if($_POST['action'] == 'addDetalleProducto'){  
    if(empty($_POST['producto']) || empty($_POST['cantidad'])){
        echo 'error';
    }else{
        //guardamos la variables
        $codproducto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $token = md5($_SESSION['id']);

        $query_iva = mysqli_query($conn,"SELECT iva FROM configuracion");
        $result_iva = mysqli_num_rows($query_iva); //se pone en result_iva la cantidad de filas que se digitaron en query_iva

        $query_detalle_temp = mysqli_query($conn,"CALL add_detalle_temp($codproducto,$cantidad,'$token')");
        $result = mysqli_num_rows($query_detalle_temp);

        //variables para los calculos
        $detalleTablaDeProductos = '';
        $sub_total = 0;
        $iva = 0;
        $total = 0;
        $arrayData = array();

        if($result > 0){
            if($result_iva > 0){
                $info_iva = mysqli_fetch_assoc($query_iva);
                $iva = $info_iva['iva'];
            }

            while($data = mysqli_fetch_assoc($query_detalle_temp)){ //pasa a un array los datos que estan en el procedimiento
                $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                $sub_total = round($sub_total + $precioTotal, 2);
                $total = round($total + $precioTotal, 2);

                $detalleTablaDeProductos .= '<tr>
                        <td >'.$data['Id_Producto'].'</td>
                        <td >'.$data['Nombre_Producto'].'</td>
                        <td >'.$data['cantidad'].'</td>
                        <td >'.$data['precio_venta'].'</td>
                        <td >'.$precioTotal.'</td>
                        <div>
                        <td class="">
                            <a class="center" class="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['Correlativo'].');"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>';
            }

            $impuesto = round($sub_total * ($iva / 100),2);
            $total_siniva = round($sub_total - $impuesto,2);
            $total = round($total_siniva + $impuesto,2);

            $detalleTotales .= '
                <tr>
                    <td colspan="5" class="textright">TOTAL Q.</td>
                    <td class="textright">'.$total.'</td>
                </tr> ';

                //pasar los datos al array creado
                $arrayData['detalle'] = $detalleTablaDeProductos;
                $arrayData['totales'] = $detalleTotales;

                //retornar el array por medio de jsonencode
                echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
        }else{
            echo 'error';
        }

        mysqli_close($conn);
    }
    exit;
}

//extrae datos del detalle temp
if($_POST['action'] == 'buscarDetalle'){

    if(empty($_POST['usuario'])){
        echo 'error';
    }else{
        //guardamos la variable
        $token = md5($_SESSION['id']); 
        
        $query = mysqli_query($conn,"SELECT tmp.Correlativo,tmp.token_user,tmp.cantidad,tmp.precio_venta,p.Id_Producto,p.Nombre_Producto
                                            FROM detalle_temp tmp
                                            INNER JOIN producto p
                                            ON tmp.Id_Producto = p.Id_Producto
                                            WHERE token_user = '$token' ");

        $result = mysqli_num_rows($query);
        
        $query_iva = mysqli_query($conn,"SELECT iva FROM configuracion");
        $result_iva = mysqli_num_rows($query_iva); //se pone en result_iva la cantidad de filas que se digitaron en query_iva


        //variables para los calculos
        $detalleTablaDeProductos = '';
        $sub_total = 0;
        $iva = 0;
        $total = 0;
        $arrayData = array();

        if($result > 0){
            if($result_iva > 0){
                $info_iva = mysqli_fetch_assoc($query_iva);
                $iva = $info_iva['iva'];
            }

            while($data = mysqli_fetch_assoc($query)){ //pasa a un array los datos que estan en el procedimiento
                $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                $sub_total = round($sub_total + $precioTotal, 2);
                $total = round($total + $precioTotal, 2);

                $detalleTablaDeProductos .= '<tr>
                        <td >'.$data['Id_Producto'].'</td>
                        <td >'.$data['Nombre_Producto'].'</td>
                        <td >'.$data['cantidad'].'</td>
                        <td >'.$data['precio_venta'].'</td>
                        <td >'.$precioTotal.'</td>
                        <div>
                        <td class="">
                            <a class="center" class="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['Correlativo'].');"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>';
            }

            $impuesto = round($sub_total * ($iva / 100),2);
            $total_siniva = round($sub_total - $impuesto,2);
            $total = round($total_siniva + $impuesto,2);

            $detalleTotales .= '
                <tr>
                    <td colspan="5" class="textright">TOTAL Q.</td>
                    <td class="textright">'.$total.'</td>
                </tr> ';

                //pasar los datos al array creado
                $arrayData['detalle'] = $detalleTablaDeProductos;
                $arrayData['totales'] = $detalleTotales;

                //retornar el array por medio de jsonencode
                echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
        }else{
            echo 'errorenlaconsulta';
        }

        mysqli_close($conn);
    }
    exit;
}

//hace el calculo de los productos
if($_POST['action'] == 'del_product_detalle'){

    if(empty($_POST['id_detalle'])){
        echo 'error';
    }else{
        //guardamos la variable
        $id_detalle = $_POST['id_detalle'];
        $token = md5($_SESSION['id']); 
        
        $query_iva = mysqli_query($conn,"SELECT iva FROM configuracion");
        $result_iva = mysqli_num_rows($query_iva); //se pone en result_iva la cantidad de filas que se digitaron en query_iva

        $query_detalle_temp      = mysqli_query($conn,"CALL delete_detalle_temp($id_detalle,'$token')");
        $result = mysqli_num_rows($query_detalle_temp);

        //variables para los calculos
        $detalleTablaDeProductos = '';
        $sub_total = 0;
        $iva = 0;
        $total = 0;
        $arrayData = array();

        if($result > 0){
            if($result_iva > 0){
                $info_iva = mysqli_fetch_assoc($query_iva);
                $iva = $info_iva['iva'];
            }

            while($data = mysqli_fetch_assoc($query_detalle_temp)){ //pasa a un array los datos que estan en el procedimiento
                
                $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                $sub_total = round($sub_total + $precioTotal, 2);
                $total = round($total + $precioTotal, 2);

                $detalleTablaDeProductos .= '<tr>
                        <td >'.$data['Id_Producto'].'</td>
                        <td >'.$data['Nombre_Producto'].'</td>
                        <td >'.$data['cantidad'].'</td>
                        <td >'.$data['precio_venta'].'</td>
                        <td >'.$precioTotal.'</td>
                        <div>
                        <td class="">
                            <a class="center" class="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['Correlativo'].');"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>';
            }

            $impuesto = round($sub_total * ($iva / 100),2);
            $total_siniva = round($sub_total - $impuesto,2);
            $total = round($total_siniva + $impuesto,2);

            $detalleTotales .= '
                <tr>
                    <td colspan="5" class="textright">TOTAL Q.</td>
                    <td class="textright">'.$total.'</td>
                </tr> ';

                //pasar los datos al array creado
                $arrayData['detalle'] = $detalleTablaDeProductos;
                $arrayData['totales'] = $detalleTotales;

                //retornar el array por medio de jsonencode
                echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
        }else{
            echo 'error';
        }

        mysqli_close($conn);
    }
    exit;
}


//anular venta
if($_POST['action'] == 'anularVenta'){

    $token = md5($_SESSION['id']);

    $query_anular = mysqli_query($conn,"DELETE FROM detalle_temp WHERE token_user = '$token' ");
    mysqli_close($conn);

    if($query_anular){
        echo 'echo!';
    }else{
        echo 'error';
    }
}

//procesar venta
if($_POST['action'] == 'procesarventa'){

    $codcliente = $_POST['codcliente'];
    $token = md5($_SESSION['id']);
    $emplea = ($_SESSION['id']);
    $prueba = $_POST['prueba'];
    $metodo = $_POST['metodo'];

    
   $query = mysqli_query($conn,"SELECT * FROM detalle_temp WHERE token_user = '$token' ");
    $result = mysqli_num_rows($query);

    if($result > 0){

        $query_procesar = mysqli_query($conn,"CALL procesar_venta($prueba,$codcliente,'$token','$metodo')");
        $resul_detalle = mysqli_num_rows($query_procesar);
        if($resul_detalle > 0){
            $data = mysqli_fetch_assoc($query_procesar);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }else{
            echo 'error';
        }
    }else{
        echo 'errorss';
    }

    mysqli_close($conn);
    exit;  

}







?>