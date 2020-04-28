let login = document.getElementById('login');
let Ingreso = document.getElementById('Ingreso');
let admin = document.getElementById('admin');
let vender = document.getElementById('vender');

/* Ingreso.addEventListener('click',Entrar) */


function Entrar(){

    let user=document.getElementById('usuario').value;
    let password=document.getElementById('Contrasena').value;

   

    let NombreAdmin = "Paula";
    let PassTrabajor = "j123"

    var val = document.getElementById("Tipo").value;
    console.log(val);



    if(val === "2"){
        

        if((NombreAdmin==user)&&(PassTrabajor===password)){
            location.href="Venta.php";
            admin.style.display = 'none';
            
            
        }else{
            alert('Contraseña Incorrecta');

        }

    }else if (val === "1"){
        ((NombreAdmin==user)&&(PassTrabajor==password))
        location.href="Venta.php";

    }else{
        alert('Contraseña Incorrecta');

    }     
    }

