<?php
session_start();
include 'DataBaseConection.php';
$nombre = $_SESSION['username'];
$usuario = $_SESSION['usuario'];
$almacen = $_SESSION['almacen'];
$resultadoProveesdores;
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$distribuidor = $_POST['distribuidor'];
$rol = $_SESSION['rol'];
if (!isset($_SESSION['username'])) {
  header('location: login');
} 



$sql = "SELECT SUM(Inicial+Valsim) AS 'Total' FROM EquiposFinanciados WHERE Distribuidor='$distribuidor' AND Fecha BETWEEN '$desde' AND '$hasta'";
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
}
?>