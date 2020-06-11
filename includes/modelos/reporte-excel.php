<?php

include "../funciones/bd_conexion.php";//abrimos la conexion

$resultado = $_POST;
$action = $_POST['generar'];
$fechainicial = $_POST['fecha_inicio'];
$fechafinal = $_POST['fecha_final'];



if(isset($action)){

   header('Content-Type: application/vnd.ms-excel');
   header('Content-Disposition: attachment; filename="Reporte.xls"');
  
   $query = mysqli_query($conn,"SELECT No_factura,Fecha,forma_pago FROM factura WHERE Fecha BETWEEN '$fechainicial' and '$fechafinal' ");
   $result = mysqli_num_rows($query);
   //var_dump($result);
   
   ?>

    <table border="1" > 
<tr>
    <td >No. factura</td>
    <td>Fecha</td>
    <td>Metodo de pago</td>
    </tr>
    
    <?php
while($fila = mysqli_fetch_assoc($query))
{
    ?>
    
    <tr>
    <td><?php echo $fila['No_factura'];?></td>
    <td><?php echo $fila['Fecha'];?></td>
    <td><?php echo $fila['forma_pago'];?></td>
   </tr>

    <?php
}

?>
</table> 




<?php
$querytotale = mysqli_query($conn,"SELECT count(*)as total from factura WHERE fecha >= '$fechainicial' and fecha <= '$fechafinal' AND forma_pago = 'efectivo'");
$resulttotale = mysqli_num_rows($querytotale);
//var_dump($resulttotale);
?>
<table border="1" > 
<tr>
    <td>total ventas efectivo</td>
    </tr>
    
    <?php
while($fila1 = mysqli_fetch_assoc($querytotale))
{
    ?>
    
    <tr>
    <td><?php echo $fila1['total'];?></td>
   </tr>

    <?php
}
?>


</table> 
           


  <?php  
  $querytotalt = mysqli_query($conn,"SELECT count(*)as totalt from factura WHERE fecha >= '$fechainicial' and fecha <= '$fechafinal' AND forma_pago = 'transferencia'");
  $resulttotalt = mysqli_num_rows($querytotalt);
  //var_dump($resulttotalt);
  ?>
  <table border="1" > 
  <tr>
      <td>total ventas transferencia</td>
      </tr>
      
      <?php
  while($fila2 = mysqli_fetch_assoc($querytotalt))
  {
      ?>
      
      <tr>
      <td><?php echo $fila2['totalt'];?></td>
     </tr>
  
      <?php
  }
  ?>
  
  
  </table> 

  <?php  
  $querytotaltodo = mysqli_query($conn,"SELECT count(*)as totaltodo from factura WHERE fecha >= '$fechainicial' and fecha <= '$fechafinal'");
  $resulttotaltodo = mysqli_num_rows($querytotalt);
  //var_dump($resulttotaltodo);
  ?>
  <table border="1" > 
  <tr>
      <td>total ventas </td>
      </tr>
      
      <?php
  while($fila3 = mysqli_fetch_assoc($querytotaltodo))
  {
      ?>
      
      <tr>
      <td><?php echo $fila3['totaltodo'];?></td>
     </tr>
  
      <?php
  }
  ?>
  
  
  </table> 
  <?php

  
}




?>