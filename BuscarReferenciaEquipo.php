


<?php 

include ('DataBaseConection.php');




?>

   
<table class=" ui small  selectable celled table center aligned segment green " >
     
  <thead class="thead-dark">
    <tr class="text-center">
      <th scope="col">Cliente</th>
      <th scope="col">Fecha </th>
      <th scope="col">Equipo</th>
	  <th scope="col">Imei</th>
	  <th scope="col">Referencia </th>
	  <th scope="col">Cuota</th>
	  <th scope="col">Cuotas</th>
	  <th scope="col">Plan</th>
	  <th scope="col">Almacén</th>
    </tr>
  </thead>
   <?php $cedula= $_POST['search'];
  
  
	 

	$sql="SELECT * FROM `EquiposFinanciados` where Documento = $cedula ";
	$result=mysqli_query($conn,$sql);

	while($mostrar=mysqli_fetch_array($result)){
	    
  
	    
	    

	
?>




  <tbody >
<tr class="text-center">
      <td><?php echo $mostrar['Cliente'] ?></th>
      <td ><?php echo $mostrar['Fecha'] ?></td>
      <td><?php echo $mostrar['Equipo'] ?></td>
	  <td><?php echo $mostrar['Imei'] ?></td>
	  <td><?php echo $mostrar['ReferenciaPago'] ?></td>
	  <td><?php echo  $mostrar['ValorCuota'] ?></td>
	  <td><?php echo $mostrar['Cuotas_Pactadas'] ?></td>
	  <td><?php echo $mostrar['Plan'] ?></td>
	  <td><?php echo $mostrar['Almacen'] ?></td>
    </tr>
    
  


	<?php
	mysqli_close($conn);
	}

	?>
	
	
    
    	</tbody>
    </table>
    