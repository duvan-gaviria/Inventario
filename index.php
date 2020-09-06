<?php
date_default_timezone_set('America/Bogota');
session_start();
include 'DataBaseConection.php';
$nombre = $_SESSION['username'];
$Empresa = $_SESSION['bodega'];
$usuario = $_SESSION['usuario'];
$almacen = $_SESSION['almacen'];
$rolUser = $_SESSION['rol'];
$resultadoProveesdores;
$resultadoPro;
$resultadoPro2; 
$resultadoPro3;
$resultadoPro4;
$almacenes;

$rol = $_SESSION['rol'];
if (!isset($_SESSION['username'])) {
  header('location: login');
} else {
   $sqlTiendas = "SELECT * FROM Almacenes WHERE Empresa = '$Empresa' AND Estado ='ACTIVO' ORDER BY Almacen";
   $almacenes= $conn -> query($sqlTiendas);
   $sqlCargaProveedores ="SELECT Id, Nombre FROM Proveedores WHERE Empresa = '$Empresa' ORDER BY Nombre ASC";
   $resultadoProveesdores = $conn -> query($sqlCargaProveedores);
   $resultadoPro= $conn -> query($sqlCargaProveedores);
   $resultadoPro2= $conn -> query($sqlCargaProveedores);
   $resultadoPro3= $conn -> query($sqlCargaProveedores);
   $resultadoPro4 = $conn -> query($sqlCargaProveedores);
} 

$Inter = false;
$ClaroFin = false;
$Impuestos = false;
$estadoEmpresa = false;
$sqlEmpresaItems= "SELECT * FROM `Companies`";
$reqemp12 = mysqli_query($conn,$sqlEmpresaItems);
if($reqemp12->num_rows >0){
    while ($ree1=mysqli_fetch_assoc($reqemp12)){
      $estadoEmpresa= $ree1['Estado'];
      mysqli_close($conn);
    }
    if($estadoEmpresa ===true){

    
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Inventario</title>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.css?v=<?php echo(rand());?>">
    <link rel="stylesheet" href="css/animate.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="semantic/dist/semantic.js"></script>
    <script src="https://kit.fontawesome.com/b7c6930328.js" crossorigin="anonymous"></script>
    
</head>

<body>
    <div class="ui left inverted vertical menu sidebar">
        <div class="item">
            <div class="ui dropdown">
                <div class="text" id="InterMenur">
                    <div class="text"><i class="shipping fast icon"></i> Interrapidisimo</div>
                </div>
                <i class="dropdown icon"></i>
                <div class="menu">
                    <div id="nuevaGuiaLink" class="item" onclick="resetTextoMenu('Menuinter','nuevaGuiaInter');"><i
                            class="plus icon"></i> Nueva Guia</div>

                    <div id="nuevaGuiaLink" class="item" onclick="resetTextoMenu('Menuinter','recibirEnvios');"><i
                            class="truck icon"></i> Recibir Envio</div>

                    <div class="item" onclick="resetTextoMenu('Menuinter','enviosBodega'); listarEnviosBodega();"><i
                            class="handshake icon"></i> Entregar Paquetes</div>
                    <div class="item" onclick="resetTextoMenu('Menuinter','manifiesto');"><i class="list ol icon"></i>
                        Generar Manifiesto</div>
                </div>
            </div>
        </div>

        <div class="item">
            <div class="ui dropdown">
                <div class="text" id="ClaroMenu">
                    <div class="text"><i class="mobile alternate icon"></i> Administrar Claro</div>
                </div>
                <i class="dropdown icon"></i>
                <div class="menu">
                    <div class="item" onclick="resetTextoMenu('Menuclaro','nuevoClienteClaro');"><i
                            class="user plus icon"></i> Nuevo Cliente</div>
                    <div class="item" onclick="resetTextoMenu('Menuclaro','equiposFinanciadosClaro');"><i
                            class="cart plus icon"></i> Venta Fininciada</div>
                    <div class="item" onclick="resetTextoMenu('Menuclaro','ingresaNuevoCelClaro');"><i
                            class="boxes icon"></i> Ingreso Equipos</div>
                    <div class="item" onclick="resetTextoMenu('Menuclaro','asignaReferenciaPago');"><i
                            class="tags icon"></i> Asignar Referencia</div>

                    <div class="item" onclick="resetTextoMenu('Menuclaro','equiposClaroDisponibles');"><i
                            class="tasks icon"></i> Equipos Disponibles</div>
                    <div class="divider"></div>
                    <div class="item" onclick="resetTextoMenu('Menuclaro','nuevaSimcard');"> &nbsp;<i
                            class="fas fa-sim-card"></i> &nbsp; &nbsp;&nbsp; Nueva Simcard</div>

                    <div class="item" onclick="resetTextoMenu('Menuclaro','nuevaRepoSim');"> &nbsp;<i
                            class="fas fa-sim-card"></i> &nbsp; &nbsp;&nbsp; Reposición Simcard</div>

                </div>
            </div>
        </div>

        <div class="item">
            <div class="ui dropdown">
                <div class="text" id="Inventmenu">
                    <div class="text"><i class="dolly flatbed icon"></i> Inventario</div>
                </div>
                <i class="dropdown icon"></i>
                <div class="menu">

                    <div class="item" onclick="resetTextoMenu('MenuInvent','nuevoCelularLibre');"><i
                            class="mobile icon"></i> Nuevo Celuar</div>
                    <div class="item" onclick="resetTextoMenu('MenuInvent','nuevoProducto');obtenerCodigoNewProduct();">
                        <i class="plus icon"></i> Nuevo Producto</div>
                    <div class="divider"></div>
                    <div class="item" onclick="resetTextoMenu('MenuInvent','productosDisponibles');"><i
                            class="clipboard check icon"></i> Productos Disponibles</div>
                </div>
            </div>
        </div>

        <div class="item">
            <div class="ui dropdown">
                <div class="text" id="VentasMenu">
                    <div class="text"><i class="shopping cart icon"></i> Ventas</div>
                </div>
                <i class="dropdown icon"></i>
                <div class="menu">
                    <div class="item" onclick="resetTextoMenu('MenuVentas','nuevaVenta');"><i
                            class="cart plus icon"></i> Nueva Venta</div>
                    <div class="divider"></div>
                    <div class="item" onclick="resetTextoMenu('MenuVentas','reimprimir');"><i class="print icon"></i>
                        Reimprimir</div>
                    <div class="item" onclick="resetTextoMenu('MenuVentas','cajaStatus');"><i
                            class="dollar sign icon"></i> Estado Caja</div>
                </div>
            </div>
        </div>

        <a class="item" onclick="openModals('nuevoTramite');"><i class="box icon"></i> Nuevo Trámite
        </a>
        <a class="item" onclick="openModals('impuestoVehicular');"><i class="plus icon"></i> Impuesto Vehicular
        </a>

        <a class="item" onclick="openModals('generaEtiquetas');"><i class="file excel icon"></i> Generar Archivo
            Etiquetas </a>
        <a class="item" onclick="openModals('cuadreDistribuidor');"><i class="dollar sign icon"></i> Cuadre
            Distribuidor
        </a>


        <a class="item" onclick="openModals('nuevoGasto');"><i class=" left dollar sign icon"></i> Nuevo Gasto
        </a>
        <a class="item" onclick="openModals('nuevoDistribuidor');"><i class=" left dollar sign icon"></i> Nuevo
            Distribuidor </a>

    </div>
    <!--finaliza el menu vertical izquierdo.-->
    <div class="pusher">
        <!--inicia la barra nav superior-->

        <div class="ui inverted menu stackable">
            <div class="header item button-left" style="cursor:pointer;"><i onclick="showmenu();" class="bars icon"></i>
                &nbsp; &nbsp; &nbsp; <a
                    style="font-size: 1.6rem; font-family: 'Quicksand', sans-serif;  font-weight: normal;" class="link"
                    href="/"><?php echo $Empresa; ?></a>
            </div>
            <div class="right menu">
                <div class="item">
                    <div class="ui action input search">
                        <input class="prompt" type="number" id="search" placeholder="BUSCAR"
                            onfocus="cambiartypeSearch();" onkeyup="autoCompleteSearchNavBar(this.value,this.type);"
                            style="text-transform:uppercase;">

                        <select class="ui compact selection dropdown" id="typesearch">
                            <?php
                       switch ($almacen) {
                           case 'CENTRO COMERCIAL':
                            case 'MOVILES GUADALUPE':
                            echo '<option selected="" value="REFPAGO">REF DE PAGO</option>
                                  <option value="PRODUCTOS">PRODUCTOS</option>
                                  <option value="SIM">SIMCARD</option>';
                    break;

                    default:
                    echo '<option  value="refpago">REF DE PAGO</option>
                    <option selected="" value="PRODUCTOS">PRODUCTOS</option>';
                    break;
                    }
                    ?>

                        </select>
                        <div class="results"></div>
                        <button class="ui icon button" id="searchLink">
                            <i class="search icon"></i>
                        </button>
                    </div>


                </div>
            </div>
            <div class="ui dropdown item" tabindex="0">
                <?php echo $nombre; ?>
                <i class="dropdown icon"></i>
                <div class="menu" tabindex="-1">
                    <div class="item" onclick="salir();"> <i class="sign-out icon"></i> Salir</div>

                </div>
            </div>
        </div>
        <!--finaliza la barra superirior-->

        <!--inicia el acordeon resumen.-->
        <div class="ui container" id="bodyprincipal">
            <div class="ui styled fluid accordion">
                <div class="title ">
                    <i class="dropdown icon"></i>
                    Trámites (En Construcción)
                </div>
                <div class="content ">
                    <div class="transition visible" style="display: block !important;">
                        <div class="ui form">
                            <div class="four fields">
                                <div class="field ui link" style="width: 0px;">
                                </div>
                                <div class="field ui link card" style="margin-right: 10px;">
                                    <table class="ui large celled table" style="border: 0px;">
                                        <thead>
                                            <tr>
                                                <th style="background: white;">
                                                    <div class="center aligned"> <img src="img/claro_logo.png"
                                                            class="d-block mx-auto " width="50" height="50" alt="...">
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="resultadoClaro">
                                            <tr>
                                                <td>DBO NO CONECTADA</td>
                                            </tr>
                                            <tr>
                                                <td>DBO NO CONECTADA</td>
                                            </tr>
                                            <tr>
                                                <td>DBO NO CONECTADA</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="field ui link card" style="margin-right: 10px;">
                                    <table class="ui large celled table " style="border: 0px;">
                                        <thead>
                                            <tr>
                                                <th style="background: white;">
                                                    <div class="center aligned">
                                                        <img src="img/LOGOinter.png" width="163" height="50"
                                                            class="card-img-top" alt="...">
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="resultadoInter">
                                            <tr>
                                                <td>
                                                    <div class="ui label">
                                                        <a href="#" class="ui label">DBO NO CONECTADA
                                                            AÚN</a></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>DBO NO CONECTADA AÚN</td>
                                            </tr>
                                            <tr>
                                                <td>DBO NO CONECTADA AÚN</td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                                <div class="field ui link card" style="margin-right: 10px;">
                                    <table class="ui large celled table" style="border: 0px;">
                                        <thead>
                                            <tr >
                                                <th style="background: white;">
                                                    <div class="center aligned">
                                                        <img src="img/tramites.png" width="163" height="50"
                                                            class="card-img-top" alt="...">
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="resultadoInter">
                                            <tr>
                                                <td>
                                                    <div class="ui label">
                                                        <a href="#" class="ui label"> NO CONECTADO
                                                            AUN</a></div>
                                                </td>
                                            </tr>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="ui label">
                                                        <a href="#" class="ui label"> NO CONECTADO
                                                            AUN</a></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="ui label">
                                                        <a href="#" class="ui label"> NO CONECTADO
                                                            AUN</a></div>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                                <div class="field ui link card" style="margin-right: 10px;">
                                    <table class="ui large celled  table" style="border: 0px;">
                                        <thead>
                                            <tr>
                                                <th style="background: white;">
                                                    <div class="center aligned">
                                                        <img src="img/logo-bancolombia2.png" width="162" height="50"
                                                            class="card-img-top" alt="...">
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="resultadoInter">
                                            <tr>
                                                <td>DBO NO CONECTADA</td>
                                            </tr>
                                            <tr>
                                                <td>DBO NO CONECTADA</td>
                                            </tr>
                                            <tr>
                                                <td>DBO NO CONECTADA</td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="title active">
                    <i class="dropdown icon"></i>
                    Ventas (En construcción)
                </div>
                <div class="content active">
                    <div class="ui form">
                        <div class="four fields">
                            <div class="field ui link" style="width: 0px;"></div>
                            <div class="field ui link card" style="margin-right: 10px;">
                                <table class="ui large celled table" style="border: 0px;">
                                    <thead>
                                        <tr>
                                            <th style="background: white;">
                                                <div class="center aligned"> <img src="img/ventas.png"
                                                        class="d-block mx-auto " width="162" height="50" alt="...">
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="resultadoVentas">
                                        <tr>
                                            <td>DBO NO CONECTADA</td>
                                        </tr>
                                        <tr>
                                            <td>DBO NO CONECTADA</td>
                                        </tr>
                                        <tr>
                                            <td>DBO NO CONECTADA</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title">
                    <i class="dropdown icon"></i>
                    En construcción
                </div>
                <div class="content">
                <div class="content">

<!-- Start Content-->
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Xeria</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Dashboard 2</li>
                    </ol>
                </div>
                <h4 class="page-title">Dashboard 2</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mt-0 mb-2">New Customers</h4>

                <div class="mt-1">
                    <div class="float-left" dir="ltr">
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#f05050 "
                            data-bgColor="#48525e" value="58"
                            data-skin="tron" data-angleOffset="180" data-readOnly=true
                            data-thickness=".15"/>
                    </div>
                    <div class="text-right">
                        <h2 class="mt-3 pt-1 mb-1"> 268 </h2>
                        <p class="text-muted mb-0">Since last week</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mt-0 mb-3">Online Orders</h4>

                <div class="mt-1">
                    <div class="float-left" dir="ltr">
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#675db7"
                            data-bgColor="#48525e" value="80"
                            data-skin="tron" data-angleOffset="180" data-readOnly=true
                            data-thickness=".15"/>
                    </div>
                    <div class="text-right">
                        <h2 class="mt-3 pt-1 mb-1"> 8715 </h2>
                        <p class="text-muted mb-0">Since last month</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mt-0 mb-3">Revenue</h4>

                <div class="mt-1">
                    <div class="float-left" dir="ltr">
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#23b397"
                            data-bgColor="#48525e" value="77"
                            data-skin="tron" data-angleOffset="180" data-readOnly=true
                            data-thickness=".15"/>
                    </div>
                    <div class="text-right">
                        <h2 class="mt-3 pt-1 mb-1"> $925 </h2>
                        <p class="text-muted mb-0">This week</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mt-0 mb-3">Daily Average</h4>

                <div class="mt-1">
                    <div class="float-left" dir="ltr">
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#ffbd4a"
                            data-bgColor="#48525e" value="35"
                            data-skin="tron" data-angleOffset="180" data-readOnly=true
                            data-thickness=".15"/>
                    </div>
                    <div class="text-right">
                        <h2 class="mt-3 pt-1 mb-1"> $78.58 </h2>
                        <p class="text-muted mb-0">Revenue today</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!-- end col -->

    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-6">
            <!-- Portlet card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">
                        <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                        <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                        <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                    </div>
                    <h4 class="header-title mb-0">Sales Analytics</h4>

                    <div id="cardCollpase1" class="collapse pt-3 show" dir="ltr">
                        <div id="apex-sales-analytics" class="apex-charts"></div>
                        <div class="text-center">
                            <div class="row mt-3">
                                <div class="col-4">
                                    <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                    <h4><i class="fe-arrow-down text-danger mr-1"></i>$7.8k</h4>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                    <h4><i class="fe-arrow-up text-success mr-1"></i>$1.4k</h4>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                    <h4><i class="fe-arrow-down text-danger mr-1"></i>$9.8k</h4>
                                </div>
                            </div> <!-- end row -->
                            
                        </div>
                    </div> <!-- collapsed end -->
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">
                        <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                        <a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                        <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                    </div>
                    <h4 class="header-title mb-0">Orders Analytics</h4>

                    <div id="cardCollpase2" class="collapse pt-3 show" dir="ltr">
                        <div id="apex-order-analytics" class="apex-charts"></div>
                        <div class="text-center">
                            <div class="row mt-3">
                                <div class="col-4">
                                    <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                    <h4><i class="fe-arrow-up text-success mr-1"></i>641</h4>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                    <h4><i class="fe-arrow-down text-danger mr-1"></i>234</h4>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                    <h4><i class="fe-arrow-up text-success mr-1"></i>3201</h4>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div> <!-- collapsed end -->
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Download</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Upload</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                    </div>
                </div>
                <h4 class="header-title">Earning Reports</h4>
                <p class="text-muted">1 Mar - 31 Mar Showing Data</p>
                <h2 class="mb-4"><i class="mdi mdi-currency-usd text-primary"></i>25,632.78</h2>

                <div class="row mb-4">
                    <div class="col-6">
                        <p class="text-muted mb-1">This Month</p>
                        <h3 class="mt-0 font-20">$120,254 <small class="badge badge-light-success font-13">+15%</small></h3>
                    </div>

                    <div class="col-6">
                        <p class="text-muted mb-1">Last Month</p>
                        <h3 class="mt-0 font-20">$98,741 <small class="badge badge-light-danger font-13">-5%</small></h3>
                    </div>
                </div>

                <h5 class="font-16"><i class="mdi mdi-chart-donut text-primary"></i> Weekly Earning Report</h5>

                <div class="mt-5">
                    <span data-plugin="peity-bar" data-colors="#f7b84b,#ebeff2" data-width="100%" data-height="80">5,3,9,6,5,9,7,3,5,2,9,7,2,1,3,5,2,9,7,2,5,3,9,6,5,9,7</span>
                </div>

            </div> <!-- end card-box -->
        </div> <!-- end col -->

        <div class="col-xl-8">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Download</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Upload</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                    </div>
                </div>
                <h4 class="header-title mb-3">Transaction History</h4>

                <div class="table-responsive">
                    <table class="table table-centered table-borderless table-hover mb-0" id="datatable">
                        <thead class="thead-light">
                        <tr>
                            <th class="border-top-0">Name</th>
                            <th class="border-top-0">Card</th>
                            <th class="border-top-0">Date</th>
                            <th class="border-top-0">Amount</th>
                            <th class="border-top-0">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <img src="assets/images/users/user-2.jpg" alt="user-pic" class="rounded-circle avatar-sm" />
                                <span class="ml-2">Imelda J. Stanberry</span>
                            </td>
                            <td>
                                <img src="assets/images/cards/visa.png" alt="user-card" height="24" />
                                <span class="ml-2">**** 3256</span>
                            </td>
                            <td>27.03.2018</td>
                            <td>$345.98</td>
                            <td><span class="badge badge-pill badge-danger">Failed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <img src="assets/images/users/user-3.jpg" alt="user-pic" class="rounded-circle avatar-sm" />
                                <span class="ml-2">Francisca S. Lobb</span>
                            </td>
                            <td>
                                <img src="assets/images/cards/master.png" alt="user-card" height="24" />
                                <span class="ml-2">**** 8451</span>
                            </td>
                            <td>28.03.2018</td>
                            <td>$1,250</td>
                            <td><span class="badge badge-pill badge-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>
                                <img src="assets/images/users/user-4.jpg" alt="user-pic" class="rounded-circle avatar-sm" />
                                <span class="ml-2">James A. Wert</span>
                            </td>
                            <td>
                                <img src="assets/images/cards/amazon.png" alt="user-card" height="24" />
                                <span class="ml-2">**** 2258</span>
                            </td>
                            <td>28.03.2018</td>
                            <td>$145</td>
                            <td><span class="badge badge-pill badge-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>
                                <img src="assets/images/users/user-5.jpg" alt="user-pic" class="rounded-circle avatar-sm" />
                                <span class="ml-2">Dolores J. Pooley</span>
                            </td>
                            <td>
                                <img src="assets/images/cards/american-express.png" alt="user-card" height="24" />
                                <span class="ml-2">**** 6950</span>
                            </td>
                            <td>29.03.2018</td>
                            <td>$2,005.89</td>
                            <td><span class="badge badge-pill badge-danger">Failed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <img src="assets/images/users/user-5.jpg" alt="user-pic" class="rounded-circle avatar-sm" />
                                <span class="ml-2">Karen I. McCluskey</span>
                            </td>
                            <td>
                                <img src="assets/images/cards/discover.png" alt="user-card" height="24" />
                                <span class="ml-2">**** 0021</span>
                            </td>
                            <td>31.03.2018</td>
                            <td>$24.95</td>
                            <td><span class="badge badge-pill badge-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>
                                <img src="assets/images/users/user-6.jpg" alt="user-pic" class="rounded-circle avatar-sm" />
                                <span class="ml-2">Kenneth J. Melendez</span>
                            </td>
                            <td>
                                <img src="assets/images/cards/visa.png" alt="user-card" height="24" />
                                <span class="ml-2">**** 2840</span>
                            </td>
                            <td>27.03.2018</td>
                            <td>$345.98</td>
                            <td><span class="badge badge-pill badge-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>
                                <img src="assets/images/users/user-7.jpg" alt="user-pic" class="rounded-circle avatar-sm" />
                                <span class="ml-2">Sandra M. Nicholas</span>
                            </td>
                            <td>
                                <img src="assets/images/cards/master.png" alt="user-card" height="24" />
                                <span class="ml-2">**** 2015</span>
                            </td>
                            <td>28.03.2018</td>
                            <td>$1,250</td>
                            <td><span class="badge badge-pill badge-danger">Failed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <img src="assets/images/users/user-8.jpg" alt="user-pic" class="rounded-circle avatar-sm" />
                                <span class="ml-2">Ronald S. Taylor</span>
                            </td>
                            <td>
                                <img src="assets/images/cards/amazon.png" alt="user-card" height="24" />
                                <span class="ml-2">**** 0325</span>
                            </td>
                            <td>28.03.2018</td>
                            <td>$145</td>
                            <td><span class="badge badge-pill badge-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>
                                <img src="assets/images/users/user-9.jpg" alt="user-pic" class="rounded-circle avatar-sm" />
                                <span class="ml-2">Beatrice L. Iacovelli</span>
                            </td>
                            <td>
                                <img src="assets/images/cards/discover.png" alt="user-card" height="24" />
                                <span class="ml-2">**** 9058</span>
                            </td>
                            <td>29.03.2018</td>
                            <td>$6,542.32</td>
                            <td><span class="badge badge-pill badge-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>
                                <img src="assets/images/users/user-10.jpg" alt="user-pic" class="rounded-circle avatar-sm" />
                                <span class="ml-2">Sylvia H. Parker</span>
                            </td>
                            <td>
                                <img src="assets/images/cards/discover.png" alt="user-card" height="24" />
                                <span class="ml-2">**** 2577</span>
                            </td>
                            <td>31.03.2018</td>
                            <td>$24.95</td>
                            <td><span class="badge badge-pill badge-danger">Failed</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div> <!-- end table-responsive -->

            </div> <!-- end card-box-->
        </div> <!-- end col-->

    </div>
    <!-- end row -->    
    
</div> <!-- container -->

</div> <!-- content -->

                </div>
            </div>

        </div>
        <!--finaliza container principal-->

        <!--inician los modulos(modals)-->

        <div id="nuevoClienteClaro" class="ui small modal">
            <div class="header">
                <i class="user plus icon"></i> Nuevo Cliente Claro
            </div>
            <div class="content">

                <!--Inicia el formulario para guardar el cliente-->
                <form class="needs-validation" method="POST" id="insertclientform" name="insertclientform">

                    <div class="ui form">
                        <!--Inican los tres primeros campos-->
                        <div class="three fields">
                            <div class="field">

                                <label>*Documento</label>
                                <div class="ui left icon input ">
                                    <input class="ui input type=" number" onfocusout="ValidaSiClienteExiste(this);"
                                        class="form-control" id="documento" name="documento" placeholder="DOCUMENTO"
                                        aria-describedby="inputGroupPrepend" required>
                                    <i class="id card icon"></i>
                                </div>
                            </div>


                            <div class="field">
                                <label>*Nombres</label>
                                <div class="ui left icon input">
                                    <input type="text" style="text-transform: uppercase;" class="form-control"
                                        id="nombres" name="nombres" placeholder="Nombres" required>
                                    <i class="user icon"></i>
                                </div>
                            </div>

                            <div class="field">
                                <label>*Apellidos</label>
                                <div class="ui left icon input">
                                    <input type="text" style="text-transform: uppercase;" class="form-control"
                                        id="apellidos" name="apellidos" placeholder="Apellidos" required>
                                    <i class="user icon"></i>
                                </div>
                            </div>
                        </div>
                        <!--Finaliza los tres primeros campos y damos salto a nuevos tres campos-->

                        <div class="three fields">
                            <div class="field">
                                <label>*Fecha Nacimiento</label>
                                <div class="ui left icon input">

                                    <input type="date" name="FechaNac" style="text-transform: uppercase;"
                                        class="form-control" id="FechaNac" aria-describedby="inputGroupPrepend"
                                        required>
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Fecha Expedición</label>
                                <div class="ui left icon input">
                                    <input type="date" name="FechaExp" style="text-transform: uppercase;"
                                        class="form-control" id="FechaExp" aria-describedby="inputGroupPrepend"
                                        required>
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Télefono</label>
                                <div class="ui left icon input">
                                    <input type="tel" class="form-control" id="tel" name="tel" placeholder="TÉLEFONO"
                                        aria-describedby="inputGroupPrepend" required>

                                    <i class="phone icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="three fields">
                            <div class="field">
                                <label>*Lugar Nacimiento</label>
                                <div class="ui left icon input">
                                    <input type="text" class="form-control" id="LugarNac" name="LugarNac"
                                        style="text-transform: uppercase;" placeholder="Lugar De Nacimiento"
                                        aria-describedby="inputGroupPrepend" required>

                                    <i class="map marker alternate icon"></i>
                                </div>
                            </div>

                            <div class="field">
                                <label>*Lugar Expedición</label>
                                <div class="ui left icon input">
                                    <input type="text" class="form-control" id="LugarExp" name="LugarExp"
                                        style="text-transform: uppercase;" placeholder="Lugar De Expedición"
                                        aria-describedby="inputGroupPrepend" required>

                                    <i class="map marker alternate icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Dirección</label>
                                <div class="ui left icon input">
                                    <input type="text" class="form-control" id="direccion" name="direccion"
                                        style="text-transform: uppercase;" placeholder="Dirección"
                                        aria-describedby="inputGroupPrepend" required>

                                    <i class="map marker alternate icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="actions">
                <em><label class=" "> * Todos los campos son obligatorios. </label></em>
                <button type="button" class="negative ui button" data-dismiss="modal"><i class="close icon"></i>
                    Cancelar</button>
                <button type="button" id="save" onclick="validaCamposClienteClaro();" name="save"
                    class="ui green button"><img id="esperaClienteGuardar" src=""><i class="save icon"></i>
                    Guardar
                    Cliente</button>
            </div>
            </form>
        </div>
        <!-- finaliza el modal nuevo cliente claro-->
        <div id="ingresaNuevoCelClaro" class="ui small modal">
            <div class="header">
                <i class=" plus icon"></i> <i class="moble icon"></i> Nuevo Equipo Claro
            </div>
            <div class="content">

                <!--Inicia el formulario para guardar el equipo claro-->
                <form class="needs-validation" method="POST" id="insertcelClaroform" name="insertcelClaroform">

                    <div class="ui form">
                        <!--Inican los tres primeros campos-->
                        <div class="three fields">
                            <div class="field">

                                <label>*Marca</label>
                                <div class="ui left icon input">
                                    <input type="text" autocomplete="off" onfocusout="" class="form-control"
                                        id="marcacelclaro" style="text-transform: uppercase;"
                                        onkeyup="autocompleteMarca();" name="marcacelclaro" placeholder="MARCA"
                                        aria-describedby="inputGroupPrepend" required>

                                    <i class="building icon"></i>
                                </div>
                            </div>


                            <div class="field">
                                <label>*Modelo</label>
                                <div class="ui left icon input">
                                    <input type="text" autocomplete="on" style="text-transform: uppercase;"
                                        class="form-control" id="modelocelclaro" name="modelocelclaro"
                                        placeholder="MODELO" required>
                                    <i class="mobile icon"></i>
                                </div>
                            </div>

                            <div class="field">
                                <label>*Color</label>
                                <div class="ui left icon input">
                                    <input type="text" autocomplete="on" style="text-transform: uppercase;"
                                        class="form-control" id="colorcelclaro" name="colorcelclaro" placeholder="COLOR"
                                        required>
                                    <i class="tint icon"></i>
                                </div>
                            </div>
                        </div>
                        <!--Finaliza los tres primeros campos y damos salto a nuevos tres campos-->

                        <div class="three fields">
                            <div class="field">
                                <label>*Imei</label>
                                <div class="ui left icon input">
                                    <input type="number" autocomplete="on" name="imeiNuevoCelClaro"
                                        style="text-transform: uppercase;" placeholder="IMEI" class="form-control"
                                        id="imeiNuevoCelClaro" aria-describedby="inputGroupPrepend" required>

                                    <i class="barcode icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Fecha Vencimiento</label>
                                <div class="ui left icon input">
                                    <input type="date" autocomplete="on" name="fechavence"
                                        style="text-transform: uppercase;" class="form-control" id="fechavence"
                                        aria-describedby="inputGroupPrepend" required>
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*incremento</label>
                                <div class="ui left icon input">
                                    <input type="number" autocomplete="on" class="form-control" id="incrementocel"
                                        name="incrementocel" placeholder="INCREMENTO"
                                        aria-describedby="inputGroupPrepend" required>
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="three fields">
                            <div class="field">

                                <label>*Distribuidor</label>
                                <div class="ui left icon input">

                                    <input type="text" autocomplete="on" class="form-control" id="distribuidor"
                                        name="distribuidor" style="text-transform: uppercase;"
                                        placeholder="DISTRUBUIDOR" aria-describedby="inputGroupPrepend" required>


                                    <i class="building icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Almacen</label>
                                <div class="ui left icon input">
                                    <input type="text" value="<?php echo $almacen; ?>" class="form-control" id="almacen"
                                        name="almacen" style="text-transform: uppercase;" placeholder="ALMACEN"
                                        aria-describedby="inputGroupPrepend" disabled required>

                                    <i class="warehouse icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="actions">
                <em><label class=" "> * Todos los campos son obligatorios. </label></em>
                <button type="submit" id="saveCelClaro" onclick="validaCamposIngresaCelClaro();" name="saveCelClaro"
                    class="ui green button"><img id="esperaCelGuardar" src="">
                    <span class="save icon" role="status" aria-hidden="true"></span>
                    Guardar Celular</button>
                <button type="button" class="negative ui button" data-dismiss="modal">Cancelar</button>
            </div>
            </form>
        </div>
        <!-- finaliza el modal ingreso cel claro-->
        <div id="nuevoProducto" class="ui small modal">
            <div class="header">
                <i class=" plus icon"></i> <i class="moble icon"></i> Nuevo Producto
            </div>
            <div class="content">

                <!--Inicia el formulario para guardar el nuevo producto-->
                <form class="needs-validation" autocomplete="on" method="POST" id="newProduct">

                    <div class="ui form">
                        <!--Inican los tres primeros campos-->
                        <div class="three fields">
                            <div class="field">
                                <label>*Tipo</label>
                                <div class="ui left icon input">
                                    <input type="text" required style="text-transform: UPPERCASE;" class="form-control "
                                        onfocusout="" placeholder="TIPO" name="tipoProduct" id="tipoProduct">

                                    <i class="thumbtack icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Marca</label>
                                <div class="ui left icon input">
                                    <input type="text" required style="text-transform: UPPERCASE;" class="form-control "
                                        onfocusout="" placeholder="MARCA" name="marcaProduct" id="marcaProduct">
                                    <i class="building icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Modelo</label>
                                <div class="ui left icon input">
                                    <input type="text" required style="text-transform: UPPERCASE;" class="form-control "
                                        onfocusout="" placeholder="MODELO" name="modeloProduct" id="modeloProduct">
                                    <i class="list icon"></i>
                                </div>
                            </div>
                        </div>
                        <!--Finaliza los tres primeros campos y damos salto a nuevos tres campos-->

                        <div class="three fields">
                            <div class="field">
                                <label>*Proveedor</label>
                                <div class="ui left icon input">
                                    <select name="proveedorProduct" id="proveedorProduct" class="form-control">
                                        <option>.::SELECCIONA::.</option>
                                        <?php while($row5 = $resultadoPro4-> fetch_assoc()){ ?>
                                        <option><?php echo $row5['Nombre']; ?></option>
                                        <?php } ?>

                                    </select>


                                </div>
                            </div>
                            <div class="field">
                                <label>*Costo</label>
                                <div class="ui left icon input">
                                    <input type="number" required style="text-transform: UPPERCASE;"
                                        class="form-control " onfocusout="" placeholder="COSTO" name="costoProduct"
                                        id="costoProduct">
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Valor</label>
                                <div class="ui left icon input">
                                    <input type="number" required style="text-transform: UPPERCASE;"
                                        class="form-control " onfocusout="" placeholder="VALOR" name="valorProduct"
                                        id="valorProduct">
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="three fields">

                            <div class="field">
                                <label>*Unidades</label>
                                <div class="ui left icon input">
                                    <input type="number" required style="text-transform: UPPERCASE;"
                                        class="form-control " onfocusout="" placeholder="UNIDADES" name="unidProduct"
                                        id="unidProduct">

                                    <i class="clipboard list icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Código</label>
                                <div class="ui left icon input">
                                    <input type="number" required style="text-transform: UPPERCASE;"
                                        class="form-control " onfocusout="" disabled placeholder="CODIGO"
                                        name="codigoProduct" id="codigoProduct">

                                    <i class="barcode icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="actions">
                <em><label class=" "> * Todos los campos son obligatorios. </label></em>
                <button type="button" class="ui negative button" onclick="limpiarModal();" data-dismiss="modal"><i
                        class="close icon"></i> Cerrar</button>
                <button type="submit" id="saveProduct" onclick="verificarCampos('guardarProductos');"
                    class="ui green button "><i class="save icon"></i> Guardar</button>
            </div>
            </form>
        </div>
        <!-- finaliza el modal nuevo producto -->
        <div class="ui small modal" id="nuevoGasto">
            <div class="header"><i class="plus icon"></i>Nuevo Gasto <i class="dollar sign icon"></i></div>
            <div class="content">
                <div class="ui form">
                    <form class="needs-validation" autocomplete="on" method="POST" id="newGastoForm">

                        <div class="three fields">
                            <div class="field">
                                <label>*Descripción</label>
                                <div class="ui left icon input">
                                    <input type="text" required placeholder="DESCRIPCION"
                                        style="text-transform: UPPERCASE;" class="form-control " name="descripcionGasto"
                                        id="descripcionGasto">
                                    <i class="clipboard icon"></i>
                                </div>

                            </div>
                            <div class="field">
                                <label>*Valor</label>
                                <div class="ui left icon input">
                                    <input type="number" required placeholder="VALOR" style="text-transform: UPPERCASE;"
                                        class="form-control " onfocusout="" name="valorGasto" id="valorGasto">
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>Comentario</label>
                                <div class="ui left icon input">
                                    <input type="text" required placeholder="COMENTARIO"
                                        style="text-transform: UPPERCASE;" class="form-control" id="comentarioGasto"
                                        name="comentarioGasto">
                                    <i class="comments icon"></i>
                                </div>
                            </div>
                        </div><!-- finaliza columna de tres-->
                </div>
            </div>
            <div class="actions">
                <em><label class=" "> * Todos los campos son obligatorios. </label></em>
                <button type="button" class=" ui negative button" onclick="limpiarModal();" data-dismiss="modal"><i
                        class="close icon"></i> Cerrar</button>
                <button type="button" class="ui green button " onclick="guardaGasto();"><i id="savega"
                        class="save icon"></i> Guardar</button>

                </form>
            </div>
        </div>
        <!--finaliza el modal gastos-->
        <div class="ui small modal" id="nuevoCelularLibre">
            <div class="header"><i class="mobile icon"></i>Nuevo Celular Libre</div>
            <div class="content">
                <div class="ui form">
                    <form class="needs-validation" autocomplete="on" method="POST" id="nuevoCelLibre"
                        name="nuevoCelLibre">
                        <!--Inicia fila de tres controles-->
                        <div class="three fields">
                            <div class="field">
                                <label>*Marca</label>
                                <div class="ui left icon input">
                                    <input type="text" placeholder="MARCA" style="text-transform: uppercase;"
                                        autocomplete="on" class="form-control" id="marcaLibre" name="marcaLibre"
                                        aria-describedby="inputGroupPrepend" required>
                                    <i class="building icon"></i>
                                </div>
                            </div>

                            <div class="field">
                                <label>*Modelo</label>
                                <div class="ui left icon input">
                                    <input type="text" style="text-transform: uppercase;" class="form-control"
                                        id="modeloLibre" name="modeloLibre" placeholder="MODELO" required>
                                    <i class="mobile icon"></i>
                                </div>
                            </div>

                            <div class="field">
                                <label>*Color</label>
                                <div class="ui left icon input">
                                    <input type="text" style="text-transform: uppercase;" class="form-control"
                                        id="colorLibre" name="colorLibre" placeholder="COLOR" required>
                                    <div class="tint icon"></div>
                                </div>
                            </div>
                        </div>
                        <!--Finaliza fila de tres controles-->
                        <!--Inicia otra fila de tres controles-->
                        <div class="three fields">
                            <div class="field">
                                <label>*Distribuidor</label>
                                <div class="ui left icon input">
                                    <select name="proveedorLibre" id="proveedorLibre" class="form-control">
                                        <option>.::SELECCIONA::.</option>
                                        <?php while($row1 = $resultadoProveesdores-> fetch_assoc()){ ?>
                                        <option><?php echo $row1['Nombre']; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <label>*Costo</label>
                                <div class="ui left icon input">
                                    <input type="number" name="costoLibre" style="text-transform: uppercase;"
                                        class="form-control" id="costoLibre" aria-describedby="inputGroupPrepend"
                                        autocomplete="on" placeholder="COSTO" required>
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Valor</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="valorLibre" name="valorLibre"
                                        placeholder="VALOR PÚBLICO" aria-describedby="inputGroupPrepend" required>
                                    <i class="dollar sign icon"></i>
                                </div>

                            </div>
                        </div>
                        <!--Finaliza fila de tres controles-->
                        <!--Inicia otra fila de tres controles-->
                        <div class="three fields">

                            <div class="field">
                                <label>*Garantia</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="garantialibre" name="garantialibre"
                                        placeholder="GARANTIA" aria-describedby="inputGroupPrepend" required>
                                    <i class="calendar icon"></i>
                                </div>

                            </div>
                            <div class="field">
                                <label>*Unidades</label>
                                <div class="ui left icon  input">
                                    <input type="number" class="form-control" id="cantLibre" name="cantLibre"
                                        style="text-transform: uppercase;" placeholder="UNIDADES"
                                        aria-describedby="inputGroupPrepend" required>
                                    <i class="clipbpard list icon"></i>

                                </div>
                            </div>
                            <div class="field">
                                <label>Doble SIm?</label>
                                <div class="ui icon left input">
                                    <div class="ui toggle checkbox">
                                        <input type="checkbox" name="doblesim" id="doblesim">
                                        <label>SI</label>
                                    </div>

                              
                            </div>
                        </div>
                </div>
                <!--Finaliza fila de tres controles-->
            </div>
        </div>
        <div class="actions">
            <em> <label> * Todos los campos son obligatorios. </label></em>
            <button type="button" class="ui negative button">Cancelar</button>
            <button type="button" id="LL" onclick="addImeisLibre();" name="LL" class="ui green button"><img
                    id="esperaClienteGuardar" src=""> Guardar Celular</button>
        </div>
        </form>
    </div><!-- aca finaliza el modal celular libre-->

    <div class="ui modal" id="productosDisponibles">
        <div class="header"><i class="boxes icon"></i>
            Productos Disponibles Almacen: <?php echo $almacen; ?>
        </div>
        <div class="scrolling content">
            <div class="ui form">
                <form class="needs-validation" autocomplete="on" method="POST" id="productosDisponibles">
                    <div class="four fields ">
                        <div class="field">
                            <label>*Tipo</label>
                            <div class="ui left icon input">
                                <input type="text" required placeholder="TIPO" style="text-transform: UPPERCASE;"
                                    class="form-control " name="tipoSearchProduct" id="tipoSearchProduct">
                                <i class="thumbtack icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Marca</label>
                            <div class="ui left icon input">
                                <input type="text" required placeholder="MARCA" style="text-transform: UPPERCASE;"
                                    class="form-control " onfocusout="" name="marcaSearchProduct"
                                    id="marcaSearchProduct">
                                <i class="building icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>Modelo</label>
                            <div class="ui left icon input">
                                <input type="text" required placeholder="Modelo" style="text-transform: UPPERCASE;"
                                    class="form-control" id="modeloSearchProduct" name="modeloSearchProduct">
                                <i class="mobile icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="four fields">
                        <div class="field">
                            <label>Desde</label>
                            <div class="ui left icon input">
                                <input type="date" required placeholder="Modelo" style="text-transform: UPPERCASE;"
                                    class="form-control" id="desdeSearchProduct" name="desdeSearchProduct">
                                <i class="calendar icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>Hasta</label>
                            <div class="ui left icon input">
                                <input type="date" required placeholder="Modelo" style="text-transform: UPPERCASE;"
                                    class="form-control" id="hastaSearchProduct" name="hastaSearchProduct">
                                <i class="calendar icon"></i>
                            </div>
                        </div>
                    </div>


                    <div id="resProduct">
                        <div class="text-center">
                            <div class="spinner-border text-success" style="width: 6rem; height: 6rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button" onclick="limpiarModal();" data-dismiss="modal"><i
                    class="fas fa-window-close"></i> Cerrar</button>
            <button type="button" class="ui green button" onclick="guardaGasto();"><i id="savega"
                    class="fas fa-save"></i> Guardar</button>
        </div>
        </form>
    </div>
    <!-- finaliza el modal productos disponibles-->
    <!--inicia modal vender equipo financiado claro-->
    <div class="ui small modal" id="equiposFinanciadosClaro">
        <div class="header"><i class="plus icon"></i>Venta Equipos Financiados Claro</div>
        <div class="content">
            <div id="camposVentaCelFin">
                <div class="ui form">
                    <form class="needs-validation" method="POST" id="vendeFinClaro" name="vendeFinClaro">
                        <div class="three fields">
                            <div class="field">
                                <label>*Documento</label>
                                <div class="ui left icon input">
                                    <input type="number" onfocusout="noHayCliente();" class="form-control"
                                        id="documentoequi" name="documentoequi" placeholder="DOCUMENTO"
                                        aria-describedby="inputGroupPrepend" maxlength="10" required
                                        onkeyup="BuscarCliente();">
                                    <i class="id card icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Nombres</label>
                                <div class="ui left icon input">
                                    <input type="text" class="form-control" id="nomclifi" name="nomclifi"
                                        placeholder="NOMBRES" disabled>
                                    <i class="user icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Apellidos</label>
                                <div class="ui left icon input">
                                    <input type="text" style="text-transform: uppercase;"
                                        style="text-transform: uppercase;" class="form-control" id="apeclifi"
                                        name="apeclifi" placeholder="Apellidos" disabled>
                                    <i class="user icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <label>*Imei</label>
                                <div class="ui left icon input">
                                    <input name="imei" style="text-transform: uppercase;" class="form-control" id="imei"
                                        aria-describedby="inputGroupPrepend" placeholder="IMEI" required
                                        onfocusout="BuscarImeiClaro();"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        type="number" maxlength="15">
                                    <i class="barcode icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Equipo </label>
                                <div class="ui left icon input">
                                    <input type="text" name="equipo" style="text-transform: uppercase;"
                                        class="form-control" id="equipo" aria-describedby="inputGroupPrepend"
                                        placeholder="EQUIPO A VENDER" disabled required>
                                    <i class="mobile icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Cuota Inicial</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="incuota" name="incuota"
                                        placeholder="CUOTA INICIAL" aria-describedby="inputGroupPrepend" required
                                        onfocusout="convierteMoneda(this);" value="0"
                                        onfocus="quiteMonedaParaEditar(this);">
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <label>*Valor Cuota Mensual</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="valcuota" name="valcuota"
                                        style="text-transform: uppercase;" value="0" placeholder="VALOR CUOTA"
                                        aria-describedby="inputGroupPrepend" onfocusout="convierteMoneda(this);"
                                        required onfocus="quiteMonedaParaEditar(this);">
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Total Cuotas</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="tcuotas" name="tcuotas"
                                        style="text-transform: uppercase;" placeholder="TOTAL CUOTAS"
                                        aria-describedby="inputGroupPrepend" required>
                                    <i class="list icon"></i>

                                </div>
                                <input type="hidden" id="proveedorEquipoAVender" name="proveedorEquipoAVender">
                            </div>
                            <div class="field">
                                <label>*Simcard</label>
                                <div class="ui left icon input">
                                    <input type="number" value="0" class="form-control" id="simcard" name="simcard"
                                        style="text-transform: uppercase;" placeholder="SERIAL DE SIMCARD"
                                        aria-describedby="inputGroupPrepend" required
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        type="number" maxlength="17">
                                    <i class="icon" style="top: 32%; "><i class="fas fa-sim-card"></i></i>

                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <label>*Incremento</label>
                                <div class="ui left icon input">
                                    <input type="number" value="0" class="form-control" id="incremento"
                                        name="incremento" style="text-transform: uppercase;" placeholder="INCREMENTO"
                                        aria-describedby="inputGroupPrepend" onfocusout="convierteMoneda(this);"
                                        required onfocus="quiteMonedaParaEditar(this);">
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Valor Sim</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="valsim" name="valsim"
                                        style="text-transform: uppercase;" placeholder="VALOR SIM"
                                        aria-describedby="inputGroupPrepend" onfocusout="convierteMoneda(this);"
                                        required onfocus="quiteMonedaParaEditar(this);" value="0">
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Plan</label>
                                <div class="ui left icon input">
                                    <select name="tipoDocumento" id="tipoDocumento" class="form-control">
                                        <option>.::SELECCIONA::.</option>
                                        <option>PREPAGO</option>
                                        <option>REPOSICION</option>
                                        <option>PLAN Y EQUIPO</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <em>* Campos Obligatorios</em>
                            </div>
                            <div class="field">

                            </div>
                            <div class="field">
                                <label>Total A Cobrar</label>
                                <div class="ui left icon input">
                                    <input tipe="number" value="0" class="form-control" placeholder="Total Cobrado"
                                        id="total" name="total" readonly>
                                    <i class="dollar icon"></i>
                                </div>
                                <div id="resultadoventafinanciado" class="container text-center "
                                    style="font-size: 1rem;">

                                    <input type="hidden" name="idequipo" id="idequipo" />

                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
        <div class="actions">

            <button type="button" class="ui negative button" data-dismiss="modal"><i class="close icon"></i>
                Cancelar</button>
            <button type="button" id="vendeequipo" name="vendeequipo" class="ui green button"
                onclick="validaCamposFinanciado()"><i class="shopping cart icon"></i><img id="mi_imagen" src="">
                Vender
                Celular</button>
        </div>
        </form>
    </div>
    <!--finaliza el modal equipo financiado-->
    <!--inicia el muevo modal etiquetas-->

    <div class="ui small modal" id="generaEtiquetas">
        <div class="header"><i class="file excel icon"> </i>Generar Archivo Excel Para Etiquetas Zebra</div>
        <div class="content">
            <div class="ui form">
                <form class="needs-validation" autocomplete="on" method="POST" id="newFileEtiquetasExcel">
                    <div class="three fields">
                        <div class="field">
                            <label>*Desde</label>
                            <div class="ui left icon input">
                                <input type="date" required style="text-transform: UPPERCASE;" class="form-control "
                                    name="desdeEtiqueta" id="desdeEtiqueta">
                                <i class="calendar icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Hasta</label>
                            <div class="ui left icon input">
                                <input type="date" required style="text-transform: UPPERCASE;" class="form-control "
                                    onfocusout="" name="hastaEtiquetas" id="hastaEtiquetas">
                                <i class="calendar icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Campos Obligatorios</label>
                            <button type="button" class="ui green button" onclick="generarEtiquetas();"
                                id="genereEtiqueta"> <i class="download icon"></i> Generar Archivo</button>
                        </div>
                    </div>


            </div>
            </form>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button" onclick="limpiarModal();" data-dismiss="modal"><i
                    class="close icon"></i> Cerrar</button>
        </div>
    </div>
    <!--finaliza el modal etiquetas-->
    <!--inicia modal nuevo distribuidor-->
    <div class="ui small modal" id="nuevoDistribuidor">
        <div class="header"><i class="fas fa-plus"></i>&nbsp;<i class="warehouse icon"></i> Nuevo
            Distribuidor</div>
        <div class="content">
            <div class="ui form">
                <form class="needs-validation" autocomplete="on" method="POST" id="newDistri">
                    <div class="three fields">
                        <div class="field">
                            <label>*Nombre</label>
                            <div class="ui left icon input">
                                <input type="text" required placeholder="NOMBRE" style="text-transform: UPPERCASE;"
                                    class="form-control " name="distriName" id="distriName">
                                <i class="warehouse icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Ciudad</label>
                            <div class="ui left icon input">
                                <input type="text" required placeholder="CIUDAD" style="text-transform: UPPERCASE;"
                                    class="form-control " onfocusout="" name="citydist" id="citydist">
                                <i class="building icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Campos Obligatorios</label>
                            <button type="button" onclick="saveDistri();" class="ui green button" id="saveDist"><i
                                    id="saveDistIcon" class="fas fa-save"></i> Guardar</button>

                        </div>
                    </div>
            </div>
        </div>
        </form>
    </div>
    <!--finaliza el modal nuevo distribuidor-->
    <!--inicia modal asigna referencia -->
    <div class="ui small modal" id="asignaReferenciaPago">
        <div class="header"><i class="plus icon"></i>Asignar Referencia De Pago</div>
        <div class="content">
            <div class="ui form">
                <form class="needs-validation" method="POST" id="inserteref" name="inserteref">
                    <div class="three fields">
                        <div class="field">
                            <label>*Documento</label>
                            <div class="ui left icon input">
                                <input type="number" class="form-control" id="docuref" name="docuref"
                                    placeholder="DOCUMENTO" maxlength="10" aria-describedby="inputGroupPrepend" required
                                    onfocusout="ConsultaIngresaRef();">
                                <i class="id card icon"></i>
                            </div>
                        </div>
                        <div class="field" style="width: 66%;">
                            <label>*Cliente</label>
                            <div class="ui left icon input">
                                <input type="text" class="form-control" id="clientenombre" name="nombrecliente"
                                    placeholder="NOMBRE DEL CLIENTE" disabled>
                                <i class="user icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label>*Imei</label>
                            <div class="ui left icon input">
                                <input type="number" name="imeiref" style="text-transform: uppercase;"
                                    class="form-control" id="imeiref" aria-describedby="inputGroupPrepend"
                                    placeholder="IMEI" required disabled>
                                <i class="barcode icon"></i>
                            </div>
                        </div>
                        <div class="field" style="width: 66%;">
                            <label>*Equipo </label>
                            <div class="ui left icon input">
                                <input type="text" name="equiporef" style="text-transform: uppercase;"
                                    class="form-control" id="equiporef" aria-describedby="inputGroupPrepend"
                                    placeholder="EQUIPO A VENDIDO" disabled required>
                                <i class="mobile icon"></i>
                            </div>
                        </div>

                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label>*Referencia De Pago</label>
                            <div class="ui left icon input">
                                <input type="number" class="form-control" id="refpago" name="refpago"
                                    placeholder="REFERENCIA DE PAGO" aria-describedby="inputGroupPrepend" required>
                                <i class="list icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Día De Pago</label>
                            <div class="ui left icon input">
                                <input type="text" class="form-control" id="diapago" name="diapago"
                                    style="text-transform: uppercase;" placeholder="DÍA DE PAGO"
                                    aria-describedby="inputGroupPrepend" required>
                                <i class="calendar icon"></i>
                                <input type="hidden" name="idref" id="idref" />
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div id="resultadoref" class="container text-center " style="font-size: 1rem;">
            <div class="ui segment">
                <div class="ui active dimmer">
                    <div class="ui massive text loader">Loading</div>
                </div>
                <p></p>
                <p></p>
                <p></p>
            </div>
        </div>
        <div class="actions">
            <em> * Campos Obligatorios.</em>

            <button type="button" class="ui negative button" data-dismiss="modal"><i class="close icon"></i>
                Cancelar</button>
            <button type="button" id="asignaref" name="asignaref" class="ui green button"><i class="save icon"></i>
                Asignar Referencia</button>
        </div>
        </form>
    </div>
    <!-- Aca finaliza el modal asigna referencia de pago-->

    <div class="ui small modal" id="cajaStatus">
        <div class="header"><i class="money bill alternate icon"></i> Estado De Caja</div>
        <div class="scrolling content">
            <div class="content">
                <div class="ui form">
                    <form class="needs-validation" autocomplete="on" method="POST" id="cajaStatusForm">
                        <div class="three fields">
                            <div class="field">
                                <label>*Desde</label>
                                <div class="ui left icon input">
                                    <input type="date" required style="text-transform: UPPERCASE;" class="form-control "
                                        name="desdeCajaStatus" id="desdeCajaStatus">
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Hasta</label>
                                <div class="ui left icon input">
                                    <input type="date" required style="text-transform: UPPERCASE;" class="form-control "
                                        name="hastaCajaStatus" id="hastaCajaStatus">
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Almacen</label>
                                <div class="ui left icon input">
                                    <select name="store" id="store" class="form-control">
                                        <?php 
                                if($rolUser == 'VENDEDOR'){
                                    echo '<option>'.$almacen.'</option>';
                                }else{
                                   echo '<option>.::SELECCIONA::.</option>';
                                   echo '<option>TODOS</option>';
                                   while($ro = $almacenes-> fetch_assoc()){ ?>
                                        <option><?php echo $ro['Almacen']; ?></option>
                                        <?php } 
                                }
                                ?>

                                    </select>

                                    <button type="button" onclick="cajaCuadre();" class="ui green button my-2 my-sm-0"
                                        id="saveD"><i id="saveDis" class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div id="salesdiv" class="text center">
                                <H4>SIN RESULTADOS.....</H4>

                            </div>

                        </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button" onclick="limpiarModal();" data-dismiss="modal"><i
                    class="close icon"></i> Cerrar</button>

        </div>
        </form>
    </div>
    <!--finaliza modal caja estatus-->
    <div class="ui small modal" id="nuevoTramite">
        <div class="header"><i class="plus icon"></i> Nuevo Trámite</div>
        <div class="content">
            <div class="ui form">
                <form class="needs-validation" autocomplete="on" method="POST" id="newTramit">
                    <div class="three fields">
                        <div class="field">
                            <label>* Documento</label>
                            <div class="ui left icon input">
                                <input type="number" id="docutramite" name="docutramite" placeholder="DOCUMENTO"
                                    required>
                                <i class="id card icon"></i>
                            </div>
                        </div>
                        <div class="field" style="width: 66%;">
                            <label>* Cliente</label>
                            <div class="ui left icon input">
                                <input type="text" id="nombretramitecliente" name="nombretramitecliente"
                                    placeholder="NOMBRE DEL CLIENTE" disabled>
                                <i class="id user icon"></i>
                            </div>

                        </div>
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label>*Trámite</label>
                            <div class="ui left icon input">
                                <input type="text" required placeholder="TRAMITE" style="text-transform: UPPERCASE;"
                                    class="form-control " name="tramit" id="tramit">
                                <i class="thumbtack icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Costo</label>
                            <div class="ui left icon input">
                                <input type="number" required placeholder="COSTO" style="text-transform: UPPERCASE;"
                                    class="form-control " onfocusout="" name="costTramite" id="costTramite">
                                <i class="dollar sign icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Valor</label>
                            <div class="ui left icon input">
                                <input type="number" required placeholder="VALOR COBRADO"
                                    style="text-transform: UPPERCASE;" class="form-control" id="valorTramit"
                                    name="valorTramit">
                                <i class="dollar sign icon"></i>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button" onclick="limpiarModal();" data-dismiss="modal"><i
                    class="close icon"></i> Cerrar</button>
            <button type="button" class="ui green button " onclick="savetramit();"><i id="savetra"
                    class="save icon"></i> Guardar Trámite</button>
        </div>
        </form>
    </div>
    <!--FINALIZA EL MODAL NUEVO TRAMITE-->

    <div class="ui small modal" id="nuevaVenta">
        <div class="header"><i class="plus icon"></i> <i class="shopping cart icon"></i>Factura:&nbsp; <i
                id="numFac"></i> &nbsp; Total: &nbsp; <i id="totalfacCobrar"></i></div>
        <div class="scrolling content">
            <div class="content">
                <div class="ui form">
                    <form id="ventaProductos" method="post">
                        <div class="three fields">
                            <div class="field">
                                <input type="hidden" name="numeroParaFactura" id="numeroParaFactura">
                                <input type="hidden" name="barras2" id="barras2">
                                <input type="hidden" name="garantia" id="garantia">
                                <label>*Documento Del Cliente</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control "
                                        onfocusout="buscaClienteFactura(this.value);" placeholder="DOCUMENTO"
                                        name="docclientefactura" id="docclientefactura">
                                    <i class="id card icon"></i>
                                </div>
                            </div>
                            <div class="field" style="width: 66%;">
                                <label>*Nombres Y Apellidos</label>
                                <div class="ui left icon input">
                                    <input type="text" class="form-control " placeholder="NOMBRES Y APELLIDOS"
                                        name="nombreclientefac" id="nombreclientefac" disabled>
                                    <i class="user id icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <label>*Código De Barras</label>
                                <div class="ui left icon input">
                                    <input type="text" class="form-control " onkeyup="detectaKeys(event);"
                                        onfocusout="buscarProducto('facturacion',this.value);" disabled
                                        placeholder="CÓDIGO DE BARRAS" name="codigoBarrasfactura"
                                        id="codigoBarrasfactura">
                                    <i class="barcode icon"></i>
                                </div>
                            </div>
                            <div class="field" style="width: 66%;">
                                <label>*Descripción Del Producto</label>
                                <div class="ui left icon input">
                                    <input style=" cursor:no-drop;" type="text" class="form-control "
                                        placeholder="DESCRIPCIÓN" name="descripcionfac" id="descripcionfac" disabled>
                                    <i class="clipboard list icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <label>*Cantidad</label>
                                <div class="ui left icon input">
                                    <input type="number" onfocusout="validaUnidadesAVender();" class="form-control "
                                        placeholder="CANTIDAD" name="cantidadfactura" disabled id="cantidadfactura">
                                    <i class="list icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Valor a Cobrar </label>
                                <div class="ui left icon input">
                                    <input type="text" class="form-control " onfocusout="aMoneda(this);"
                                        onfocus="quiteMonedaParaEditar(this);" placeholder="VALOR" name="valorproducto"
                                        disabled id="valorproducto">
                                    <i class="dollar sign icon"></i>
                                </div>
                                <input type="hidden" id="idProductoAVender" name="IdProducto">
                                <input type="hidden" id="valPro">
                                <input type="hidden" id="costo" name="Costo">
                                <input type="hidden" id="tipoPro" name=Tipo>
                                <input type="hidden" id="totalFac" name="totalFac">
                            </div>
                            <div class="field">
                                <label>*Disponibles</label>
                                <div class="ui left icon input">
                                    <input type="text" class="form-control " placeholder="DISPONIBLES" name="dispopro"
                                        id="dispopro" disabled>
                                    <i class="list icon"></i>
                                    <input type="hidden" name="cantdisponibles" id="cantdisponibles">
                                    <button type="button" id="btn-addpro" disabled
                                        onclick="verificarCampos('validarCamposParaAgregarProductosAFactura');"
                                        class="ui green compact icon button""><i class=" plus icon"></i></button>
                                </div>
                            </div>
                        </div>

                        <div id="resultadoFacturacion">
                            <div class="center">

                                <div id="elementosFactura">
                                    No Hay Productos Agregados....


                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button" onclick="limpiarModal();" data-dismiss="modal"><i
                    class="close icon"></i> Cerrar</button>

            <div class="ui buttons">
                <button class="ui orange button" type="button" onclick="validaSiHayProductosAfacturar(this);"
                    id="saveFactura"><i class="fas fa-save"></i> Guardar</button>
                <div class="or" data-text="Ó"></div>
                <button class="ui green button" type="button" id="imprimirFacturVenta"
                    onclick="validaSiHayProductosAfacturar(this);"><i class="fas fa-print"></i> Terminar e
                    imprimir</button>
            </div>



        </div>
    </div>
    <!--finaliza el modal ventas-->

    <div class="ui small modal" id="reimprimir">
        <div class="header"><i class="print icon"></i>Reimprimir Facturas</div>
        <div class="content">
            <div class=" ">
                <div class="ui form">
                    <form class="needs-validation" method="POST" id="Reimprimir">
                        <div class="three fields">
                            <div class="field">
                                <label>*Factura</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control " onfocusout="" placeholder="FACTURA"
                                        name="facturaReimprimir" id="facturarReimprimir">
                                    <button type="button" class="ui green button mini" id="searchFacturaImprimir"
                                        onclick="buscarFactura(this);"><span class="fa fa-search"></span></button>
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Documento Cliente</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control " onfocusout="" placeholder="DOCUMENTO"
                                        name="docReimprimir" id="docReimprimir">
                                    <button type="button" class="ui green button mini" id="searchdocFacturaImprimir"
                                        onclick="buscarFactura(this);"><span class="fa fa-search"></span></button>
                                    <i class="id card icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Fecha</label>
                                <div class="ui left icon input">
                                    <input type="date" class="form-control" name="dateRePrint" id="dateRePrint"
                                        style="text-transform: UPPERCASE;" aria-describedby="buscarFechaFac">
                                    <button class="ui green button mini" onclick="buscarFactura(this);" type="button"
                                        id="buscarFechaFac"><span class="fa fa-search"></span></button>
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div id="elementosFactur">

                                <div id="elementosFacture">
                                    <h4>No Hay Facturas Encontradas....</h4>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
        </div>
        </form>
        <div class="actions">
            <button type="button" class="ui negative button" onclick="limpiarModal();" data-dismiss="modal"><i
                    class="close icon"></i> Cerrar</button>
        </div>
    </div>
    <!--finaliza el modal reimprimir-->

    <div class="ui small modal" id="equiposClaroDisponibles">
        <div class="header"><i class="mobile icon"></i> Equipos Claro Disponibles</div>
        <div class="scrolling content">
            <div class="content">
                <div class="ui form">
                    <div class="three fields">
                        <div class="field">
                            <label>*Distribuidor</label>
                            <div class="ui left icon input">
                                <select onchange="consultaPorDistribuidor(this.value);" name="diatribuidorEquipos"
                                    id="distribuidorEquipos" class="form-control">
                                    <option>.::SELECCIONA::.</option>
                                    <option>TODOS</option>
                                    <?php while($row3 = $resultadoPro3-> fetch_assoc()){ ?>
                                    <option><?php echo $row3['Nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Marca</label>
                            <div class="ui left icon input">
                                <select name="AlmacenClaro" id="marcaSelectEquipos" class="form-control">
                                    <option>.::SELECCIONA::.</option>
                                    <option>PREPAGO</option>
                                    <option>REPOSICION</option>
                                    <option>PLAN Y EQUIPO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div id="todosLosEquiposResultado">
                            <div class="text-center">
                                <div class="spinner-border text-success" style="width: 6rem; height: 6rem;"
                                    role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>




            </div>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button" onclick="limpiarModal();" data-dismiss="modal"><i
                    class="close icon"></i> Cerrar</button>
        </div>
    </div>

    <div class="ui small modal" id="cuadreDistribuidor">
        <div class="header">Cuadre Distribuidor</div>
        <div class="scrolling content">
            <div class="content">
                <div class="ui form">
                    <form class="needs-validation" method="POST" id="cuadreDistClaro" name="cuadreDistClaro">
                        <div class="three fields">
                            <div class="field">
                                <label>*Distribuidor</label>

                                <select name="distribuidorcuadre" id="distribuidorcuadre" class="form-control">
                                    <option>.::SELECCIONA::.</option>
                                    <?php while($row = $resultadoPro2-> fetch_assoc()){ ?>
                                    <option><?php echo $row['Nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="field">
                                <label>*Desde</label>
                                <div class="ui left icon input">
                                    <input class="form-control" type="date" id="desdecuadredist" name="desdecuadredist"
                                        required>
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Hasta</label>
                                <div class="ui left icon input">
                                    <input type="date" class="form-control" id="hastacuadredist" name="hastacuadredist"
                                        required>
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button" data-dismiss="modal">Cancelar</button>
            <button type="button" id="saveSi" onclick="consultarDeudaDistribuidor();" name="saveSi"
                class="ui green button"><img id="esperaConsultaDistribuidor" src=""> Consultar</button>
        </div>
        </form>
    </div>
    <!--finaliza el modal cuadre distribuidor-->

    <div class="ui small modal" id="nuevaSimcard">
        <div class="header"><i class="plus icon"></i> <i class="fas fa-sim-card"></i> Nueva Simcard</div>
        <div class="scrolling content">
            <div class="content">
                <form class="needs-validation" method="POST" id="insertSim" name="insertSim">
                    <div class="ui form">
                        <div class="three fields">
                            <div class="field">
                                <label>*Distribuidor</label>
                                <div class="ui left icon input">
                                    <select name="distribuidorSim" id="distribuidorSim" class="form-control">
                                        <option>.::SELECCIONA::.</option>
                                        <?php while($row = $resultadoPro-> fetch_assoc()){ ?>
                                        <option><?php echo $row['Nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Tipo</label>
                                <div class="ui left icon input">
                                    <select name="tipoSim" id="tipoSim" class="form-control">
                                        <option>.::SELECCIONA::.</option>
                                        <option>POSTPAGO</option>
                                        <option>CAMBIO DE SERVICIO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Costo</label>
                                <div class="ui left icon input">
                                    <input type="number" style="text-transform: uppercase;" class="form-control"
                                        id="costoSimD" name="costoSimD" placeholder="COSTO" required>
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <label>*Valor Público</label>
                                <div class="ui left icon input">
                                    <input type="numb" name="valSimC" style="text-transform: uppercase;"
                                        class="form-control" id="valSimC" aria-describedby="inputGroupPrepend"
                                        placeholder="VALOR" required>
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Vence</label>
                                <div class="ui left icon input">
                                    <input type="date" name="SimVence" style="text-transform: uppercase;"
                                        class="form-control" id="SimVence" aria-describedby="inputGroupPrepend"
                                        required>
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Cantidad</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="cantSim" name="cantSim"
                                        placeholder="CANTIDAD" aria-describedby="inputGroupPrepend" required>
                                    <i class="list icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="actions">
            <em> * Todos los campos son obligatorios.</em>

            <button type="button" class="ui negative button " data-dismiss="modal">Cancelar</button>
            <button type="button" id="saveSim" onclick="validarCamposVacios(this);" name="saveSim"
                class="ui green button"><img id="esperaSimGuardar" src=""> Guardar Simcard</button>
        </div>
        </form>
    </div>
    <!--finaliza modal nueva sim-->

    <div class="ui small modal" id="nuevaRepoSim">
        <div class="header"><i class="fas fa-sim-card"></i> <i class="exchange icon"></i> <i
                class="fas fa-sim-card"></i> Nueva Reposición De Simcard</div>
        <div class="ui content">
            <form class="needs-validation" method="POST" id="insertrepoSim" name="insertrepoSim">
                <div class="ui form">
                    <div class="three fields">
                        <div class="field">
                            <label>*Documento</label>
                            <div class="ui left icon input">
                                <input type="number" onfocusout="ValidaSiClienteExiste(this);" class="form-control"
                                    id="documentoSim" name="documentoSIm" placeholder="DOCUMENTO"
                                    aria-describedby="inputGroupPrepend" required>
                                <i class="id card icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Nombres</label>
                            <div class="ui left icon input">
                                <input type="text" style="text-transform: uppercase;" class="form-control"
                                    id="nombresSim" name="nombresSIm" placeholder="Nombres" disabled required>
                                <i class="user icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Apellidos</label>
                            <div class="ui left icon input">
                                <input type="text" style="text-transform: uppercase;" disabled class="form-control"
                                    id="apellidosSim" name="apellidosSim" placeholder="Apellidos" required>
                                <i class="user icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label>*Número Recuperado</label>
                            <div class="ui left icon input">
                                <input type="numb" name="Numero" style="text-transform: uppercase;" class="form-control"
                                    id="Numero" aria-describedby="inputGroupPrepend" placeholder="# A RECUPERAR"
                                    required>
                                <i class="phone icon"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Simcard Nueva</label>
                            <div class="ui left icon input">
                                <input type="text" name="Simcard" style="text-transform: uppercase;"
                                    class="form-control" id="Simcard" aria-describedby="inputGroupPrepend"
                                    placeholder="NUEVA SIMCARD" required>
                                <i class="icon" style="top: 32%; "><i class="fas fa-sim-card"></i></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>*Valor Sim</label>
                            <div class="ui left icon input">
                                <input type="number" class="form-control" id="valSimRepo" name="valSimRepo"
                                    placeholder="VALOR SIM" aria-describedby="inputGroupPrepend" required>
                                <i class="dollar sign icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label>*Plan</label>
                            <div class="ui left icon input">
                                <select name="PlanSimRepo" id="PlanSimRepo" class="form-control">
                                    <option>.::SELECCIONA::.</option>
                                    <option>PREPAGO</option>
                                    <option>POSTPAGO</option>
                                </select>
                            </div>
                        </div>
                        <div class="field">

                        </div>
                    </div>
                </div>
        </div>
        </form>
        <div class="actions">
            <em> * Todos los campos son obligatorios</em>
            <button type="button" class="ui negative button" data-dismiss="modal">Cancelar</button>
            <button type="button" id="saveRepoSim" onclick="saveRepoSimClaro();" name="saveReposim"
                class="ui green button">
                <i id="saverep" class="fa fa-save"></i> Guardar Reposición</button>
        </div>
    </div>
    <!--finaliza modal repo sim-->

    <div class="ui modal" id="impuestoVehicular">
        <div class="header"><i class="fas fa-motorcycle"></i> Impuestos Vehiculares</div>
        <div class="scrolling content">
            <div class="ui form">
                <form class="needs-validation" method="POST" id="newImpuesto" name="newImpuesto">
                    <div class="content">
                        <div class="four fields">
                            <div class="field">
                                <label>*Placa</label>

                                <div class="ui fluid  search">
                                    <div class="ui left icon input">

                                        <input type="text" onkeyup="autocompletaSemantic(this.value);" class="prompt"
                                            id="placaimp" name="placaimp" placeholder="PLACA"
                                            aria-describedby="inputGroupPrepend" style="text-transform: uppercase;"
                                            maxlength="6" required>
                                        <i class="card id icon"></i>
                                    </div>
                                    <div class="results"></div>
                                </div>


                            </div>


                            <div class="field">
                                <label>*Marca</label>
                                <div class="ui left icon input">
                                    <input type="text" class="form-control" id="marcaImp" name="marcaImp"
                                        placeholder="MARCA" required>
                                    <i class="building icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Modelo</label>
                                <div class="ui left icon input">
                                    <input type="text" style="text-transform: uppercase;"
                                        style="text-transform: uppercase;" class="form-control" id="modeloImp"
                                        name="modeloImp" placeholder="MODELO" required>
                                    <i class="list icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Departamento</label>
                                <div class="ui left icon input">
                                    <input type="text" class="form-control" id="depimp" name="depimp"
                                        placeholder="DEPARTAMENTO" aria-describedby="inputGroupPrepend" required>
                                    <i class="building icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="four fields">
                            <div class="field">
                                <label>*Transito</label>
                                <div class="ui left icon input">
                                    <input type="text" autocomplete="on" class="form-control" id="tranimp"
                                        name="tranimp" style="text-transform: uppercase;" placeholder="Transito"
                                        aria-describedby="inputGroupPrepend" required>
                                    <i class="building icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Año a pagar</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="anioAPagar" name="anioAPagar"
                                        placeholder="AÑO A PAGAR" aria-describedby="inputGroupPrepend" required
                                        type="number" maxlength="17">
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Tipo de vehiculo</label>
                                <div class="ui icon left input">
                                    <select name="tipoVehiculo" id="tipoVehiculo" class="form-control">
                                        <option>.::SELECCIONA::.</option>
                                        <option>MOTO</option>
                                        <option>CARRO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Tipo De Pago</label>
                                <select name="tipoPagoImp" id="tipoPagoImp">
                                    <option>.::SELECCIONA::.</option>
                                    <option>RODAMIENTO</option>
                                    <option>SEMAFORIZACIÓN</option>
                                </select>
                            </div>
                        </div>
                        <div class="four fields">
                            <div class="field">
                                <label>*Total a cobrar</label>
                                <div class="ui left icon input">
                                    <input tipe="number" value="0" class="form-control" placeholder="Total Cobrado"
                                        id="SumImp" name="SumImp" readonly>
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Valor</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="valorImp" name="valorImp"
                                        style="text-transform: uppercase;" placeholder="VALOR IMPUESTO"
                                        aria-describedby="inputGroupPrepend" required>
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Cobro Por Pago</label>
                                <div class="ui left icon input">
                                    <input type="number" value="0" class="form-control" id="totalImpC" name="totalImpC"
                                        placeholder="COBRO POR PAGO" aria-describedby="inputGroupPrepend" required
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        type="number" maxlength="17">
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Documento</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="docimpu" name="docimpu"
                                        placeholder="DOCUMENTO" aria-describedby="inputGroupPrepend" required
                                        maxlength="17">
                                    <i class="id card icon"></i>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <div class="actions">
        <button type="button" class="ui negative button" data-dismiss="modal"><i class="fas fa-ban"></i>
            Cancelar</button>

        <button type="button" onclick="validarCamposVacios(this);" id="vendeIMP" name="vendeIMP" name="vendeIMP"
            class="ui green button"><i class="fa fa-shopping-cart"></i><img id="mi_img" src=""> Generar
            Recibo</button>
    </div>
    <div class="ui large modal" id="resltSearchRef">
        <div class="header" id="ced"></div>
        <div class="scrolling content">
            <div class="content">
                <div id="resultado" style="font-size: 0.84em;">
                </div>

            </div>
        </div>
        <div class="actions">
            <button type="button" onclick="showmenu();" class="ui negative button"><i class="close icon"></i>
                Cerrar</button>
        </div>
    </div>
    <!--finaliza modal-->
    <div class="ui large modal" id="resultEquiDiaclaro">
        <div class="header">Equipos Claro Financiados Hoy</div>
        <div class="srolling content">
            <div class="content">
                <div id="resultEquiDia">

                </div>
            </div>
        </div>
        <div class="actions">
            <button class="ui negative button" onclick=""><i class="close icon"></i> Cerrar</button>
        </div>
    </div>
    <!--finaliza modal-->
    <div class="ui large modal " id="resultCelDia">
        <div class="header">Equipos Vendidos Hoy</div>
        <div class="scrollling content">
            <div id="resultCellDia">
                <h1>Nada Que Mostrar Por Aquí</h1>
            </div>

        </div>
        <div class="actions">
            <button class="ui negative button"><i class="close icon"></i> Cerrar</button>
        </div>
    </div>
    <!--finaliza modal  resulCelDia-->
    <div class="ui large modal" id="resultAccesoriosDia">
        <div class="header">Accesorios Vendidos Hoy</div>
        <div class="scrolling content">
            <div id="resultAccsDia">
                <h3>Nada Que Mostrar Por Aquí</h3>
            </div>


        </div>
        <div class="actions">
            <button class="ui negative button"><i class="close icon"></i> Cerrar</button>
        </div>

    </div>
    <!--finaliza modal resultAccsDia-->

    <div class="ui small modal" id="nuevaGuiaInter">
        <div class="header"><i class="plus icon"></i>Nueva Guia Interrapidisimo</div>
        <div class="scrolling content">
            <div class="ui content">
                <div class="ui form">
                    <form method="POST" id="nuevaGuia">
                        <div class="three fields">
                            <div class="field">
                                <label>*Guia</label>
                                <div class="ui left icon input">
                                    <input type="number" class="form-control" id="guia" name="guia" placeholder="GUIA"
                                        aria-describedby="inputGroupPrepend" maxlength="12">
                                    <i class="id card icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Documento Remitente</label>
                                <div class="ui left icon input">
                                    <input type="number" id="docremitente" name="docremitente" placeholder="DOCUMENTO">
                                    <i class="id card icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Cliente</label>
                                <div class="ui left icon input">
                                    <input type="text" id="remitente" style="text-transform: uppercase;"
                                        name="remitente" placeholder="REMITENTE">
                                    <i class="id card icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <label>*Destinatario</label>
                                <div class="ui left icon input">
                                    <input type="text" id="docdestinatario" name="docdestinatario"
                                        placeholder="DESTINATARIO">
                                    <i class="id card icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Tipo</label>
                                <div class="ui left icon input">
                                    <select name="tipoEnvio" id="tipoEnvio">
                                        <option value="SOBRE">SOBRE</option>
                                        <option value="PAQUETE">PAQUETE</option>
                                        <option value="CAJA">CAJA</option>
                                    </select>

                                </div>
                            </div>
                            <div class="field">
                                <label>*Forma De Pago</label>
                                <div class="ui left icon input">
                                    <select name="tipoEnvio" id="tipoEnvio">
                                        <option value="CONTADO">CONTADO</option>
                                        <option value="CREDITO">CREDITO</option>
                                        <option value="AL COBRO">AL COBRO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <label>*Cidudad</label>
                                <div class="ui left icon input">
                                    <input type="text" id="city" name="city" style="text-transform: uppercase;"
                                        placeholder="DESTINO">
                                    <i class="building icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Dirección</label>
                                <div class="ui left icon input">
                                    <input type="text" id="destino" style="text-transform: uppercase;" name="destino"
                                        placeholder="DIRECCIÓN">
                                    <i class="map marker icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Valor</label>
                                <div class="ui left icon input">
                                    <input type="number" id="valorEnvio" name="valorEnvio" placeholder="VALOR">
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button"><i class="close icon"></i>Cerrar</button>
            <button type="button" class="ui green button" onclick="validaCamposGuiaNueva();"><i
                    class="save icon"></i>Guardar Guia</button>
        </div>
        </form>

    </div><!-- finaliza modal ingreso guias para enviar -->


    <div class="ui modal" id="recibirEnvios">
        <div class="header"><i class="plus icon"></i> Recibir Envio</div>
        <div class="scrolling content">
            <div class="ui form">
                <div class="ui content">
                    <form id="recepEnvios">
                        <div class="four fields">
                            <div class="field">
                                <label>*Guia</label>
                                <div class="ui left icon input">
                                    <input type="number" id="guiaEnvio" name="guiaEnvio" placeholder="GUIA">
                                    <i class="barcode icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Cliente</label>
                                <div class="ui left icon input">
                                    <input type="text" id="ClientDestino" style="text-transform: uppercase;"
                                        name="ClientDestino" placeholder="DESTINATARIO">
                                    <i class="id card icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Forma De Pago</label>
                                <div class="ui left icon input">
                                    <select name="fpagoenvio" id="fpagoenvio">
                                        <option .::SELECCIONE::.</option>
                                        <option>CONTADO</option>
                                        <option>AL COBRO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label>*Valor Cobrado</label>
                                <div class="ui left icon input">
                                    <input type="number" id="ValCob" name="ValCob" placeholder="VALOR">
                                    <i class="dollar sign icon"></i>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            </form>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button"><i class="close icon"></i> Cerrar</button>
            <button type="button" class="ui green button" onclick="validaCamposRecibirEnvios();"><i
                    class="save icon"></i> Guardar</button>

        </div>
    </div> <!-- finaliza el modal recibir envios-->


    <div class="ui modal" id="enviosBodega">
        <div class="header"><i class="handshake icon"></i> Envios disponibles para entregar</div>
        <div class="scrolling content">
            <div class="content">
                <div id="enviosForEntrega">
                </div>
            </div>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button"><i class="close icon"></i> Cerrar</button>

        </div>
    </div> <!-- finaliza entrega de envios-->


    <div class="ui tiny modal" id="manifiesto">
        <div class="header">Generar Manifiesto</div>
        <div class="content">
            <div id="resultConsultaManifiesto">
            </div>
        </div>
        <div class="actions">
            <button type="button" class="ui negative button"><i class="close icon"></i> Cancelar</button>
            <button type="button" class="ui green button" onclick="consultaDatosManifiesto();"><i class="sync icon"></i>
                Obtener Datos</button>

        </div>
    </div>


    </div>
    <!--finaliza pusher-->
    <div class="ui message container center aligned">
        Todos los Derechos Reservados Tecnoricel <?php $anio = date('Y'); echo $anio; ?>
        &copy;
    </div>
    <!-- Site end content !-->

    <script>
    window.onload = function() {
        $('.ui.dropdown').dropdown();
    };
    </script>
    <script src="js/duvan.js"></script>
    <script type="text/javascript" src="js/app.js?v=<?php echo(rand()); ?>"></script>
    <script src="js/animated.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <srcipt src="js/InertEquiClaro.js"></srcipt>

</body>