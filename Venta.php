    <?php

      include 'includes/funciones/sessiones.php';
      include_once 'includes/templates/header-venta.php';
      include 'includes/funciones/consultas.php';
      ?>

    <section id="container">
      <div class="title_page">
        <h1><i class="fas fa-shopping-cart"></i>Sistema de Ventas Ferrer</h1>
      </div>
        <div class="datos_cliente">
          <div class="action_cliente">
            <h4>Datos cliente</h4>
            <a href="#" class="btn_new btn_new_cliente"><i class="fas fa-user-plus"></i>Nuevo Cliente</a>
          </div>

          <form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos">
            <input type="hidden" name="action" value="addCliente">
            <input type="hidden" id="idcliente" name="idcliente" value="" required>


            <input type="hidden" id="prueba" name="prueba" value="<? echo $_SESSION['id']?>">
            <div class="wd30">
              <label  class="label" for="Nit">Cedula</label>
              <input class="wid1000" type="text" name="nit_cliente" id="nit_cliente" >
            </div>
            <div class="wd30">
              <label class="label" for="Nit">Nombre</label>
              <input class="wid1000" type="text" name="nom_cliente" id="nom_cliente"  disabled="disabled" required >
            </div>
            <div class="wd30">
              <label class="label" for="Telefono">Telefono</label>
              <input class="wid1000" type="number" name="tel_cliente" id="tel_cliente"  disabled="disabled" required>
            </div>
            <div class="wd30">
              <label class="label" for="Direccion">Direccion</label>
              <input class="wid1000" type="text" name="dir_cliente" id="dir_cliente"disabled="disabled" required >
            </div>
            <div id="div_registro_cliente" class="wd100">
              <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar</button>
            </div>
          </form> 
        </div>
        <div class="datos_venta">
          <h4>Datos de venta</h4>
          <div class="datos">
            <div class="wd50">
              <label for="Vendedor">Vendedor</label>
              <p><?php echo $_SESSION['nombre']; ?></p>
            </div>
            <div class="wd50">
              <div id="acciones_venta">
                <a href="#" class="btn_ok textcenter" id="btn_facturar_venta"><i class="fas fa-ban"></i>Procesar</a>
                <a href="#" class="btn_new textcenter" id="btn_anular_venta"><i class="far fa-edit">Anular</i></a>
              </div>
            </div>

          </div>

        </div>
        <table  class="tbl_venta">
          <thead>
            <tr>
              <th width="100px">Codigo</th>
              <th>Nombre Producto</th>
              <th>Existencia</th>
              <th width="100px">Cantidad</th>
              <th class="textright">Precio</th>
              <th class="textright">Precio Total</th>
              <th>Accion</th>
            </tr>
            <tr>
              <td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
              <td id="txt_nombre_producto">-</td>
              <td id="txt_existencia">-</td>
              <td><input type="number" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled require></td>
              <td id="txt_precio" class="textright">0.00</td>
              <td  id="txt_precio_total" class="textright">0.00</td>
              <td> <a href="#"  class="link_add" id="add_product_venta"><i class="far fa-edit">Agregar</i></a></td>
            </tr>
          </thead>
          <tbbody >
          <tr>
              <th>Codigo</th>
              <th colspan="1">Nombre Producto</th>
              <th colspan="1" class="right" >Cantidad</th>
              <th colspan="2" class="right">Precio</th>
              <th colspan="0" class="textright">Precio Total</th>
              <th>Accion</th>
            </tr>
          </tbbody>
          </table>
          <div class="container">
          <div id="detalle_venta"></div>
          </div>
          
          <div id="detalle_totales">
          <!--contenido AJAX-->

          </div>
        
    </section>
<?php include_once 'includes/templates/footer.php'; ?>

<script>
  $(document).ready(function(){
    var usuarioid = '<?php echo $_SESSION['id']; ?>';
    buscarDetalle(usuarioid);
  });
</script>

