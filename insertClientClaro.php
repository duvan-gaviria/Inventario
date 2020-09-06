<?php
session_start();
include ('DataBaseConection.php');
date_default_timezone_set('America/Bogota');
$nomb= strtoupper($_POST['nombres']);
$apell= strtoupper( $_POST['apellidos']);
$doc= $_POST['documento'];
$fecha = date('Y-m-d');
$fnac= $_POST['FechaNac'];
$fexp= $_POST['FechaExp'];
$tel= $_POST['tel'];
$lnac= strtoupper($_POST['LugarNac']);
$lexp= strtoupper($_POST['LugarExp']);
$direc= strtoupper($_POST['direccion']);
$quienEnvia = $_POST['soy'];
$Empresa = $_SESSION['bodega'];
$almacen = $_SESSION['almacen'];
//anteriormente se recuperaron los valores del formulario y se asignaron a cada variable separados
//validamos si el cliente ya existe

switch ($quienEnvia) 
{
  case 1:
    $sql ="SELECT * FROM Clientes WHERE Documento = '$doc'";
    $query=mysqli_query($conn,$sql);
  $counter=mysqli_num_rows($query);
  $user=mysqli_fetch_array($query);
  if ($counter==1){
     // Le diecimos al Ajax que existe el cliente
     
       mysqli_close($conn);
       $conn->close();
       echo json_encode(array('error' => true));
  break;
  } else {
      // Le diecimos al Ajax que no existe el cliente
     
  mysqli_close($conn);
  $conn->close();
  echo json_encode(array('error' => false));
  }
  
  break;

  case 2:
    $query = "INSERT INTO Clientes(Nombres, Apellidos, Documento, FechaNac, FechaExp, LugarExp, LugarNac, Telefono, Direccion) VALUES('$nomb', '$apell', '$doc', '$fnac', '$fexp', '$lnac', '$lexp', '$tel', '$direc')";

     if ($conn->query($query) === TRUE) {
         
      echo json_encode(array('error' => false));   
     break;
  }else{
    echo json_encode(array('error' => true));   
  }

  case 3: 
    $MarcaC = strtoupper($_POST['marcacelclaro']);
    $Modelocelc = strtoupper($_POST['modelocelclaro']);
    $colorcel = strtoupper($_POST['colorcelclaro']);
    $imeic = $_POST['imeiNuevoCelClaro'];
    $vence = $_POST['fechavence'];
    $distri = strtoupper($_POST['distribuidor']);
    $incrementon = $_POST['incrementocel'];
    $vence = $_POST['fechavence'];

    $bodega = strtoupper($_SESSION['bodega']);
    $sqlInsertaCelClaro = "INSERT INTO CelularesClaro (Marca, Modelo, Color, Imei, Distribuidor, Ingreso, Vence, Empresa, Almacen, Estado, Incremento) VALUES ('$MarcaC','$Modelocelc','$colorcel','$imeic','$distri','$fecha','$vence','$Empresa','$almacen','1','$incrementon')";
    if($conn->query($sqlInsertaCelClaro) === TRUE){
      
      mysqli_close($conn);
      $conn->close();
      echo json_encode(array('error' => false)); 
    break;
    }else{
      echo("Error description: " . mysqli_error($conn));
      mysqli_close($conn);
      $conn->close();
      echo json_encode(array('error' => true)); 
    break;
    }
   

}

?>


