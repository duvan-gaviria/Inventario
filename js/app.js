$(document).ready(function() {
        $("#saveProduct").click(function(event){
          event.preventDefault();
        });
        $('body').on('click', '#searchLink', function(){
          openModals('resltSearchRef')
          $("#resultado").html(spinners)
          let search  = $('#search').val();
          $('#ced').html(`Resultados Para La Cédula:<em> ${search}</em>`)
          $.ajax({
            url:'BuscarReferenciaEquipo.php',
            type:'POST',
            data: {search},
            success: function(response) {
          $('#resultado').html(response);}});
        })
});

function validaCamposGuiaNueva(){
    if($("#guia").val().length < 12 ){
         
         muestreerror("La guia debe contener almenos 12 caracteres",'Falta Guia')
    }else if($("#docremitente").val().length< 6){
        document.getElementById('docremitente').focus()
        muestreerror("El documento debe tener almenos 6 caracteres",'Documento incompleto')
    }else if($("#remitente").val().length < 8 ){
         muestreerror('El nombre del remitente debe de tener almenos 8 caracteres','Nombre Muy Corto')
    }else if($("#docdestinatario").val().length < 1){
        muestreerror('El campo debe tener almenos un digito','Docuemnto vacio')
    }else if($("#destinatario").val().length < 8){
        muestreerror('El nombre del destinatario es demasiado corto','Destinatario incompleto')
    }else if($("#telDestinatario").val().length <10){
        muestreerror('El télefono del destinatario debe de contener almenos 10 caracteres','Télefono incompleto')
    }else if($("#city").val().length < 4){
        muestreerror('La ciudad de destino esta incompleta','Ciudad Error')
    }else if($("#destino").val().length < 10){
        muestreerror('La dirección esta incompleta','Incompleto')
    }else if($("#valorEnvio").val() < 15000){
      muestreerror('El valor cobrado es inferior al valor minimo cobrado $ 15.000,00','Incompleto')
    }else {
        guardaGuiaInter()
    }
}


function guardaGuiaInter(){
    let dataToSend = $("#nuevaGuia").serialize()
    $.ajax({
      url: 'saveAll.php',
      type: 'POST',
      data: `soy=guardaGuias&${dataToSend}`,
      success: function(req){
        let respuesta = JSON.parse(req)
        if(!respuesta.error){
          $("#nuevaGuia")[0].reset();
          document.getElementById('guia').focus()
          operacionExitosa('Guia guardada con exito.','Exito')
        }else{
        muestreerror('Algo salio mal','Error')
        }
      },
      error: function(re){
        muestreerror(re,"Error")
      }
    })
}


function listarEnviosBodega(){
    $.ajax({
        url: 'consultas.php',
        type: 'POST',
        data: `queHacer=listaEnviosBodega`,
        success: function(req){
            let response = req
            $("#enviosForEntrega").html(response)
        }


    })
}


function consultaDatosManifiesto(){
    $.ajax({
        url: 'consultas.php',
        type: 'POST',
        data: `queHacer=manifiestoGeneraConsulta`,
        success: function(req){
            $("#resultConsultaManifiesto").html(req)
        }

    })
}


function entregarEnvios(id,guia,valor){
  Swal.fire({
    title: `Guia: ${guia}`,
    text: `La guia ¿Es correcta?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, es correcta!'
  }).then((result) => {
    if (result.value) {
        $.ajax({
            url: 'consultas.php',
            type: 'POST',
            data: `queHacer=entregarEnvio&idEnvio=${id}&guia=${guia}&valor=${valor}`,
            success: function(res){
                let response = JSON.parse(res)
                if(!response.error){
                    operacionExitosa('Envio entregado con exito','Exito')
                    listarEnviosBodega()
                }else{
                  muestreerror('Se produjo un error al tratar de entregar el envio','Error')
                }
            },
            error: function(){
              muestreerror('Al parecer no tienes internet.... Y pues asi no funciono','Sin Internet')
            }

        })

    }
  })
}


function validaCamposRecibirEnvios(){
    if($("#guiaEnvio").val().length < 12){
        document.getElementById('guiaEnvio').focus()
        muestreerror('El campo guia esta vacio o tiene menos de 12 caracteres','Campo Incompleto')
    }else if($("#ClientDestino").val().length < 8){
         document.getElementById('ClientDestino').focus()
         muestreerror('El campo Cliente esta vacio o tiene menos de 8 caracteres','Campo Incompleto')
    }else if($("#fpagoenvio").val() === '.::SELECCIONE::.'){
          document.getElementById('fpagoenvio').focus()
          muestreerror('Primero debe de seleccionar una forma de pago valida','Falta Forma De Pago')
    }else if($("#ValCob").val().length < 4){
        document.getElementById('ValCob').focus()
        muestreerror('El campo Valor No parece estar completo','Valor Incompleto')
    }else{
           let dataSend = $("#recepEnvios").serialize()
           
           $.ajax({
               url: 'saveAll.php',
               type: 'POST',
               data: `soy=recibeEnvios&${dataSend}`,
               success: function(req){
                   let respuestaServer = JSON.parse(req)
                   if(!respuestaServer.error){
                        $("#recepEnvios")[0].reset();
                        document.getElementById('guiaEnvio').focus()
                        operacionExitosa('Envio recepcionado con exito','Exito')
                   }else{
                     muestreerror('Operacion fallida: El servidor confirma que no pudo completar esta operación','Fallo!!!')
                   }

               },
               error: function(){
                 muestreerror('No pudimos conectarnos a internet para procesar tu solicitud','No tenes internet')
               }
           })
    }
}





function resetTextoMenu(menu,id){
  switch (menu) {
    case 'Menuinter':
      openModals(id)
      setTimeout(() => {
        $("#InterMenur").html(`<div class="text"><i class="shipping fast icon"></i> Interrapidisimo</div>`)
      }, 1);
     
      break;
     case 'Menuclaro':
       openModals(id)
       setTimeout(() => {
        $("#ClaroMenu").html(`<div class="text"><i class="mobile alternate icon"></i> Administrar Claro</div>`)
      }, 1);
       break;
       case 'MenuVentas':
        obtenerFacturacion();
         openModals(id)
         setTimeout(() => {
         $("#VentasMenu").html(`<div class="text"><i class="shopping cart icon"></i> Ventas</div>`)
        }, 1);
        
         break;
         case 'MenuInvent':
             openModals(id)
             setTimeout(() => {
              $("#Inventmenu").html(`<div class="text"><i class="dolly flatbed icon"></i> Inventario</div>`)
             }, 1);
         break;
    default:
      break;
  }
}


function cambiartypeSearch()
{
  if($("#typesearch").val() === 'PRODUCTOS'){
    
    document.getElementById('search').type = 'text';
    $("#search").val('')
  }else if($("#typesearch").val() === 'REFPAGO'){
    
    document.getElementById('search').type = 'number';
    $("#search").val('')
  }else{
    document.getElementById('search').type = 'tel';
    $("#search").val('')
  }
}


function autoCompleteSearchNavBar(parametro,tipo){
  let datasending=`queHacer=autocompletarSearch&tipo=${tipo}&Dato=${parametro}`
      $.ajax({
        url: 'consultas.php',
        type: 'POST',
        data: `${datasending}`,
        success: function(res){
        
     var categoryContent = JSON.parse(res)
     $('.ui.search').search({
        source: categoryContent
      });
        }
    
    
      })
     
  
  

    }



$('.ui.accordion')
  .accordion()
;

// initialize all modals
$('.coupled.modal')
  .modal({
    allowMultiple: true
  })
;




function autocompletaSemantic(valor){

  let datasending=`queHacer=autocompletarPlaca&Placa=${valor}`

  $.ajax({
    url: 'consultas.php',
    type: 'POST',
    data: `${datasending}`,
    success: function(res){
    
 var categoryContent = JSON.parse(res)
 $('.ui.search')
  .search({
    type: 'category',
    source: categoryContent
  });
    }


  })
  

 
}

function consultaAccesoriosDia(){
  $.ajax({
    url: 'consultas.php',
    type: 'POST',
    data: `queHacer=mostrarAccesoriosDia`,
    success: function(req){
      showmenu();
      $("#resultAccsDia").html(req)
    },
    error: function(err){
     muestreerror('Al parecer Internet no esta funcionando',err)
  }
  })
}


function consultaCelDiaLibres(){
  $.ajax({
    url: 'consultas.php',
    type: 'POST',
    data: `queHacer=mostrarCelLibreDia`,
    success: function(req){
      showmenu();
      $("#resultCellDia").html(req)
    },
    error: function(err){
      showmenu();
      muestreerror('Al parecer Internet no esta funcionando',err)
    }
  })
}


function mostrarEquiposClarodia(){
 
  $.ajax({
    url: 'consultas.php',
    type: 'POST',
    data: `queHacer=mostrarClaroEquiposDia`,
    success: function(res){
      showmenu();
     $('#resultEquiDia').html(res)
     
    },
    error: function(err){
      showmenu();
      muestreerror('Eror: No hay internet al parecer',err)
    }
  })
  
}

function showmenu(){

  $('.ui.sidebar').sidebar('toggle');
}


function uuuu(){
  $("#test").addClass('ui dimmer modals page transition visible active')
  $('#notificación').modal('show')
 
}

function salir(){
  location.href="/salir";
}

function Buttonclic(){
  $(`#testm`).modal('setting', 'transition', 'horizontal flip',{
    allowMultiple: true},
    )
  .modal('show');

}

function openModals(modal){
        
      showmenu()

        $(`#${modal}`).modal('setting', 'transition', 'horizontal flip')
        .modal('show');
      


    }









const convierteAPeso = new Intl.NumberFormat('es-CO', {
  style: 'currency',
  currency: 'COP',
  minimumFractionDigits: 0
});



let spinners = `
<div class="ui segment " style="height: 150px;">
  <div class="ui active inverted dimmer" >
    <div class="ui huge text loader">Obteniendo datos del servidor...</div>
  </div>
  
</div>
`;


function cambioIconoAcordeon(drop){
  let elementoclickeado = drop
  if($(`#${elementoclickeado}`).hasClass("fa-plus") ){
    $(`#${elementoclickeado}`).removeClass('fa-plus')
    $(`#${elementoclickeado}`).addClass('fa-minus')
  }else{
    $(`#${elementoclickeado}`).removeClass('fa-minus')
    $(`#${elementoclickeado}`).addClass('fa-plus')
  }
 
}


function consultaVentasDia(){
    let datosSend = 'queHacer=mostrarVentasDia'
    $.ajax({
      url: 'consultas.php',
      type: 'POST',
      data: `${datosSend}`,
      success: function(req){
        $("#resultadoVentas").html(req)

      }, error: function(error){
        muestreerror(`Algo salio mal: ${error}`,'Upps! Algo No Esta Bien')
      }

    })
}






function autocoo(){
  var key = $("#search").val();		
  var dataString = 'queHacer=Marcas&key='+key;

  $.ajax({
      type: "POST",
      url: "consultas.php",
      data: dataString,

      success: function(data) {
      
        var items = JSON.parse(data);
        $("#search").autocomplete({
            source: items
        });
      }
  });
}


function autoCompletar(quienInvoco,ordenBackend){
    
    let idElemento = quienInvoco.id
    let valorAEnviar = quienInvoco.value
		
  var dataString = `${ordenBackend}&key=${valorAEnviar}`
 switch (idElemento) {
   case 'search':
    var aa = document.getElementById("search");
    if(aa.type === 'text'){
      $.ajax({
        type: "POST",
        url: "consultas.php",
        data: dataString,
  
        success: function(data) {
        
          var items = JSON.parse(data);
         if(!items.error){
          $(`#${idElemento}`).autocomplete({
            source: items
        });
         }
        }
    });
    }else{

    }

     break;
   case 'modelocelclaro':
     let marcaCC = $("#marcacelclaro").val();
     if(marcaCC.length > 1){
      $.ajax({
        type: "POST",
        url: "consultas.php",
        data: `MarcaCel=${marcaCC}&${dataString}`,
  
        success: function(data) {
        
          var items = JSON.parse(data);
         if(!items.error){
          $(`#${idElemento}`).autocomplete({
            source: items
        });
         }
        }
    });
     }else{
      $.ajax({
        type: "POST",
        url: "consultas.php",
        data: dataString,
  
        success: function(data) {
        
          var items = JSON.parse(data);
         if(!items.error){
          $(`#${idElemento}`).autocomplete({
            source: items
        });
         }
        }
    });
     }
    
     break;
 
   default:
    $.ajax({
      type: "POST",
      url: "consultas.php",
      data: dataString,

      success: function(data) {
    
        var items = JSON.parse(data);
       if(!items.error){
        $(`#${idElemento}`).autocomplete({
          source: items
      });
       }
      }
  });
     break;
 }
  
}

function v(){
  $('#suggestions').fadeOut(1000)

}



function detectaKeys(event){
  var keycode = event.keyCode;
  if(keycode == '13'){
    buscarProducto('facturacion',$("#codigoBarrasfactura").val())
    
}
}



function cajaCuadre(){
    
  if($("#desdeCajaStatus").val().length < 10 ){
    muestreerror("La fecha de inicio al parecer no esta completa","Error")
  }else if($("#hastaCajaStatus").val().length < 10 ){
    muestreerror("La fecha final al parecer no esta completa","Error")
}else if($("#desdeCajaStatus").val() > $("#hastaCajaStatus").val()){
  $("#salesdiv").html('<H4 >SIN RESULTADOS.....</H4>')
  muestreerror("La fecha desde es menor a la fecha final.","¡Uppps!")
}else if($("#store").val()==='.::SELECCIONA::.'){
  muestreerror('Primero seleccione un almacen','Almacen no valido')

  }else{
    $("#salesdiv").html(spinners)
    let datoToSendServer = $("#cajaStatusForm").serialize()
    $.ajax({
      url: 'consultas.php',
      type: 'POST',
      data: `queHacer=cuadreCaja&${datoToSendServer}`,
      success: function(req){
     console.log(datoToSendServer)
        $("#salesdiv").html(req)
      },
      error: function(err){
        muestreerror("Error: Al parecer no hay internet estable","Error De Conexión")
      }
    })
  }

}



function imeisSave(xveses,ximeis){
  
  switch (ximeis) {
    case 1:
      var i = xveses;
     
      Swal.mixin({
        input: 'text',
        inputPlaceholder: 'IMEI 15 DIGITOS',
        confirmButtonText: 'Guardar &rarr;',
        showCancelButton: true,
        progressSteps: [`${xveses-i}`,'2']
      }).queue([
        {
          title: 'Registrar Imei',
          text: `Faltan: ${i} de ${xveses}`
        }
      ]).then((result) => {
        if (result.value) {
          var iccidNuevo = result.value[0];
          var cadenaEnviar = `${formularioSim}&Iccid=${iccidNuevo}&soy=guardaSim`
          addSim(cadenaEnviar);
          actual ++;
      
          if(actual < XVECES){
           
           
            pregunte(XVECES,formularioSim);
          }else{
            actual=0;
            var cantss = $("#cantSim").val()
            operacionExitosa(`${cantss} Simcards insertada(s) correctamente`, "Tarea Terminada")
            $("#insertSim")[0].reset();
      
      
          }
          
        }
        
      }) 
     
      break;
  
    default:
      break;
  }
   
   }
   



function saveDistri(){
  if($("#distriName").val().length < 2){
    $("#distriName").focus();
    muestreerror("Error: El nombre del distribuidor es demaciado corto","Nombre Incorrecto")
  }else if($("#citydist").val().length < 3 ){
    $("#citydist").focus();
    muestreerror("Error: El nombre de la ciudad del distribuidor es demaciado corto","Ciudad Incorrecto")
  }else{
    $("#saveDistIcon").removeClass('fa fa-save')
    $("#saveDistIcon").addClass('spinner-border spinner-border-sm')
    $("#saveDist").prop('disabled', true);
    let namedistt = $("#distriName").val()
    let cityd = $("#citydist").val()
    $.ajax({
      url: 'saveAll.php',
      type: 'POST',
      data: `soy=guardaDistribuidor&Nombre=${namedistt}&Ciudad=${cityd}`,
      success: function(res){
         let respuesta = JSON.parse(res)
         if(!respuesta.error){
           operacionExitosa("Distribuidor Guardado Con Exito. Recuarda: No se vera cargado hasta reiniciar la pagina","Exito")
         }
      },
      error: function(){
        muestreerror("Al parecer estas sin internet y asi no funciono","Error")
      }
    })
  }
}

function saveRepoSimClaro(){
if($("#nombresSim").val().length < 3){
  $("#nombresSim").focus();
  muestreerror("Primero debe de seleccionar un cliente valido","Cliente Invalido")
}else if($("#Numero").val().length <10){
  $("#Numero").focus();
  muestreerror("El numero a recuperar no esta completo","Numero No Invalido")
}else if($("#Simcard").val().length < 17 ){
  $("#Simcard").focus();
  muestreerror("La Nueva simcard esta incompleta","Nueva Sim < 17")
}else if($("#valSimRepo").val() < 2380){
  $("#valSimRepo").focus();
  muestreerror("La nueva simcar debe ser cobrada por un valor superiro al costo","Nueva Sim < 2380")
}else if($("#PlanSimRepo").val() === '.::SELECCIONA::.'){
  $("#PlanSimRepo").focus();
  muestreerror("Primero seleccione si la simcard era prepago o postpago","Plan Invalido")
}else{
  $("#nombresSim").prop('disabled', false);
  $("#apellidosSim").prop('disabled', false);
  $("#saverep").removeClass('fa fa-save')
  $("#saverep").addClass('spinner-border spinner-border-sm')
  $("#saveRepoSim").prop('disabled', true);
  let datosend = $("#insertrepoSim").serialize()
  $.ajax({
    url: 'saveAll.php',
    type: 'POST',
    data: `soy=SaveRepoSim&${datosend}`,
    success: function(res){
       let respuesta = JSON.parse(res)
       if(!respuesta.error){
        $("#insertrepoSim")[0].reset()
        $("#saverep").removeClass('spinner-border spinner-border-sm')
        $("#saverep").addClass('fa fa-save')
        $("#saveRepoSim").prop('disabled', false);
        $("#nombresSim").prop('disabled', true);
        $("#apellidosSim").prop('disabled', true);
          operacionExitosa("Tarea completada con exito","Exito")
       }
    },
    error: function(req){
      muestreerror(`Errror: ${req}, Esto se debe a falta de internet`,"Error")
    }
  })
}
}

function searchCode(invocacion){
let invo = invocacion
switch (invo.id) {
  case 'buscarCodeNavBar':
   
      let Codeproduct = $("#searchcodena").val()
      $.ajax({
        url: 'Search.php',
        type: 'POST',
        data: `soy=searchCodeNavBar&Codigo=${Codeproduct}`,
        success: function(res){
              $("#resultado").html(res)
        },
        error: function(req){
          muestreerror(req,"Error")
        }
      })
    break;

  default:
    break;
}
}


function mostrarProductos(quieninvoca){
  let invocacion = quieninvoca
    if(invocacion.id === 'showProduct'){
      
     $.ajax({
       url: 'Search.php',
       type: 'POST',
       data: `soy=caragaTodoDisponible`,
       success: function(res){
        
       $("#resProduct").html(res)
       },
       error: function(req){
            
       }
     })
    }else{
      alert("EEEEEE")
    }
}

function guardaFactura(factura,ClienteFactura,documentoc,tottal){
   $.ajax({
     url: 'Vender.php',
     type: 'POST',
     data: `soy=guardaFactura&Factura=${factura}&Cliente=${ClienteFactura}&Documento=${documentoc}&Valor=${tottal}`,
     success: function(res){
        let respuesta = JSON.parse(res);
        if(!respuesta.error){
            operacionExitosa("Factura Gaurdada Con Exito","Todo Ok")
            $("#ventaProductos")[0].reset;
            obtenerFacturacion();
            consultaVentasDia();

        }else{
          muestreerror(respuesta.error,"Error")
        }
     },error: function(req){

     }
   })
}




 function guardaGasto(){
  
  if($("#descripcionGasto").val().length < 4){
    muestreerror("La descripcion es demasiado corta","DEscripción No Valida")
  }else if($("#valorGasto").val().length < 3){
    muestreerror("El valor es demasiado corto","Valor Invalido")
  }else{
    $("#savega").removeClass('fas fa-save')
    $("#savega").addClass('spinner-border spinner-border-sm')
    let dataSend = $("#newGastoForm").serialize()
    $.ajax({
      url: 'saveAll.php',
      type: 'POST',
      data: `soy=guardaGastos&${dataSend}`,
      success: function(res){
      
        let respuesta = JSON.parse(res)
       
        if(!respuesta.error){
          $("#savega").removeClass('spinner-border spinner-border-sm')
          $("#savega").addClass('fas fa-save')
          operacionExitosa("Gasto guardado correctamente","Exito")
            $("#newGastoForm")[0].reset();
        }else{
          $("#savega").removeClass('spinner-border spinner-border-sm')
          $("#savega").addClass('fas fa-save')
          muestreerror("Algo salio mal al intentar guardar el Gasto","Error")
        }
      },
      error: function(err){
        muestreerror(err,"Error")
      }
    })
  }
 }



function generarEtiquetas(){
  if($("#desdeEtiqueta").val().length < 10 ){
     muestreerror("La fecha de inicio esta incompleta.","Fecha Incompleta")
  }else if($("#hastaEtiquetas").val().length < 10){
    muestreerror("La fecha Hasta esta incompleta.","Fecha Incompleta")
  }else if($("#hastaEtiquetas").val() < $("#desdeEtiqueta").val()){
    muestreerror("La fecha desde es mayor a la fecha hasta.","Fechas erroneas")
  }else{
    let formmm = $("#newFileEtiquetasExcel").serialize();
  
    $.ajax({
      url: 'Search.php',
      type: 'POST',
      data: `soy=generarEtiquetas&${formmm}`,
      success: function(res){
        let respuesta = JSON.parse(res)
          if(!respuesta.error){
           
            operacionExitosa("Archivo generado con exito","Ok")

            window.open(`/etiquetas.php?${formmm}`);
          }else{
            muestreerror("No hay registros para las fechas seleccionadas","NO Hay Registros")
          }
      },error: function(req){
            muestreerror(req,"Error")
      }
    })
  }
}


function obtenerCodigoNewProduct(){
    
    $.ajax({
      url: 'Search.php',
      type: 'POST',
      data: `soy=obtenCodigoProductos`,
      success: function(res){
          let respuesta = JSON.parse(res);
          if(!respuesta.error){

              $("#codigoProduct").val(respuesta.CodigoP);
          }else{
            muestreerror("No se pudo obtener el Código para asignar","¡Uppss!");

          }
      }

    })

}

function reimprimirFacs (factura){
  abrirpopupImprimeFactura(`/recibo.php?tipo=imprimeReciboImpuesto&numero=${factura}`,300,600);
}


function buscarFactura(boton){
 
  var idboton = boton.id;
  $(`#${idboton}`).addClass('spinner-border spinner-border-sm')
  switch (idboton) {
    case 'buscarFechaFac':
      let fechaa = $("#dateRePrint").val()
      if(fechaa.length < 10){
        $("#elementosFactur").html(`<div class="text-center"><div id="elementosFacture"><h4>No Hay Facturas Encontradas....</h4></div> </div>`)
        $(`#${idboton}`).removeClass('spinner-border spinner-border-sm')
        muestreerror("La fecha esta incompleta","Fecha No Valida")
      }else{
        $("#elementosFactur").html(spinners)
        $.ajax({
          url: 'Search.php',
          type: 'POST',
          data: `soy=buscarFacturasPorfech&Fecha=${fechaa}`,
          success: function(res){ 
             $("#elementosFactur").html(res)
             $(`#${idboton}`).removeClass('spinner-border spinner-border-sm')
         
          }
        })
      }
    break;

    case 'searchdocFacturaImprimir':
       let documento = $("#docReimprimir").val();
       if(documento.length < 6 ){
        $("#elementosFactur").html(`<div class="text-center"><div id="elementosFacture"><h4>No Hay Facturas Encontradas....</h4></div> </div>`)
        $(`#${idboton}`).removeClass('spinner-border spinner-border-sm')
        muestreerror("El Documento debe contener al menos 1 caracter","Documento Incompleto");   
       }else{
        $("#elementosFactur").html(spinners)
           $.ajax({
             url: 'Search.php',
             type: 'POST',
             data: `soy=buscarFacturasPorDoc&Documento=${documento}`,
             success: function(res){ 
              
               
                $("#elementosFactur").html(res)
                $(`#${idboton}`).removeClass('spinner-border spinner-border-sm')
            
             }
           })
       }
    break;
     case 'searchFacturaImprimir':
      
     let factura = $("#facturarReimprimir").val();
     if(factura.length < 3){
      $(`#${idboton}`).removeClass('spinner-border spinner-border-sm')
       muestreerror("La factura debe contener al menos 4 caracteres","Factura incompleta");
     }else{
       $.ajax({
         url: 'Search.php',
         type: 'POST',
         data: `soy=buscoFacturasReimprimir&Factura=${factura}`,
         success: function(res){
          let respu = JSON.parse(res);
          if(!respu.error){
            $(`#${idboton}`).removeClass('spinner-border spinner-border-sm')
              abrirpopupImprimeFactura(`/recibo.php?tipo=imprimeReciboImpuesto&numero=${factura}`,300,600);
          }else{
            $(`#${idboton}`).removeClass('spinner-border spinner-border-sm')
            muestreerror("La factura no existe","No encontrada");
          }

         }
       })
     }

      
      break;
  
    default:
      break;
  }
}


function BuscarImeiClaro(){
  if($("#imei").val().length >14){
    let dataform = $("#imei").val();
    $.ajax({
          url:'Search.php',
          type:'POST',
          data: `soy=buscoImeiClaro&imei=${dataform}`,
          datatype: 'text',
          success: function(respuesta) {
          var obj = respuesta;
           var equipo= JSON.parse(respuesta)
         
            if (!equipo.error) {
              $("#equipo").val(equipo[0].Marca + " " + equipo[0].Modelo + " " + equipo[0].Color);
              $("#incremento").val(equipo[0].Incremento);
              $("#idequipo").val(equipo[0].Id);
              $("#proveedorEquipoAVender").val(equipo[0].Distribuidor);
              
       }else{
           muestreerror(`No se pudo acceder a la información del equipo con imei: ${$("#imei").val()}, Puede ser que este ya este vendido anteriormente o a que este simplemente no este en el inventario`,"Imei No Valido");
    }
           }
          }
      );
      
  } else{
    muestreerror("Dejaste el campo imei incompleto","Campo vacio");
  }
}  




   function aMoneda(elemento){
     var idAconvertir = elemento;
     $(`#${idAconvertir.id}`).attr('type','text');
     var valorEnMoneda = convierteAPeso.format(idAconvertir.value);
     $(`#${idAconvertir.id}`).val(valorEnMoneda);

   }

  



function ocultarmodalbyclass(modal,funcionAqueSigue,datoParaSeguir){
  window.$(`.${modal}`).modal('hide');
   switch (funcionAqueSigue){
     case "CrearClientesExpress":
      setTimeout(GuardaClienteExpress(datoParaSeguir),2000);
   }
}

function GuardaClienteExpress(documento){
 
  Swal.mixin({
    input: 'text',
    
    confirmButtonText: 'Continuar &rarr;',
    showCancelButton: true,
    progressSteps: ['1', '2', '3']
  }).queue([
    {
      inputValue: `${documento}`,
      title: 'Agregar Cliente',
      text: 'Confirmar Documento'
    },
    'Nombres',
    'Apellidos'
  ]).then((result) => {
    if (result.value) {
      
      var nombreC = result.value[1];
     var apellidoC = result.value[2];
   
      $.ajax({
          url: 'insertClientClaro.php',
          type: 'POST',
          data: `soy=2&documento=${documento}&nombres=${nombreC}&apellidos=${apellidoC}`,
          success: function(response){
              let respuestaxpress = JSON.parse(response);
              if(!respuestaxpress.error){
                buscaClienteFactura(documento);
                $("#codigoBarrasfactura").prop('disabled', false);
               
                window.$(".facturacion").modal('show');
              setTimeout(() => {
                $("#codigoBarrasfactura").focus();
              }, 1000);



              }
          }




      })
    }
  })
}

function buscaClienteFactura(documento){
 
  $("#iconCliente").removeClass("fa fa-user");
  $("#iconCliente").addClass("spinner-border spinner-border-sm");
   $.ajax({
       url: 'Search.php',
       type: 'POST',
       data:`soy=buscoClienteFacturacion&documentoequi=${documento}`,
       success: function(respuestacliente){
       
        var obj = JSON.parse(respuestacliente);

        if (!obj.error) {
          $("#iconCliente").addClass("fa fa-user");
          $("#iconCliente").removeClass("spinner-border spinner-border-sm");
          let respuestaServer = JSON.parse(respuestacliente);
          var nombres = respuestaServer[0].Nombres;
          var apellidos = respuestaServer[0].Apellidos;
          $("#nombreclientefac").val(`${nombres} ${apellidos}`);
          $("#codigoBarrasfactura").prop('disabled', false);
          $("#codigoBarrasfactura").focus();
          }else{
            $("#iconCliente").addClass("fa fa-user");
            $("#iconCliente").removeClass("spinner-border spinner-border-sm");
           muestreerror(`El cliente ${documento} No existe`,"Cliente NO Encontrado");
           ocultarmodalbyclass('facturacion','CrearClientesExpress',documento); 
          }

       }
   });


}


function eliminarElementosDeFactura(idventa,unidades,IdElemento){
  Swal.fire({
    title: 'Eliminar Producto',
    text: "¿Estas seguro que deseas eliminar este item de la factura?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminalo!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: 'Vender.php',
        type: 'POST',
        data: `soy=QuitarProductosDeFactura&IdVenta=${idventa}&Unidades=${unidades}&IdProducto=${IdElemento}`,
        success: function(res){
        
        let respuesta = JSON.parse(res);
        if(!respuesta.error){
          Swal.fire(
            'Eliminado!',
            'El producto se elimino correctamente.',
            'success'
          )
          obtenerFacturacion();
        }else{
          Swal.fire(
            'Upps!',
            'El producto no se pudo eliminar correctamente.',
            'error'
          )
        }
        }
      })
     
    }
  })

}

function cargarProductosPrefacturados(factura){
  $.ajax({
    url: 'consultas.php',
    type: 'POST',
    data: `queHacer=listarProductosFactura&factura=${factura}`,
    success: function(res){
        $("#elementosFactura").html(res);
    }
  })
}

function obtenerValorTotalFactura(numeroFactura){
 
  $.ajax({
     url: 'consultas.php',
     type: 'POST',
     data: `queHacer=obtenerTotalFactura&factura=${numeroFactura}`,
     success: function(res){
         let resp = JSON.parse(res);
         console.log(resp)
         $("#totalFac").val(resp[0].Total);
         $("#totalfacCobrar").html(convierteAPeso.format(resp[0].Total));
      
         if(resp[0].Total > 0){
             cargarProductosPrefacturados(numeroFactura);
         } else{
          $("#elementosFactura").html(`<h4>No Hay Productos Agregados....</h4>`);
         }
     }

})
}


function obtenerFacturacion(){
  $.ajax({
    url: 'Vender.php',
    type: 'POST',
    data: `soy=ObtenerFacturacion`,
    success: function(res){
      var Factura = JSON.parse(res);
      var nuevoNumero =  parseInt(Factura[0].NumeroActual)
      nuevoNumero ++;
      $("#numFac").html(nuevoNumero);
      $("#numeroParaFactura").val(nuevoNumero);
       obtenerValorTotalFactura(nuevoNumero);

    },
    error: function(error){
     setTimeout(() => {
       
      muestreerror("Esto fue lo que ocurrio: No se pudo conectar al servidor.","Error Obteniendo Facturación");
      window.$("#facturacion").modal('hide');
     }, 2000);
    }
  })
}


function venderProductos(){
 
  var valorProduc = document.getElementById("valorproducto");
  quiteMonedaParaEditar (valorProduc);
  var cantVende = parseInt($("#cantidadfactura").val());
  var cantdispo = parseInt($("#cantdisponibles").val());
  var quedan = cantdispo - cantVende;
  var datoform = $("#ventaProductos").serialize();
  var datoVender = `soy=vendeProductos&${datoform}&quedan=${quedan}`;
  $("#elementosFactura").html(spinners);
  $.ajax({
    url: 'Vender.php',
    type: 'POST',
    data: datoVender,
    success: function(res){
     
    $("#elementosFactura").html(res);
    $("#btn-add-pro-fac").removeClass('spinner-border spinner-border-sm');
    $("#valorproducto").val('');
    $("#valorproducto").attr('disabled', true);
    $("#cantidadfactura").attr('disabled', true);
    $("#cantidadfactura").val('');
    $("#nombreclientefac").attr('disabled', true);
    $("#descripcionfac").val('');
    $("#descripcionfac").attr('disabled', true);
    $("#codigoBarrasfactura").val('');
    obtenerValorTotalFactura($("#numeroParaFactura").val());
    

    }
  })
 
}


function validaUnidadesAVender(){
  var cantVende = parseInt($("#cantidadfactura").val());
  var cantdispo = parseInt($("#cantdisponibles").val());
 
  if( cantVende > cantdispo){
    $("#cantidadfactura").val("");
    muestreerror("La cantidad que intentas vender es superior a la cantidad disponible","Cantidad No Disponible");
  }else{
    var valorProduct = parseInt($("#valPro").val());
    $("#valorproducto").attr('disabled', false);
    var nuevoTotal = valorProduct * cantVende;
    $("#valorproducto").val(convierteAPeso.format(nuevoTotal));
  }
}

function operacionExitosa(mensaje,titulo){
  Swal.fire({
    icon: 'success',
    title: `${titulo}`,
    text: `${mensaje}`,
    showClass: {
      popup: 'animated rollIn faster'
    },
    hideClass: {
      popup: 'animated rollOut faster'
    },

    timerProgressBar: true,
    timer: 3000
  })
}

function verificarCampos(paraQuien){
  switch(paraQuien){
    case 'guardarProductos':
      
       if($("#tipoProduct").val().length < 3){
        $("#tipoProduct").focus();
           muestreerror("El campo tipo debe contener almenos 3 caracteres","Tipo Incompleto");
        }else if($("#marcaProduct").val().length < 3 ){
          $("#marcaProduct").focus();
         muestreerror("La marca esta incompleta","Marca incompleta");
       }else if($("#modeloProduct").val().length < 2 ){
        $("#modeloProduct").focus();
           muestreerror("Modelo incompleto","Modelo incompleto");
       }else if($("#proveedorProduct").val() === '.::SELECCIONA::.'){
        $("#proveedorProduct").focus();
           muestreerror("Primero selecciona un proveedor","Proveedor no seleccionado");
       }else if($("#costoProduct").val().length < 3){
        $("#costoProduct").focus();
           muestreerror("El costo debe tener almenos 3 carcteres","Costo incompleto");
       }else if($("#valorProduct").val().length < 4){
        $("#valorProduct").focus();
           muestreerror("El valor es demaciado corto debe tener almenos 4 caracteres","Valor incompleto");
       }else if($("#unidProduct").val().length < 1 | $("#unidProduct").val() < 1){
        $("#unidProduct").focus();
           muestreerror("Unidades no validas, Las unidadades deben ser diferentes a 0 y vacio","Unidades no validas");
       }else{ 
        $("#codigoProduct").attr('disabled', false);
         let newProductForm = $("#newProduct").serialize();
         $.ajax({
          url: 'saveAll.php',
          type: 'POST',
          data: `soy=nuevoProducto&${newProductForm}`,
          success: function(res){
            $("#codigoProduct").attr('disabled', false);
              let respuesta = JSON.parse(res);
              if(!respuesta.error){
                $("#codigoProduct").attr('disabled', true);
                operacionExitosa("Producto agregado correctamente","Guardado");
                $("#newProduct")[0].reset();
                obtenerCodigoNewProduct();
              }else{
                muestreerror("Algo no salio bien","Error");
              }
          }, error: function(req){
            $("#codigoProduct").attr('disabled', true);
            muestreerror(req,"Error");
          }
         })
        }

    break;

    case 'validarCamposParaAgregarProductosAFactura':
      $("#btn-addpro").attr("disabled", true)
      $("#btn-add-pro-fac").addClass("spinner-border spinner-border-sm");
      if($("#cantidadfactura").val() < 1){
        $("#btn-addpro").attr("disabled", false)
        $("#btn-add-pro-fac").removeClass("spinner-border spinner-border-sm");
        muestreerror("Unidades No Validas","Unidades No Validas");
      }else{
        $("#btn-addpro").attr("disabled", true)
       
        var cantVende = parseInt($("#cantidadfactura").val());
        var cantdispo = parseInt($("#cantdisponibles").val());
        if( cantVende <= cantdispo){
          $("#nombreclientefac").attr("disabled", false);
          $("#descripcionfac").attr("disabled", false);
   
          $("#valorproducto").attr("disabled", false)
          venderProductos();
        }
      }

    break;
  }
}

function buscarProducto(buscarPara,codigoABuscar){
  const QUIEN_INVOCO_FUNCION = buscarPara;
  const Codigo = codigoABuscar;
  switch (QUIEN_INVOCO_FUNCION){
    case 'facturacion':
      $("#iconProducto").removeClass("fa fa-user");
      $("#iconProducto").addClass("spinner-border spinner-border-sm");
        $.ajax({
          url: 'Search.php',
          type: 'POST',
          data: `soy=barrasFacturacion&Codigo=${Codigo}`,
          success: function(res){
            let producto = JSON.parse(res);
            if(!producto.error){
                if(producto[0].Estado ==='VENDIDO'){
                  $("#iconProducto").addClass("fa fa-user");
                  $("#iconProducto").removeClass("spinner-border spinner-border-sm");
                  muestreerror("Este producto se encuentra en estado VENDIDO por lo tanto no se puede agregar",`${producto[0].Tipo} ${producto[0].Marca} ${producto[0].Modelo} ${producto[0].Color}`)
                  $("#codigoBarrasfactura").val('');
                }else{
                  $("#iconProducto").addClass("fa fa-user");
                  $("#iconProducto").removeClass("spinner-border spinner-border-sm");
                  $("#descripcionfac").val(`${producto[0].Tipo} ${producto[0].Marca} ${producto[0].Modelo} ${producto[0].Color}`);
                  $("#valorproducto").val('0');
                  $("#valorproducto").attr('type', 'text');
                  $("#valorproducto").val(convierteAPeso.format(`${producto[0].Valor}`));
                  $("#dispopro").val(`${producto[0].Unidades}`);
                  $("#tipoPro").val(`${producto[0].Tipo}`);
                  $("#cantidadfactura").prop('disabled', false);
                  $("#garantia").val(`${producto[0].Garantia}`);
                  $("#cantidadfactura").focus();
                  $("#barras2").val(`${producto[0].Codigo2}`);
                  $("#cantdisponibles").val(`${producto[0].Unidades}`);
                  $("#idProductoAVender").val(`${producto[0].Id}`);
                  $("#valPro").val(`${producto[0].Valor}`);
                  $("#costo").val(`${producto[0].Costo}`);
                  $("#btn-addpro").prop('disabled', false);
                  $("#cantidadfactura").focus();
                }

            } else{
              $("#iconProducto").addClass("fa fa-user");
              $("#iconProducto").removeClass("spinner-border spinner-border-sm");
              muestreerror("Producto no encontrado","Sin Resultados")
            }
          }
        })
    break;
  }
}


function resetFieldsVentaClaroFin(){
  $("#camposVentaCelFin").html(`  <div class="ui form">
  <form class="needs-validation" method="POST" id="vendeFinClaro" name="vendeFinClaro">
      <div class="three fields">
          <div class="field">
              <label>*Documento</label>
              <div class="ui left icon input">
                  <input type="number" onfocusout="noHayCliente();" class="form-control"
                      id="documentoequi" name="documentoequi" placeholder="DOCUMENTO"
                      aria-describedby="inputGroupPrepend" maxlength="10" required
                      onkeyup="BuscarCliente();">
                  <i class="id card icon"></i>
              </div>
          </div>
          <div class="field">
              <label>*Nombres</label>
              <div class="ui left icon input">
                  <input type="text" class="form-control" id="nomclifi" name="nomclifi"
                      placeholder="NOMBRES" disabled>
                  <i class="user icon"></i>
              </div>
          </div>
          <div class="field">
              <label>*Apellidos</label>
              <div class="ui left icon input">
                  <input type="text" style="text-transform: uppercase;"
                      style="text-transform: uppercase;" class="form-control" id="apeclifi"
                      name="apeclifi" placeholder="Apellidos" disabled>
                  <i class="user icon"></i>
              </div>
          </div>
      </div>
      <div class="three fields">
          <div class="field">
              <label>*Imei</label>
              <div class="ui left icon input">
                  <input name="imei" style="text-transform: uppercase;" class="form-control" id="imei"
                      aria-describedby="inputGroupPrepend" placeholder="IMEI" required
                      onfocusout="BuscarImeiClaro();"
                      oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                      type="number" maxlength="15">
                  <i class="barcode icon"></i>
              </div>
          </div>
          <div class="field">
              <label>*Equipo </label>
              <div class="ui left icon input">
                  <input type="text" name="equipo" style="text-transform: uppercase;"
                      class="form-control" id="equipo" aria-describedby="inputGroupPrepend"
                      placeholder="EQUIPO A VENDER" disabled required>
                  <i class="mobile icon"></i>
              </div>
          </div>
          <div class="field">
              <label>*Cuota Inicial</label>
              <div class="ui left icon input">
                  <input type="number" class="form-control" id="incuota" name="incuota"
                      placeholder="CUOTA INICIAL" aria-describedby="inputGroupPrepend" required
                      onfocusout="convierteMoneda(this);" value="0"
                      onfocus="quiteMonedaParaEditar(this);">
                  <i class="dollar sign icon"></i>
              </div>
          </div>
      </div>
      <div class="three fields">
          <div class="field">
              <label>*Valor Cuota Mensual</label>
              <div class="ui left icon input">
                  <input type="number" class="form-control" id="valcuota" name="valcuota"
                      style="text-transform: uppercase;" value="0" placeholder="VALOR CUOTA"
                      aria-describedby="inputGroupPrepend" onfocusout="convierteMoneda(this);"
                      required onfocus="quiteMonedaParaEditar(this);">
                  <i class="dollar sign icon"></i>
              </div>
          </div>
          <div class="field">
              <label>*Total Cuotas</label>
              <div class="ui left icon input">
                  <input type="number" class="form-control" id="tcuotas" name="tcuotas"
                      style="text-transform: uppercase;" placeholder="TOTAL CUOTAS"
                      aria-describedby="inputGroupPrepend" required>
                  <i class="list icon"></i>

              </div>
              <input type="hidden" id="proveedorEquipoAVender" name="proveedorEquipoAVender">
          </div>
          <div class="field">
              <label>*Simcard</label>
              <div class="ui left icon input">
                  <input type="number" value="0" class="form-control" id="simcard" name="simcard"
                      style="text-transform: uppercase;" placeholder="SERIAL DE SIMCARD"
                      aria-describedby="inputGroupPrepend" required
                      oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                      type="number" maxlength="17">
                  <i class="icon" style="top: 32%; "><i class="fas fa-sim-card"></i></i>

              </div>
          </div>
      </div>
      <div class="three fields">
          <div class="field">
              <label>*Incremento</label>
              <div class="ui left icon input">
                  <input type="number" value="0" class="form-control" id="incremento"
                      name="incremento" style="text-transform: uppercase;" placeholder="INCREMENTO"
                      aria-describedby="inputGroupPrepend" onfocusout="convierteMoneda(this);"
                      required onfocus="quiteMonedaParaEditar(this);">
                  <i class="dollar sign icon"></i>
              </div>
          </div>
          <div class="field">
              <label>*Valor Sim</label>
              <div class="ui left icon input">
                  <input type="number" class="form-control" id="valsim" name="valsim"
                      style="text-transform: uppercase;" placeholder="VALOR SIM"
                      aria-describedby="inputGroupPrepend" onfocusout="convierteMoneda(this);"
                      required onfocus="quiteMonedaParaEditar(this);" value="0">
                  <i class="dollar sign icon"></i>
              </div>
          </div>
          <div class="field">
              <label>*Plan</label>
              <div class="ui left icon input">
                  <select name="tipoDocumento" id="tipoDocumento" class="form-control">
                      <option>.::SELECCIONA::.</option>
                      <option>PREPAGO</option>
                      <option>REPOSICION</option>
                      <option>PLAN Y EQUIPO</option>

                  </select>
              </div>
          </div>
      </div>
      <div class="three fields">
          <div class="field">
              <em>* Campos Obligatorios</em>
          </div>
          <div class="field">

          </div>
          <div class="field">
              <label>Total A Cobrar</label>
              <div class="ui left icon input">
                  <input tipe="number" value="0" class="form-control" placeholder="Total Cobrado"
                      id="total" name="total" readonly>
                  <i class="dollar icon"></i>
              </div>
              <div id="resultadoventafinanciado" class="container text-center "
                  style="font-size: 1rem;">

                  <input type="hidden" name="idequipo" id="idequipo" />

              </div>
          </div>
      </div>

</div>`)
}



function limpiarModal(){
  setTimeout(despuesDElCierreModal(),1000);
}

function consultaPorDistribuidor(valor){
    if(valor===".::SELECCIONA::."){
      $("#todosLosEquiposResultado").html('');
      //cierreprimer if
    }else if(valor==="TODOS"){
        $("#todosLosEquiposResultado").html(spinners);
        $.ajax({
          url: 'consultas.php',
          type: 'POST',
          data: `queHacer=TodosCelClaroDisp&nameDist=${valor}`,
          success: function(respuestaEquipos){
            $("#todosLosEquiposResultado").html(respuestaEquipos);
            habilitarCloseButton();
          },
          error: function(){
            muestreerror('No se pudo obtener respuesta del servidor.','Sin Respuesta')
          }

        })//end 2doIf
    }else{
      $("#todosLosEquiposResultado").html(spinners);
      $.ajax({
          
      url: 'consultas.php',
      type: 'POST',
      data: `queHacer=TodosCelClaroDispPorDist&nameDist=${valor}`,
      success: function(respuestaEquipos){
        $("#todosLosEquiposResultado").html(respuestaEquipos);
        habilitarCloseButton();
      }
      })
    }
  }

  function habilitarCloseButton (){
    $('.message .close')
  .on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  })
  }

function despuesDElCierreModal(){
 $("#todosLosEquiposResultado").html(spinners);
}


function mostrarEquiposDisponibles(){
    $.ajax({
    url: 'EquiposDisponibles.php',
    type: 'POST',
    data: `soy=equiposdispinibles`,
    success: function(response){
       $("#todosLosEquiposResultado").html(response);
   },
    error: function(errorT){
        alert(errorT);
    }
});

}

function consultarDeudaDistribuidor(){
    if($("#distribuidorcuadre").val() === ".::SELECCIONA::."){
        muestreerror("Distribuidor no seleccionado","Distribuidor no valido");
    }else if($("#desdecuadredist").val() === ""){
        muestreerror("La fecha desde debe ser diligenciada en su totalidad.","¡Uppps!")
    }else if($("#hastacuadredist").val() === ""){
      muestreerror("La fecha hasta debe ser diligenciada en su totalidad.","¡Uppps!")
    }else if($("#hastacuadredist").val() < $("#desdecuadredist").val()){

      muestreerror("La fecha desde es menor a la fecha final.","¡Uppps!")
    }else{
      document.getElementById("esperaConsultaDistribuidor").src = "img/loader.gif";
      let distri = $("#distribuidorcuadre").val();
      let desdefecha = $("#desdecuadredist").val();
      let hastafecha = $("#hastacuadredist").val();
      $.ajax({
        
        url:'cuadredist.php',
        type:'POST',
        data: `desde=${desdefecha}&hasta=${hastafecha}&distribuidor=${distri}`,
        success: function(response) {
          console.log(response)
       var mensaje = JSON.parse(response);
       var desd = desdefecha;
       desd = moment().format("DD-MM-YYYY");
       var Hast = hastafecha;
       Hast = moment().format("DD-MM-YYYY");
       var valor = convierteAPeso.format(mensaje[0].Total);
       valor.replace(/[-.+$()\s]/g, '');
       document.getElementById("esperaConsultaDistribuidor").src = "";
       muestreInfo(`El monto adeudado desde: ${desd} Hasta: ${Hast} es de: ${valor}`,distri);
         
        
        }
    });
    }

}


function muestreInfo(Mensaje,titulo){
  Swal.fire({
    
    title: 'Deuda a distribuidores',
    text: Mensaje,
    imageUrl: `img/${titulo}.jfif`,
    imageWidth: 200,
    imageHeight: 100,
    imageAlt: `  Logo ${titulo}, no encontrado`

  })
}


function validaSim(quienValida,simcardSerial) {
let tipoValidacion = quienValida;
let distribuidords = $("#proveedorEquipoAVender").val();
let simcardAValidar = simcardSerial;
if(simcardAValidar.length < 17){
    muestreerror("El serial de la simcard debe tener 17 digitos","Serial Sim Incorrecto");
}else{
  switch (tipoValidacion){
    
    case 'EquiposFinanciados':
      $.ajax({
        url:'validaciones.php',
        type:'POST',
        data: `soy=simcardEquiposFinanciados&Iccid=${simcardSerial}&Proveedor=${distribuidords}`,
        success: function(response) {
          var respuestaSim = JSON.parse(response);
          if (!respuestaSim.error) {
              let distribuidorSim = respuestaSim[0].Distribuidor;
              let tipoSimValidada = respuestaSim[0].Tipo;
              let vencesimcard = respuestaSim[0].Vence;
              var fechaactual = moment().format("YYYY-MM-DD");
             
              if(distribuidorSim === distribuidords){
                  if(tipoSimValidada === "POSTPAGO"){
                      
                  }else{
                      muestreerror("La simcard no es POSTPAGO, Use una simcard POSTPAGO valida.","Tipo de simcard invalido");
                  }    
                  $("#simcard").val('');
                  muestreerror("La simcard NO existe por lo tanto no se puede usar con este equipo.","SIM NO VALIDA")
               
              }else{
                $("#simcard").val('');
                muestreerror("La simcard existe pero es de un distribuidor direrente al distribuidor del equipo","Distribuidor Errado")
             
              }
              
          }else{
            $("#simcard").val('');
            muestreerror("La simcard NO existe por lo tanto no se puede usar con este equipo.","SIM NO VALIDA")
         
          }
         

          
            
        }
    });    
        break;
    case '':  
        
        }
   

}
}




function validarCamposVacios(formularioAValidar){

let formulario = formularioAValidar.id;
switch(formulario){
case "vendeIMP":
  if ($("#docimpu").val().length < 6 ){
    document.getElementById('docimpu').focus();
    muestreerror("El campo: Documento esta más vacio de lo esperado.","Documento Incompleto");
  }else if ($("#nomcliimp").val().length < 3 ) {
    document.getElementById('nomcliimp').focus();
    muestreerror("El campo: Nombre esta más vacio de lo esperado.","Campo vacio");
  
  }
break;
    case "saveSim":
  
      if($("#distribuidorSim").val() === ".::SELECCIONA::." ){
          muestreerror("El Selector: Distribuidor, no tiene una selección valida.","Distribuido desconocido"); 
      }else if($("#tipoSim").val() === ".::SELECCIONA::."){
        muestreerror("El Selector: Tipo, no tiene una selección valida.","Tipo desconocido"); 
      }else if ($("#costoSimD").val().length <3){
        muestreerror("El campo: Costo es mas corto de lo esperado","Costo Invalido");
      }else if($("#valSimC").val().length < 4 ){
        muestreerror("El Campo Valor Sim No es valido o es mas corto de lo esperado","Valor Invalido");
      }else if($("#SimVence").val() === ""){
        muestreerror("La fecha de vencimiento esta incompleta.","Fecha Vence Invalida");
      }else if($("#cantSim").val() <="0" ){
        muestreerror("Unidades no validas para el campo: Cantidad.","Cantidad no valida");
      }else{
        var veces = $("#cantSim").val();
        var formularioNuevaSim = $("#insertSim").serialize();
        preguntarSerialDesim(veces,formularioNuevaSim);
      }

break;

}
 
}



var actual = 0;
function preguntarSerialDesim(veces,formularioSim){
  window.$("#nuevaSim").modal('hide');
    
    actual=0;
    setTimeout(pregunte(veces,formularioSim),100);
}
 
function pregunte(XVECES,formularioSim){
  
 Swal.mixin({
  input: 'text',
  inputPlaceholder: 'ICCID 17 DIGITOS',
  confirmButtonText: 'Guardar &rarr;',
  showCancelButton: true,
  progressSteps: [`${XVECES-actual}`]
}).queue([
  {
    title: 'Iccid',
    text: `Faltan: ${XVECES-actual} de ${XVECES}`
  }
]).then((result) => {
  if (result.value) {
    var iccidNuevo = result.value[0];
    var cadenaEnviar = `${formularioSim}&Iccid=${iccidNuevo}&soy=guardaSim`
    addSim(cadenaEnviar);
    actual ++;

    if(actual < XVECES){
     
     
      pregunte(XVECES,formularioSim);
    }else{
      actual=0;
      var cantss = $("#cantSim").val()
     operacionExitosa(`${cantss} Simcards insertada(s) correctamente`, "Tarea Terminada")
      $("#insertSim")[0].reset();


    }
    
  }
  
})
 
}

function addSim(datos){
  let datoGuardar = datos;
  $.ajax({
    url: 'saveAll.php',
    type: 'POST',
    data: datoGuardar,
    success: function(respuestaSaveSim){
        var respuesta = JSON.parse(respuestaSaveSim);
        if(respuesta.duplicado){
           muestreerror("La simcard ya fue ingresada con anterioridad","Iccid Duplicado");
        }else if(!respuesta.error) {
        
        }else{
          muestreerror("Fue imposible guardar la Simcard","Fallo de red");
        }

    }

})



}




function validaSiHayProductosAfacturar(boton){
  let invoco = boton

  let factura = $("#numeroParaFactura").val();
    if($("#totalFac").val() > 0){
      $("#nombreclientefac").attr('disabled', false);
      var ClienteFactura = $("#nombreclientefac").val();
      var documentoc = $("#docclientefactura").val();
      var tottal = $("#totalFac").val();
      if(invoco.id === 'saveFactura'){
         guardaFactura(factura,ClienteFactura,documentoc,tottal);
      }else{
        formalizarFactura(factura,ClienteFactura,documentoc,tottal);
      }
      
    }else{
      muestreerror(`No se pudo recuperar productos para facturar.`,"Sin Productos...");
    }
}

function formalizarFactura(factura,cliente,documento,valorTotal){
    $.ajax ({
        url: 'Vender.php',
        type: 'POST',
        data: `soy=formalizaFactura&Factura=${factura}&Cliente=${cliente}&Documento=${documento}&Valor=${valorTotal}`,
                 success: function(res){
          var respuesta= JSON.parse(res);
          if(!respuesta.error){

              abrirpopupImprimeFactura(`/recibo.php?tipo=imprimeReciboImpuesto&numero=${factura}`,300,600);
              $("#ventaProductos")[0].reset;
              obtenerFacturacion();
              consultaVentasDia();

            }else{
            muestreerror("Algo salio mal, no pude formalizar la factura. Intentalo de nuevo.","¡Oppss!")
          }
        }


    })
}

function abrirpopupImprimeFactura(url,ancho,alto){
    
    //Ajustar horizontalmente
    var x=(screen.width/2)-(ancho/2);
    //Ajustar verticalmente
    var y=(screen.height/2)-(alto/2);
    window.open(url, 'Imprimir Factura', 'resizable=false, width=' + ancho + ', height=' + alto + ', left=' + x + ', top=' + y +'');
}

//Enviamos a la función la url, el ancho y el alto de la ventana
 function variosCel(colorCelLibre,formularioCelLibre,imeis,cantidadCels){   
  
  if(imeis === 2){
    window.$('#nuevoCelularLibre').modal('hide');
    Swal.mixin({
        input: 'text',
        inputPlaceholder: 'Ingrese Aqui',
        
        confirmButtonText: 'Siguiente &rarr;',
        showCancelButton: true,
        progressSteps: ['1', '2','3']
      }).queue([
        {
          title: 'Color',
          inputValue: `${colorCelLibre}`
        },
        'Imei 1',
        'Imei 2'
      ]).then((result) => {
        if (result.value) {
          var primerImei = result.value[1];
          var sdoImei = result.value[2];
          var colorRReal = result.value[0];
        validaImie(primerImei,sdoImei,`${formularioCelLibre}&DobleSim=SI&ImeiUno=${primerImei}&ImeiDos=${sdoImei}&colorReal=${colorRReal}`,cantidadCels);
    
      }
      })
  }else{
    window.$('#nuevoCelularLibre').modal('hide');
    Swal.mixin({
        input: 'text',
        inputPlaceholder: 'Ingrese Aqui',
        
        confirmButtonText: 'Siguiente &rarr;',
        showCancelButton: true,
        progressSteps: ['1', '2']
      }).queue([
        {
          title: 'Color',
          inputValue: `${colorCelLibre}`
        },
        'Imei'
      ]).then((result) => {
        if (result.value) {
          var primerImei = result.value[1];
          var colorReal = result.value[0];
        validaImie(primerImei,'N',`${formularioCelLibre}&DobleSim=NO&ImeiUno=${primerImei}&colorReal=${result.value[0]}&ColorReal=${colorReal}`,cantidadCels);
      
      }
      })
  }

    
  }
 



function validaImie(primerImei,sdoImei,datosguardar,faltan){

    if(sdoImei === 'N'){
      $.ajax({
        url: 'evitaDuplicados.php',
        type: 'POST',
        data: `soy=ingresoCelsLibresSingleSIm&ImeiUno=${primerImei}&${datosguardar}`,
        success: function(respuestaValidaImei){
          var respuestaDuplicado= JSON.parse(respuestaValidaImei);
          if(!respuestaDuplicado.duplicado){
            if(!respuestaDuplicado.error){
              operacionExitosa("Celular Agregado con exito","Exito")
              if(faltan > 0){
                  
              }
            }else{
              muestreerror("El Celular no se pudo guardar.","Algo salio mal");
            }
          
          }else{
            muestreerror("El Celular ya existe.","Algo salio mal");
                 
          }
        }
      })
    }else{

  $.ajax({
    url: 'evitaDuplicados.php',
    type: 'POST',
    data: `soy=ingresoCelsLibres&ImeiUno=${primerImei}&ImeiDos=${sdoImei}&${datosguardar}`,
    success: function(respuestaValidaImei){
      var respuestaDuplicado= JSON.parse(respuestaValidaImei);
      if(!respuestaDuplicado.duplicado){
        if(!respuestaDuplicado.error){
        operacionExitosa("Celular Agregado con exito","Exito")
         if(faltan > 0){
                  
              }
        }else{
          
          muestreerror("El Celular no se pudo guardar.","Algo salio mal");
        }
      
      }else{
        muestreerror("El Celular ya existe.","Algo salio mal");

      }
    }
  });
}
return function(){
  alert('Completados')
}
}




function updateTimeUpdatedLastCardClaro(timeActual){
tiempoQueHaPasadoTranscurridoClaro ++
$("#footer-card-claro").html(`<small class="text-muted">Actualizado hace: ${timeActual} minutos.</small>
<a calss="btn" href="#" onclick="consultaValorEquiposClaroDia();"><i class="fas fa-sync-alt"></i></a>`)
}

function addImeisLibre(){
    if($("#marcaLibre").val().length < 2){
        document.getElementById('marcaLibre').focus();
        muestreerror("La marca debe de contener almenos dos caracteres","Marca Incompleta")   
    }else if($("#modeloLibre").val().length < 2){
       document.getElementById('modeloLibre').focus(); 
       muestreerror("El modelo debe de contener almenos dos caracteres","Modelo Incompleto")   
    }else if($("#colorLibre").val().length < 4){
      document.getElementById('colorLibre').focus(); 
      muestreerror("El color debe de contener almenos cuatro caracteres","Color Incompleto")  
    }else if($("#proveedorLibre").val() === '.::SELECCIONA::.'){
      document.getElementById('proveedorLibre').focus(); 
      muestreerror("El proveedor no esta seleccionado","Proveedor No Seleccionado")   
    }else if($("#costoLibre").val().length < 4 | $("#costoLibre").val() < 10000 ){
      document.getElementById('costoLibre').focus(); 
      muestreerror("El costo debe tener como minimo 4 caracteres ","Costo Incompleto")   
    }else if($("#valorLibre").val().length < 4 | $("#valorLibre").val() < 10000){
      document.getElementById('valorLibre').focus(); 
      muestreerror("El valor debe tener como minimo 4 caracteres ","Valor Incompleto")   
    }else if($("#cantLibre").val() < 1 ){
      document.getElementById('cantLibre').focus(); 
      muestreerror("Las unidades deben de ser superiores a 0","Unidades No validas")   
    }else if($("#garantialibre").val().length < 2 ){
      document.getElementById('garantialibre').focus(); 
      muestreerror("La grarantia debe ser superior a 0","Garantia No valida")   
    } else{
      
        if($("#doblesim").is(':checked')){
          var ColorIm = $("#colorLibre").val().toUpperCase();
          var datoGuardar = $("#nuevoCelLibre").serialize();
          let imeisCant = 2;
          let canttt = $("#cantLibre").val()
          setTimeout(variosCel(ColorIm,datoGuardar,imeisCant,canttt),300); 
        }else{
          var ColorIm = $("#colorLibre").val().toUpperCase();
          var datoGuardar = $("#nuevoCelLibre").serialize();
          let imeisCant2 = 1;
          let canttt2 = $("#cantLibre").val()
          setTimeout(variosCel(ColorIm,datoGuardar,imeisCant2,canttt2),300);
        }
    }
 
  
  }

  

  var tiempoQueHaPasadoTranscurridoClaro = 0;


function consultaValorEquiposClaroDia(){

  tiempoQueHaPasadoTranscurridoClaro = 0;
  updateTimeUpdatedLastCardClaro(-1)
  $.ajax({
    url: 'consultas.php',
    type: 'POST',
    data: `queHacer=consultarValorCelClaroDia`,
    success: function(respuestaValores){
    
      $('#resultadoClaro').html(respuestaValores);
    }
  });

}


function validaCamposIngresaCelClaro(){
  if($("#marcacelclaro").val().length < 2 ){
    document.getElementById('marcacelclaro').focus();
    muestreerror("La marca es más corta de lo que se esperaba.","Marca Vacia");
  }else if($("#modelocelclaro").val().length < 2){
    document.getElementById('modelocelclaro').focus();
    muestreerror("El Modelo es más corto de lo que se esperaba.","Modelo malo");
  }else if($("#colorcelclaro").val().length < 4){
    document.getElementById('colorcelclaro').focus();
    muestreerror("El Color es más corto de lo que se esperaba.","Color errado");
  }else if ($("#imeiNuevoCelClaro").val().length < 15){
    document.getElementById('imeiNuevoCelClaro').focus();
    muestreerror("El Imei es más corto de lo que se esperaba.","Imei Error");
  }else if($("#incrementocel").val().length < 5){
    document.getElementById('incrementocel').focus();
    muestreerror("El Incremento es más corto de lo que se esperaba.","Incremento con anomalias");
  } else if($("#distribuidor").val().length < 7){
    document.getElementById('distribuidor').focus();
    muestreerror("El Distribuidor es más corto de lo que se esperaba.","Distribuidor");
  }else{
    guardarNuevoCelClaro();
  }
 
}

function guardarNuevoCelClaro(){
  let dataform =$('#insertcelClaroform').serialize(); 
  document.getElementById("esperaCelGuardar").src = "img/loader.gif";
 $("#saveCelClaro").prop('disabled', true);

  $.ajax({
  url:'insertClientClaro.php',
  type:'POST',
  data:`soy=3&${dataform}`,
  success: function(respuestaIngresoCel){

var respuestacel= JSON.parse(respuestaIngresoCel);
  ValidarespuestaNuevoCelClaro(respuestacel);
  }
  
  });
}




function BuscarCliente() {
     
  let dataform =$('#vendeFinClaro').serialize();
    
      $.ajax({
        url:'Search.php',
        type:'POST',
        data: `soy=buscoClienteFacturacion&${dataform}`,
        datatype: 'json',
        success: function(response) {
             var obj = response;

          if (obj == "[]") {
          }else{
            
     var cliente = JSON.parse(response);
      $("#nomclifi").val(cliente[0].Nombres);
      $("#apeclifi").val(cliente[0].Apellidos);
           
        }
        }
        }
      
    );
      }

function ValidarespuestaNuevoCelClaro(respuestacelv){

  if(!respuestacelv.error){
    
      Swal.fire({
          icon: 'success',
      position: 'center',
      title: 'Celular Guardado',
      text: 'El celular se guardo con exito',
      showConfirmButton: false,
      timer: 3000
      });
      document.getElementById("esperaCelGuardar").src = "";
     
      $("#insertcelClaroform")[0].reset();
      
     $("#saveCelClaro").prop('disabled', false);
      
  }else{
    muestreerror("No se pudo Guardar el Celular","Algo salio mal");
  }

}

function ValidaSiClienteExiste(invocoacion){
  let para = invocoacion.id
  switch (para) {
    case 'documentoSim':
      let documen = $("#documentoSim").val()
      $.ajax({
        url: 'Search.php',
        type: 'POST',
        data: `soy=ClienteParaRepoSim&documentoSIm=${documen}`,
        success: function(res){
         let respuesta = JSON.parse(res)
         if(!respuesta.error){
             $("#nombresSim").val(respuesta[0].Nombres)
             $("#apellidosSim").val(respuesta[0].Apellidos)
         }else{
           muestreerror("Cliente no existe","Error")
         }
        },
        error: function(req){
          muestreerror(`Error: ${req}, esto se debe a falta de internet`,"Error")
        }

      })
      break;
  
    default:
      var docy = $('#documento').val();
 
var soy = 1;
  $.ajax({
  url:'insertClientClaro.php',
  type:'POST',
  data:{soy: soy, documento: docy},
  success: function(respuestacliente){
   siExisteError(respuestacliente);
  }
  
  });
  
  
      break;
  }

 
  }
  
  function siExisteError(respuestacliente){
    var ServerResponse = JSON.parse(respuestacliente);
    if(!ServerResponse.error){
  
  }else{
    var doc = $("#documento").val();
    $("#documento").focus();
     
    muestreerror(`Ya esiste un cliente con el documento: ${doc}, Por lo tanto no se puede continuar.`,"Cliente Duplicado");
    document.getElementById("documento").value = '';
  
  }

  }

  function noHayCliente(){

    if ($("#nomclifi").val().length < 3 ){
      var docu = $("#documentoequi").val();
      window.parent.document.getElementById('documento').Value = docu;
     
      window.$('#ingEquiFinanciClaro').modal('hide');
      
 
      window.$('#nuevoclienteclaro').modal('show');
      $("#nombres").focus();
    
 
    
    }
   
  }

function validaCamposClienteClaro(){
  if ($("#documento").val().length < 6 ){
    document.getElementById('documento').focus();
     muestreerror("El Número de documento es más corto de lo que se esperaba.","CC Error");
  }else if($("#nombres").val().length < 3 ){
    document.getElementById('nombres').focus();
    muestreerror("El nombre es más corto de lo que se esperaba.","Nombre Error");
  }else if($("#apellidos").val().length < 4 ){
    document.getElementById('apellidos').focus();
    muestreerror("El apellido es más corto de lo que se esperaba.","Apellido Error");
  }else if($("#tel").val().length < 10 ){
    document.getElementById('tel').focus();
    muestreerror("El Número de Télefono es más corto de lo que se esperaba.","Telefono");
  }else if($("#LugarNac").val().length < 4){
    document.getElementById('LugarNac').focus();
    muestreerror("El Lugar de nacimiento es más corto de lo que se esperaba.","Lugar");
  }else if($("#LugarExp").val().length < 4){
    document.getElementById('LugarExp').focus();
    muestreerror("El Lugar de expedición es más corto de lo que se esperaba.","Lugar");
  }else if($("#direccion").val().length < 5){
    document.getElementById('direccion').focus();
    muestreerror("El campo dirección es más corto de lo que se esperaba.","Direccion");
  }else{
    guardaClienteClaro();
  }
 
}

  function guardaClienteClaro(){
       
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
    
    }
      
  

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
window.$("#nuevoclienteclaro").modal('hide');

}

function quiteMonedaParaEditar (b){
     
  var dato= b.value;
      dato=dato.replace(/[-.+$()\s]/g, ''); 
      
       var  campo = b;
       campo.value=dato;
       campo.type="number";
     
  }

  function muestreok (){
    Swal.fire({
        icon: 'success',
   position: 'center',
   title: 'Todo ok',
   text: 'Venta Realizada Con Exito',
   
   showConfirmButton: false,
   timer: 4000
 });
    
    
 }
     
 function validaResultadoVenta(respuestaVentaFinan){
    
  var responseVenta = JSON.parse(respuestaVentaFinan);
 if(!responseVenta.error){
     
    muestreok();
  resetFieldsVentaClaroFin()
          document.getElementById("mi_imagen").src = "";
            document.getElementById('vendeequipo').val='Vender Ahora';
          $("#vendeequipo").prop('disabled', false);
     
     
 } else{
    muestreerror("¡Upps! houston tenemos un problema","Error");
 }
 


}
 
function venderCelularFinanciadoClaro(){
  var inicial = document.getElementById("incuota");
  quiteMonedaParaEditar (inicial);

  var incre = document.getElementById("incremento");
  quiteMonedaParaEditar (incre);
  var valorsim = document.getElementById("valsim");
  quiteMonedaParaEditar (valorsim);
  
 var total = document.getElementById("total");
  quiteMonedaParaEditar (total);
   $("#equipo").prop('disabled', false);
  
 $("#apeclifi").prop('disabled', false);
   $("#nomclifi").prop('disabled', false);
 document.getElementById("mi_imagen").src = "img/loader.gif";
   document.getElementById('vendeequipo').val='Un momento, por favor...';
 $("#vendeequipo").prop('disabled', true);
           
let dataform =$('#vendeFinClaro').serialize();
$.ajax({
url:'venderFinClaro.php',
type:'POST',
data: dataform,
datatype: 'json',
success: function(response) {
validaResultadoVenta(response);
}
}
);


}

function validaCamposFinanciado(){
  var titulo="Campos Vacios";
if ($("#nomclifi").val().length < 3 ){
 document.getElementById('documentoequi').focus();
  muestreerror("No hay un cliente seleccionado, seleccione un cliente e intentelo de nuevo",titulo);

} else if($("#equipo").val().length < 3) {
   document.getElementById('imei').focus();
    muestreerror("No hay un Celular seleccionado, seleccione un celular e intentelo de nuevo",titulo);
  
  
}else if ($("#incuota").val().length < 1) {
   document.getElementById('incuota').focus();
  muestreerror("El campo Cuota Inicial Esta vacio.",titulo);
  
} else if ($("#valcuota").val().length < 5) {
   document.getElementById('valcuota').focus();
  muestreerror("El valor de la Cuota parece estar vacio.",titulo);
  
} else if ($("#tcuotas").val().length < 1 ) {
   document.getElementById('tcuotas').focus();
  muestreerror("El campo Total Cuotas esta vacio",titulo);
  
}else if ($("#simcard").val().length < 17 ){
   document.getElementById('simcard').focus();
  muestreerror("El serial de la simcard no esta completo",titulo);
  
}else if ($("#incremento").val().length < 4) {
   document.getElementById('incremento').focus();
  muestreerror("Error: El incremento es muy inferior al esperado",titulo);
} else if ($("#valsim").val().length < 4) {
   document.getElementById('valsim').focus();
  muestreerror("El valor de la sim no es el esperado",titulo);
  
} else if ($("#tipoDocumento").val() == '.::SELECCIONA::.') {
   document.getElementById('tipoDocumento').focus();
  muestreerror("Primero debe de seleccionar un Plan",titulo);
  
} else {
  
venderCelularFinanciadoClaro();
}
  
}


function ConsultaIngresaRef() {
  let dataform = $("#docuref").val();
    $.ajax({
         url:'Search.php',
         type:'POST',
         data: `soy=BuscarEquiposParaAsigRef&documentoequi=${dataform}`,
         success: function(respue) {
         
          var equipo= JSON.parse(respue);
         if(!equipo.error){
            $("#equiporef").val(equipo[0].Equipo);
            $("#clientenombre").val(equipo[0].Cliente);
            $("#imeiref").val(equipo[0].Imei);
            $("#idref").val(equipo[0].Id);
          }else{
             muestreerror(`No se encontraron equipos sin referencia de pago para el documento: ${dataform}`,"Sin Resultados");
    
         }
         
         
         }
         }
     );
     
     
}
     
$('#asignaref').click(function() {
 if ($("#equiporef").val().length < 5) {
     
     $('#resultadoref').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡¡Upps!! No hay un equipo seleccionado para asignar una referencia<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
     
 }  else if ($("#refpago").val().length < 10 ) {
      $('#resultadoref').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡¡Upps!! La referencia de pago no tiene el mínimo de 10 caracteres requerido.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
     
 } else if ($("#diapago").val().length < 11 ) {
      $('#resultadoref').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡¡Upps!! El día de pago debe incluir al menos 11 cararcteres ejemplo: 01 CADA MES.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
     
 } else {
     $("#resultadoref").html('<div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
      let dataform =$('#inserteref').serialize();
     
       $.ajax({
         url:'Vender.php',
         type:'POST',
         data: `soy=AgregaReferencia&${dataform}`,
         
         success: function(res) {
           operacionExitosa("Referencia Asignada Con Exito","Exito")
            

      $("#inserteref")[0].reset();
      
         }
         
         
       });
      
      
      
 }
  
       
     });
     
     



 function resetForm (formulario){
          
 }
       
  function convierteMoneda(campito) {
    var  campo = campito;
    campo.type='text';
    var dato= campito.value; 
    campo.value=convierteAPeso.format(dato);
     var totalcuotainicial = document.getElementById("incuota").value.replace(/[-.+$()\s]/g, '');
   
    var  totalincremento = document.getElementById("incremento").value.replace(/[-.+$()\s]/g, '');
    
     var totalsim = document.getElementById("valsim").value.replace(/[-.+$()\s]/g, '');
     
     var totalsuma =0;
     totalsuma = parseInt(totalcuotainicial) +parseInt(totalincremento) + parseInt(totalsim)
   $("#total").val(convierteAPeso.format(totalsuma) );

 }

function muestreerror (mensaje,titulo){
  Swal.fire({
    icon: 'error',
    title: `${titulo}`,
    text: `${mensaje}`,
    showClass: {
      popup: 'animated rollIn faster'
    },
    hideClass: {
      popup: 'animated rollOut faster'
    },

    timerProgressBar: true,
    timer: 3000
  })
 
}
$('.ui.checkbox')
  .checkbox()
;

consultaValorEquiposClaroDia();
consultaVentasDia();
setInterval(function(){ updateTimeUpdatedLastCardClaro(tiempoQueHaPasadoTranscurridoClaro + 1 );}, 60000);
