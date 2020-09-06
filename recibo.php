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
    if ($tipo=='imprimeReciboImpuesto'){
       
    }
  }
  
  
  $numero = $_GET['numero'];
  date_default_timezone_set('America/Bogota');
  setlocale(LC_TIME,"es_CO");
  $fecha = date('d/m/y g:i:s A');
  $Almacen = $_SESSION['almacen'];
  $Usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura <?php echo $numero; ?></title>
    
  
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
    
    <img class="logo" src="img/logotecnoricel.png"><br>
    <?php
      $sqlCargaCliente = "SELECT * FROM Ventas WHERE Factura='$numero'";
      $resultadosCliente=mysqli_query($conn,$sqlCargaCliente);
      $doccu;
      $clientee;
      $formaPdago;
      $FechaFacC;
      $vendedor;
      while($mostrarcliente=mysqli_fetch_array($resultadosCliente)){
          $clientee= $mostrarcliente['Cliente'];
          $doccu = $mostrarcliente['Documento'];
          $formaPdago = $mostrarcliente['FormaPago'];
          $FechaFacC = date("d/m/Y", strtotime($mostrarcliente['Fecha']));
          $vendedor = $mostrarcliente['Usuario'];  }
      ?>
    <p><?php echo 'Factura de venta: '. $numero; ?></p>
    <p>Fecha De Facturación</p>
    <p> <?php echo $FechaFacC; ?></p>
    <p>Fecha Y Hora De Impresión</p>
    <p> <?php echo $fecha ?></p>
    <p><?php echo $dirEmpre; ?></p>
    <p><?php echo 'DUVAN GAVIRIA'; ?></p>
    <p><?php echo 'Nit: '. '1151437852-4'; ?></p>
    <p><?php echo 'NO RESPONSABLE DEL IVA' ?></p>
   
    <p>Vendedor: <?php echo $vendedor; ?></p>
    <P>---------------------------------------</P>
    <P><b>Información del cliente</b></P>
    <P>---------------------------------------</P>
   
    <p><?php echo 'Nombre: '. $clientee;?></p>
    <p><?php echo 'Documento: '. $doccu; ?></p>
    <p><?php echo 'Forma de pago: '. $formaPdago; ?></p>
    <P>---------------------------------------</P>
    <P><b>Descripción</b></P>
    <P>---------------------------------------</P>
    <?php
        $sqlCargaElementosFactura = "SELECT * FROM Ventas WHERE Factura='$numero'";
        $total = 0;
        $totalProductos = 0;
        $resultadosFactura=mysqli_query($conn,$sqlCargaElementosFactura);
        while($mostrar=mysqli_fetch_array($resultadosFactura)){
            $total = $total + $mostrar['Valor'];
            $totalProductos = $totalProductos + $mostrar['Cantidad'];
    ?>
    <p><?php echo 'Cant.: '. $mostrar['Cantidad']. ' '. $mostrar['Descripcion']; ?></p>
    <P><?php echo 'Serial(es): '. $mostrar['Codigo']. ' - ' .$mostrar['Codigo2'];?> </P>
    <P><?php echo 'Valor: <b>'. money_format("%.0n", $mostrar['Valor']).'</b>'; ?></P>
    <p><?php echo 'Garantía: '. $mostrar['Garantia']. ' Dia(s).';?></p>
    <P><?php echo '---------------------------------------';}?></P>
   
</div>
<div id="id_transaccion">
    <p>Totales:</p>
    <p><?php echo $totalProductos. ' Producto(s).'; ?> </p>
    <p><?php echo 'Total a pagar: <b>'. money_format("%.0n", $total);?> </p>
            </div>        
    




<div id="id_transaccion">
   
<p>Factura de venta con efectos legales, artículo No. 774 del Código de Comercio. y se expide según la ley 1231 del 17 de Junio de 2008. NOTA: NO SE DEVUELVE DINERO UNA VEZ USADO ESTE PRODUCTO.</p>

  
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