
<html>
    <body>

<?php
session_start();
date_default_timezone_set('America/Bogota');
$almacen = $_SESSION['almacen'];

?>
<div class=" table-responsive-sm">
    <div class="alert alert-secondary alert-dismissible fade show" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php 

include ('DataBaseConection.php');
$usuario = $_SESSION['username'];
$sql="";
if($usuario == 'DUVAN'){
    $sql ="SELECT *  FROM `CelularesClaro` WHERE Estado = '1' ORDER BY Vence ASC ";
    
} else{
    $sql="SELECT Marca, Modelo, Color , Incremento  FROM `CelularesClaro` WHERE Estado = '1' ORDER BY Vence ASC ";
  

}
$result=mysqli_query($conn,$sql);
$numero = $result->num_rows;
$row_cnt =mysqli_affected_rows($conn);

?>
        <br>
        <div class="alert alert-success  alert-dismissible fade show container text-center" role="alert">
            <?php echo $row_cnt." Equipos Disponibles Bodega " .$almacen; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>


        <div class=" ">
            <div class="table table-sm table-responsive-sm ">
                <table class="table  table-sm table-info table-hover table-bordered ">

                    <thead class="thead-dark">
                        <tr class="text-center w-25 h-25 ">
                            <th scope="col" class="text-center">Equipo</th>
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
            </div>
            </tbody>
            <caption><?php echo $row_cnt; ?> Equipos Encontrados.</caption>
            </table>


    </body>
</html>