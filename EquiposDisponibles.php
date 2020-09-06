<?php
session_start();
date_default_timezone_set('America/Bogota');
$Empresa = $_SESSION['bodega'];
$almacen = $_SESSION['almacen'];

?>
<div class=" table-responsive-sm">

    <?php 

include ('DataBaseConection.php');
$usuario = $_SESSION['username'];
$sql="";
if($usuario == 'DUVAN'){
    $sql ="SELECT *  FROM `CelularesClaro` WHERE Estado = '1'  ORDER BY Vence ASC ";
    
} else{
    $sql="SELECT *  FROM `CelularesClaro` WHERE Estado = '1' AND Almacen = '$almacen' AND Empresa='$Empresa' ORDER BY Vence ASC ";
  

}
$result=mysqli_query($conn,$sql);
$numero = $result->num_rows;
$row_cnt =mysqli_affected_rows($conn);

?>
    <br>
    <div class="ui small positive message">
        <i class="close icon"></i>
        <div class="header">
            Resultados
        </div>
        <p><?php echo $row_cnt." Equipos Disponibles Bodega " .$almacen; ?></p>
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