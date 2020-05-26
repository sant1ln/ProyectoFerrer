<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	if(empty($_SESSION['login']))
	{
		header('location: ../Venta.php');
	}

	include "../includes/funciones/bd_conexion.php";
	require_once '../pdf/vendor/autoload.php';
	use Dompdf\Dompdf;

	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la factura.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$anulada = '';

		$query_config   = mysqli_query($conn,"SELECT * FROM configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}


		$query = mysqli_query($conn,"SELECT f.No_factura, DATE_FORMAT(f.Fecha, '%d/%m/%Y') as Fecha, DATE_FORMAT(f.Fecha,'%H:%i:%s') as  hora, f.Cod_cliente, f.estado,
												 v.Nombre as vendedor,
												 cl.cedula_cliente, cl.nombre, cl.telefono,cl.direccion
											FROM factura f
											INNER JOIN empleado v
											ON f.Empleado = v.id_empleado
											INNER JOIN cliente cl
											ON f.Cod_cliente = cl.id_cliente
											WHERE f.No_factura = $noFactura AND f.Cod_cliente = $codCliente  AND f.estado != 10 ");

		$result = mysqli_num_rows($query);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$no_factura = $factura['No_factura'];

			if($factura['estado'] == 2){
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}

			$query_productos = mysqli_query($conn,"SELECT p.Nombre_Producto,dt.cantidad,dt.precio_venta,(dt.cantidad * dt.precio_venta) as precio_total
														FROM factura f
														INNER JOIN detalle_factura dt
														ON f.No_factura = dt.No_factura
														INNER JOIN producto p
														ON dt.id_producto = p.Id_Producto
														WHERE f.No_factura = $no_factura ");
			$result_detalle = mysqli_num_rows($query_productos);

			

			ob_start();
		    include(dirname('__FILE__').'/factura.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('factura_'.$noFactura.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>