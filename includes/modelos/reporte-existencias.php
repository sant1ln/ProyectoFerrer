<?php 

include "../funciones/bd_conexion.php";//abrimos la conexion

$resultado = $_POST;
$action = $_POST['generar'];

if(isset($action)){

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Reporte.xls"');
   
    $query = mysqli_query($conn,"SELECT Nombre_Producto, SUM(Cantidad_Producto) as existencia FROM producto, entradas_de_producto WHERE producto.Id_Producto=entradas_de_producto.Id_Productoo GROUP BY Nombre_Producto");
    $result = mysqli_num_rows($query);
    //var_dump($result);
    
    ?>
 
     <table border="1" > 
 <tr>
     <td >Nombre del producto</td>
     <td>Existencia</td>
     </tr>
     
     <?php
 while($fila = mysqli_fetch_assoc($query))
 {
     ?>
     
     <tr>
     <td><?php echo $fila['Nombre_Producto'];?></td>
     <td><?php echo $fila['existencia'];?></td>
    </tr>
 
     <?php
 }
 
 ?>

   </table> 
   <?php
 
   
 }


?>