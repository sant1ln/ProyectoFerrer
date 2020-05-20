    <?php

      include 'includes/funciones/sessiones.php';
      include_once 'includes/templates/header-venta.php';
      include 'includes/funciones/consultas.php';
      
    ?>

    <div class="contenedor">
        <section class="Registradora">
            <img src="./img/logo.png" alt="Logo">
        <!--REGISTRO-SELECCION PRODUCTOS-->
            <div class="AreaRegistro3" id="AreaRegistro">
                <i class="fas fa-long-arrow-alt-left iconoAtras" id="cerrarVentana"></i>
                <table class="table">
                    <thead>
                      <tr >
                        <th scope="col">Cod</th>
                        <th scope="col">Articulo</th>
                        <th scope="col">Cant</th>
                        <th scope="col">Valor &incare;</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php $abonos = obtenerCuidos();
                    /* $ProductoA = $abonos["Id_Tipo_Producto"]; */
                      if($abonos -> num_rows){
                          foreach ($abonos as $abono) { ?>
                            <tr class="Seleccion">
                              <td scope="row"><?php echo $abono["Id_Producto"] ?></th>
                              <td><?php echo $abono["Nombre_Producto"] ?></td>
                              <td><input class="Cant" id="Cantidad-abonos" type="number"></td>
                              <td id="valoran"><?php echo $abono["Precio_Venta"] ?></td>
                            </tr>
                     <?php  }                        
                      }?> 
                      
                   </tbody>
            </table>
            </div>

            <!--CONTENEDOR PRINCIPAL-->
            <div class="AreaRegistro centrador">
                <ul class="Lista-Articulos">
                    <li id="RegistroProducto" class="Articulo">Abonos</li>
                    <li id="RegistroProducto" class="Articulo">Cuidos</li>
                    <li id="RegistroProducto" class="Articulo">Semillas</li>
                    <li id="RegistroProducto" class="Articulo">Medicina</li>
                    <li id="RegistroProducto" class="Articulo">Acs Animales</li>
                    <li id="RegistroProducto" class="Articulo">Acs Fincas</li>
                    
                </ul>
            </div>
            <section class="Vendedor">
                <button class="boton btn-aceptar" id="registrar" >Registrar</button>
                <div class="Facturador-contenedor" >
                    <div id="Facturador">
                        
                    </div>
    
                    <div id="total">
                       

                    </div>
                </div>
                <button class="boton btn-aceptar">Vender</button>
            </section>
        </section>
    </div>
    
        
       
    
   

<?php include_once 'includes/templates/footer.php'; ?>