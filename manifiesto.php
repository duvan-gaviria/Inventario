<?php
session_start();
setlocale(LC_MONETARY,"es_CO");
include ('DataBaseConection.php');
date_default_timezone_set('America/Bogota');
$telEmpre = $_SESSION['telefonoempresa'];
$dirEmpre = $_SESSION['direccionempresa'];
$Empresa = $_SESSION['bodega'];
if (!isset($_SESSION['username'])) {
    header('location: login');
  } else {
    $tipo = $_GET['tipo'];
    if ($tipo=='imprimeManifiesto'){
       
    }
  }
  
  
  date_default_timezone_set('America/Bogota');
  setlocale(LC_TIME,"es_CO");
  $fecha = date('d/m/y g:i:s A');
 
  $Usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Generador Manifiestos</title>
    <link rel="stylesheet" href="css/recibos.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet"/>
</head>


<body onload="fn_print();">
    <div id="container"> 
    <div class="div_boton_finish">
    <a id="print" onclick="fn_print();" class="waves-effect waves-light btn" style="display: block;"><h1><i class="fas fa-print"></i> Imprimir</h1>

</a>
</div>
    <div id="header">
    
    <img class="logo" src="img/LOGOinter.png" width="200px"><br>
   
    <p>Relación de envios y pruebas de entrega</p>
    <p>Fecha De Envio</p>
    <p> <?php echo $FechaFacC; ?></p>
    <p>Fecha Y Hora De Impresión</p>
    <p> <?php echo $fecha ?></p>
    <p><?php echo 'Creado por: DUVAN GAVIRIA'; ?></p>
    <p> Agencia: ANORI / 3874</p>
    <P>---------------------------------------</P>
    <P><b>Listado Envios</b></P>
    <P>---------------------------------------</P>
    <?php
        $sqlEnvios = "SELECT * FROM GuiasRecepToSend WHERE Estado = 'EN BODEGA'";
         $resultEnvios = mysqli_query($conn,$sqlEnvios);
         $NumEnvios = $resultEnvios ->num_rows;
         while($mostrar0=mysqli_fetch_array($resultEnvios)){
            echo '<p> '.$mostrar0['Guia'].'</p>'; }
            ?>    

    <P>---------------------------------------</P>
    <P><b>Pruebas De Entrega</b></P>
    <P>---------------------------------------</P>
  
    <?php
         $sqlCargaPRUEBASdEeNTREGA = "SELECT * FROM Interrapidisimo WHERE PruebaDeEntrega='SIN ENVIAR' AND Estado='ENTREGADO'";
         $resultadosCliente=mysqli_query($conn,$sqlCargaPRUEBASdEeNTREGA);
       
        
        $totalProductos = $resultadosCliente ->num_rows ;
    
        while($mostrar=mysqli_fetch_array($resultadosCliente)){
           
             echo '<p> '.$mostrar['Guia'].'</p>'; }
    ?>    

</div>
<div id="id_transaccion">
    <p>Totales:</p>
    <p><?php echo $totalProductos. ' Pruebas(s) De Entrega.'; ?> </p>
    <p><?php echo 'Total a pagar: <b>'. money_format("%.0n", $total);?> </p>
     </div>        
    

<div id="id_transaccion">

  
</div>

    <div class="div_boton_finish">
<a id="print_second" onclick="fn_print();" class="waves-effect waves-light btn" style="display: block;" > <h1><i class="fas fa-print"></i> Imprimir</h1>
</div>
</div>


    <script>
 
        function fn_print() {
            document.getElementById("print").style.display = 'none'
            document.getElementById("print_second").style.display = 'none'
    
           window.print();
    
            window.onmouseover = function() {
                document.getElementById("print").style.display = 'block';
                document.getElementById("print_second").style.display = 'block';
            }
        }
    </script>
</body>
</html>

