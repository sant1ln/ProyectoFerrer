<?php 
   include 'includes/funciones/bd_conexion.php';//abrimos la conexion
   include 'includes/funciones/sessiones.php';
   include 'includes/templates/header-venta.php';
   include 'includes/funciones/consultas.php';
 
?>


<div class="Estilos-Venta">
<h2><i class="fas fa-shopping-cart"></i>Listado de Ventas</h2>

</div>
<div class="reportev">
    <form  action="buscar_venta.php" method="get" >
         <div class="reportef">
            <input class="reportexDia" type="date" name="fecha_inicio" id="FechaIncio" required>
            <input class="reportexDia" type="date" name="fecha_final" id="FechaFin"  required>
            <button class="Btn-generar" type="submit" id="Reporte" >Generar</button>
        </div>
    </form>
</div>
<table class="table table-striped" id="Lista_Provedores">
                    <thead>
                      <tr>
                      <!-- <th scope="col">Codigo</th> -->
                      <th scope="col">No.</th>
                      <th scope="col">Fecha/Hora</th>
                      <th scope="col">Cliente</th>
                      <th scope="col">Vendedor</th>
                      <th scope="col">Estado</th>
                      <th scope="col">Metodo pago</th>
                      <th scope="col">Total Factura</th>
                      <th scope="col">Acciones</th>

                      </tr>
                    </thead>

                    <?php 
                        $sql_registe = mysqli_query($conn,"SELECT COUNT(*) as total_registro from factura WHERE estado != 10");
                        $result_register = mysqli_fetch_array($sql_registe);
                        $total_registro = $result_register['total_registro'];

                        $query = mysqli_query($conn,"SELECT f.No_factura,f.Fecha,f.total_factura,f.Cod_cliente,f.forma_pago,f.estado,
                                                u.Nombre as vendedor,
                                                cl.nombre as cliente
                                                FROM factura f
                                                INNER JOIN empleado u
                                                ON f.Empleado = u.id_empleado
                                                INNER JOIN cliente cl
                                                ON f.Cod_cliente = cl.id_cliente
                                                WHERE f.estado !=10
                                                ORDER BY f.Fecha");
                        mysqli_close($conn);

                        $result = mysqli_num_rows($query);
                        if($result >0){

                            while($data = mysqli_fetch_array($query)){
                                if($data['estado'] == 1){
                                    $estado = '<span class="pagada">pagada</span>';
                                }else{
                                    $estado = '<span class="pagada">anulada</span>';
                                };
                            ?>
                                <tr id="row_<?php echo $data['No_factura'];?>">
                                <td><?php echo $data['No_factura'];?></td>
                                <td><?php echo $data['Fecha'];?></td>
                                <td><?php echo $data['cliente'];?></td>
                                <td><?php echo $data['vendedor'];?></td>
                                <td><?php echo $estado;?></td>
                                <td><?php echo $data['forma_pago'];?></td>
                                <td><?php echo $data['total_factura'];?></td>

                                <td>
                                        <div class="div_accione">
                                            <div>
                                                <button class="btn_view view_factura" type="button" cl="<?php echo $data['Cod_cliente']; ?>" f="<?php echo $data['No_factura']?>"><i class="fas fa-eye"></i></button>
                                            </div>


                                        </div>

                                </td>
                                </tr> 

                            <?php }
                            
                        }?>
                        <?php include_once 'includes/templates/footer.php'; ?>

                   
