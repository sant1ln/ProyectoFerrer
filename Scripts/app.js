const formularioProducto = document.querySelector('#producto'),
      formularioProductoEntrada = document.querySelector('#producto-entrada'),
      listadoProductos = document.querySelector('#listado-productos tbody');

eventListeners();


function eventListeners(){
    //cuando el formulario de crear se ejecuta
    formularioProducto.addEventListener('submit',leerFormularioProducto);
    formularioProductoEntrada.addEventListener('submit',leerFormularioProductoEntrada);

    //listener para eliminar producto
    listadoProductos.addEventListener('click',eliminarProductos);
}

function leerFormularioProductoEntrada(e){
    e.preventDefault();

     //leero los datos de los inputs
     const  Cantidad = document.querySelector('#Cantidad').value,
           CodProducto = document.querySelector('#CodProducto').value,
           CedProveedor = document.querySelector('#CedProveedor').value;
           Nombre_u = document.querySelector('#Nombre_u').value;
           Accion=document.querySelector('#Accion').value;

    if(Cantidad === '' || CodProducto === '' || CedProveedor === ''){
        Swal.fire({
            type: 'error',
            title: 'Error',
            text: 'Ambos campos son obligatorios',
          })
    }
    else{
        const infoProductoEntrada = new FormData();
        infoProductoEntrada.append('Cantidad',Cantidad);
        infoProductoEntrada.append('CodProducto',CodProducto);
        infoProductoEntrada.append('CedProveedor',CedProveedor);
        infoProductoEntrada.append('Nombre_u',Nombre_u);
        infoProductoEntrada.append('Accion',Accion);

         //console.log(...infoProductoEntrada); //MIRAR QUE ESTAN PASANDO BIEN MIS DATOS

        
        if(Accion === 'ingresar'){
            // crearemos un nuevo contacto
            insertarBDE(infoProductoEntrada);
       } else {
           
       }
    }
}

function insertarBDE(datos){

    //llamado a ajax

     // crear el objeto
     const xhr = new XMLHttpRequest();

     // abrir la conexion
     xhr.open('POST', 'includes/modelos/modelo-entrada-productos.php', true);

     // pasar los datos
     xhr.onload = function() {
          if(this.status === 200) {
               console.log(JSON.parse(xhr.responseText)); //PERMITE mostrar sus valores como json para ingresar sus valores individualmente
              
               // leemos la respuesta de PHP
               const respuesta = JSON.parse(xhr.responseText);

             
               


                // Resetear el formulario
                document.querySelector('#producto-entrada').reset();
 
                // Mostrar la notificacion
                Swal.fire(
                    'Correcto!',
                    `Entrada al inventario exitosa!`,
                    'success'
                    )
          }
     }
 
     // enviar los datos
     xhr.send(datos)


}

function leerFormularioProducto(e){
    e.preventDefault(); //para que no actualiza la url
    
    //leero los datos de los inputs
    const Codigo = document.querySelector('#Codigo').value,
          Nombre = document.querySelector('#Nombre').value,
          Tipo = document.querySelector('#Tipo').value,
          Precio = document.querySelector('#Precio').value,
          Nombre_u = document.querySelector('#Nombre_u').value,
          Accion=document.querySelector('#Accion').value;
    
    if(Codigo === '' || Nombre === '' || Tipo === "" || Precio === ''){
        Swal.fire({
            type: 'error',
            title: 'Error',
            text: 'Ambos campos son obligatorios',
          })
        
    }else{
        //pasa la validacion crear llamado a ajax
        const infoProducto = new FormData(); //mejor forma para leer datos de formulario a traves de ajax
        infoProducto.append('Codigo',Codigo);
        infoProducto.append('Nombre',Nombre);
        infoProducto.append('Tipo',Tipo);
        infoProducto.append('Precio',Precio);
        infoProducto.append('Nombre_u',Nombre_u);
        infoProducto.append('Accion',Accion);
        

       //console.log(...infoProducto); //MIRAR QUE ESTAN PASANDO BIEN MIS DATOS

        if(Accion === 'ingresar'){
            // crearemos un nuevo contacto
            insertarBD(infoProducto);
       } else {
           //editar el producto
           //leer el id
           const idRegistro = document.querySelector('#id').value;
           infoProducto.append('id',idRegistro);
           actualizarRegistroP(infoProducto);
           
       }

    }
   
}


/**inserta en la bd via ajax */
function insertarBD(datos) {
    // llamado a ajax

    // crear el objeto
    const xhr = new XMLHttpRequest();

    // abrir la conexion
    xhr.open('POST', 'includes/modelos/modelo-productos.php', true);

    // pasar los datos
    xhr.onload = function() {
         if(this.status === 200) {
              console.log(JSON.parse(xhr.responseText)); //PERMITE mostrar sus valores como json para ingresar sus valores individualmente
             
              // leemos la respuesta de PHP
              const respuesta = JSON.parse(xhr.responseText);

                //inserta un nuevo elemento a la tabla
                const nuevoproducto = document.createElement('tr')


                nuevoproducto.innerHTML = `

                 <td>${respuesta.datos.Codigo}</td>
                 <td>${respuesta.datos.Nombre}</td>
                 <td>${respuesta.datos.Tipo}</td>
                 <td>${respuesta.datos.Precio}</td>
                 <td>${respuesta.datos.Nombre_u}</td>

               `; 

               //crear contenedor para los botones viene siendo el padre
               const contenedorAcciones = document.createElement('td');


               //crear el icono de editar
               const iconoEditar = document.createElement('i');
               iconoEditar.classList.add('fas','fa-pen-square', 'btn-editar');

               //crea el enlace para editar
               const btnEditar = document.createElement('a');
               btnEditar.appendChild(iconoEditar)
               btnEditar.href= `editar.php?id=${respuesta.datos.Codigo}`;
               btnEditar.classList.add('btn', 'btn_editar');

               //agregar al padre
               contenedorAcciones.appendChild(btnEditar);

               //crear el icono de eliminar
            const iconoEliminar = document.createElement('i');
            iconoEliminar.classList.add('fas','fa-trash-alt', 'btn-borrar');

            //crear el boton para eliminar
            const btnEliminar = document.createElement('button');
                  btnEliminar.appendChild(iconoEliminar);
                  btnEliminar.setAttribute('data-id',respuesta.datos.Codigo);
                  btnEliminar.classList.add('btn','btn-borrar');

            //agregarndo el boton eliminar al padre
            contenedorAcciones.appendChild(btnEliminar);

            //agregar los bonotenes (td) al tr
            nuevoproducto.appendChild(contenedorAcciones);

            //agregarlo con los contactos o sea la tabla
            listadoProductos.appendChild(nuevoproducto);

               // Resetear el formulario
               document.querySelector('form').reset();

               // Mostrar la notificacion
               Swal.fire(
                'Exito!',
                `${respuesta.datos.Nombre} registrado correctamente`,
                'success'
                )
         }
    }

    // enviar los datos
    xhr.send(datos)
}

function actualizarRegistroP(datos){
     console.log(...datos); 

    const xhr = new XMLHttpRequest();

    xhr.open('POST', 'includes/modelos/modelo-productos.php', true);

    xhr.onload = function(){
        
        if(this.status == 200){
            const respuesta = JSON.parse(xhr.responseText);
           
            console.log(Nombre_u);
          
            if(respuesta.respuesta === 'correcto' ){
                // mostrar notificación de Correcto
                Swal.fire(
                    'Exito!',
                    'Producto Editado exitosamente!',
                    'success'
                    )
                 setTimeout(() => {
                        window.location.href = 'Admin.php';
                        }, 1000);
        }else {
                // hubo un error
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: 'Debes Hacer la Edición del Producto',
                  })
           }
           
            
        }

    }
        xhr.send(datos);
}






//eliminar el prodcuto
// Eliminar el Contacto
function eliminarProductos(e) {
    if( e.target.parentElement.classList.contains('btn-borrar') ) {
         // tomar el ID
         const id = e.target.parentElement.getAttribute('data-id');

         // console.log(id);
         // preguntar al usuario
         const respuesta = confirm('¿Estás Seguro (a) ?');

         if(respuesta) {
              // llamado a ajax
              // crear el objeto
              const xhr = new XMLHttpRequest();

              // abrir la conexión
              xhr.open('GET', `includes/modelos/modelo-productos.php?id=${id}&Accion=borrar`, true);

              // leer la respuesta
              xhr.onload = function() {
                   if(this.status === 200) {
                        const resultado = JSON.parse(xhr.responseText);
                       if(resultado.respuesta == 'correcto'){
                           //eliminar el registro en el dom
                           e.target.parentElement.parentElement.parentElement.remove();

                           //mostrar notifiacion
                           Swal.fire(
                            'Exito!',
                            'Producto Borrado!',
                            'success'
                            )

                       }else{
                           //mostrar una notificacion
                          MostrarNotificacionP('No pudo borrarse el producto','error');
                       }
                                    
                   }
              }

              // enviar la petición
              xhr.send();
         }else{
             console.log('lo pensare');
         }
    }
}

//Notificacion en pantalla
 //DOS PARAMETROS MENSAJE Y CLASE
function MostrarNotificacionP(mensaje,clase){
    const Notificacion = document.createElement('div'); //GENERO UN DIV
    Notificacion.classList.add(clase,'Notificacion','sombra'); //Y LE AGREGO LA CLASE NOTIFICACION
    Notificacion.textContent=mensaje;

    

    //seleccionar el formulario
    formularioProducto.insertBefore(Notificacion,document.querySelector('form div')); //primero que y donde
    //ocultar y mostrar notificacion
    setTimeout(() => { //funcion que espera cierto timepo a  mostrar ejecutar codigo
        Notificacion.classList.add('visible');
        setTimeout(() => {
             Notificacion.classList.remove('visible');           
             setTimeout(() => { //LO DESAPAREZCA TOTALMENTE
                  Notificacion.remove();
             }, 500)
        }, 3000);
   }, 100);
}

function MostrarNotificacionE(mensaje,clase) {
    const NotificacionE = document.createElement('div'); //GENERO UN DIV
    NotificacionE.classList.add(clase,'Notificacion','sombra'); //Y LE AGREGO LA CLASE NOTIFICACION
    NotificacionE.textContent=mensaje;

    //seleccionar el formulario
    formularioProductoEntrada.insertBefore(NotificacionE,document.querySelector('form p'));

    setTimeout(() => { //funcion que espera cierto timepo a  mostrar ejecutar codigo
        NotificacionE.classList.add('visible');
        setTimeout(() => {
             NotificacionE.classList.remove('visible');           
             setTimeout(() => { //LO DESAPAREZCA TOTALMENTE
                  NotificacionE.remove();
             }, 500)
        }, 3000);
    }, 100);
    
}
