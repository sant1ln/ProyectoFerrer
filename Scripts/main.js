
let RegistroProducto = document.getElementById('RegistroProducto');

let Articulo = document.getElementsByClassName('Articulo')
let AreaRegistro = document.getElementById('AreaRegistro')
let cerrarVentana = document.getElementById('cerrarVentana');
let valoran = document.getElementById('valoran');
let valory = document.getElementsByClassName('valory');
let valori = document.getElementsByClassName('valori');
let cantidadan = document.getElementById('cantan');
let cantidady = document.getElementById('canty');
let cantidadi = document.getElementById('canti');
let registrar = document.getElementById('registrar');
let FacturadoP = document.getElementById('Facturador');
let TotalP = document.getElementById('total');

RegistroProducto.addEventListener('click', AbrirVentana);
cerrarVentana.addEventListener('click',cerrar)
registrar.addEventListener('click',registrarproductos);


for(var i=0;i<Articulo.length;i++){
    Articulo[i].addEventListener('click', AbrirVentana);
}

function AbrirVentana(){
    AreaRegistro.style.display = 'block'
} 

function registrarproductos (){

    let Cantabono = parseInt(cantidadan.value,10)||0,
    Cantyerbas = parseInt(cantidady.value,10)||0,
    Cantinserticidas = parseInt(cantidadi.value,10)||0;

    

let totalpagar = Cantabono + Cantyerbas + Cantinserticidas*valori;
let listadoproductos = [];

if(Cantabono>0){
    listadoproductos.push(Cantabono+'cantidad abonos');
}

if(Cantyerbas>0){
    listadoproductos.push(Cantyerbas+'cantidad yerbas'); 
}

if(Cantinserticidas>0){
    listadoproductos.push(Cantinserticidas +'cantidad inserticidas')
}

FacturadoP.innerHTML=" ";

for(let i=0;i<listadoproductos.length;i++){
    FacturadoP.innerHTML+= listadoproductos[i]+ '<br/>';
}

TotalP.innerHTML= "Total:  $ "+ totalpagar;



}

function cerrar(){
   /*  console.log('Funciono') */
   AreaRegistro.style.display = 'none'
}

