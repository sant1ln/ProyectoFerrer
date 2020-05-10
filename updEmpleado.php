<?php include_once 'includes/templates/header.php'; 
include_once 'includes/funciones/consultas.php';
?>

<?php /* echo "<pre>";  */

        $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
        if(!$id){
            die('No es valido');
        }
        //var_dump($id); 
        $resultado = obtenerEmpleado($id);
        $contacto = $resultado->fetch_assoc();
?>
    <div class="inventarioMORE UPDATE" ><!-- AÑADIR  Empleado -->
            <div class="TengoEstilos">
               <img src="./img/logo.png" alt="Logo">
                <h3>EDITAR EMPLEADO</h3>
                <a href="Admin.php"><i class="fas fa-sign-out-alt Singout" id="CerrarEmpleado"></i></a>
            </div>
        <div class="container">
               <form class="Anadir" id="Fempleado" method="POST">
                       <div class="form-row">
                            <div class="col">
                              <label for="">Tipo</label>
                                <input list="looker" value="<?php echo $contacto['Cargo'] ?>" placeholder="Cargo empelado" id="cargo" name="Tipo" class="form-control">
                                  <datalist id="looker">
                                      <option value="Administrador">
                                      <option value="Cajero">
                                  </datalist>
                            </div>
  
                        
                            <div class="col">
                              <label for="nombre">Nombre</label>
                              <input type="text" name="nombre" id="nombreEmpleado" class="form-control"
                              value="<?php echo $contacto['Nombre'] ?>">
                            </div>
                                              
                        
                            <div class="col">
                              <label for="cedula">Cedula</label>
                              <input type="number" name="cedula" id="CedulaEmpleado" class="form-control"
                              value="<?php echo $contacto['Cedula'] ?>">
                            </div>
                        
                            <div class="col">
                              <label for="celular">Celular</label>
                              <input type="tel" name="celular" id="CelularEmpleado" class="form-control" 
                              value="<?php echo $contacto['Celular'] ?>">
                            </div>

                            <div class="col">
                              <label for="direccion">Direccion</label>
                              <input type="text" name="direccion" id="direccionEmpleado" class="form-control"
                              value="<?php echo $contacto['Direccion'] ?>" >
                            </div>

                            <div class="col">
                              <label for="contraseña">Nueva Contraseña</label>
                              <input type="password" name="contraseña" id="passEmpleado" class="form-control" 
                              value="<?php echo $contacto['passwd'] ?>" >
                             </div> 

                              <input type="hidden" value="<?php echo $id ?>" id="id_empleado">

                            <div class="col Enviar">
                              <input type="hidden" id="Accion2" value="editar">
                              <?php if(isset($contacto['id'])){?>
                                <input type="hidden" id="id" value=" <?php echo $contacto['id'] ?>">

                              <?php } ?>
                              <button type="submit"  class="btn btn-primary mb-2">Editar</button>
                            </div>

                      </div>
            </form>
        </div>
    </div>


<?php include_once 'includes/templates/footer.php'; ?>