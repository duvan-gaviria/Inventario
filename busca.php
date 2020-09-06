<?php 

include '';
	 $cedula= $_POST['nombre'];
	
	$sql="SELECT * from EquiposFinanciados WHERE Documento = $cedula ";
	$result=mysqli_query($conexion,$sql);

	while($mostrar=mysqli_fetch_array($result)){
	    
	    
	 ?>
