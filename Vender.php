<?php
session_start();
setlocale(LC_MONETARY,"es_CO");
include ('DataBaseConection.php');
date_default_timezone_set('America/Bogota');
$almacen = $_SESSION['almacen'];
$Empresa = $_SESSION['bodega'];



$QueVender = $_POST['soy'];
$fecha = date('Y-m-d');
switch ($QueVender) {
    case 'AgregaReferencia':
        $IdRef= $_POST['idref'];
        $REff = $_POST['refpago'];
        $FechaP = strtoupper($_POST['diapago']);
        $sqlRef = "UPDATE EquiposFinanciados SET ReferenciaPago = '$REff', Fecha_Pago = '$FechaP' WHERE Id = '$IdRef'";
        if ($conn->query($sqlRef) === TRUE) {
            mysqli_close($conn);
            $conn->close(); 
            echo $sqlRef;
            echo json_encode(array('error' => false));
        }else{
            mysqli_close($conn);
                $conn->close(); 
                echo json_encode(array('error' => true));
        }
    break;


    case 'QuitarProductosDeFactura':
        $IdProEnFactura = $_POST['IdVenta'];
        $IdProenProduct = $_POST['IdProducto'];
        $devolver = (int) $_POST['Unidades'];
        $hay = (int) 0;
        $sqlUpdeleteVentaproduct = "DELETE FROM Ventas WHERE Id = '$IdProEnFactura'";
        if ($conn->query($sqlUpdeleteVentaproduct) === TRUE) {
            $sqlproductsee = "SELECT SUM(Unidades) AS Hay FROM Productos WHERE Id='$IdProenProduct'";
            $resultUnidades=mysqli_query($conn,$sqlproductsee);
            while($mostraruni=mysqli_fetch_array($resultUnidades)){
            $hay = (int) $mostraruni['Hay'];
            }
            $TotalDevolver = (int) $hay + $devolver;
           
            $sqldevolverunidades = "UPDATE Productos SET Unidades ='$TotalDevolver', Estado ='EN BODEGA' WHERE Id ='$IdProenProduct'";
            if ($conn->query($sqldevolverunidades) === TRUE) {
                mysqli_close($conn);
                $conn->close(); 
                echo json_encode(array('error' => false));
            }else{
            mysqli_close($conn);
                $conn->close(); 
                echo json_encode(array('error' => true));
        } 
        }else{
            mysqli_close($conn);
                $conn->close(); 
                echo json_encode(array('error' => true));  

        }
    break;
    case 'guardaFactura':
        $Facturax = $_POST['Factura'];
        $SQLFormalizax = "UPDATE Ventas SET Estado = 'FORMALIZADA' WHERE Empresa='$Empresa' AND Almacen = '$almacen' AND Factura = '$Facturax'";
        $conn->query($SQLFormalizax);
        $sqlFormaFacx = "UPDATE Factura SET NumeroActual = '$Facturax' WHERE Empresa = '$Empresa' AND Almacen = '$almacen'";
        if ($conn->query($sqlFormaFacx) === TRUE) {
           $CLiente = $_POST['Cliente'];
           $DOcumento = $_POST['Documento'];
           $VAlor = $_POST['Valor'];
           $SQLnuefac ="INSERT INTO Facturas (Cliente, Documento, Factura, Fecha, Usuario, Empresa, Valor, Almacen) VALUES('$Clientex','$Documentox','$Facturax','$fecha','$Usuario','$Empresa','$Valorx','$almacen')";
           if ($conn->query($SQLnuefac) === TRUE){
            mysqli_close($conn);
            $conn->close(); 
            echo json_encode(array('error' => false)); 
           }
        }
    break;


    case 'formalizaFactura':
        $Factura = $_POST['Factura'];
        $SQLFormaliza = "UPDATE Ventas SET Estado = 'FORMALIZADA' WHERE Empresa='$Empresa' AND Almacen = '$almacen' AND Factura = '$Factura'";
        $conn->query($SQLFormaliza);
        $sqlFormaFac = "UPDATE Factura SET NumeroActual = '$Factura' WHERE Empresa = '$Empresa' AND Almacen = '$almacen'";
        if ($conn->query($sqlFormaFac) === TRUE) {
            $Clientex = $_POST['Cliente'];
            $Documentox = $_POST['Documento'];
            $Valorx = $_POST['Valor'];
            $SQnuefac ="INSERT INTO Facturas (Cliente, Documento, Factura, Fecha, Usuario, Empresa, Valor, Almacen) VALUES('$Clientex','$Documentox','$Factura','$fecha','$Usuario','$Empresa','$Valorx','$almacen')";
            if ($conn->query($SQnuefac) === TRUE) {
                mysqli_close($conn);
                $conn->close(); 
                echo json_encode(array('error' => false)); 
            }else{
                mysqli_close($conn);
                $conn->close(); 
                echo json_encode(array('error' => true));  
            } 
            }else{
                mysqli_close($conn);
                $conn->close(); 
                echo json_encode(array('error' => true));  
            } 
         
         

    break;


    case 'vendeProductos':
        $Cliente = $_POST['nombreclientefac'];
        $DocCliente = $_POST['docclientefactura']; 
        $CodigoBarras = $_POST['codigoBarrasfactura'];
        $Descripcion = $_POST['descripcionfac'];
        $Cantidad = $_POST['cantidadfactura'];
        $Valor = $_POST['valorproducto'];
        $IdPtoducto = $_POST['IdProducto'];
        $Costo = $_POST['Costo'];
        $Tipo = $_POST['Tipo'];
        $Quedan = $_POST['quedan'];
        $garantia = $_POST['garantia'];
        $codigoBarras2 = $_POST['barras2'];
        $Usuario = $_SESSION['usuario'];
        $FacturaNumero = $_POST['numeroParaFactura'];
        $sqlVender = "INSERT INTO Ventas (Descripcion, Fecha, Costo, Valor, Cliente, Documento, Factura, Usuario, Cantidad, Codigo, Codigo2, Tipo, FormaPago, Garantia, Empresa, Almacen, IdProducto) VALUES ('$Descripcion','$fecha','$Costo','$Valor','$Cliente','$DocCliente','$FacturaNumero','$Usuario','$Cantidad','$CodigoBarras','$codigoBarras2','$Tipo','CONTADO','$garantia','$Empresa','$almacen','$IdPtoducto')";
        switch($Quedan){
            case 0:
                $sqlUpdateProductos = "UPDATE Productos SET Estado='VENDIDO', Unidades='0' WHERE Id='$IdPtoducto'";
                if ($conn->query($sqlUpdateProductos) === TRUE) {

                    if($conn->query($sqlVender) === TRUE) {
                        $sqlListarVentas="SELECT * FROM `Ventas` WHERE Factura = '$FacturaNumero' AND Empresa='$Empresa' AND ALmacen='$almacen' ";
                        $resultadosVentas=mysqli_query($conn,$sqlListarVentas);
    
                          ?>
                          
                        <div >
                         <div class="table table-sm table-responsive-sm "  >
                         <table class="ui celled table">
                         <thead class="thead-dark">
                          <tr class="text-center w-25 h-25 ">
                          <th class="text-center" scope="col">Cant.</th>
                          <th class="text-center" scope="col">Descripción</th>
                          <th class="text-center" scope="col">Valor</th>
                          <th class="text-center" scope="col"> Acciones</th>
                          </tr>
                         </thead> 
                         <?php 
                              while($mostrar=mysqli_fetch_array($resultadosVentas)){
                            ?> 
                         <tbody>
                        <tr class="table-light ">
         
                          <td class="h-5"> <?php echo $mostrar['Cantidad']; ?></td>
                          <td class="h-5"><?php echo $mostrar['Descripcion']; ?></td>
                         <td class="h-5"><?php echo money_format("%.0n", $mostrar['Valor']); ?></td>
                         <td class="h-5">
                             <button type="button" class="ui red compact icon button" onclick="eliminarElementosDeFactura(this.id,<?php echo $mostrar['Cantidad']; ?>,<?php echo $mostrar['IdProducto']; ?>);"  id="<?php echo $mostrar['Id']; ?>"><i class="trahs alternate"></i></button>
                           
                            </td>
                       </tr>    
                       <?php   } ?>
                       </tbody>
                       </table>
                       </div>
                              <div>           
                              <?php 
                        mysqli_close($conn);
                        $conn->close(); 
                              break;
                    }else{
                        mysqli_close($conn);
                        $conn->close(); 
                        echo json_encode(array('venta' => true)); 
                    }
                }else{
                    echo json_encode(array('update' => true));    
                    mysqli_close($conn);
                    $conn->close(); 
                }
            break;
            default:
            $sqlUpdateProductos = "UPDATE Productos SET Unidades='$Quedan' WHERE Id='$IdPtoducto'";
            if ($conn->query($sqlUpdateProductos) === TRUE) {
                if($conn->query($sqlVender) === TRUE) {
                    $sqlListarVentas="SELECT * FROM `Ventas` WHERE Factura = '$FacturaNumero' ";
                    $resultadosVentas=mysqli_query($conn,$sqlListarVentas);

            
                      ?>
                      
                      <div >
                     <div class="table table-sm table-responsive-sm "  >
                     <table class="table table-sm table-info table-hover  table-bordered ">
                     <thead class="thead-dark">
                      <tr class="text-center w-25 h-25 ">
                      <th class="text-center" scope="col">Cant.</th>
                      <th class="text-center" scope="col">Descripción</th>
                      <th class="text-center" scope="col">Valor</th>
                      <th class="text-center" scope="col"> Acciones</th>
                      </tr>
                     </thead> 
                     <?php 
                          while($mostrar=mysqli_fetch_array($resultadosVentas)){
                        ?> 
                     <tbody>
                    <tr class="table-light ">
     
                      <td class="h-5"> <?php echo $mostrar['Cantidad']; ?></td>
                      <td class="h-5"><?php echo $mostrar['Descripcion']; ?></td>
                     <td class="h-5"><?php echo money_format("%.0n", $mostrar['Valor']); ?></td>
                     <td class="h-5">
                         <button class="btn btn-danger fas fa-trash-alt" onclick="eliminarElementosDeFactura(this.id,<?php echo $mostrar['Cantidad']; ?>,<?php echo $mostrar['IdProducto']; ?>);"  id="<?php echo $mostrar['Id']; ?>"></button>
                       
                        </td>
                   </tr>    
                   <?php   } ?>
                   </tbody>
                   </table>
                   </div>
                          <div>           
                          <?php   
                }else{
                    $errorr = mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
                    echo $errorr;
                }
            }else{
                echo json_encode(array('update2' => true));    
                mysqli_close($conn);
                $conn->close(); 
            break;
            }
        break;
        }
        

    break;
    
    case 'ObtenerFacturacion':
        $sqlFacturacion = "SELECT * FROM Factura WHERE Almacen = '$almacen' AND Empresa = '$Empresa'";
        $queryFacturacion=mysqli_query($conn,$sqlFacturacion);
        $datafactura = array();
        $arrayFacturacion = array();
        $counterF=mysqli_num_rows($queryFacturacion);
        $userF=mysqli_fetch_array($queryFacturacion);
        $resultadoFacturacion = mysqli_query($conn, $sqlFacturacion);
        if ($counterF==1){
            while($datafactura = mysqli_fetch_assoc($resultadoFacturacion)){
            
                $arrayFacturacion[]=$datafactura;
                mysqli_close($conn);
                  
                $conn->close();
                echo json_encode($arrayFacturacion);   
         break;
        }
    }
       
    break;
    
    
    }

?>