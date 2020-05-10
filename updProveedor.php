<?php 
include_once 'includes/templates/header.php'; 
include_once 'includes/funciones/consultas.php';
include 'includes/funciones/sessiones.php';


$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
      /* echo $id; */
      
    $respuesta = obtenerProveedor($id);
    $proveedor = $respuesta->fetch_assoc();
    
?>

<div class="inventarioMORE UPDATE" id="EmpladoMORE"><!-- AÑADIR Provedores-->
              <div class="TengoEstilos">
                 <img src="./img/logo.png" alt="Logo">
                        <h3>Proveedores - Editar </h3>
                  
                  <a href="Admin.php"> <i class="fas fa-sign-out-alt Singout" id="CerrarAnadir"></i></a>
              </div>
              <div class="container">
                    
                    <form class="Anadir" id="Fproveedor" method="POST">
                       <div class="form-row">
                                               
                        <div class="col">
                          <label for="cedula">Cedula - Nit</label>
                          <input type="number" value="<?php echo ($proveedor['Cedula_Proveedor']) ?>" name="cedula" id="CedulaProveedor" class="form-control">
                        </div>

                        <div class="col">
                          <label for="nombre">Nombre</label>
                          <input type="text" value="<?php echo ($proveedor['Nombre_proveedor']); ?>" name="nombre" id="nombreProveedor" class="form-control">
                        </div>                                              
                        
                        
                        <div class="col">
                          <label for="celular">Telefono</label>
                          <input type="number"  value="<?php echo ($proveedor['Telefono_proveedor']) ?>" name="celular" id="CelularProveedor" class="form-control" >
                        </div>

                        <div class="col">
                          <label for="direccion">Direccion</label>
                          <input type="text"  value="<?php echo ($proveedor['Ciudad_proveedor']) ?>" name="direccion" id="direccionProveedor" class="form-control" >
                        </div>
                        

                        <input type="hidden" placeholder="Responsable" id="Nombre_u" name="Precio" class="form-control" value=" <?php echo($_SESSION['nombre']); ?>" >
                          <input type="hidden" id="ProvEdit" value="<?php echo ($proveedor['Cedula_Proveedor']); ?>" >
                        
                        <div class="col Enviar">
                          <input type="hidden" id="AccionP" value="editar">
                          <button type="submit"  class="btn btn-primary mb-2">Editar</button>
                        </div>

                      </div>
                    </form>

                    <!-- Ver Proveedores -->
                   
                  </div>   
             
            </div>
            <script src="./Scripts/Admin.js"></script>
            <script src="./Scripts/sweetalert2.all.min.js"></script>
            <script src="./Scripts/Proveedor.js"></script>