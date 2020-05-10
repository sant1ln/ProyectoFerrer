const Formularioempleado = document.querySelector('#Fempleado'),
      Lista_empleados = document.querySelector('#Lista_empleados tbody');

eventListenersE();


function eventListenersE(){
        // cuando el form se ejecuta;
        Formularioempleado.addEventListener('submit',leerFormulario);
        Lista_empleados.addEventListener('click',eliminarContacto)
        
}
// leer form
function leerFormulario(e){
    e.preventDefault();
    console.log("Presionaste añadir");

    //Leer datos
    const cargo = document.querySelector('#cargo').value;
    const nombreEmpleado = document.querySelector('#nombreEmpleado').value;
    const CedulaEmpleado = document.querySelector('#CedulaEmpleado').value;
    const CelularEmpleado = document.querySelector('#CelularEmpleado').value;
    const direccionEmpleado = document.querySelector('#direccionEmpleado').value;
    const contrasenaEmpleado = document.querySelector('#passEmpleado').value;
    
    const Accion = document.querySelector('#Accion2').value;
    // console.log(cargo + nombreEmpleado + CedulaEmpleado + CelularEmpleado + direccionEmpleado  )

    if(cargo === '' || nombreEmpleado === '' || CedulaEmpleado === 
    '' || CelularEmpleado === '' || direccionEmpleado === '' || contrasenaEmpleado === '' ){
        Swal.fire({
            type: 'error',
            title: 'Error',
            text: 'Todos los son obligatorios',
          })
    }else{
        
        // Pasa validacion, crear llamado a AJAX
        const infoEmpleado = new FormData();
        infoEmpleado.append('cargo', cargo);
        infoEmpleado.append('nombre',nombreEmpleado);
        infoEmpleado.append('cedula',CedulaEmpleado);
        infoEmpleado.append('celular',CelularEmpleado);
        infoEmpleado.append('direccion',direccionEmpleado);
        infoEmpleado.append('pass',contrasenaEmpleado);
        infoEmpleado.append('accion',Accion);

        /* console.log(...infoEmpleado); */

        if(Accion == 'crear'){
            insertarBsD(infoEmpleado)
        }else{
            const idRegistro = document.querySelector('#id_empleado').value;
            infoEmpleado.append('id_empleado', idRegistro); 
            actualizarRegistro(infoEmpleado);
        }
    }

}

// Inserta en la BD via con AJAX
 function insertarBsD(datosE){

    // crear objeto
    var xhr = new XMLHttpRequest();

    //  abrir conexion
    xhr.open('POST', 'includes/modelos/modelo-empleados.php', true);


    // Se pasan los datos
    xhr.onload = function(){
        if(this.status === 200){
           
            
            // console.log(JSON.parse(xhr.responseText));
            // leemos la respues de PHP
            
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta.respuesta);
            document.getElementById("Fempleado").reset(); // Resetea el formulario
            if(respuesta.respuesta === 'correcto'){
                Swal.fire(
                    'Exito!',
                    `${respuesta.datos.nombre} registrado correctamente`,
                    'success'
                    )
            }
            // Inserta un nuevo elemento a la tabla empelado
             const nuevoEmpleado = document.createElement('tr');
             
             nuevoEmpleado.innerHTML = `
                <td>${respuesta.datos.cargo}</td>
                <td>${respuesta.datos.nombre}</td>
                <td>${respuesta.datos.cedula}</td>
                <td>${respuesta.datos.telefono}</td>
                <td>${respuesta.datos.direccion}</td>
             `;

            // crear contenedor para los botones
            const contenedorAcciones = document.createElement('td');
            
            // crear icono de editar.
            const BtnEditar = document.createElement('i');
            BtnEditar.classList.add('fas', 'fa-pen-square', 'btn-editar');

            // creamos elemento a.
            const enlaceEdit = document.createElement('a');
            enlaceEdit.classList.add('btn');
            enlaceEdit.appendChild(BtnEditar);
            enlaceEdit.href = `editar.php?=${respuesta.datos.id_insertado}`;

            // agregarlo al padre
            contenedorAcciones.appendChild(enlaceEdit);

            // creamos icono eliminar
            const iconoEliminar = document.createElement('i');
            iconoEliminar.classList.add('fas', 'fa-trash-alt', 'btn-borrar');

            const BtnEliminar = document.createElement('button');
            BtnEliminar.appendChild(iconoEliminar);
            BtnEliminar.setAttribute('data-id',respuesta.datos.id_insertado);
            BtnEliminar.classList.add('btn');
            
            contenedorAcciones.appendChild(BtnEliminar);  

            // Agregarlo al tr

            nuevoEmpleado.appendChild(contenedorAcciones);
            
            Lista_empleados.appendChild(nuevoEmpleado);

            /* NotificacionEmpleado('Empleado ingresado correctamente!','correcto'); */
        }
    }


    xhr.send(datosE);

}


function eliminarContacto(e){
    if(e.target.parentElement.classList.contains('btn-borrar')){
        //tomar id
        const id = e.target.parentElement.getAttribute('data-id');
        // console.log(id);

        const respuesta = confirm(`¿Estas seguro? Perderas el registro permanentemente`)
        
        if(respuesta){
           /*  console.log("1"); */
            
            const xhr = new XMLHttpRequest();

            xhr.open('GET',`includes/modelos/modelo-empleados.php?id=${id}&accion=borrar`,true);
            
            xhr.onload = function(){
                /* console.log("2"); */
                 if(this.status === 200){
                    
                     /* console.log("3"); */
                     
                     const resultado = JSON.parse(xhr.responseText);
                        if(resultado.respuesta === 'correcto'){
                            e.target.parentElement.parentElement.parentElement.remove();
                            /* NotificacionEmpleado('Empleado Eliminado satisfactoriamente','correcto'); */
                        }else{
                           /*  NotificacionEmpleado('hubo un error',error); */
                        }
                     
                     
                 }
            }
            xhr.send();
        }
    }
    
}


function actualizarRegistro(datosU){
    //console.log(...datosU); 

    const xhr = new XMLHttpRequest();

    xhr.open('POST', 'includes/modelos/mod-editarEmpleado.php', true);

    xhr.onload = function(){
        if(this.status == 200){            
            const respuesta = JSON.parse(xhr.responseText);
         
            console.log(respuesta);

            if(respuesta.respuesta === 'correcto' ){
                // mostrar notificación de Correcto
                Swal.fire(
                    'Exito!',
                    'Usuario Editado exitosamente!',
                    'success'
                    )
                 setTimeout(() => {
                        window.location.href = 'Admin.php';
                        }, 1000);
        }
            
        }

    }
        xhr.send(datosU);
}

// notificacion
function NotificacionEmpleado(mensaje,clase) {
    const NotificacionEmpleado = document.createElement('div'); //GENERO UN DIV
    NotificacionEmpleado.classList.add(clase,'Notificacion','sombra'); //Y LE AGREGO LA CLASE NOTIFICACION
    NotificacionEmpleado.textContent=mensaje;

    //seleccionar el formulario
    Formularioempleado.insertBefore(NotificacionEmpleado,document.querySelector('form div'));

    setTimeout(() => { //funcion que espera cierto timepo a  mostrar ejecutar codigo
        NotificacionEmpleado.classList.add('visible');
        setTimeout(() => {
             NotificacionEmpleado.classList.remove('visible');           
             setTimeout(() => { //LO DESAPAREZCA TOTALMENTE
                  NotificacionEmpleado.remove();
             }, 500)
        }, 3000);
    }, 100);
    
}
