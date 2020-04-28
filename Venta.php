<?php include_once 'includes/templates/header.php'; ?>
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
                    <tr class="Seleccion">
                        <th scope="row">AB1</th>
                        <td>AbonoNatural</td>
                        <td><input class="Cant" id="cantan" type="number"></td>
                        <td id="valoran">21500</td>
                      </tr>
                      <tr class="Seleccion">
                        <th scope="row">AB2</th>
                        <td>Yerbas</td>
                        <td><input class="Cant" id="canty" type="number"></td>
                        <td id="valory">15000</td>
                      </tr>
                      <tr class="Seleccion">
                        <th scope="row">AB3</th>
                        <td>Inecticida</td>
                        <td><input class="Cant" id="canti" type="number"></td>
                        <td id="valori">5000</td>
                      </tr>
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