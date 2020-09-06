<?php
session_start();
include 'DataBaseConection.php';
$nombre = $_SESSION['username'];
$usuario = $_SESSION['usuario'];
$almacen = $_SESSION['almacen'];

$validar = $_POST['soy'];

if (!isset($_SESSION['username'])) {
    header('location: login');
  } else {

  }

  switch ($validar){
      case 'simcardEquiposFinanciados':
          $Iccid = $_POST['Iccid'];
          $sql = "SELECT * FROM Simcards WHERE Iccid='$Iccid'";  
          $result = mysqli_query($conn, $sql);
          $query=mysqli_query($conn,$sql);
          $counter=mysqli_num_rows($query);
          $arrayCelular = array();
          if ($counter==1){
            while($data = mysqli_fetch_assoc($result)){
    
                $arrayCelular[]=$data;
                mysqli_close($conn);
                $conn->close();
                echo json_encode($arrayCelular);
               
            }
         } else {
            echo json_encode(array('error' => true));
          break;
        
         }

          }
    
  



?>