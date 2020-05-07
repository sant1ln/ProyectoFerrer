const Formularioproveedor = document.querySelector('#Fproveedor')

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
            console.log(respuesta)
        }

    }
    xhr.send(datosP);

}