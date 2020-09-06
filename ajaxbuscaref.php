 

<div class="table-responsive">
<table class="table table-striped table-dark  table table-sm table-hover table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Cliente</th>
      <th scope="col">Fecha </th>
      <th scope="col">Equipo</th>
	  <th scope="col">Imei</th>
	  <th scope="col">Referencia </th>
	  <th scope="col">$ Cuota</th>
	  <th scope="col">#Cuotas</th>
	  <th scope="col">Día Pago</th>
	  <th scope="col">Almacén</th>
    </tr>
  </thead>
  <?php 
	 $cedula= $_POST['cedula'];
	
	$sql="SELECT * from EquiposFinanciados WHERE Documento = $cedula ";
	$result=mysqli_query($conexion,$sql);
     if(b=p){
		 echo 'como';
	 }
	while($mostrar=mysqli_fetch_array($result)){
	 ?>


  <tbody>
    <tr>
      <th scope="row"><?php echo $mostrar['Cliente'] ?></th>
      <td scope="row"><?php echo $mostrar['Fecha'] ?></td>
      <td><?php echo $mostrar['Equipo'] ?></td>
	  <td><?php echo $mostrar['Imei'] ?></td>
	  <td><?php echo $mostrar['ReferenciaPago'] ?></td>
	  <td><?php echo  $mostrar['ValorCuota'] ?></td>
	  <td><?php echo $mostrar['Cuotas_Pactadas'] ?></td>
	  <td><?php echo $mostrar['Fecha_Pago'] ?></td>
	  <td><?php echo $mostrar['Almacen'] ?></td>
    </tr>
    
  </tbody>
</table>
	</div>
<br>
 
 <?php 
}

 ?>
 <input type="submit" value=" << Realizar Otra Busqueda"  class="btn btn-success my-2 my-sm-0" onclick="window.location.href='/'"  style:"padding: 10px;">