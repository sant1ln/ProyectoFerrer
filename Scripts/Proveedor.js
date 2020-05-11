const Formularioproveedor = document.querySelector('#Fproveedor'),
Lista_Provedores = document.querySelector('#Lista_Provedores tbody')

eventListeresP();

function eventListeresP(){

    Formularioproveedor.addEventListener('submit',leerFormularioP);
    Lista_Provedores.addEventListener('click',eliminarProveedor);
}

function leerFormularioP(e){
   
    e.preventDefault();
       

    const cedulaProv = document.querySelector('#CedulaProveedor').value;
    const nombreProv = document.querySelector('#nombreProveedor').value;
    const telefonoProv = document.querySelector('#CelularProveedor').value;
    const dirProv = document.querySelector('#direccionProveedor').value;
    const creador = document.querySelector('#creador_P').value;
    const accion = document.querySelector('#AccionP').value;

    if(cedulaProv == '' || nombreProv == '' || telefonoProv == '' || dirProv == ''){
        Swal.fire({
            type: 'error',
            title: 'Error',
            text: 'Todos los son obligatorios',
          })
    }else{
        const infoProvedor = new FormData();
        infoProvedor.append('cedulaP',cedulaProv);
        infoProvedor.append('nombreP', nombreProv);
        infoProvedor.append('telefonoP',telefonoProv);
        infoProvedor.append('direccionP',dirProv);
        infoProvedor.append('creador',creador);
        infoProvedor.append('accion',accion);


        /* console.log(...infoProvedor); */

        if(accion == 'crear'){
            insertarBD(infoProvedor)
        }else{
            const ProvEdit = document.querySelector('#ProvEdit').value;
            /* const btnedit = document.querySelector('#AccionPU').value; */
            infoProvedor.append('cedula',ProvEdit);
            /* nfoProvedor.append('AccionPU',btnedit) */
            actualizarProvedor(infoProvedor);
        }
    }

}

function  insertarBD(datosP){

    var xhr = new XMLHttpRequest();

    //  abrir conexion
    xhr.open('POST', 'includes/modelos/modelo-provedor.php', true);

    xhr.onload = function(){
        if(this.status === 200){
            console.log(xhr.responseText);
            
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);
            if(respuesta.respuesta == 'correcto'){
                Swal({
                    title: 'Exito',
                    text: `El proveedor a sido ingresado`,
                    type: 'success'

                });
                Formularioproveedor.reset();
                MostrarProvedorCreado(respuesta);
            }else if(respuesta.respuesta == 'error'){
                Swal.fire({
                    type: 'error',
                    title: 'Error!',
                    text: `El documento del proveedor ya se encuentra registrado `,
                    })
                /* document.querySelector('#CedulaProveedor').style.border.color = "Red"; */
                    
            }
        }

    }
    xhr.send(datosP);

}

function actualizarProvedor(datosUP){

    const xhr = new XMLHttpRequest();

    xhr.open('POST','includes/modelos/mod-editarProveedor.php', true);

    xhr.onload = function(){
        if(this.status == 200){
            /* console.log(xhr.responseText); */
            
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);
            if(respuesta.respuesta == 'correcto' ){
                Swal({
                    title: 'Exito',
                    text: `El proveedor ${respuesta.nombre} a sido actualizado`,
                    type: 'success'

                });
                /* setTimeout(() => {
                    window.location.href = 'Admin.php';
                }, 1000); */
            }else {
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: 'Debe de hacer una edicion',
                  })
           }
        }
    }
    xhr.send(datosUP);
}



function MostrarProvedorCreado(respuesta){
    /* console.log("Quiero café"); */

    const nuevoProveedor = document.createElement('tr');
    
    nuevoProveedor.innerHTML = `
    <td>${respuesta.cedula}</td>
    <td>${respuesta.nombre}</td>
    <td>${respuesta.telefono}</td>
    <td>${respuesta.direccion}</td>
    <td>${respuesta.creador}</td>
     `;
     const contenedorAcciones = document.createElement('td');
     const iconoEditar = document.createElement('i');
               iconoEditar.classList.add('fas','fa-pen-square', 'btn-editar');

               //crea el enlace para editar
               const btnEditar = document.createElement('a');
               btnEditar.appendChild(iconoEditar)
               btnEditar.href= `updProveedor.php?id=${respuesta.cedula}`;
               btnEditar.classList.add('btn', 'btn_editar');

               //agregar al padre
               contenedorAcciones.appendChild(btnEditar);

               //crear el icono de eliminar
            const iconoEliminar = document.createElement('i');
            iconoEliminar.classList.add('fas','fa-trash-alt', 'btn-borrar');

            //crear el boton para eliminar
            const btnEliminar = document.createElement('button');
                  btnEliminar.appendChild(iconoEliminar);
                  btnEliminar.setAttribute('data-id',respuesta.cedula);
                  btnEliminar.classList.add('btn','btn-borrar');

            //agregarndo el boton eliminar al padre
            contenedorAcciones.appendChild(btnEliminar);

            nuevoProveedor.appendChild(contenedorAcciones);

            //agregarlo con los contactos o sea la tabla
            Lista_Provedores.appendChild(nuevoProveedor);
}

function eliminarProveedor(e){
        if(e.target.parentElement.classList.contains('btn-borrar')){
            const id = e.target.parentElement.getAttribute('data-id');
            console.log(id);
            

            const respuesta = confirm('¿Estas Seguro?')

            if(respuesta){
                const xhr = new XMLHttpRequest();
                
                 xhr.open('GET',`includes/modelos/modelo-provedor.php?id=${id}&accion=borrar`, true );
                 xhr.onload = function(){
                    if(this.status === 200){
                          console.log(xhr.responseText);
                                              
                        const resultado = JSON.parse(xhr.responseText);
                        console.log(resultado.resultado);
                        if(resultado.resultado == 'correcto'){
                            Swal({
                                title: 'Exito',
                                text: `El proveedor  a sido eliminado`,
                                type: 'success'
            
                            });
                            e.target.parentElement.parentElement.parentElement.remove();
                            
                            
                        }
                        
                    }
                 }
                 
                 xhr.send();
            }
            
        }
        
}