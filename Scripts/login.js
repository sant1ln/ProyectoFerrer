const formulariologin = document.querySelector('#login');

eventListenersL();

function eventListenersL(){
    formulariologin.addEventListener('submit', leerFormularioLogin);
}

function leerFormularioLogin(e){
    e.preventDefault();

    const usuario = document.querySelector('#usuario').value;
    const contrasena = document.querySelector('#contrasena').value;
    const Accion = document.querySelector('#Accion').value;

   if(usuario === '' || contrasena === ''){
    Swal.fire({
        type: 'error',
        title: 'Error',
        text: 'Ambos campos son obligatorios',
      })
   }else{
        const infologin = new FormData();
        infologin.append('usuario',usuario);
        infologin.append('contrasena',contrasena);
        infologin.append('Accion',Accion);

        //llamado a ajax

        var xhr = new XMLHttpRequest();

        //abrir la conexion
        xhr.open('POST','includes/modelos/modelo-login.php',true)
        
         //retorno de datos
         xhr.onload = function(){
            if(this.status === 200){
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta);
                
                if(respuesta.Accion === 'login' && respuesta.tipo_empleado === 'Administrador'){
                    Swal({
                        title: 'Iniciando Sesion...',
                        text: `Bienvenido ${usuario}`,
                        type: 'success'

                    })
                    .then(resultado => {
                       if(resultado.value){
                           window.location.href='Admin.php';
                       }
                        
                    })
                }else if(respuesta.Accion === 'login' && respuesta.tipo_empleado === 'Cajero'){
                    Swal({
                        title: 'Iniciando Sesion...',
                        text: `Bienvenido ${usuario}`,
                        type: 'success'

                    })
                    .then(resultado => {
                       if(resultado.value){
                           window.location.href='Venta.php';
                       }
                        
                    })
                    
                }
                else{
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Contraseña o Usuario incorrecto!',
                        footer: '<a href="#">¿Olvidaste tu Contraseña?</a>'
                      })

                }
            }
    
         }

          // Enviar la petición
          xhr.send(infologin);

   
      }

   }

