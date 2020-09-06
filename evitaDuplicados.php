<?php
session_start();
include 'DataBaseConection.php';
$nombre = $_SESSION['username'];
$usuario = $_SESSION['usuario'];
$almacen = $_SESSION['almacen'];
$Empresa = $_SESSION['bodega'];
$rol = $_SESSION['rol'];
$quienEnvia = $_POST['soy'];
$imeiUnoCelLibre = $_POST['ImeiUno'];
$imeiDosLibre = $_POST['ImeiDos'];
$fecha = date('Y-m-d');
switch ($quienEnvia) {

    case 'ingresoCelsLibresSingleSIm':
        $sqlsinglesim = "SELECT * FROM Productos WHERE Codigo='$imeiUnoCelLibre' OR Codigo2='$imeiUnoCelLibre' AND Empresa='$Empresa' AND Almacen='$almacen' ";
        $query2=mysqli_query($conn,$sqlsinglesim);
        $counter2=mysqli_num_rows($query2);
        if ($counter2==1){
            mysqli_close($conn);
            $conn->close();
            echo json_encode(array('duplicado' => true));
        }else{
            $tipo = "CELULAR";
            $marca =strtoupper($_POST['marcaLibre']);
            $modelo = strtoupper($_POST['modeloLibre']);
            $color = strtoupper($_POST['colorReal']);
            $proveedor = strtoupper($_POST['proveedorLibre']);
            $costo = strtoupper($_POST['costoLibre']);
            $valor = $_POST['valorLibre'];
            $garantia = $_POST['garantialibre'];
            $sqlGuardasingle = "INSERT INTO Productos (Tipo, Marca, Modelo, Color, Codigo, Costo, Valor, Unidades, Estado, Ingreso, Garantia, Proveedor, Empresa, Almacen) VALUES ('$tipo','$marca','$modelo','$color','$imeiUnoCelLibre','$costo','$valor','1','EN BODEGA','$fecha','$garantia','$proveedor','$Empresa','$almacen')";
            if ($conn->query($sqlGuardasingle) === TRUE) {
                mysqli_close($conn);
            $conn->close();
            echo json_encode(array('error' => false)); 
            }else{
                mysqli_close($conn);
                $conn->close();
                echo json_encode(array('error' => true)); 
            }
        }
    break;
    case "ingresoCelsLibres":
        $sqldual = "SELECT * FROM Productos WHERE Codigo = '$imeiUnoCelLibre' OR Codigo2 = '$imeiDosLibre' OR Codigo='$imeiDosLibre' OR Codigo2='$imeiUnoCelLibre' AND Empresa='$Empresa' AND Almacen='$almacen'";
        $query2e=mysqli_query($conn,$sqldual);
        $countere=mysqli_num_rows($query2e);
        if ($countere==1){
            mysqli_close($conn);
            $conn->close();
            echo json_encode(array('duplicado' => true));
        break;
        }else{
            $tipo2 = "CELULAR";
            $marca2 = strtoupper($_POST['marcaLibre']);
            $modelo2 = strtoupper($_POST['modeloLibre']);
            $color2 = strtoupper($_POST['colorReal']);
            $proveedor2 = strtoupper($_POST['proveedorLibre']);
            $costo2 = $_POST['costoLibre'];
            $valor2 = $_POST['valorLibre'];
            $garantia2 = $_POST['garantialibre'];
            $sqlGuardadualsim = "INSERT INTO Productos (Color, Tipo, Marca, Modelo, Codigo, Codigo2, Costo, Valor, Unidades, Estado, Ingreso, Garantia, Proveedor, Empresa, Almacen) VALUES ('$color2','$tipo2','$marca2','$modelo2','$imeiUnoCelLibre','$imeiDosLibre','$costo2','$valor2','1','EN BODEGA','$fecha','$garantia2','$proveedor2','$Empresa','$almacen')";
            if ($conn->query($sqlGuardadualsim) === TRUE) {
              
                mysqli_close($conn);
            $conn->close();
            echo json_encode(array('error' => false)); 
            }   else{
                mysqli_close($conn);
                $conn->close();
                echo json_encode(array('error' => mysqli_error($conn))); 
            }
        }
  
    break;
}


?>