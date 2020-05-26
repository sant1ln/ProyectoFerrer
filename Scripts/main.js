$( document ).ready(function() {

    $('.btn_new_cliente').click(function(e){
        e.preventDefault();
        $('#nom_cliente').removeAttr('disabled');
        $('#tel_cliente').removeAttr('disabled');
        $('#dir_cliente').removeAttr('disabled');
    
        $('#div_registro_cliente').slideDown();
    });

    //buscar cliente
    $('#nit_cliente').keyup(function(e){
        e.preventDefault();

        var cl = $(this).val();
        var action = 'searchCliente';

        $.ajax({
            url: 'includes/modelos/modelo-clientes.php',
            type: "POST",
            async: true,
            data: {action:action,cliente:cl},

            success: function(response){
                if(response == 0){
                    $('#idcliente').val('');
                    $('#nom_cliente').val('');
                    $('#tel_cliente').val('');
                    $('#dir_cliente').val('');

                    //Mostrar boton agregar
                    $('.btn_new_cliente').slideDown();
                }else{
                    var data = $.parseJSON(response);
                    $('#idcliente').val(data.id_cliente);
                    $('#nom_cliente').val(data.nombre);
                    $('#tel_cliente').val(data.telefono);
                    $('#dir_cliente').val(data.direccion);

                    //ocultar btn agregar
                    $('.btn_new_cliente').slideUp();

                    //bloquee campos
                    $('#nom_cliente').attr('disabled','disabled');
                    $('#tel_cliente').attr('disabled','disabled');
                    $('#dir_cliente').attr('disabled','disabled');

                    //oculta btn guardar 
                    $('#div_registro_cliente').slideUp();
                }     
            },
            error: function(error){

            }
        });
    });

    //Crear Cliente  desde la venta

    $('#form_new_cliente_venta').submit(function(e){
       e.preventDefault(); 

       $.ajax({
        url: 'includes/modelos/modelo-clientes.php',
        type: "POST",
        async: true,
        data: $('#form_new_cliente_venta').serialize(), //para enviar todos los datos de un  formulario

        success: function(response){
            if(response != 'error'){
                $('#idcliente').val(response);

                //bloquee campos
                $('#nom_cliente').attr('disabled','disabled');
                $('#tel_cliente').attr('disabled','disabled');
                $('#dir_cliente').attr('disabled','disabled');

                //ocultar btn agregar
                $('.btn_new_cliente').slideUp();

                //ocultar btn guardar
                $('#div_registro_cliente').slideUp();

                Swal({
                    title: 'Cliente Registrado',
                    type: 'success'

                })
                .then(resultado => {
                   if(resultado.value){
                       window.location.href='Venta.php';
                   }
                    
                })


            }
            
        },
        error: function(error){

        }
    });


    });

    //buscar producto
    $('#txt_cod_producto').keyup(function(e){ //keyup se activa cuando presionamos una tecla
        e.preventDefault(); 

        var producto = $(this).val(); //captura el valor del elemento del id seleccionado
        var action = 'infoProducto';
 

        $.ajax({
         url: 'includes/modelos/modelo-clientes.php',
         type: "POST",
         async: true,
         data: {action:action,producto:producto}, //para enviar todos los datos de un  formulario
 
         success: function(response){
            if(response != 'error'){
                var datos = JSON.parse(response);
                $('#txt_nombre_producto').html(datos.Nombre_Producto);
                $('#txt_existencia').html(datos.Cantidad_Producto);
                $('#txt_cant_producto').val('1');
                $('#txt_precio').html(datos.Precio_Venta);
                $('#txt_precio_total').html(datos.Precio_Venta);

                //activar campo de cantidad
                $('#txt_cant_producto').removeAttr('disabled');

                //mostrar boton agregar
                $('#add_product_venta').slideDown();
            }else{
                $('#txt_nombre_producto').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant_producto').val('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');

                //bloquear campo de cantidad
                $('#txt_cant_producto').attr('disabled','disabled');

                //ocultar btn agregar
                $('#add_product_venta').slideUp();
            }
                
         },
         error: function(error){
 
         }
     });
 
 
     });
     
     //calcular la cantidad del producto antes de agregar
    $('#txt_cant_producto').keyup(function(e){
        e.preventDefault();

        var precio_total = $(this).val() * $('#txt_precio').html();
        var existencia = parseInt($('#txt_existencia').html());
        $('#txt_precio_total').html(precio_total);

        //oculta el campo agregar si la cantidad es menos que 1
        if($(this).val() < 1  || $(this).val() > existencia ){
            $('#add_product_venta').slideUp();
        }else{
            $('#add_product_venta').slideDown();
        }
    });

    $('#add_product_venta').click(function(e){
        e.preventDefault();

        if($('#txt_cant_producto').val() >0){
            var codProducto = $('#txt_cod_producto').val();
            var cantidad = $('#txt_cant_producto').val();
            var action = 'addDetalleProducto';
            
            $.ajax({
                url: 'includes/modelos/modelo-clientes.php',
                type: "POST",
                async: true,
                data: {action:action,producto:codProducto,cantidad:cantidad},

                success:function(response){
                    //console.log(response);
                    if(response != 'errors'){
                        var info = JSON.parse(response); //convieto formato json a un obtejo
                        $('#detalle_venta').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                        $('#txt_cod_producto').val('');
                        $('#txt_nombre_producto').html('-');
                        $('#txt_existencia').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        //bloquear cantidad
                        $('#xt_cant_producto').attr('disabled','disabled');


                        //ocultar btn agregar
                        $('#add_product_venta').slideUp();

                    }else{
                        console.log('hubo un error!');
                    }
                    $('.btn_ok').css('display','inline-block')
                },
                error: function(error){
                    
                }

            })
        }

    });

    //anular venbta
    $('#btn_anular_venta').click(function(e){

        e.preventDefault();

        var rows = $('#detalle_venta tr').length;

        //console.log(rows);

        if(rows > 0){
            
            var action = 'anularVenta';


            $.ajax({
                url: 'includes/modelos/modelo-clientes.php',
                type: "POST",
                async: true,
                data: {action:action},

               success: function(response){ 
                   console.log(response)                   
                    if(response != 'error'){
                        location.reload();
                    }
                },
                error: function(error){

                }
              
            });
        }



    });

    //procesar venta
    $('#btn_facturar_venta').click(function(e){

        e.preventDefault();

        var rows = $('#detalle_venta tr').length;

        //console.log(rows);

        if(rows > 0){
            
            var action = 'procesarventa';
            var codcliente = $('#idcliente').val();
            var prueba = $('#prueba').val();

            $.ajax({
                url: 'includes/modelos/modelo-clientes.php',
                type: "POST",
                async: true,
                data: {action:action,codcliente:codcliente,prueba:prueba},

               success: function(response){  
                   
                 //console.log(response);
                    
                    if(response != 'error'){

                        var info = JSON.parse(response);
                        //console.log(info);

                        generarPDF(info.Cod_cliente,info.No_factura);

                       
                         window.location.href='Venta.php';
                       
                    }else{
                        console.log('no datos');
                        
                    }
                },
                error: function(error){

                }
              
            });
        }



    });
}); //finaliza el ready


function generarPDF(cliente,factura){
    var ancho = 1000;
    var alto = 800;

    //calcula posicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");



}

function del_product_detalle(Correlativo){

    var action = 'del_product_detalle';
    var id_detalle = Correlativo;

    $.ajax({
        url: 'includes/modelos/modelo-clientes.php',
        type: "POST",
        async: true,
        data: {action:action,id_detalle:id_detalle},

        success:function(response){
            console.log(response);

            if(response != 'error'){
                var info = JSON.parse(response);

                        $('#detalle_venta').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                        $('#txt_cod_producto').val('');
                        $('#txt_nombre_producto').html('-');
                        $('#txt_existencia').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        //bloquear cantidad
                        $('#xt_cant_producto').attr('disabled','disabled');


                        //ocultar btn agregar
                        $('#add_product_venta').slideUp();

                       window.location.reload();
        
                



            }else{
                console.log('error de proceso');
                window.location.reload();  
            }
            btnprocesar();

        },
        error: function(error){

        }

    })

}

//ocultar btn procesas
function btnprocesar(){
    if($('#detalle_venta tr') == ''){

        $('#btn_facturar_venta').show();
    }else{
        $('#btn_facturar_venta').hide();

    }
}

function buscarDetalle(id_u){
    var action = 'buscarDetalle';
    var usuario = id_u;

    $.ajax({
        url: 'includes/modelos/modelo-clientes.php',
        type: "POST",
        async: true,
        data: {action:action,usuario:usuario},

        success:function(response){

            if(response != 'error'){
                var info = JSON.parse(response); //convieto formato json a un obtejo
                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);
            }else{
                console.log('hubo un error!');
            }
           
            $('.btn_ok').css('display','inline-block')
        },
        error: function(error){

        }

    })
}

