var admins = document.getElementById('admins') /* Obtener contenedor */
/* Abrir Crear(mostrarinventario ) Cerrar Inventario */
var inventarioMORE = document.getElementById('inventarioMORE');
var botonAbrir = document.getElementById('botonAbrir').addEventListener('click',AbrirInventario);
var CerrarInventario = document.getElementById('CerrarInventario').addEventListener('click',CerrarInventario)

function AbrirInventario(){
    inventarioMORE.style.display = 'flex'
    admins.style.display = 'none';
}

function CerrarInventario(){
    admins.style.display = 'flex';
    inventarioMORE.style.display = 'none';
    inventarioADD.style.display = 'none';
}

/* Abrir Crear(Añadirinventario ) Cerrar Inventario */
var inventarioADD = document.getElementById('inventarioADD')
var botonAnadir = document.getElementById('botonAnadir').addEventListener('click',AbrirADD)
var CerrarAnadir = document.getElementById('CerrarAnadir').addEventListener('click',CerrarADD)

function AbrirADD(){
    inventarioADD.style.display = 'flex';
    admins.style.display = 'none';
}

function CerrarADD(){
    inventarioADD.style.display = 'none';
    admins.style.display = 'flex';
    
}

/* Abrir crear (AñadirEmpleado) Cerrar Empleados */ 
var botonAnadirE = document.getElementById('botonAnadirE').addEventListener('click',AbrirADDEmpleado);
var EmpleadoADD = document.getElementById('EmpleadoADD');
var BTNEmpleado = document.getElementById('CerrarEmpleado').addEventListener('click',CerrarADDEmpleado);

function AbrirADDEmpleado(){
    EmpleadoADD.style.display = 'flex'
    admins.style.display = 'none';
}

function CerrarADDEmpleado(){
    EmpleadoADD.style.display = 'none'
    admins.style.display = 'flex';
}

/* Abrir crear(ver inventario) cerrar Empleados */
var botonVerE = document.getElementById('botonVerE').addEventListener('click',VerEmpleado);
var CerrarEmpleados = document.getElementById('CerrarEmpleados').addEventListener('click',CerrarEmpleados);
var EmpladoMORE = document.getElementById('EmpladoMORE');

    /* Temporal */
EmpladoMORE.style.display = 'flex';
    admins.style.display = 'none';
    /* Temporal */
function VerEmpleado(){
    EmpladoMORE.style.display = 'flex';
    admins.style.display = 'none';
}

function CerrarEmpleados(){
    EmpladoMORE.style.display = 'none';
    admins.style.display = 'flex';
}

/* Abrir crear(AñadirEntrada) cerrar Empleados  */
var botonAnadirEntrada = document.getElementById('botonAnadirEntrada').addEventListener('click',AnadirEntrada);
var CerrarAnadirEntrada = document.getElementById('CerrarAnadirEntrada').addEventListener('click',CerrarEntrada);
var EntradaADD = document.getElementById('EntradaADD');
 
function AnadirEntrada(){
   
        EntradaADD.style.display = "flex";
        admins.style.display = 'none';
}

function CerrarEntrada(){
    EntradaADD.style.display = "none";
    admins.style.display = 'flex';
}

