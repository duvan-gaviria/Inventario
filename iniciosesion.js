
function envie(){
   
     let datasend = $("#login").serialize();
        document.getElementById("mi_imagen").src = "img/loader.gif";
           
             $("#ingresa").prop('disabled', true);
              
     $.ajax({
         
            url:'login1.php',
            type:'POST',
            data: `${datasend}`,
            datatype: 'json',
            success: function(respuesta) {
            
            validaResultadoLogin(respuesta);
            
            }
        
            }
        );
}


function detectaKeys(event){
   var keycode = event.keyCode;
   if(keycode == '13'){
    validaUsuario();
     
 }
 }

function validaResultadoLogin (respuestaConsulta){
    var cliente = JSON.parse(respuestaConsulta);
    if(!cliente.error){
       if(cliente[0].Estado==="INACTIVO"){
         muestreerror(`Hola ${cliente[0].Nombre}, No estas activo, lamentablemente no puedes continuar`,6000);
         location.href = "http://pruebas.tecnoricel.net/salir";
       }else{
         muestreok(`Hola ${cliente[0].Nombre}`);
       }
       
        
    } else{
       muestreerror("La combinación de correo y contraseña no es valida",3000);
       $("#email").val('');
       $("#password").val('');
    }
    
}

function validaUsuario(){
     var email = $("#email").val();
     var pass = $("#password").val();


   if(email===''){
       
      muestreerror('El correo esta vacio.',1000);
   }else if(pass===''){
        muestreerror('La contraseña esta vacia.', 1000);
   }else{
       envie();
   }
     
}




function muestreerror (mensaje, tiempo){
   Swal.fire({
       icon: 'error',
  position: 'center',
  title: 'Oops...',

  text: mensaje,
  showConfirmButton: false,
  timer: tiempo
  
  
  
});
    document.getElementById("mi_imagen").src = "";
              
             $("#ingresa").prop('disabled', false);
}

function muestreok (titulo){
   Swal.fire({
       icon: 'success',
  position: 'center',
  title: titulo,
  text: 'Redirigiendo a la pagina principal...',
  
  showConfirmButton: false,
  timer: 4000
});
   setTimeout(() => {
      location.href = "/";
   }, 1000);
  
}

