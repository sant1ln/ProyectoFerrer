const Formularioproveedor = document.querySelector('#Fproveedor'),
Lista_Provedores = document.querySelector('#Lista_Provedores')

eventListeresP();

function eventListeresP(){

    Formularioproveedor.addEventListener('submit',leerFormularioP);

}

function leerFormularioP(e){
   
    e.preventDefault();
       

    const cedulaProv = document.querySelector('#CedulaProveedor').value;
    const nombreProv = document.querySelector('#nombreProveedor').value;
    const telefonoProv = document.querySelector('#CelularProveedor').value;
    const dirProv = document.querySelector('#direccionProveedor').value;
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
        infoProvedor.append('accion',accion);


        /* console.log(...infoProvedor); */

        if(accion == 'crear'){
            insertarBD(infoProvedor)
        }
    }

}

function  insertarBD(datosP){

    var xhr = new XMLHttpRequest();

    //  abrir conexion
    xhr.open('POST', 'includes/modelos/modelo-provedor.php', true);

    xhr.onload = function(){
        if(this.status === 200){
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);
            if(respuesta.respuesta == 'correcto'){
                Swal({
                    title: 'Exito',
                    text: `El proveedor ${respuesta.nombre} a sido ingresado`,
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

function MostrarProvedorCreado(respuesta){
    /* console.log("Quiero café"); */

    const nuevoProveedor = document.createElement('tr');
    
    nuevoProveedor.innerHTML = `
    <td>${respuesta.cedula}</td>
    <td>${respuesta.nombre}</td>
    <td>${respuesta.telefono}</td>
    <td>${respuesta.direccion}</td>
     `;
     const contenedorAcciones = document.createElement('td');
     const iconoEditar = document.createElement('i');
               iconoEditar.classList.add('fas','fa-pen-square', 'btn-editar');

               //crea el enlace para editar
               const btnEditar = document.createElement('a');
               btnEditar.appendChild(iconoEditar)
               btnEditar.href= `editarP.php?id=${respuesta.id_insertado}`;
               btnEditar.classList.add('btn', 'btn_editar');

               //agregar al padre
               contenedorAcciones.appendChild(btnEditar);

               //crear el icono de eliminar
            const iconoEliminar = document.createElement('i');
            iconoEliminar.classList.add('fas','fa-trash-alt', 'btn-borrar');

            //crear el boton para eliminar
            const btnEliminar = document.createElement('button');
                  btnEliminar.appendChild(iconoEliminar);
                  btnEliminar.setAttribute('data-id',respuesta.id_insertado);
                  btnEliminar.classList.add('btn','btn-borrar');

            //agregarndo el boton eliminar al padre
            contenedorAcciones.appendChild(btnEliminar);

            nuevoProveedor.appendChild(contenedorAcciones);

            //agregarlo con los contactos o sea la tabla
            Lista_Provedores.appendChild(nuevoProveedor);
}