<?php
session_start();

include ('DataBaseConection.php');
setlocale(LC_MONETARY,"es_CO");
$doc= $_POST['documentoequi'];
$imei = $_POST['imei'];
$docRef = $_POST['documentoref'];
$idref = $_POST['idref'];
$quienPideBuscar=$_POST['soy'];
$almacen = $_SESSION['almacen'];
$Empresa = $_SESSION['bodega'];
switch ($quienPideBuscar){

case 'ClienteParaRepoSim':
  $doccc = $_POST['documentoSIm'];
  $data = array();
  $sql = "SELECT * FROM Clientes WHERE Documento = '$doccc'";
  $arrayCliente = array();    
  $result = mysqli_query($conn, $sql);
  $query=mysqli_query($conn,$sql);
  $counter=mysqli_num_rows($query);
  if ($counter < 1){
    echo json_encode(array('error' => true));  
  }else{
  
    while($data = mysqli_fetch_assoc($result)){
       $arrayCliente[]=$data;
       mysqli_close($conn);
       $conn->close();
       echo json_encode($arrayCliente);
       break;
      }
  }
    break;


break;



case 'searchCodeNavBar':

$CODIGOPR = $_POST['Codigo'];
$sqlsearchnavbar = "SELECT * FROM Productos WHERE Empresa = '$Empresa' AND Almacen = '$almacen' AND Codigo='$CODIGOPR' OR Empresa = '$Empresa' AND Almacen = '$almacen' AND Codigo2='$CODIGOPR' ";
$resultProD=mysqli_query($conn,$sqlsearchnavbar);
?>

<br>
<div class=" table-responsive-sm">
    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
 
  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
<table class="table table-sm table-info table-hover table-bordered  table-striped ">
  
  <thead class="thead-dark">
    <tr class="text-center">
                <th scope="col" class="text-center">Cant</th>
                <th scope="col" class="text-center">Producto</th>
                <th scope="col" class="text-center">Valor</th>
               
                </tr>
            </thead>
            <?php 
            while($resqU=mysqli_fetch_array($resultProD)){ ?>
            <tbody>
           <tr class="text-center">
           <td class="h-5"><?php echo $resqU['Unidades'] ?></td>
           <td class="h-5"> <?php echo $resqU['Tipo']. " ". $resqU['Marca']. " ". $resqU['Modelo']. " ". $resqU['Color']. " ". $resqU['Codigo']; ?></td>
           <td class="h-5"><?php echo money_format("%.0n",  $resqU['Valor']) ?></td>
           
           </tr>
           <?php  }
             mysqli_close($conn);
            $conn->close();
            ?>
            
            </tbody>
            <caption><?php echo $row_cntP; ?> Productos Encontrados.</caption>
            </table>
           <?php


break;



   case 'caragaTodoDisponible':
   $sqlAllDispo = "SELECT * FROM Productos WHERE Almacen = '$almacen' AND Empresa = '$Empresa' AND Estado <> 'VENDIDO' AND Unidades > 0";
   $resultProducts=mysqli_query($conn,$sqlAllDispo);
   $numeroProducts = $resultProducts->num_rows;
   $row_cntP =mysqli_affected_rows($conn);
?>
<br>
<div class="alert alert-success  alert-dismissible fade show container text-center" role="alert">
    <?php echo $row_cntP." Productos Disponibles Bodega " .$almacen; ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>


<div class=" ">
    <div class="table table-sm table-responsive-sm ">
        <table class="ui green striped sortable selectable celled table ">

            <thead class="thead-dark">
                <tr class="text-center w-25 h-25 ">
                <th scope="col" class="text center">Cant</th>
                <th scope="col" class="text center">Producto</th>
                <th scope="col" class="text center">Valor</th>
                <th scope="col" class="text center">Acciones</th>
                </tr>
            </thead>
            <?php 
            while($resq=mysqli_fetch_array($resultProducts)){ ?>
            <tbody>
           <tr class="text-center">
           <td class="h-5"><?php echo $resq['Unidades'] ?></td>
           <td class="h-5"> <?php echo $resq['Tipo']. " ". $resq['Marca']. " ". $resq['Modelo']. " ". $resq['Color']. " ". $resq['Codigo']; ?></td>
           <td class="h-5"><?php echo money_format("%.0n",  $resq['Valor']) ?></td>
           <td class="h-5"><?php echo '<input type="button" class="btn btn-success"'; ?></td>
           </tr>
           <?php  }
             mysqli_close($conn);
            $conn->close();
            ?>
            
            </tbody>
            <caption><?php echo $row_cntP; ?> Productos Encontrados.</caption>
            </table>
           <?php

   break;



  case 'generarEtiquetas':
      $Desdec = $_POST['desdeEtiqueta'];
      $Hastac = $_POST['hastaEtiquetas'];

      $sqlGeneraTirillas ="SELECT COUNT(*) AS 'Cuantos' FROM `Productos` WHERE Ingreso BETWEEN '$Desdec' AND '$Hastac' AND Empresa = '$Empresa' AND Almacen = '$almacen'";
      $resultadoeti = mysqli_query($conn,$sqlGeneraTirillas);
      while($mostrarC=mysqli_fetch_array($resultadoeti)){
        $Codi = intval($mostrarC['Cuantos']);
        if($Codi > 0){
          echo json_encode(array('error' => false));
        }else{
          echo json_encode(array('error' => true));
        }
      }
  break;

  case 'obtenCodigoProductos':
  $sqlBuscaCodigoAsigg = "SELECT SUM(Codigo) AS 'Cod' FROM CodigoProductos WHERE Almacen='$almacen' AND Empresa = '$Empresa'";
  $resultadoCodigos = mysqli_query($conn,$sqlBuscaCodigoAsigg);
  $CodigoProduct;
  while($mostrarCod=mysqli_fetch_array($resultadoCodigos)){
      $CodigoProduct = $mostrarCod['Cod'];

  }
  $CodigoProduct ++;
   echo json_encode(array('CodigoP' => $CodigoProduct));

  break;

   case 'buscarFacturasPorfech':
    $fechaaa = $_POST['Fecha'];
    $sqlListarFacFech="SELECT * FROM `Facturas` WHERE Fecha BETWEEN '$fechaaa' AND '$fechaaa' AND Empresa ='$Empresa' AND Almacen ='$almacen' ";
    $resultadosfacFECH=mysqli_query($conn,$sqlListarFacFech);
    ?>
                     
                
    
        <table class="ui Stackable selectable celled table green center aligned segment">
        <thead class="thead-dark">
        <tr>
        <th scope="col">Factura</th>
                      <th scope="col">Fecha</th>
                      <th scope="col">Cliente y valor</th>
                      <th  scope="col"> Acciones</th>
                      </tr>
                     </thead> 
                     <?php 
                          while($mostrar3=mysqli_fetch_array($resultadosfacFECH)){
                        ?> 
                     <tbody>
                    <tr class="table-light ">
     
                      <td class="h-5 text-center"> <?php echo $mostrar3['Factura']; ?></td>
                      <td class="h-5 text-center"><?php echo date("d/m/Y", strtotime($mostrar3['Fecha'])); ?></td>
                      <td class="h-5 text-center"><?php echo $mostrar3['Cliente']. ' '.money_format("%.0n", $mostrar3['Valor']); ?></td>
                      <td class="h-5 text-center"><button class="ui mini black button" onclick="reimprimirFacs(<?php echo $mostrar3['Factura']; ?>);"  id="<?php echo $mostrar3['Factura']; ?>"><span class="fa fa-print"></span></button></td>
                   </tr>    
                   <?php
	mysqli_close($conn);
	}

	?>
	
                   </tbody>
                   </table>
                   
                                 
                          <?php  
   break;

    case 'buscarFacturasPorDoc':
       $DocumentoCliente = $_POST['Documento'];
       $sqlListarFac="SELECT * FROM `Facturas` WHERE Documento = '$DocumentoCliente' AND Empresa ='$Empresa' AND Almacen ='$almacen' ";
       $resultadosfac=mysqli_query($conn,$sqlListarFac);
       ?>
                      
        
      
        <table class="ui Stackable selectable celled table green center aligned segment">
        <thead class="thead-dark">
        <tr class="text-center w-25 h-25 ">
        <th class="text-center" scope="col">Factura</th>
                      <th class="text-center" scope="col">Fecha</th>
                      <th class="text-center" scope="col">Cliente y valor</th>
                      <th class="text-center" scope="col"> Acciones</th>
                      </tr>
                     </thead> 
                     <?php 
                          while($mostrar=mysqli_fetch_array($resultadosfac)){
                        ?> 
                     <tbody>
                    <tr class="table-light ">   
                      <td class="h-5 text-center"> <?php echo $mostrar['Factura']; ?></td>
                      <td class="h-5 text-center"><?php echo date("d/m/Y", strtotime($mostrar['Fecha'])); ?></td>
                      <td class="h-5 text-center"><?php echo $mostrar['Cliente']. ' '.money_format("%.0n", $mostrar['Valor']); ?></td>
                      <td class="h-5 text-center"><button class="btn btn-dark fa fa-print text-center" onclick="reimprimirFacs(<?php echo $mostrar['Factura']; ?>);"  id="<?php echo $mostrar['Factura']; ?>"></button></td>
                   </tr>    
                   <?php
                  	mysqli_close($conn);
	}
	?>
                   </tbody>
                   </table>      
                          <?php  
          


    break;
    case 'buscoFacturasReimprimir':
        $facturaReimp = $_POST['Factura'];
        $sqlSearchFac ="SELECT * FROM Ventas WHERE Factura = '$facturaReimp' AND Empresa = '$Empresa' AND Almacen='$almacen'";
        $queryfa=mysqli_query($conn,$sqlSearchFac);
        $countrefa=mysqli_num_rows($queryfa);
        if ($countrefa < 1){
          mysqli_close($conn);
          $conn->close();
          echo json_encode(array('error' => true));  
        }else{
          mysqli_close($conn);
          $conn->close();
            mysqli_close($conn);
          $conn->close();
          echo json_encode(array('error' => false));
        }
    break;


  case 'BuscarEquiposParaAsigRef':
    $datosRef = array();
    $sqlRef = "SELECT * FROM EquiposFinanciados WHERE Documento = '$doc' AND ReferenciaPago='NO ASIGNAD'";
    $arrayRef = array();   
    $resRef = mysqli_query($conn, $sqlRef);
    $queryref=mysqli_query($conn,$sqlRef);
    $countref=mysqli_num_rows($queryref);
    if ($countref < 1){
      mysqli_close($conn);
      $conn->close();
      echo json_encode(array('error' => true,'col'=> $countref)); 
    }else{
      while($datosRef = mysqli_fetch_assoc($resRef)){
        $arrayRef[]=$datosRef;
        mysqli_close($conn);
        $conn->close();
        echo json_encode($arrayRef);
        break;
       }
   }
    

break;


  case 'buscoClienteFacturacion':
    $data = array();
    $sql = "SELECT * FROM Clientes WHERE Documento = '$doc'";
    $arrayCliente = array();    
    $result = mysqli_query($conn, $sql);
    $query=mysqli_query($conn,$sql);
    $counter=mysqli_num_rows($query);
    if ($counter < 1){
      echo json_encode(array('error' => true));  
    }else{
    
      while($data = mysqli_fetch_assoc($result)){
         $arrayCliente[]=$data;
         mysqli_close($conn);
         $conn->close();
         echo json_encode($arrayCliente);
         break;
        }
    }
      break;

  case 'barrasFacturacion':
      $datosProducto = array();
      $codigo = $_POST['Codigo'];
      $sqlBuscaEquipos ="SELECT * FROM Productos WHERE Codigo = '$codigo' AND Empresa = '$Empresa' AND Almacen = '$almacen' OR Codigo2 = '$codigo' AND Empresa = '$Empresa' AND Almacen = '$almacen'";
      $resultadoProductos = mysqli_query($conn, $sqlBuscaEquipos);
      $queryProducto=mysqli_query($conn,$sqlBuscaEquipos);
      $countP=mysqli_num_rows($queryProducto); 
      if ($countP < 1){
        echo json_encode(array('error' => true));
      }else{
    
        while($datosP = mysqli_fetch_assoc($resultadoProductos)){
            
            $datosProducto[]=$datosP;
            mysqli_close($conn);
              $conn->close();
            echo json_encode($datosProducto);
        break;
      }
    }
    break;
    case 'buscoImeiClaro':
      $datosimei = array();
      $imeiclaro = $_POST['imei'];
      $sqlImeiClaro ="SELECT * FROM CelularesClaro WHERE Imei = '$imeiclaro' AND Estado='1'";
      $resultadocelclaro = mysqli_query($conn, $sqlImeiClaro);
      $queryimeiclaro=mysqli_query($conn,$sqlImeiClaro);
      $countimei=mysqli_num_rows($queryimeiclaro); 
      if ($countimei < 1){
        echo json_encode(array('error' => true));
      }else{
        while($datosime = mysqli_fetch_assoc($resultadocelclaro)){            
            $datosimei[]=$datosime;
            mysqli_close($conn);
              $conn->close();
            echo json_encode($datosimei);
        break;
      }
    }

    break;
}


?>