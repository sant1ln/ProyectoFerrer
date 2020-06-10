var admins = document.getElementById('admins') /* Obtener contenedor */
/* Abrir Crear(mostrarinventario ) Cerrar Inventario */
var inventarioMORE = document.getElementById('inventarioMORE');
var botonAbrir = document.getElementById('botonAbrir').addEventListener('click',AbrirInventario);
var CerrarInventario = document.getElementById('CerrarInventario').addEventListener('click',CerrarInventario)
var contenedorAlertas = document.querySelector('#alertasC');
function AbrirInventario(){
    inventarioMORE.style.display = 'flex'
    admins.style.display = 'none';
    contenedorAlertas.style.display = 'none';
}

function CerrarInventario(){
    admins.style.display = 'flex';
    inventarioMORE.style.display = 'none';
    inventarioADD.style.display = 'none';
    contenedorAlertas.style.display = 'flex';
}

/* Abrir Crear(Añadirinventario ) Cerrar Inventario */
var inventarioADD = document.getElementById('inventarioADD')
var botonAnadir = document.getElementById('botonAnadir').addEventListener('click',AbrirADD)
var CerrarAnadir = document.getElementById('CerrarAnadir').addEventListener('click',CerrarADD)

function AbrirADD(){
    inventarioADD.style.display = 'flex';
    admins.style.display = 'none';
    contenedorAlertas.style.display = 'none';
}

function CerrarADD(){
    inventarioADD.style.display = 'none';
    admins.style.display = 'flex';
    contenedorAlertas.style.display = 'flex';
}

/* Abrir crear (AñadirEmpleado) Cerrar Empleados */ 
var botonAnadirE = document.getElementById('botonAnadirE').addEventListener('click',AbrirADDEmpleado);
var EmpleadoADD = document.getElementById('EmpleadoADD');
var BTNEmpleado = document.getElementById('CerrarEmpleado').addEventListener('click',CerrarADDEmpleado);

function AbrirADDEmpleado(){
    EmpleadoADD.style.display = 'flex'
    admins.style.display = 'none';
    contenedorAlertas.style.display = 'none';
}

function CerrarADDEmpleado(){
    EmpleadoADD.style.display = 'none'
    admins.style.display = 'flex';
    contenedorAlertas.style.display = 'flex';
}

/* Abrir crear(ver inventario) cerrar Empleados */
var botonVerE = document.getElementById('botonVerE').addEventListener('click',VerEmpleado);
var CerrarEmpleados = document.getElementById('CerrarEmpleados').addEventListener('click',CerrarEmpleados);
var EmpladoMORE = document.getElementById('EmpladoMORE');


function VerEmpleado(){
    EmpladoMORE.style.display = 'flex';
    admins.style.display = 'none';
    contenedorAlertas.style.display = 'none';
}

function CerrarEmpleados(){
    EmpladoMORE.style.display = 'none';
    admins.style.display = 'flex';
    contenedorAlertas.style.display = 'flex';
}

/* Abrir crear(AñadirEntrada) cerrar Empleados  */
var botonAnadirEntrada = document.getElementById('botonAnadirEntrada').addEventListener('click',AnadirEntrada);
var CerrarAnadirEntrada = document.getElementById('CerrarAnadirEntrada').addEventListener('click',CerrarEntrada);
var EntradaADD = document.getElementById('EntradaADD');
 
function AnadirEntrada(){
   
        EntradaADD.style.display = "flex";
        admins.style.display = 'none';
        contenedorAlertas.style.display = 'none';
}

function CerrarEntrada(){
    EntradaADD.style.display = "none";
    admins.style.display = 'flex';
    contenedorAlertas.style.display = 'flex';
}

/* Abrir/Cerrar Reporte */

const ReportCreate = document.querySelector('#ReportCreate'),
      CerrarReporte = document.querySelector('#CerrarReporte').addEventListener('click',CerrarRep),
      Reporte = document.querySelector('#Reporte').addEventListener('click',AbrirReporte);

function AbrirReporte(){
    ReportCreate.classList.toggle('Reporte');
    admins.style.display = 'none';
    contenedorAlertas.style.display = 'none';
}
function CerrarRep(){
    ReportCreate.classList.toggle('Reporte');
    admins.style.display = 'flex';
    contenedorAlertas.style.display = 'flex';
}

const alert = document.getElementsByClassName('alert')

for(var i=0;i<alert.length;i++){
    alert[i].addEventListener('click', CerrarAlerta)
    console.log(i);
}

function CerrarAlerta(){
    const alerta = document.getElementsByClassName('alerta')
    /* console.log(alerta); */
    alerta.style.display = 'none'
}
