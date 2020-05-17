const Form_Report = document.querySelector('#Form_Report');

eventListenersR();

function eventListenersR(){
    Form_Report.addEventListener('submit',leerFechas);
}

function leerFechas(e){
    e.preventDefault();
    console.log("Presionaste Reporte");
    const FechaIncio = document.querySelector('#FechaIncio').value,
    FechaFin = document.querySelector('#FechaFin').value;
    document.querySelector('#FechaI').innerHTML = FechaIncio,
    document.querySelector('#FechaF').innerHTML = FechaFin;
    console.log(FechaIncio);
    console.log(FechaFin);
    
    
}


   
      
      
      