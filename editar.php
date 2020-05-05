<?php include_once 'includes/templates/header.php'; 
include_once 'includes/funciones/consultas.php';
include 'includes/funciones/sessiones.php';


    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if(!$id){
      die('No es valido');
  }
    $resultado = obtenerProducto($id);
    $producto = $resultado->fetch_assoc();


    ?>

    <pre>

 
</pre>

<div class="inventarioMORE UPDATE" id="inventarioADD"><!-- AÑADIR A INVENTARIO -->
                <div class="TengoEstilos">
                  <img src="./img/logo.png" alt="Logo">
                  <H3>EDITAR PRODUCTO</H3>
                  <a href="Admin.php"> <i class="fas fa-sign-out-alt Singout" id="CerrarAnadir"></i></a>
                </div>
                <div class="container">
                  <form   id="producto" class="Anadir" method="POST">
                    <div class="form-row">
                    <div class="col">
                        <label for="">Codigo</label>
                        <input type="text" placeholder="Codigo Producto" id="Codigo" name="Codigo" readonly="readonly" class="form-control" value="<?php echo ($producto['Id_Producto']) ? $producto['Id_Producto'] : ''; ?>" >
                      </div>
                      <div class="col">
                        <label for="">Nombre</label>
                        <input type="text" placeholder="Nombre Producto" id="Nombre" name="Nombre" class="form-control" value="<?php echo ($producto['Nombre_Producto']) ? $producto['Nombre_Producto'] : ''; ?>" >
                      </div>
                      <div class="col">
                        <label for="">Tipo</label>
                        <input list="buscador"placeholder="Tipo Producto" id="Tipo" name="Tipo" class="form-control" value="<?php echo ($producto['Id_Tipo_Producto']) ? $producto['Id_Tipo_Producto'] : ''; ?>" >
                        <datalist id=buscador>
                            <option value="Abonos">
                            <option value="Cuidos">
                            <option value="Insecticida">
                            <option value="Semillas">
                        </datalist>
                      </div>
                     
                      <div class="col">
                        <label for="Nombre">Precio</label>
                        <input type="number" placeholder="Precio" id="Precio" name="Precio" class="form-control" value="<?php echo ($producto['Precio_Venta']) ? $producto['Precio_Venta'] : ''; ?>" >
                      </div>

                        <input type="hidden" placeholder="Responsable" id="Nombre_u" name="Precio" class="form-control" value=" <?php echo($_SESSION['nombre']); ?>" >
                     

                      <div class="col Enviar">

                          <?php 

                           $textoBtn = ($producto['Precio_Venta']) ? 'Guardar' : 'añadir';
                           $accion = ($producto['Precio_Venta']) ? 'editar' : 'ingresar';
                          ?>
                        <input type="hidden" id="Accion" value="<?php echo $accion; ?>">
                        <?php if(isset($producto['Id_Producto'] )){?>

                           <input type="hidden" id="id" value="<?php echo $producto['Id_Producto']; ?>">

                       <?php }?>
                            
                        
                        <input type="submit" name="submit" value="<?php echo $textoBtn; ?>" class="btn btn-primary mb-2">
                      </div>
                    </div>
 
<?php include_once 'includes/templates/footer.php'; ?>