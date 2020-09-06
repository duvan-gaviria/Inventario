<?

 date_default_timezone_set('America/Bogota');
 
 session_start();
 $usuario = $_SESSION['usuario'];
$almacen = $_SESSION['almacen'];

include ('DataBaseConection.php');

$docCliente = $_POST['documentoequi'];
$nombreCliente =  $_POST['nomclifi'];
$apellidoCliente = $_POST['apeclifi'];
$cliente= $nombreCliente. " ". $apellidoCliente;

$imei = $_POST['imei'];
$cuotaInicial = $_POST['incuota'];
$valorCuota = $_POST['valcuota'];
$totalCuotas = $_POST['tcuotas'];
$simcard = $_POST['simcard'];
$incremento = $_POST['incremento'];
$valorSim = $_POST['valsim'];
$plan = $_POST['tipoDocumento'];
$equipo = $_POST['equipo'];
$total = $_POST['total'];
$deuda = $valorCuotas * $totalCoutas;
$distribuidor =$_POST['proveedorEquipoAVender'];
$Id = $_POST['idequipo'];
$Cliente = $nombreCliente;

 $fecha = date('Y-m-d');
 
 $sqlUpdate ="UPDATE CelularesClaro SET Venta='$fecha', Documento ='$docCliente', Cliente ='$cliente', Plan='$plan', Cuotas='$totalCuotas', Estado='0' WHERE Id ='$Id' ";
 
 $sqlventa = "INSERT INTO EquiposFinanciados (Plan, Distribuidor, Cliente, Documento, Equipo, Fecha, Imei, Iccid, Inicial, ValorDeuda, ValorCuota, Almacen, Usuario, Cuotas_Pactadas, Incremento, ValSim, TotalCobrado, ReferenciaPago) VALUES ('$plan','$distribuidor', '$cliente', '$docCliente', '$equipo', '$fecha', '$imei', '$simcard', '$cuotaInicial', '$deuda', '$valorCuota', '$almacen', '$usuario', '$totalCuotas', '$incremento', '$valorSim', '$total','NO ASIGNAD')";
 
 if ($conn->query($sqlUpdate) === TRUE) {
     
   if($conn->query($sqlventa) === TRUE) {
       
      echo json_encode(array('error' => false));
      mysqli_close($conn);
      $conn->close();
   }else {
       echo json_encode(array('error' => true));    
       mysqli_close($conn);
       $conn->close(); 
   }
     
 }else{
  mysqli_close($conn);
  $conn->close();
     echo json_encode(array('error' => true));
 }



?>