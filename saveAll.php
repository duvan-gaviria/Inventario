<?php
session_start();
include 'DataBaseConection.php';
$nombre = $_SESSION['username'];
$usuario = $_SESSION['usuario'];
$almacen = $_SESSION['almacen'];

$Empresa = $_SESSION['bodega'];


date_default_timezone_set('America/Bogota');
$fecha = date('Y-m-d');


$rol = $_SESSION['rol'];
if (!isset($_SESSION['username'])) {
  header('location: login');
}

$quienEs = $_POST['soy'];

switch($quienEs){
   case 'guardaDistribuidor':
      $namee = strtoupper($_POST['Nombre']);
      $city = strtoupper($_POST['Ciudad']);
      $sqlDistNew = "INSERT INTO Proveedores (Nombre, Direccion, Empresa) VALUES ('$namee','$city','$Empresa')";
      if($conn->query($sqlDistNew) === TRUE){
        mysqli_close($conn);
        $conn->close();
        echo json_encode(array('error' => false));
       }else{
        mysqli_close($conn);
        $conn->close();
        echo json_encode(array('error' => true));
       }
   break;
       case 'recibeEnvios':
           $guiarecep = $_POST['guiaEnvio'];
           $cliented =strtoupper($_POST['ClientDestino']);
           $FPagoa =strtoupper($_POST['fpagoenvio']);
           $valCob = $_POST['ValCob'];
           $sqlRecepEnvio = "INSERT INTO Interrapidisimo (Guia, TipoPago, Valor, Cliente, Ingreso, Estado) VALUES ('$guiarecep','$FPagoa','$valCob','$cliented','$fecha','EN BODEGA')";
           $sqlCajaInter = "INSERT INTO CajaInter (Tipo, Descripcion, Fecha, Valor) VALUES ('VENTA','ENVIO ADMITIDO GUIA: $guiarecep','$fecha','$valCob')";
            if($conn -> query($sqlRecepEnvio) === TRUE){
               if($conn -> query($sqlCajaInter) === TRUE){
                mysqli_close($conn);
                $conn->close();
                echo json_encode(array('error' => false));
               }else{
                mysqli_close($conn);
                $conn->close();
                echo json_encode(array('error' => true));
               }
              }
          break;
   case 'guardaGuias':
       $guia = $_POST['guia'];
       $docRe = strtoupper($_POST['docremitente']);
       $Remitente = strtoupper($_POST['remitente']);
       $docdest = $_POST['docdestinatario'];
       $destinatario = strtoupper($_POST['destinatario']);
       $telDestin = $_POST['telDestinatario'];
       $city = strtoupper($_POST['city']);
       $direccion = strtoupper($_POST['destino']);
       $Valor = $_POST['valorEnvio'];
       $sqlCajaInter2 = "INSERT INTO CajaInter (Tipo, Descripcion, Fecha, Valor) VALUES ('VENTA','ENVIO ADMITIDO GUIA: $guia','$fecha','$Valor')";
       $sqlNueGuia = "INSERT INTO GuiasRecepToSend (Guia, Remitente, DocumentoR, DocDestino, Destinatario, TelefonoDestino, CiudadDestino, Direccion, Valor, FechaIngreso) VALUES ('$guia','$Remitente','$docRe','$docdest','$destinatario','$telDestin','$city','$direccion','$Valor','$fecha')";
       if($conn->query($sqlNueGuia) === TRUE){
        if($conn ->query($sqlCajaInter2) === TRUE){
          mysqli_close($conn);
          $conn->close();
          echo json_encode(array('error' => false));
         }else{
          mysqli_close($conn);
          $conn->close();
          echo json_encode(array('error' => true));
         }
       }
     
      break;

   case 'SaveRepoSim':
       $documen = $_POST['documentoSIm'];
       $nombressim = $_POST['nombresSIm']. " ". $_POST['apellidosSim'];
       $numerosim = $_POST['Numero'];
       $ICCID = $_POST['Simcard'];
       $ValSimrepo = $_POST['valSimRepo'];
       $plann = $_POST['PlanSimRepo'];
       $sqlSaveRepoSim ="INSERT INTO RepoSim (Cliente, Documento, Fecha, Linea, Sim, Costo, ValorCobrado, Producto, Usuario, Almacen,Empresa) VALUES ('$nombressim','$documen','$fecha','$numerosim','$ICCID','2380','$ValSimrepo','$plann','$usuario','$almacen','$Empresa')";
       if($conn->query($sqlSaveRepoSim) === TRUE){
        mysqli_close($conn);
        $conn->close();
        echo json_encode(array('error' => false));
       }else{
        mysqli_close($conn);
        $conn->close();
        echo json_encode(array('error' => true));
       }
   break;

   case 'guardaGastos':
       $desc = strtoupper($_POST['descripcionGasto']);
       $Vallor = $_POST['valorGasto'];
       $Comentario = strtoupper($_POST['comentarioGasto']);
       $sqlGastos = "INSERT INTO Gastos (Descripcion, Fecha, Valor, Usuario, Empresa, Almacen, Comentario) VALUES ('$desc','$fecha','$Vallor','$usuario','$Empresa','$almacen','$Comentario')";
       if($conn->query($sqlGastos) === TRUE) {
        #Como salio bien Incrementamos el contador de codigos
        mysqli_close($conn);
        $conn->close();
        echo json_encode(array('error' => false));
       }else{
        echo json_encode(array('error' => true));
        echo json_encode(array('error' =>  mysqli_error($conn)));
        
       }
   break;


  case 'nuevoProducto':
    #Obtener valores desde POST 
    $Tipo = strtoupper($_POST['tipoProduct']);
    $Marca = strtoupper($_POST['marcaProduct']);
    $Modelo = strtoupper($_POST['modeloProduct']);
    $Proveedor = strtoupper($_POST['proveedorProduct']);
    $Costo = $_POST['costoProduct'];
    $Valor = $_POST['valorProduct'];
    $Unidades = $_POST['unidProduct'];
    $Codigo = $_POST['codigoProduct'];
    #Crear SQL Para guardar
    $sqlNuevoProducto ="INSERT INTO `Productos` (Tipo, Marca, Modelo, Color, Codigo, Costo, Valor, Unidades, Estado, Ingreso, Garantia, Usuario, Proveedor, Empresa, Almacen) VALUES ('$Tipo', '$Marca', '$Modelo', '.', '$Codigo', '$Costo', '$Valor', '$Unidades', 'EN BODEGA', '$fecha', '0','$usuario', '$Proveedor', '$Empresa', '$almacen')";
    # EJECUTAR EL SQL
    if($conn->query($sqlNuevoProducto) === TRUE) {
         #Como salio bien Incrementamos el contador de codigos
         $sqlUpdateCodigos = "UPDATE CodigoProductos SET Codigo = '$Codigo' WHERE Empresa = '$Empresa' AND Almacen = '$almacen'";
         if($conn->query($sqlUpdateCodigos) === TRUE) {
          mysqli_close($conn);
          $conn->close();
          echo json_encode(array('error' => false));
         }else{
           echo json_encode(array('error' => true));
      mysqli_close($conn);
      $conn->close();
      
    }

    }else{ echo json_encode(array('error' =>true));
      mysqli_close($conn);
      $conn->close();
     
    }
  break;
    case "guardaSim":
        $Distribuidor = $_POST['distribuidorSim'];
        $tipoSim = $_POST['tipoSim'];
        $costoSim = $_POST['costoSimD'];
        $valsim = $_POST['valSimC'];
        $simVence = $_POST['SimVence'];
        $iccid= $_POST['Iccid'];
        $sqlnuevaSim = "INSERT INTO Simcards (Iccid, Costo, Valor, Distribuidor, Ingreso, Usuario, Vence, Estado, Tipo, Almacen) VALUES ('$iccid', ' $costoSim', '$valsim', '$Distribuidor', '$fecha', '$usuario', '$simVence', 'EN BODEGA', '$tipoSim', '$almacen')";
        
        $sql ="SELECT * FROM Simcards WHERE Iccid = '$iccid'";
        $query=mysqli_query($conn,$sql);
        $counter=mysqli_num_rows($query);
        $user=mysqli_fetch_array($query);
        if ($counter==1){
         // Le diecimos al Ajax que existe el cliente
         
           mysqli_close($conn);
           $conn->close();
           echo json_encode(array('duplicado' => true));
      break;
      } else{

        if($conn->query($sqlnuevaSim) === TRUE) {
        mysqli_close($conn);
        $conn->close();

        echo json_encode(array('error' => false, 'duplicado' => false));
         }else {
            mysqli_close($conn);
            $conn->close();
             echo json_encode(array('error' => true ));     
         }
    break;

}
}

?>