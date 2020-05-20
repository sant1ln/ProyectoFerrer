
let RegistroProducto = document.getElementById('RegistroProducto');

let Articulo = document.getElementsByClassName('Articulo')
let AreaRegistro = document.getElementById('AreaRegistro')
let cerrarVentana = document.getElementById('cerrarVentana');
let Registrar = document.getElementById('registrar');



RegistroProducto.addEventListener('click', AbrirVentana);
cerrarVentana.addEventListener('click',cerrar)
Registrar.addEventListener('click',RegistrarProducto);



for(var i=0;i<Articulo.length;i++){
    Articulo[i].addEventListener('click', AbrirVentana);
}

function AbrirVentana(){
    AreaRegistro.style.display = 'block'
} 

function RegistrarProducto(){
   
    let Cantidadabonos=document.getElementsByClassName('Cant');
    let Productosaregistrar = new Array();
    
  

    for (var i =0;i<=Cantidadabonos.length;i++){
      
 
        Cantidadabonos[i];
        console.log(Cantidadabonos[i].value);
        console.log(Productosaregistrar);

        if(Cantidadabonos[i].value.trim() !== ''){
            console.log('true');
            Productosaregistrar.push(...Productosaregistrar,Cantidadabonos[i].value);


        }else{
            console.log('false');
            alert('datos vacios');

        }

        
       


    }
    
   
}



function cerrar(){
   /*  console.log('Funciono') */
   AreaRegistro.style.display = 'none'
}

