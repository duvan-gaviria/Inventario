<?php
session_start();
include ('DataBaseConection.php');
setlocale(LC_MONETARY, 'es_CO');
date_default_timezone_set('America/Bogota');
$fechaActual = date('Y-m-d');
$Empresa = $_SESSION['bodega'];
$queHago = $_POST['queHacer'];
$almacen = $_SESSION['almacen'];
$rolUser = $_SESSION['rol'];
$valtotalEqui = 0;
$valRepoSim =0;
$valreposimSinformat=0;
$valTotalPlanes =0;
$equiposClaro =0;
$totalEquiposClaro=0;
$Repo = 0;
switch ($queHago) {
    case 'entregarEnvio':
        $idenv = $_POST['idEnvio'];
        $GUIAA = $_POST['guia'];
        $valGuia = $_POST['valor'];
        $sqlEntregaEnvio = "UPDATE Interrapidisimo SET Entregado = '$fechaActual', Estado = 'ENTREGADO' WHERE Id ='$idenv'";
        $sqlEsAlCobro = "SELECT COUNT(*) FROM Interrapidisimo WHERE Id='$idenv' AND TipoPago = 'AL COBRO'";
        $resulCobro = mysqli_query($conn,$sqlEsAlCobro);
        $rqCobro = $resulCobro->num_rows;
        if($conn->query($sqlEntregaEnvio) === TRUE) {
          switch ($rqCobro) {
              case 0:
                mysqli_close($conn);
                $conn->close(); 
                echo json_encode(array('error' => FALSE));
                  break;
              default:
                  $sqlCajaint2 = "INSERT INTO CajaInter (Tipo, Descripcion, Fecha, Valor) VALUES ('AL COBRO','RECAUDO AL COBRO GUIA: $GUIAA','$fechaActual','$valGuia')";
                  if($conn->query($sqlCajaint2) === TRUE){
                    mysqli_close($conn);
                    $conn->close(); 
                    echo json_encode(array('error' => FALSE));
                  }
              break;
            
          }
        }else{
            mysqli_close($conn);
            $conn->close(); 
            echo json_encode(array('error' => true));
        }
    break;

    case 'manifiestoGeneraConsulta':
        $sqlConsultaPruebasDeEntrega ="SELECT * FROM Interrapidisimo WHERE Estado='ENTREGADO' AND PruebaDeEntrega='SIN ENVIAR'";
        $sqlConsultaEnvios = "SELECT * FROM GuiasRecepToSend WHERE Estado ='EN BODEGA'";
        $resultPruebasEntrega = mysqli_query($conn,$sqlConsultaPruebasDeEntrega);
        $resultEnvios = mysqli_query($conn,$sqlConsultaEnvios);
        $total_Pruebas_Entrega = $resultPruebasEntrega->num_rows;
        $totalEnvios = $resultEnvios->num_rows;
        ?>
<table class=" ui small green selectable celled table center aligned segment  " style="width: 100%;">
    <thead class="thead-dark">
        <tr class="text-center w-25 h-25 ">
            <th scope="col" class="text-center">Envios Pendientes</th>
            <th scope="col" class="text-center">Pruebas De Entrega </th>
            <th scope="col" class="text-center">Acciones </th>
        </tr>
    </thead>
    <tbody>
        <tr class="text-center">
            <td> <?php echo $totalEnvios; ?></td>
            <td> <?php echo $total_Pruebas_Entrega; ?></td>
            <?php 
                if($totalEnvios >0 || $total_Pruebas_Entrega >0){?>
            <td><button class="ui green compact icon button" onclick="generaManifiesto();"><i class="check icon"></i></button></td> <?php
                }else{?>
            <td><button class="ui red compact icon button" onclick="muestreerror('No se puede realizar la operación debido a que no hay guias para preocesar','Sin guias');"><i class="close icon"></i></button></td>
            <?php
                }
            ?>
        </tr>
    </tbody>
</table>

<?php 
         mysqli_close($conn);
        $conn->close();

    break;
    case 'listaEnviosBodega':
        $sqlEnviosAllBodega = "SELECT * FROM Interrapidisimo WHERE Estado='EN BODEGA'";
        $enviosR = mysqli_query($conn,$sqlEnviosAllBodega);
        $NumRes = $enviosR->num_rows;
                    
?>

<div class="ui small positive message">
    <i class="close icon"></i>
    <div class="header">
        Resultados
    </div>
    <p><?php echo "(". $NumRes.") Envios diosponibles para entregar. " ?></p>
</div>
<table class=" ui small green selectable celled table center aligned segment  " style="width: 100%;">
    <thead class="thead-dark">
        <tr class="text-center w-25 h-25 ">
            <th scope="col" class="text-center">Guia</th>
            <th scope="col" class="text-center">Destinatario </th>
            <th scope="col" class="text-center">Forma De Pago </th>
            <th scope="col" class="text-center">Valor </th>
            <th scope="col" class="text-center">Acciones</th>
        </tr>
    </thead>
    <?php 
while($mostr=mysqli_fetch_array($enviosR)){
?>
    <tbody>
        <tr class="text-center">
            <td> <?php echo $mostr['Guia']; ?></td>
            <td> <?php echo $mostr['Cliente']; ?></td>
            <td><?php echo $mostr['TipoPago']; ?></td>
            <td><?php echo  money_format("%.0n", $mostr['Valor']); ?></td>
            <td>

                <button class="ui compact icon green button"
                    onclick="entregarEnvios('<?php echo $mostr['Id']; ?>','<?php echo $mostr['Guia'];?>','<?php echo $mostr['Valor']; ?>')"><i
                        class="handshake icon"></i></button>

            </td>
        </tr>
        <?php  }
         mysqli_close($conn);
        $conn->close();
        ?>
    </tbody>
</table>
<?php

    break;

    case 'cuadreCaja':
      $tienda =  $_POST['store'];
      $desde = $_POST['desdeCajaStatus'];
      $hasta = $_POST['hastaCajaStatus'];
      $sqlCajaStatusValor = "SELECT SUM(Valor) AS 'Total' FROM Ventas WHERE Fecha BETWEEN '$desde' AND '$hasta' AND Almacen = '$tienda' AND Empresa = '$Empresa' AND Estado='FORMALIZADA' ";
      $sqlCajaStatusCosto = "SELECT SUM(Costo) AS 'Total' FROM Ventas WHERE Fecha BETWEEN '$desde' AND '$hasta' AND Almacen = '$tienda' AND Empresa = '$Empresa' AND Estado='FORMALIZADA' ";
      $resultValor = mysqli_query($conn,$sqlCajaStatusValor);
      $resultCosto = mysqli_query($conn,$sqlCajaStatusCosto);
      $totalCostos = 0;
      $TotalVenta = 0;
      ?>
<table class="ui Stackable selectable celled table green center aligned segment">
    <thead>
        <tr>
            <th>Total Ventas</th>
            <th>Total Costos</th>
            <th>Total Gastos</th>
            <th>Total Ganancias</th>
        </tr>
    </thead>
    <?php 
                   while($cajastatus=mysqli_fetch_array($resultValor)){
                       $TotalVenta = $cajastatus['Total'];
                   }
                   while($cajacosto = mysqli_fetch_array($resultCosto)){
                        $totalCostos =  $cajacosto['Total'];
                   }
                 ?>
    <tbody>
        <tr>
            <?php $ganancias = $TotalVenta - $totalCostos; ?>
            <td><?php echo money_format("%.0n",$TotalVenta); ?></td>
            <?php if($rolUser ==='VENDEDOR'){?>
            <td> <?php echo '$ *** *** ***'; ?></td>
            <td><?php echo '0'; ?></td>
            <td> <?php echo '$ *** *** ***'; ?></td>
            <?php }else{?>
            <td> <?php echo money_format("%.0n",$totalCostos); ?></td>
            <td><?php echo '0'; ?></td>
            <td><?php echo  money_format("%.0n",$ganancias); ?></td>
            <?php }?>





            <td><?php echo money_format("%.0n", $cajastatus['Valor']); ?></td>
        </tr>

    </tbody>
</table>
<?php  
        mysqli_close($conn);
        $conn->close();
      echo '<label>' .$cc .'</label>' ;

    break;
    case 'TodosCelClaroDisp':
        $sqlClaroAll ="SELECT *  FROM `CelularesClaro` WHERE Estado = '1' AND Empresa='$Empresa' AND Almacen='$almacen' ORDER BY Vence ASC ";
        $result=mysqli_query($conn,$sqlClaroAll);
        $numero = $result->num_rows;
        $row_cnt =mysqli_affected_rows($conn);
            
?>
<br>
<div class="ui small positive message">
    <i class="close icon"></i>
    <div class="header">
        Resultados
    </div>
    <p><?php echo "(". $row_cnt.") Equipos de: <em>TODOS LOS DISTRIBUIDORES</em>, disponibles bodega: " .$almacen; ?>
    </p>
</div>
<table class=" ui small green selectable celled table center aligned segment  " style="width: 100%;">
    <thead class="thead-dark">
        <tr class="text-center w-25 h-25 ">
            <th scope="col" class="text-center">Información del equipo</th>
            <th scope="col" class="text-center">Cuota Inicial </th>
        </tr>
    </thead>
    <?php 
while($mostrar=mysqli_fetch_array($result)){
?>
    <tbody>
        <tr class="text-center">
            <td class="h-5"> <?php echo  substr($mostrar['Distribuidor'],0,3). " "; ?>
                <?php echo substr($mostrar['Marca'],0,3); ?>
                <?php echo " " .$mostrar['Modelo'] ?><?php echo " ".substr($mostrar['Color'],0,2) ?><?php echo " " .$mostrar['Imei'] ?><?php $fechaVence = date('d/m', strtotime($mostrar['Vence']));  echo " (" .$fechaVence.") "; ?>
            </td>
            <td class="h-5"><?php echo $mostrar['Incremento'] ?></td>
        </tr>
        <?php  }
         mysqli_close($conn);
        $conn->close();
        ?>
    </tbody>
</table>
<?php

    break;
    case 'TodosCelClaroDispPorDist':
        $distName = $_POST['nameDist'];
        $sqlClaroPorDist ="SELECT *  FROM `CelularesClaro` WHERE Estado = '1' AND Empresa='$Empresa' AND Almacen='$almacen' AND Distribuidor = '$distName' ORDER BY Vence ASC ";
        $result=mysqli_query($conn,$sqlClaroPorDist);
        $numero = $result->num_rows;
        $row_cnt =mysqli_affected_rows($conn);
?>
<br>
<div class="ui small positive message">
    <i class="close icon"></i>
    <div class="header">
        Resultados
    </div>
    <p><?php echo "(". $row_cnt.") Equipos de: <em>". $distName. "</em>, disponibles bodega: " .$almacen; ?></p>
</div>

<table class=" ui small green selectable celled table center aligned segment  " style="width: 100%;">

    <thead class="thead-dark">
        <tr class="text-center w-25 h-25 ">
            <th scope="col" class="text-center">Información del equipo</th>
            <th scope="col" class="text-center">Cuota Inicial </th>

        </tr>
    </thead>
    <?php 



while($mostrar=mysqli_fetch_array($result)){
       


?>

    <tbody>
        <tr class="text-center">

            <td class="h-5"> <?php echo  substr($mostrar['Distribuidor'],0,3). " "; ?>
                <?php echo substr($mostrar['Marca'],0,3); ?>
                <?php echo " " .$mostrar['Modelo'] ?><?php echo " ".substr($mostrar['Color'],0,2) ?><?php echo " " .$mostrar['Imei'] ?><?php $fechaVence = date('d/m', strtotime($mostrar['Vence']));  echo " (" .$fechaVence.") "; ?>
            </td>
            <td class="h-5"><?php echo $mostrar['Incremento'] ?></td>


        </tr>




        <?php  }
                                    mysqli_close($conn);
                                   $conn->close();
                                        ?>

    </tbody>

</table>
<?php

    break;

    case 'mostrarCelLibreDia':
        $sqlCelVentaDia = "SELECT * FROM Ventas WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen = '$almacen' AND Empresa='$Empresa' AND Tipo ='CELULAR'";
        $resultVentaEquiDia= mysqli_query($conn,$sqlCelVentaDia);
        if ($resultVentaEquiDia->num_rows > 0){
            ?>
<table class="ui Stackable selectable celled table green center aligned segment">
    <thead>
        <tr>
            <th>Documento</th>
            <th>Cliente</th>
            <th>Equipo</th>
            <th>Factura</th>
            <th>Valor</th>
        </tr>
    </thead>
    <?php 
             while($mostrarcelVentadia=mysqli_fetch_array($resultVentaEquiDia)){
           ?>
    <tbody>
        <tr>
            <td><?php echo $mostrarcelVentadia['Documento']; ?></td>
            <td> <?php echo  $mostrarcelVentadia['Cliente']; ?></td>
            <td><?php echo $mostrarcelVentadia['Descripcion']. '  '. $mostrarcelVentadia['Codigo']; ?></td>
            <td><?php echo  $mostrarcelVentadia['Factura']; ?></td>
            <td><?php echo money_format("%.0n", $mostrarcelVentadia['Valor']); ?></td>
        </tr>
        <?php   } ?>
    </tbody>
</table>
<?php  
        }else{
            echo '<h3> Nada que mostrar por aquí</h3>';
        }
    break;

    case 'mostrarAccesoriosDia':
        $sqlAccesoriosDia = "SELECT * FROM Ventas WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen = '$almacen' AND Empresa='$Empresa' AND Tipo <>'CELULAR'";
        $resultAccesoriosDia = mysqli_query($conn,$sqlAccesoriosDia);
        if($resultAccesoriosDia->num_rows > 0){
        ?>
<table class="ui Stackable selectable celled table green center aligned segment">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Cliente</th>
            <th>Accesorio Y Código</th>
            <th>Factura</th>
            <th>Valor</th>
        </tr>
    </thead>
    <?php 
             while($mostrarAccVentadia=mysqli_fetch_array($resultAccesoriosDia)){
           ?>
    <tbody>
        <tr>
            <td><?php echo $mostrarAccVentadia['Cantidad']; ?></td>
            <td> <?php echo  $mostrarAccVentadia['Cliente']; ?></td>
            <td><?php echo $mostrarAccVentadia['Descripcion']. '  '. $mostrarAccVentadia['Codigo']; ?></td>
            <td><?php echo  $mostrarAccVentadia['Factura']; ?></td>
            <td><?php echo money_format("%.0n", $mostrarAccVentadia['Valor']); ?></td>
        </tr>
        <?php   } ?>
    </tbody>
</table>
<?php  
        }else{
            echo '<h3> Nada que mostrar por aquí</h3>';
        }
    break;


    case 'mostrarVentasDia':
        $ventasCelDia ="SELECT SUM(Valor) AS 'Cel' FROM Ventas WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen='$almacen' AND Empresa='$Empresa' AND Tipo='CELULAR'";
        $resCelDia = mysqli_query($conn,$ventasCelDia);
        $totalCelHoy = 0;
        $totalAccesorios = 0;
        $totalCantAccesorios = 0;
        while($celDia =mysqli_fetch_assoc($resCelDia)){ 
            $totalCelHoy = $celDia['Cel'];
        }
        $sqlAccesoriosTotaldia = "SELECT SUM(Valor) AS 'Accesorios' FROM Ventas WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen='$almacen' AND Empresa='$Empresa' AND Tipo<>'CELULAR' ";
        $resultAcce = mysqli_query($conn,$sqlAccesoriosTotaldia);
        while($valAccesorio = mysqli_fetch_assoc($resultAcce)){
            $totalAccesorios = $valAccesorio['Accesorios'];
        }
        $sqlCantAccesorios = "SELECT COUNT(*) AS 'Cant' FROM Ventas WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen='$almacen' AND Empresa='$Empresa' AND Tipo<>'CELULAR'";
        $resCant = mysqli_query($conn,$sqlCantAccesorios);
        while($cantAcc = mysqli_fetch_assoc($resCant)){
            $totalCantAccesorios = $cantAcc['Cant'];

        }

        $sqlTotalCelDia = "SELECT COUNT(*) AS 'Cant' FROM Ventas WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen='$almacen' AND Empresa = '$Empresa' AND Tipo='CELULAR'";
        $cantCel = 0;
        $resultCelDia = mysqli_query($conn,$sqlTotalCelDia);
        while($reqTotalCelDia = mysqli_fetch_assoc($resultCelDia)){
            $cantCel = $reqTotalCelDia['Cant'];
        }
        $totalVentasDia = $totalAccesorios + $totalCelHoy;


        echo '<tr><td>
        <div class="ui compact mini menu ">
        <a class="item" onclick="openModals(`resultCelDia`); consultaCelDiaLibres();">
           <i class="mobile icon"></i> Equipos <div class="detail">'. money_format("%.0n",$totalCelHoy).'
          <div class="floating ui red label">'.$cantCel.'</div></a></div>
         </td></tr>

         <tr><td>
        <div class="ui compact mini menu ">
        <a class="item" onclick="openModals(`resultAccesoriosDia`); consultaAccesoriosDia(); ">
           <i class="mobile icon"></i> Accesorios <div class="detail">'. money_format("%.0n",$totalAccesorios).'
          <div class="floating ui red label">'.$totalCantAccesorios.'</div></a></div>
         </td></tr>


         
         <tr><td>
        <div class="ui compact mini menu ">
        <a class="item">
           <i class="mobile icon"></i> Total <div class="detail">'. money_format("%.0n",$totalVentasDia).'
         </a></div>
         </td></tr>


         <tr><td>
         <div  id="footer-card-ventas" name="footer-card-ventas">
         Actualizado Justo ahora. <a style="color: blue;"> <i class="fas fa-sync-alt" onclick="consultaVentasDia();"></i></a>
        </div>
         </td></tr>
         
         ';

    break;
    case 'mostrarClaroEquiposDia':
        $sqlEquiposFinanciadosDia = "SELECT * FROM EquiposFinanciados WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen = '$almacen'";
        $resultEquiposDiaClaro= mysqli_query($conn,$sqlEquiposFinanciadosDia);
        if ($resultEquiposDiaClaro->num_rows > 0){
            ?>
<table class="ui unstackable compact selectable striped celled table center aligned segment">
    <thead>
        <tr>
            <th>Documento</th>
            <th>Cliente</th>
            <th>Equipo</th>
            <th> Simcard</th>
            <th>Plan</th>
            <th>Valor</th>

        </tr>
    </thead>
    <?php 
             while($mostrarclarodia=mysqli_fetch_array($resultEquiposDiaClaro)){
           ?>
    <tbody>
        <tr>
            <td><?php echo $mostrarclarodia['Documento']; ?></td>
            <td> <?php echo  $mostrarclarodia['Cliente']; ?></td>
            <td><?php echo $mostrarclarodia['Equipo']. '  '. $mostrarclarodia['Imei']; ?></td>
            <td><?php echo  substr($mostrarclarodia['Iccid'],5,17); ?></td>
            <td><?php echo substr($mostrarclarodia['Plan'],0,4); ?></td>
            <td class="h-5"><?php echo money_format("%.0n", $mostrarclarodia['TotalCobrado']); ?></td>

        </tr>
        <?php   } ?>
    </tbody>
</table>


<?php  



        }else{
            echo '<h4> Nada que mostrar por aquí';
        }
    break;


    case 'autoCompleteMarcaCelClaro':
      
  
        $Dato = strtoupper($_POST['key']);
        $sqlLive = "SELECT DISTINCT * FROM CelularesClaro WHERE Marca LIKE '%$Dato%' AND Empresa='$Empresa' GROUP BY Marca";
        $RESS = mysqli_query($conn,$sqlLive);
        $arrayAutoComplete = array();
        if ($RESS->num_rows > 0) {
            while ($row = $RESS->fetch_assoc()) {                
        array_push($arrayAutoComplete,$row['Marca']);
            }
            echo json_encode($arrayAutoComplete);
            mysqli_close($conn);
            $conn->close();
        }else{
           
            echo json_encode(array('error' => true));
            mysqli_close($conn);
            $conn->close();
        }

       
    break;

    case 'autocompletarSearch':
        $Parametro =strtoupper($_POST['Dato']);
        $typeSearch = $_POST['tipo'];
        if($typeSearch === 'number'){
            $sqlCompleteRefPago = "SELECT DISTINCT * FROM EquiposFinanciados WHERE Documento LIKE '%$Parametro%' GROUP BY Documento ORDER BY Cliente";
            $resultClient = mysqli_query($conn,$sqlCompleteRefPago);
            $arrayResq = array();
            if($resultClient->num_rows >0){
                while ($refid = $resultClient->fetch_assoc()){
                    $arrayResq[]=array('description' => $refid['Cliente'], 'title' => $refid['Documento']);
                }
                echo json_encode($arrayResq);
                mysqli_close($conn);
                $conn->close();
            }else{
                echo json_encode(array());
            mysqli_close($conn);
            $conn->close();
            }
        }else if($typeSearch === 'tel'){
            $sqlAutoCompleteSimcard ="SELECT DISTINCT * FROM Simcards WHERE Iccid LIKE '%$Parametro%' AND Almacen ='$almacen'";
            $resultSimm = mysqli_query($conn,$sqlAutoCompleteSimcard);
            $arraySimm = array();
            if($resultSimm -> num_rows > 0){
                while($simdata=$resultSimm->fetch_assoc()){
                    $arraySimm[]=array('title' => $simdata['Iccid'], 'description' => substr($simdata['Distribuidor'],0,3). ' '.substr($simdata['Tipo'],0,3).' ' . $simdata['Estado'], 'price' => $simdata['Vence']);
                }
                echo json_encode($arraySimm);
                mysqli_close($conn);
                $conn->close();
            }else{
                echo json_encode(array());
                mysqli_close($conn);
                $conn->close(); 
            }

        }else{
            $sqlProductutoComplet ="SELECT DISTINCT * FROM Productos WHERE Codigo LIKE '%$Parametro%' AND Empresa='$Empresa' AND Almacen ='$almacen' AND Estado ='EN BODEGA' OR Codigo LIKE '%$Parametro%' AND Empresa='$Empresa' AND Almacen ='$almacen' AND Estado='EN BODEGA' ORDER BY Id DESC";
            $ResultProdu =mysqli_query($conn,$sqlProductutoComplet);
            $arrayProdu = array();
            if($ResultProdu->num_rows>0){
                while ($reqpro = $ResultProdu->fetch_assoc()){
                    $arrayProdu[]=array('description'=> $reqpro['Tipo']. ' '.$reqpro['Marca'].' '.$reqpro['Modelo'].' '.$reqpro['Color'], 'title' =>$reqpro['Codigo'],'price' =>money_format("%.0n",$reqpro['Valor']));
                }

                echo json_encode($arrayProdu);
                mysqli_close($conn);
                $conn->close();
            }else{
            echo json_encode(array());
            mysqli_close($conn);
            $conn->close();
            }
        }


    break;


    case 'autocompletarPlaca':
        $placa = strtoupper($_POST['Placa']);
        $sqlPlaca="SELECT DISTINCT * FROM ImpuestosVehiculos WHERE Placa LIKE  '%$placa%' AND Empresa='$Empresa' GROUP BY Placa";
        $resultPlaca = mysqli_query($conn,$sqlPlaca);
        $arraySend = array();
        if($resultPlaca->num_rows > 0){
          while ($carid = $resultPlaca->fetch_assoc()){
            $arraySend[]=array('category' => substr($carid['Tipo'],0,4), 'title' => substr($carid['Placa'],0,6), 'description' => $carid['Cliente'] );
          }
          echo json_encode($arraySend);
       
          mysqli_close($conn);
          $conn->close();
        }else{
            echo json_encode(array());
            mysqli_close($conn);
            $conn->close();
        }
     


    break;

    case 'autoCompletarColor':
        $Dato2 = strtoupper($_POST['key']);
        $sqlLive2 = "SELECT DISTINCT * FROM CelularesClaro WHERE Color LIKE '%$Dato2%' AND Empresa='$Empresa' GROUP BY Color";
        $RESS2 = mysqli_query($conn,$sqlLive2);
        $arrayAutoComplete2 = array();
        if ($RESS2->num_rows > 0) {
            while ($row2 = $RESS2->fetch_assoc()) {                
        array_push($arrayAutoComplete2,$row2['Color']);
            }
            echo json_encode($arrayAutoComplete2);
            mysqli_close($conn);
            $conn->close();
        }else{
           
            echo json_encode(array('error' => true));
            mysqli_close($conn);
            $conn->close();
        }

    break;

    
    case 'autoCompleteModeloCelClaro':
        $Dato1 = strtoupper($_POST['key']);
        $sqlLive1 = "";
        $traeMarca = $_POST['MarcaCel'];
        if(strlen($traeMarca) < 2){
          $sqlLive1 = "SELECT Modelo FROM CelularesClaro WHERE Modelo LIKE '%$Dato1%' AND Empresa='$Empresa' GROUP BY Modelo";
        }else{
            $sqlLive1 = "SELECT Modelo FROM CelularesClaro WHERE Modelo LIKE '%$Dato1%' AND Empresa='$Empresa' AND Marca ='$traeMarca' GROUP BY Modelo";
        }
   
       
        $RESS1 = mysqli_query($conn,$sqlLive1);
        $arrayAutoComplete1 = array();
        if ($RESS1->num_rows > 0) {
            while ($row = $RESS1->fetch_assoc()) {                
        array_push($arrayAutoComplete1,$row['Modelo']);
            }
            echo json_encode($arrayAutoComplete1);
            mysqli_close($conn);
            $conn->close();
        }else{
           
            echo json_encode(array('error' => true));
            mysqli_close($conn);
            $conn->close();
        }

       

    break;

    case 'obtenerTotalFactura':
        $factura = $_POST['factura'];
        $arrayTotalFactura = array();
        $sqlTotalFactura = "SELECT SUM(Valor) AS Total FROM Ventas WHERE Factura = '$factura' AND Almacen ='$almacen'";
        $querytf=mysqli_query($conn,$sqlTotalFactura);
        while($resultadotf=mysqli_fetch_array($querytf)){
        $arrayTotalFactura[]=$resultadotf;
     
       //Aca se acaba de conseguir el total para equipos financiados e inicia consulta de reposim
    } 
    mysqli_close($conn);
     $conn->close();
    echo json_encode($arrayTotalFactura);
    break;
   
    case 'listarProductosFactura':
        $factural = $_POST['factura'];
        $sqlListarVentas="SELECT * FROM `Ventas` WHERE Factura = '$factural' ";
        $resultadosVentas=mysqli_query($conn,$sqlListarVentas); ?>

<table class="ui small selectable celled table">
    <thead class="thead-dark">
        <tr class="text-center w-25 h-25 ">
            <th class="text-center" scope="col">Cant.</th>
            <th class="text-center" scope="col">Descripción</th>
            <th class="text-center" scope="col">Valor</th>
            <th class="text-center" scope="col"> Acciones</th>
        </tr>
    </thead>
    <?php 
             while($mostrar=mysqli_fetch_array($resultadosVentas)){
           ?>
    <tbody>
        <tr class="table-light ">

            <td class="h-5"> <?php echo $mostrar['Cantidad']; ?></td>
            <td class="h-5"><?php echo $mostrar['Descripcion']; ?></td>
            <td class="h-5"><?php echo money_format("%.0n", $mostrar['Valor']); ?></td>
            <td class="h-5">
                <button type="button" class="ui red compact icon button"
                    onclick="eliminarElementosDeFactura(this.id,<?php echo $mostrar['Cantidad']; ?>,<?php echo $mostrar['IdProducto']; ?>);"
                    id="<?php echo $mostrar['Id']; ?>"><i class="trash altered icon"></i></button>

            </td>
        </tr>
        <?php   } ?>
    </tbody>
</table>

<?php   

    break;

case 'consultarValorCelClaroDia':
    $sqlTotal = "SELECT SUM(`TotalCobrado`) AS 'Total' FROM `EquiposFinanciados` WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen='$almacen'";
    $sqlTotalCSAim = "SELECT SUM(`ValorCobrado`) AS 'TotalSim' FROM `RepoSim` WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen='$almacen'";
    $sqlTotalEquiposClaro ="SELECT COUNT(*) AS 'NumVentas' FROM `EquiposFinanciados` WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen='$almacen'";
    $sqlTotalRepoSim = "SELECT COUNT(*) AS 'NumRepos' FROM `RepoSim` WHERE Fecha BETWEEN '$fechaActual' AND '$fechaActual' AND Almacen='$almacen'";
    $queryTotalEquiposClaro =mysqli_query($conn,$sqlTotalEquiposClaro);
    $queryTotalRepoSim = mysqli_query($conn,$sqlTotalRepoSim);
    while ($resultEquiCla=mysqli_fetch_array($queryTotalEquiposClaro)) {
        $totalEquip = number_format($resultEquiCla['NumVentas']);
        $totalEquiposClaro = $totalEquip;
    }

    $query=mysqli_query($conn,$sqlTotal);
    while($resultado=mysqli_fetch_array($query)){
        $valtotalEqui = number_format($resultado['Total']);
  $equiposClaro = $resultado['Total'];
 
   //Aca se acaba de conseguir el total para equipos financiados e inicia consulta de reposim
} 
$query2=mysqli_query($conn,$sqlTotalCSAim);
    while($resultado2=mysqli_fetch_array($query2)){
        $valRepoSim = number_format($resultado2['TotalSim']);
  $Repo= $resultado2['TotalSim'];
 
   //Aca se acaba de conseguir el total para equipos financiados
} 
$cantSimRepos = 0;
while($reqCantSim = mysqli_fetch_array($queryTotalRepoSim)){
    $cantSimRepos = $reqCantSim['NumRepos'];
}

mysqli_close($conn);
$conn->close();
$TotalesClaro = $Repo + $equiposClaro + $valTotalPlanes;
$ttlclaro = number_format($TotalesClaro);

echo '<tr><td>
<div class="ui compact mini menu ">
<a class="item"  onclick="openModals(`resultEquiDiaclaro`); mostrarEquiposClarodia();">
   <i class="mobile icon"></i> Equipos<div class="detail"> $ '.$valtotalEqui.'
  <div class="floating ui red label">'.$totalEquiposClaro.'</div></a></div>
 </td></tr>

<tr><td>
<div class="ui compact mini menu ">
<a class="item">
 <i class="fas fa-sim-card"></i>&nbsp;Reposición De Sim<div class="detail"> $ '.$valRepoSim.'
  <div class="floating ui red label">'.$cantSimRepos.'</div></a></div>
</td></tr>

<tr><td>
<div class="ui compact mini menu ">
<a class="item">
<i class="phone volume icon"></i>&nbsp;Planes Y Por...<div class="detail"> $ '.$valTotalPlanes.'
  <div class="floating ui red label">0</div></a></div>
</td></tr>

<tr><td>
<div class="ui compact tiny menu ">
<a class="item">
<i class="list icon"></i>Total<div class="detail">&nbsp; $'.$ttlclaro.'</a></div>
</td></tr> 

 <tr><td>
 <div class="ui large label" id="footer-card-claro" name="footer-card-claro">
 Actualizado hace: 0 minutos. <i class="fas fa-sync-alt" onclick="consultaValorEquiposClaroDia();"></i>
</div>
 </td></tr>';  
    
break;    
     
}




?>