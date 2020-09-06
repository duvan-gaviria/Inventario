$(document).ready(function() {

  $('#save').click(function() {
       
      let dataform =$('#insertclientform').serialize();
      
      document.getElementById("esperaClienteGuardar").src = "img/loader.gif";
     $("#save").prop('disabled', true);
          $.ajax({
            url:'insertClientClaro.php',
            type:'POST',
            data: `soy=2&${dataform}`,
            success: function(response) {
              var responder = JSON.parse(response);
              
              clienteok(responder);
              
            }
        });
        });
        
        
    
 
});

function clienteok (respuesta){
  if(!respuesta.error){
    var ncliente = $("#nombres").val().toUpperCase();
    var apeclie = $("#apellidos").val().toUpperCase();
    okcliente(`${ncliente} ${apeclie}, Agregado.`);
  }else{
    failcliente(`No se pudo agregar el cliente: ${ncliente} ${apeclie}.`);
  }
}

function failcliente (mensaje){
  Swal.fire({
      icon: 'error',
 position: 'center',
 title: 'Algo Fallo',
 text: mensaje,
 
 showConfirmButton: true,
 timer: 4000
});
}
  
function okcliente (mensaje){
  Swal.fire({
      icon: 'success',
 position: 'center',
 title: 'Todo Ok',
 text: mensaje,
 showConfirmButton: false,
 timer: 3000
});
document.getElementById("esperaClienteGuardar").src = "";
$("#save").prop('disabled', false);
$("#insertclientform")[0].reset();
$("#nuevoclienteclaro").modal('hide');

}
