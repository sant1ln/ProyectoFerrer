<?php include_once 'includes/templates/header.php'; 
include_once 'includes/funciones/consultas.php';


 ?>

<div class="inventarioMORE UPDATE" id="inventarioADD"><!-- AÑADIR A INVENTARIO --> 
        <div class="TengoEstilos">
                    <img src="./img/logo.png" alt="Logo">
                    <h3>EDITAR ENTRADA</h3>
                   <a href="Admin.php"><i class="fas fa-sign-out-alt Singout" id="CerrarAnadirEntrada"></i></a>
                  </div>
                  <div class="container">
                  <p></p> <!--santi no borres este parrafo  Santiago Responde= Dale :D -->
                  <form  id="producto-entrada" class="Anadir" method="POST">
                      <div class="form-row">
                                                
                        <div class="col">
                          <label for="">Cantidad</label>
                          <input placeholder="Cantidad Producto" id="Cantidad" type="Number" name="Cantidad" class="form-control">
                         
                        </div>

                        <div class="col">
                          <label for="Cantidad">Codigo Producto</label>
                          <input placeholder="Codigo Producto" id="CodProducto" type="text" name="CodigoP" class="form-control" >
                        </div>
          
                        
                        <div class="col">
                          <label for="Valor">Cedula Proveedor</label>
                          <input placeholder="Cedula proveedor" id="CedProveedor" type="number" name="CedulaP" class="form-control">
                        </div>

                        <input type="hidden" id="Nombre_u" value="<?php echo ($_SESSION['nombre']); ?>">
                        
                        <div class="col Enviar">
                          <input type="hidden" id="Accion" value="ingresar">
                          <button type="submit"  name="submit" class="btn btn-primary mb-2">Añadir</button>
                        </div>
  
                      </div>
                    </form>
                  </div>
           </div>
 
<?php include_once 'includes/templates/footer.php'; ?>