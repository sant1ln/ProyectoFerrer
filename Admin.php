<?php 
  include 'includes/funciones/sessiones.php';
  include 'includes/templates/header.php';
  include 'includes/funciones/consultas.php';
  //echo($_SESSION['nombre']);
 
?>
    <div>
<?php
/* $hoy = date("Y-m-j");
echo $hoy; */
?>
    </div>
  <div class="contenedor contenedorA">
    <div class="contenedorInventario">

      <div id="ReportCreate" class="inventarioMORE ReporteDown">  <!-- Reporte -->
          <div class="TengoEstilos">
            <img src="./img/logo.png" alt="Logo">
            <h3>Reporte</h3>
            <i class="fas fa-sign-out-alt Singout" id="CerrarReporte"></i>
          </div>
          <div class="contador-rango">
            <h4 class="Rango">Del <span class="fechas" id="FechaI"></span> Al <span  class="fechas" id="FechaF"></span></h4> 
          </div>
          <table class="table table-striped">
            <thead>
              
                  <th scope="col">Dia</th>
                 <th scope="col">Producto</th>
                 <th scope="col">Cantidad</th>
                 <th scope="col">Valor</th>
                 <th scope="col">Vendedor</th>
              
            </thead>
            <tbody>
               <tr>
                <td>25/02/2020</td>
                <td>Dog Show</td>
                <td>5</td>
                <td>25000</td>
                <td><?php echo($_SESSION['nombre']); ?></td>
               </tr> 
            </tbody>
          </table>
      </div>

      <div class="inventarioMORE" id="inventarioMORE"><!-- VER inventario -->
          <div class="TengoEstilos">
            <img src="./img/logo.png" alt="Logo">
            <h3>Ver inventario</h3>
            <i class="fas fa-sign-out-alt Singout" id="CerrarInventario"></i>
          </div>
        <table id="listado-entrada" class="table table-striped" >
                <thead>
                  <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Existencia</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Accion</th>

                  </tr>
                </thead>
                <tbody>
                
                <?php  $inventarios = obtenerInventario();
                //var_dump($inventarios);
                  
                   
                   
                   if($inventarios->num_rows) { 
                                
                    foreach($inventarios as $inventario) { ?>

                            <tr>
                                <td><?php echo $inventario['Id_Producto']; ?></td>
                                <td><?php echo $inventario['Id_Tipo_Producto']; ?></td>
                                <td><?php echo $inventario['Nombre_Producto']; ?></td>
                                <td><?php echo $inventario['Precio_Venta']; ?></td>
                                <td><?php echo $inventario['existencia']; ?></td>
                                <td><?php echo $inventario['Nombre_Usuarioo']; ?> <br>
                <span class="fecha"><?php echo $inventario['FechaCreacion']; ?></span> </td>

                                <td>
                                        <button data-id="<?php echo $inventario['Id_Producto']; ?>" type="button"  class="btn-borrar btn"><i class="fas fa-trash-alt btn-borrar"></i></button>
                                    </td>
                                
                            </tr>
                    <?php } 
                } ?>
                   
                  </tbody>
       </table>
      </div>
                
      <div class="inventarioMORE" id="inventarioADD"><!-- AÑADIR inventario -->
                <div class="TengoEstilos">
                  <img src="./img/logo.png" alt="Logo">
                  <h3>Añadir Producto</h3>
                  <i class="fas fa-sign-out-alt Singout" id="CerrarAnadir"></i>
                </div>
                <div class="container">
                  <form   id="producto" class="Anadir" method="POST">
                    <div class="form-row">
                    <div class="col">
                        <label for="">Codigo</label>
                        <input type="text" placeholder="Codigo Producto" id="Codigo" name="Codigo" class="form-control" >
                      </div>
                      <div class="col">
                        <label for="">Nombre</label>
                        <input type="text" placeholder="Nombre Producto" id="Nombre" name="Nombre" class="form-control" >
                      </div>
                      <div class="col">
                        <label for="">Tipo</label>
                        <input list="buscador"placeholder="Tipo Producto" id="Tipo" name="Tipo" class="form-control">
                        <datalist id=buscador>
                            <option value="Abonos">
                            <option value="Cuidos">
                            <option value="Insecticida">
                            <option value="Semillas">
                        </datalist>
                      </div>
                     
                      <div class="col">
                        <label for="Nombre">Precio</label>
                        <input type="number" placeholder="Precio" id="Precio" name="Precio" class="form-control">
                      </div>

                   
                      <input type="hidden" id="Nombre_u" value="<?php echo($_SESSION['nombre']); ?>">
                  

                      <div class="col Enviar">
                        <input type="hidden" id="Accion" value="ingresar">
                        <button type="submit" name="submit" class="btn btn-primary mb-2">Añadir</button>
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>

                    <table id="listado-productos" class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">Codigo</th>
                      <th scope="col">Nombre Producto</th>
                      <th scope="col">Tipo Producto</th>
                      <th scope="col">Precio Producto</th>
                      <th scope="col">Responsable</th>
                      <th scope="col">Accion</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $Productos = obtenerProductos();

                    if($Productos->num_rows) { 
                                
                        foreach($Productos as $Producto) { ?>

                                <tr>
                                    <td><?php echo $Producto['Id_Producto']; ?></td>
                                    <td><?php echo $Producto['Nombre_Producto']; ?></td>
                                    <td><?php echo $Producto['Id_Tipo_Producto']; ?></td>
                                    <td><?php echo $Producto['Precio_Venta']; ?></td>
                                    <td><?php echo $Producto['Nombre_Usuario']; ?> <br>
                                    <span title="FechaCreacion" class="fecha"><?php echo $Producto['FechaCreacion']; ?></span></td>

                                    <td>
                                        <a class="btn-swe3btn" href="editar.php?id=<?php echo $Producto['Id_Producto']; ?>"><i class="fas fa-pen-square btn-editar"></i></a>
                                        <button data-id=<?php echo $Producto['Id_Producto']; ?> type="button" class="btn-borrar btn"><i class="fas fa-trash-alt btn-borrar"></i></button>
                                    </td>
                                </tr>
                        <?php } 
                    } ?>
                                          
                    </tbody>
              </table>

                  
                  </form>
                </div>
      </div>

      <div class="inventarioMORE" id="EmpleadoADD"><!-- AÑADIR  Empleado -->
                  <div class="TengoEstilos">
                     <img src="./img/logo.png" alt="Logo">
                      <h3>Empleados</h3>
                      <i class="fas fa-sign-out-alt Singout" id="CerrarEmpleado"></i>
                  </div>
                  <div class="container">
                    
                    <form class="Anadir" id="Fempleado" method="POST">
                       <div class="form-row">
                        <div class="col">
                          <label for="">Tipo</label>
                            <input list="looker" placeholder="Cargo empelado" id="cargo" name="Tipo" class="form-control">
                              <datalist id="looker">
                                  <option value="Administrador">
                                  <option value="Cajero">
                              </datalist>
                        </div>
                        
                        <div class="col">
                          <label for="nombre">Nombre</label>
                          <input type="text" name="nombre" id="nombreEmpleado" class="form-control">
                        </div>                                              
                        
                        <div class="col">
                          <label for="cedula">Cedula</label>
                          <input type="number" name="cedula" id="CedulaEmpleado" class="form-control">
                        </div>
                        
                        <div class="col">
                          <label for="celular">Celular</label>
                          <input type="tel" name="celular" id="CelularEmpleado" class="form-control" >
                        </div>

                        <div class="col">
                          <label for="direccion">Direccion</label>
                          <input type="text" name="direccion" id="direccionEmpleado" class="form-control" >
                        </div>

                        <div class="col">
                          <label for="contraseña">Contraseña</label>
                          <input type="password" name="contraseña" id="passEmpleado" class="form-control" >
                        </div>  
  
                        <div class="col Enviar">
                          <input type="hidden" id="Accion2" value="crear">
                          <button type="submit" class="btn btn-primary mb-2">Añadir</button>
                        </div>

                      </div>
                    </form>

                    <!-- Ver empelados -->
                    <table class="table table-striped" id="Lista_empleados">
                    <thead>
                    <tr>
                      <!-- <th scope="col">Codigo</th> -->
                      <th scope="col">Cargo</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Cedula</th>
                      <th scope="col">Telefono</th>
                      <th scope="col">Direccion</th>
                      <th scope="col">Acciones</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                    <?php   $empleados = obtenerEmpleados();
                    
                   if($empleados->num_rows){
                      
                      foreach($empleados as $empelado){  ?>
                      <tr>
                      
                        
                        <td><?php echo $empelado['Cargo']; ?></td>
                        <td><?php echo $empelado["Nombre"]; ?></td>
                        <td><?php echo $empelado["Cedula"]; ?></td>
                        <td><?php echo $empelado["Celular"]; ?></td>
                        <td><?php echo $empelado["Direccion"]; ?></td>
                        <td>
                            <a class="btn" href="updEmpleado.php?id=<?php echo $empelado["id_empleado"] ?> "><i class="fas fa-pen-square  btn-editar"></i></a>
                            <button type="button" data-id="<?php echo $empelado["id_empleado"] ?>" class="btn-borrar btn"><i class="fas fa-trash-alt btn-borrar"></i></button>
                        </td>
                      </tr>
                    <?php  }
                    } ?>
                    </tbody>
                    </table>

                  </div>
      </div>

      <div class="inventarioMORE" id="EmpladoMORE"><!-- AÑADIR Provedores-->
              <div class="TengoEstilos">
                 <img src="./img/logo.png" alt="Logo">
                 <h3>Proveedores</h3>
                  <i class="fas fa-sign-out-alt Singout" id="CerrarEmpleados"></i>
              </div>
              <div class="container">
                    
                    <form class="Anadir" id="Fproveedor" method="POST">
                       <div class="form-row">
                                               
                        <div class="col">
                          <label for="cedula">Cedula - Nit</label>
                          <input type="number" name="cedula" id="CedulaProveedor" class="form-control">
                        </div>

                        <div class="col">
                          <label for="nombre">Nombre</label>
                          <input type="text" name="nombre" id="nombreProveedor" class="form-control">
                        </div>                                              
                        
                        
                        <div class="col">
                          <label for="celular">Telefono</label>
                          <input type="number" name="celular" id="CelularProveedor" class="form-control" >
                        </div>

                        <div class="col">
                          <label for="direccion">Direccion</label>
                          <input type="text" name="direccion" id="direccionProveedor" class="form-control" >
                        </div>

                        <input type="hidden" id="creador_P" value="<?php echo($_SESSION['nombre']); ?>">

                        <div class="col Enviar">
                          <input type="hidden" id="AccionP" value="crear">
                          <button type="submit" class="btn btn-primary mb-2">Añadir</button>
                        </div>

                      </div>
                    </form>

                    <!-- Ver Proveedores -->
                    <table class="table table-striped" id="Lista_Provedores">
                    <thead>
                      <tr>
                      <!-- <th scope="col">Codigo</th> -->
                      <th scope="col">Cedula provedor</th>
                      <th scope="col">Nombre provedor</th>
                      <th scope="col">Telefono provedor</th>
                      <th scope="col">Direccion provedor</th>
                      <th scope="col">Resposable</th>
                      <th scope="col">Acciones</th>
                      
                      </tr>
                    </thead>
                    <tbody>
                    <?php   $proveedores = obtenerProveedores();
                    
                   if($proveedores->num_rows){
                      
                      foreach($proveedores as $proveedor){  ?>
                      <tr>
                      
                        
                      <td><?php echo $proveedor["Cedula_Proveedor"]; ?></td>
                      <td><?php echo $proveedor["Nombre_proveedor"]; ?></td>
                      <td><?php echo $proveedor["Telefono_proveedor"]; ?></td>
                      <td><?php echo $proveedor["Ciudad_proveedor"]; ?></td>
                      <td><?php echo $proveedor["creador"]; ?> <br>
                      <span title="FechaCreacion" class="fecha"><?php echo $proveedor['FechaCreacion']; ?></span></td>
                        <td>                
                            <a class="btn" href="updProveedor.php?id=<?php echo $proveedor["Cedula_Proveedor"] ?> "><i class="fas fa-pen-square  btn-editar"></i></a>
                            <button type="button" data-id="<?php echo $proveedor["Cedula_Proveedor"] ?>" class="btn-borrar btn"><i class="fas fa-trash-alt btn-borrar"></i></button>
                        </td>
                      </tr>
                    <?php  }
                    } ?>
                    </tbody>
                    </table>

                  </div>   
             
      </div>

      <div class="inventarioMORE" id="EntradaADD"><!-- AÑADIR  entrada -->
                  <div class="TengoEstilos">
                    <img src="./img/logo.png" alt="Logo">
                    <h3>Añadir entrada</h3>
                    <i class="fas fa-sign-out-alt Singout" id="CerrarAnadirEntrada"></i>
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
            

      <div id="admins">
              <div class="seccionR"> <!-- Reporte por día -->
                <div>
                <h2>Reporte de ventas</h2>
                </div>
                <div class="reporte">
                    <form action="" id="Form_Report">
                        <label for="">Ingrese Fecha inicial</label>
                        <input class="reportexDia" type="date" name="" id="FechaIncio">
                        <label for="">Ingrese Fecha Final</label>
                        <input class="reportexDia" type="date" name="" id="FechaFin">
                        
                        <button class="Btn-generar" type="submit" id="Reporte" >Generar</button>
                    </form>
                </div>
              </div>
                    
                    
              <div class="seccionR"> <!-- Mostrar e añadir al inventario -->
                <div>
                    <h2>Inventario</h2>
                </div>
                <div class="reporte inventario">
                    <input class="boton" id="botonAnadir"  type="button" value="Añadir Producto">
                    <input class="boton" id="botonAnadirEntrada"  type="button" value="Añadir Entrada">
                    <input class="boton" id="botonAbrir" type="button" value="Inventario">


                   <!--  <ul>
                        <li>Estiercol <span class="unidad">400</span></li>
                        <li>Agujas    <span class="unidad">50</span></li>
                        <li>Espermicida <span class="unidad">30</span></li>
                        <li>Alambrados <span class="unidad">10</span></li>
                        <li>Semillas<span class="unidad">100</span></li>
                    </ul> -->
                </div>
              </div>
              <div class="seccionR"><!-- Empleado y Proveedor -->
                <div>
                    <h3>Empleados y Proveedores</h3>
                </div>
                <div class="reporte inventario">
                    <input type="button" id="botonAnadirE" class="boton btn-aceptar ADD" value="Añadir Empleado">
                    <input type="button" id="botonVerE" class="boton btn-aceptar " value="Añadir Provedores">
                </div>
      </div>
           </div>
    </div>
  </div>
    <?php include_once 'includes/templates/footer.php'; ?>