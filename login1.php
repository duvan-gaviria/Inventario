<?php
session_start();
include 'DataBaseConection.php';

$email = $_POST['email'];

$pass = $_POST['password'];
$data = array();
$arrayUsuario = array();
$sql ="SELECT * FROM autoriza WHERE Email = '$email' and Pass = '$pass'";
$query=mysqli_query($conn,$sql);
$counter=mysqli_num_rows($query);
$user=mysqli_fetch_array($query);
if ($counter==1){
	 // Guardamos los datos del usuario en la supervarible session para acceder a ellos desde cualquier lugar
	  $_SESSION['username'] = $user['Nombre'];
    $_SESSION['usuario'] = $user['Nombre']. ' ' . $user['Apellido'];
    $_SESSION['almacen'] = $user['Almacen'];
    $_SESSION['rol'] = $user['Rol'];
    $_SESSION['bodega'] = $user['Empresa'];
    $_SESSION['telefonoempresa'] = $user['TelefonoEmpresa'];
    $_SESSION['direccionempresa'] = $user['DireccionEmpresa'];
    $result = mysqli_query($conn, $sql);

     // Enviamos respuesta al Ajax para que redirija a la pagina de inicio solo en el caso de que no este bloqueado
     while($data = mysqli_fetch_assoc($result)){
    
     $arrayUsuario[]=$data;
     mysqli_close($conn);
      
     $conn->close();
     echo json_encode($arrayUsuario);
      
  }

	
   } else {
    // Le diecimos al Ajax que no puede iniciar session
	  echo json_encode(array('error' => true));
   mysqli_close($conn);
}
   
   
  
   
   
    
mysqli_close($conn);


?>