<?php
session_start();
$almacen = $_SESSION['almacen'];
$Empresa = $_SESSION['bodega'];
include 'DataBaseConection.php';


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=Etiquetas.xls');
header('Pragma: no-cache');
header('Expires: 0');
$desde = $_GET['desdeEtiqueta'];
$hasta = $_GET['hastaEtiquetas'];
$SqlEtiquetas = "SELECT * FROM Productos WHERE Empresa ='$Empresa' AND Almacen ='$almacen' AND Ingreso BETWEEN '$desde' AND '$hasta' AND Tipo <>'SIMCARD' AND Tipo <> 'CELULAR'";



?>

<table width="80%" border="1" align="center">
  
    <td width="5%" bgcolor="#3399CC">Descripcion</td>
    <td width="15%" bgcolor="#3399CC">Fecha</td>
    <td width="15%" bgcolor="#3399CC">Valor</td>
    <td width="15%" bgcolor="#3399CC">Unidades</td>
    <td width="10%" bgcolor="#3399CC">Proveedor</td>
    <td width="15%" bgcolor="#3399CC">Codigo</td> 
  </tr>
  <?php  
   $resultadoCodigos = mysqli_query($conn,$SqlEtiquetas);
  
   while($res=mysqli_fetch_array($resultadoCodigos)){
  
  ?>
  <tr>
      <td><?php echo $res['Tipo']. ' ' . $res['Modelo'];?></td>
      <td><?php echo $res['Ingreso'];?></td>
    <td><?php echo $res['Valor'];?></td>
    <td><?php echo $res['Unidades'];?></td>
    <td><?php echo $res['Proveedor'];?></td>
    <td><?php echo $res['Codigo'];?></td>
    
    </tr>
  <?php 
  } //cerrar el while
  ?>
</table>