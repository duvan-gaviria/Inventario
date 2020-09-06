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
   mysqli_close($conn);
} 

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <title>Inventario</title>
    <meta charset="utf-8">

    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/test.css">
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.css">
    <script src="semantic/dist/semantic.js"></script>
    
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/duvan.css">
    <link rel="stylesheet" href="css/toastr.min.css">
    <script src="js/toastr.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"
        integrity="sha256-H9jAz//QLkDOy/nzE9G4aYijQtkLt9FvGmdUTwBk6gs=" crossorigin="anonymous"></script>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <link rel="stylesheet" href="css/animaciones.css">
    <script src="js/bootstrap.js"></script>
   



</head>

<body>


    <main>
        <header class="header">
            <nav class="navbar navbar-toggleable-md  pt-0 pb-0 " style="background-color: black;">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class=" "> <a href="#" class="button-left"><span class="fa fa-fw fa-bars "></span></a> </div>
                <a class="navbar-brand  col-4" style="color: white; font-size: 2rem; "
                    href="/"><?php echo $Empresa; ?></a>
                <form class="form-inline" method="POST" style="justify-content: flex-end;">
                    <div class="dropdown">
                        <a class="btn btn-danger dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                class="fas fa-user-cog"></i>
                            <?php echo $nombre; ?>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#">No hago nada aún </a>
                            <a class="dropdown-item" href="#">No hago nada aún</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn btn-danger" href="salir"><i class="fas fa-sign-out-alt"></i>
                                Salir</a>
                        </div>
                    </div>
                    <?php
                      switch ($almacen) {
                          case 'CENTRO COMERCIAL':
                            case 'MOVILES GUADALUPE':
                              echo ' 
                         
                              <input id="search" onkeyup="autocoo();" name="search" class="form-control mr-sm-2" type="text"
                                  placeholder="Buscar"  aria-label="Search">
                                  <div class="mid btn text-center p-1">

                              <label class="rocker">
                                <input type="checkbox" id="ccOrName" checked>
                                <span class="switch-left">CC</span>
                                <span class="switch-right">NOM</span>
                              </label>
                            
                            </div>
                              <button id="buscar" name="buscar" onclick="searchAll();" data-toggle="modal" data-target="#resultadosBusquedasModal" type="button" class="btn btn-primary my-2 my-sm-0"><span
                                      class="fa fa-search"></span></button>
                                     
                              <input id="searchcodena" name="searchcodena" class="form-control mr-sm-2" type="number"
                                  placeholder="Código Del Producto" aria-label="Search">

                              <button id="buscarCodeNavBar" name="buscarCodeNavBar" onclick="searchCode(this);" type="button" class="btn btn-success my-2 my-sm-0"><span
                                      class="fas fa-box-open"></span></button>';
                              break;
                          
                          default:
                              echo '
                              <label for="" style="color: white; padding: 10px;">Productos: </label>
                              <input id="searchcodena" name="searchcodena" class="form-control mr-sm-2" type="number"
                                  placeholder="Código Del Producto" aria-label="Search">
                              <button id="buscarCodeNavBar" name="buscarCodeNavBar" onclick="searchCode(this);" type="button" class="btn btn-success my-2 my-sm-0"><span
                                      class="fa fa-search"></span> Buscar</button>';
                              break;
                      }
                    ?>
                </form>

            </nav>

        </header>
        <div class="main">
            <div class="row">

                <aside>
                    <div class="sidebar left " style="margin-left: 1rem;" ;>

                        <ul class="list-sidebar bg-defoult">
                            <li> <a href="#" data-toggle="collapse" data-target="#dashboard" class="collapsed active">
                                    <i class="fa fa-th-large"></i> <span class="nav-label"> Funciones </span> <span
                                        class="fa fa-chevron-left pull-right"></span> </a>
                                <ul class="sub-menu collapse" id="dashboard">
                                    <li class="active" data-toggle="modal" data-target=".bd-example-modal-lg"><a
                                            href="#"><i class="fa fa-user-plus"></i>Nuevo Cliente Claro</a></li>
                                    <li><a href="#"><i class="fa fa-user-plus"></i>Nuevo Cliente</a></li>

                                    <li><a href="#" data-toggle="modal" data-target="#ingresaNuevoCelClaro"><i
                                                class="fa fa-mobile" aria-hidden="true"></i> Ingreso Equipos Claro</a>
                                    </li>
                                    <li><a href="#" data-toggle="modal" data-target="#ingresareferencia"><i
                                                class="fas fa-plus"></i> Agregar Referencia De Pago</a></li>

                                    <li><a href="#" data-toggle="modal" data-target=".clientesAdmin"><i
                                                class="fas fa-users-cog"></i>Administrar Clientes</a></li>
                                    <li><a href="#" data-toggle="modal" data-target=".nuevoProducto"
                                            onclick="obtenerCodigoNewProduct();"><i class="fas fa-plus"></i>Nuevo
                                            Producto</a></li>

                                    <li><a href="#" data-toggle="modal" data-target=".nuevoDistribuidor"><i
                                                class="fas fa-plus"></i>Nuevo Distribuidor</a></li>
                                </ul>
                            </li>

                            <li> <a href="#" data-toggle="collapse" data-target="#tools" class="collapsed active"> <i
                                        class="fas fa-tools"></i> <span class="nav-label">Herramientas</span> <span
                                        class="fa fa-chevron-left pull-right"></span> </a>
                                <ul class="sub-menu collapse" id="tools">
                                    <li><a href="#" onclick="" data-toggle="modal" data-target=".generaEtiquetas"><i
                                                class="fas fa-barcode"></i> Etiquetas Zebra</a></li>

                                </ul>
                            </li>
                            <li> <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">Grid
                                        options</span></a>
                            </li>





                            <li> <a href="#" data-toggle="collapse" data-target="#products" class="collapsed active"> <i
                                        class="fa fa-bar-chart-o"></i> <span class="nav-label">Informes</span> <span
                                        class="fa fa-chevron-left pull-right"></span> </a>
                                <ul class="sub-menu collapse" id="products">
                                    <li><a href="#" onclick="mostrarEquiposDisponibles();" data-toggle="modal"
                                            data-target="#equiposDisponibles"><i class="fas fa-plus"></i> Equipos Claro
                                            Disponibles</a></li>
                                    <li><a href="#" onclick="" data-toggle="modal" data-target="#nuevoGasto"><i
                                                class="fas fa-plus"></i> Nuevo Gasto</a></li>
                                    <li><a href="#" id="showProduct" onclick="mostrarProductos(this);"
                                            data-toggle="modal" data-target="#productosDisponibles"><i
                                                class="fas fa-plus"></i> Productos Disponibles</a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#cajaStatus"><i
                                                class="fas fa-cash-register"></i>Estado Caja</a></li>

                                </ul>
                            </li>
                            <li> <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">Grid
                                        options</span></a>
                            </li>
                            <li> <a href="#" data-toggle="collapse" data-target="#tables" class="collapsed active"><i
                                        class="fa fa-table"></i> <span class="nav-label">Tables</span><span
                                        class="fa fa-chevron-left pull-right"></span></a>
                                <ul class="sub-menu collapse" id="tables">
                                    <li><a href=""> Static Tables</a></li>
                                    <li><a href=""> Data Tables</a></li>
                                    <li><a href=""> Foo Tables</a></li>
                                    <li><a href=""> jqGrid</a></li>
                                </ul>
                            </li>
                            <li> <a href="#" data-toggle="collapse" data-target="#e-commerce" class="collapsed active">
                                    <i class="fa fa-shopping-cart"></i> <span class="nav-label">Ventas</span><span
                                        class="fa fa-chevron-left pull-right"></span> </a>

                                <ul class="sub-menu collapse" id="e-commerce">
                                    <li><a href="#" data-toggle="modal" onclick="obtenerFacturacion();"
                                            data-target=".facturacion"><i class="fa fa-plus"></i> Nueva Venta</a></li>

                                    <li><a href="#" data-toggle="modal" onclick="" data-target=".reimprimir"><i
                                                class="fa fa-print"></i> Reimprimir</a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#ingEquiFinanciClaro"><i
                                                class="fa fa-mobile"></i> Equipos Financiados</a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#nuevoCelularLibre"><i
                                                class="fa fa-mobile"></i>Nuevo Celular Libre</a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#nuevaRepoSim"><i
                                                class="fas fa-sim-card"></i> Reposición Simcard</a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#nuevaSim"><i
                                                class="fas fa-sim-card"></i> Nueva Simcard</a></li>
                                    <li><a href="#" href="#" data-toggle="modal" data-target="#nuevoImpuestoVhicular">
                                            <i class="fas fa-car"></i> Impuestos Vehiculares</a></li>

                                    <li><a href="#" href="#" data-toggle="modal" data-target="#nuevoTramite">
                                            <i class="fas fa-car"></i> Nuevo Trámite</a></li>
                                    <li><a href=""> Others</a> </li>
                                    <li><a href="#" href="#" data-toggle="modal"
                                            data-target="#cuadreDistribuidoresClaro">
                                            <i class="fas fa-car"></i> Cuadre Distribuidores</a></li>
                                </ul>
                            </li>

                            </li>
                        </ul>
                    </div>
                </aside>
                <div class=" container container-fluid  p-2">


                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" onclick="cambioIconoAcordeon('acordeonTramites');"
                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        <i class="fas fa-minus" id="acordeonTramites"></i> Tramites
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <div class="col-12">
                                        <div class="card-deck">
                                            <div class="form-row" id="centroComercial">
                                                <div class="card mb-3 bg-light card-animated-tecnoricel"
                                                    style="max-width: 15rem;">
                                                    <div class="card-header">
                                                        <img src="img/claro_logo.png" class="d-block mx-auto "
                                                            width="50" height="50" alt="...">
                                                    </div>
                                                    <ul class="list-group list-group-flush" id="resultadoClaro">
                                                        <li class="list-group-item bg-light" id="valorEquiposClaroDia">
                                                            Equipos: $0,00</li>
                                                        <input type="hodden" id="claroeq">
                                                        <li class="list-group-item bg-light" id="repoSImDia">CS Sim:
                                                            $0,00</li>
                                                        <input type="hidden" id="csdia">
                                                        <li class="list-group-item bg-light">Planes: $61.900</li>
                                                        <li class="list-group-item bg-light">Total: $541.900</li>
                                                    </ul>

                                                    <div class="card-footer" id="footer-card-claro"
                                                        name="footer-card-claro">
                                                        <small class="text-muted">Actualizado hace: 0 minutos.</small>
                                                        <a calss="btn" href="#"
                                                            onclick="consultaValorEquiposClaroDia();"><i
                                                                class="fas fa-sync-alt"></i></a>
                                                    </div>
                                                </div>
                                                <!-- Aqui termina la primer card -->

                                                <div class="card mb-3 bg-light card-animated-tecnoricel"
                                                    style="max-width: 15rem;">
                                                    <div class="card-header">
                                                        <img src="img/tramites.png" width="50" height="50"
                                                            class="card-img-top" alt="...">
                                                    </div>
                                                    <ul class="list-group list-group-flush" id="resultadoBancolombia">
                                                        <li class="list-group-item bg-light" id="valorB">Equipos: $0,00
                                                        </li>
                                                        <li class="list-group-item bg-light">CS Sim: $30.000</li>
                                                        <li class="list-group-item bg-light">Planes: $61.900</li>
                                                        <li class="list-group-item bg-light">Total: $541.900</li>
                                                    </ul>

                                                    <div class="card-footer" id="footer-card-tramites"
                                                        name="footer-card-tramites">
                                                        <small class="text-muted">Actualizado hace: 0 minutos.</small>
                                                        <a calss="btn" href="#" onclick=""><i
                                                                class="fas fa-sync-alt"></i></a>
                                                    </div>
                                                </div>
                                                <!-- Aqui termina otra card -->

                                                <div class="card mb-3 bg-light card-animated-tecnoricel"
                                                    style="max-width: 15rem;">
                                                    <div class="card-header">
                                                        <img src="img/LOGOinter.png" width="50" height="50"
                                                            class="card-img-top" alt="...">
                                                    </div>
                                                    <ul class="list-group list-group-flush" id="resultadoBancolombia">
                                                        <li class="list-group-item bg-light" id="valorB">Equipos: $0,00
                                                        </li>
                                                        <li class="list-group-item bg-light">CS Sim: $30.000</li>
                                                        <li class="list-group-item bg-light">Planes: $61.900</li>
                                                        <li class="list-group-item bg-light">Total: $541.900</li>
                                                    </ul>

                                                    <div class="card-footer" id="footer-card-inter"
                                                        name="footer-card-inter">
                                                        <small class="text-muted">Actualizado hace: 0 minutos.</small>
                                                        <a calss="btn" href="#" onclick=""><i
                                                                class="fas fa-sync-alt"></i></a>
                                                    </div>
                                                </div>
                                                <!-- Aqui termina otra card -->
                                                <div class="card mb-3 bg-light card-animated-tecnoricel"
                                                    style="max-width: 15rem;">
                                                    <div class="card-header">
                                                        <img src="img/logo-bancolombia2.png" width="50" height="50"
                                                            class="card-img-top" alt="...">
                                                    </div>
                                                    <ul class="list-group list-group-flush" id="resultadoBancolombia">
                                                        <li class="list-group-item bg-light" id="valorB">Equipos: $0,00
                                                        </li>
                                                        <li class="list-group-item bg-light">CS Sim: $30.000</li>
                                                        <li class="list-group-item bg-light">Planes: $61.900</li>
                                                        <li class="list-group-item bg-light">Total: $541.900</li>
                                                    </ul>

                                                    <div class="card-footer" id="footer-card-Bancolombia"
                                                        name="footer-card-bancolombia">
                                                        <small class="text-muted">Actualizado hace: 0 minutos.</small>
                                                        <a calss="btn" href="#" onclick=""><i
                                                                class="fas fa-sync-alt"></i></a>
                                                    </div>
                                                </div>
                                                <!-- Aqui termina otra card -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed"
                                            onclick="cambioIconoAcordeon('acordeonVenta');" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            <i class="fas fa-plus" id="acordeonVenta"></i> Ventas
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordion">
                                    <div class="card-body">

                                        <div class="col-12">
                                            <div class="card-deck">

                                                <div class="form-row">
                                                    <div class="card mb-3 bg-light card-animated-tecnoricel"
                                                        style="max-width: 15rem;">
                                                        <div class="card-header">
                                                            <img src="img/ventas.png" width="50" height="50"
                                                                class="card-img-top" alt="...">
                                                        </div>
                                                        <ul class="list-group list-group-flush" id="resultadoventas">
                                                            <li class="list-group-item bg-light" id="valorV">Equipos:
                                                                $0,00</li>
                                                            <li class="list-group-item bg-light">CS Sim: $30.000</li>
                                                            <li class="list-group-item bg-light">Planes: $61.900</li>
                                                            <li class="list-group-item bg-light">Total: $541.900</li>
                                                        </ul>

                                                        <div class="card-footer" id="footer-card-ventas"
                                                            name="footer-card-ventas">
                                                            <small class="text-muted">Actualizado hace: 0
                                                                minutos.</small>
                                                            <a calss="btn" href="#" onclick=""><i
                                                                    class="fas fa-sync-alt"></i></a>
                                                        </div>
                                                    </div>
                                                    <!-- Aqui termina otra card -->
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed"
                                            onclick="cambioIconoAcordeon('acordeoninformes');" data-toggle="collapse"
                                            data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            <i class="fas fa-plus" id="acordeoninformes"></i> Informes
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam commodo ligula in
                                        mauris suscipit consequat. Nulla sed dui lectus. Donec rhoncus nibh sit amet
                                        ligula placerat, eu lacinia eros rutrum. Maecenas vitae purus ipsum. Phasellus
                                        nisl odio, pellentesque eu sodales eu, sollicitudin a enim. Fusce posuere
                                        faucibus lectus at luctus. Nunc id maximus velit. Nullam eu mollis tellus.
                                        Nullam tellus tellus, vestibulum ac turpis et, pellentesque faucibus purus.
                                        Fusce viverra nunc ex, quis imperdiet ante rhoncus nec. Nam rutrum mattis mi,
                                        sed finibus arcu. Nulla mattis eleifend eros, nec pellentesque metus gravida at.
                                        Nunc dignissim vehicula tortor vel placerat.
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>


    </main>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="nuevoclienteclaro"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> Agregar Nuevo Cliente
                        Claro</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" method="POST" id="insertclientform" name="insertclientform">

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Documento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-id-card" id="inputGroupPrepend"></span>
                                    </div>
                                    <input type="number" onfocusout="ValidaSiClienteExiste();" class="form-control"
                                        id="documento" name="documento" placeholder="DOCUMENTO"
                                        aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Nombres</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>

                                    <input type="text" style="text-transform: uppercase;" class="form-control"
                                        id="nombres" name="nombres" placeholder="Nombres" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">*Apellidos</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input type="text" style="text-transform: uppercase;" class="form-control"
                                        id="apellidos" name="apellidos" placeholder="Apellidos" required>
                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Fecha Nacimiento</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-calendar" id="inputGroupPrepend"></span>

                                    <input type="date" name="FechaNac" style="text-transform: uppercase;"
                                        class="form-control" id="FechaNac" aria-describedby="inputGroupPrepend"
                                        required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Fecha Expedición</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-calendar" id="inputGroupPrepend"></span>

                                    <input type="date" name="FechaExp" style="text-transform: uppercase;"
                                        class="form-control" id="FechaExp" aria-describedby="inputGroupPrepend"
                                        required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Télefono</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-phone-square" id="inputGroupPrepend"></span>

                                    <input type="tel" class="form-control" id="tel" name="tel" placeholder="TÉLEFONO"
                                        aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Lugar Nacimiento</label>
                                <div class="input-group-prepend">
                                    <span class="fa fa-map-marker input-group-text" id="inputGroupPrepend"></span>

                                    <input type="text" class="form-control" id="LugarNac" name="LugarNac"
                                        style="text-transform: uppercase;" placeholder="Lugar De Nacimiento"
                                        aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Lugar Expedición</label>
                                <div class="input-group-prepend">
                                    <span class="fa fa-map-marker input-group-text" id="inputGroupPrepend"></span>

                                    <input type="text" class="form-control" id="LugarExp" name="LugarExp"
                                        style="text-transform: uppercase;" placeholder="Lugar De Expedición"
                                        aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Dirección</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-home" id="inputGroupPrepend"></span>

                                    <input type="text" class="form-control" id="direccion" name="direccion"
                                        style="text-transform: uppercase;" placeholder="Dirección"
                                        aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label" for="invalidCheck">
                                    * Todos los campos son obligatorios.
                                </label>

                            </div>
                        </div>


                        <div class="modal-footer">

                            <button type="button" id="save" onclick="validaCamposClienteClaro();" name="save"
                                class="btn btn-success"><img id="esperaClienteGuardar" src=""> Guardar Cliente</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

    <div id="ingEquiFinanciClaro" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-mobile"></i> Vender Equipo Financiado
                        Claro</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" method="POST" id="vendeFinClaro" name="vendeFinClaro">

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Documento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-id-card" id="inputGroupPrepend"></span>
                                    </div>
                                    <input type="number" onfocusout="noHayCliente();" class="form-control"
                                        id="documentoequi" name="documentoequi" placeholder="DOCUMENTO"
                                        aria-describedby="inputGroupPrepend" maxlength="10" required
                                        onkeyup="BuscarCliente();">

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Nombres</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" aria-hidden="true" id="inputGroupPrepend"><i
                                            class="fas fa-user"></i></span>

                                    <input type="text" class="form-control" id="nomclifi" name="nomclifi"
                                        placeholder="NOMBRES" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">*Apellidos</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" aria-hidden="true" id="inputGroupPrepend"><i
                                            class="fas fa-user"></i></span>
                                    <input type="text" style="text-transform: uppercase;"
                                        style="text-transform: uppercase;" class="form-control" id="apeclifi"
                                        name="apeclifi" placeholder="Apellidos" disabled>
                                </div>
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Imei</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text " id="inputGroupPrepend"><i
                                            class="fas fa-barcode"></i></span>
                                    <input name="imei" style="text-transform: uppercase;" class="form-control" id="imei"
                                        aria-describedby="inputGroupPrepend" placeholder="IMEI" required
                                        onfocusout="BuscarImeiClaro();"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        type="number" maxlength="15">

                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Equipo </label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-mobile"></i></span>

                                    <input type="text" name="equipo" style="text-transform: uppercase;"
                                        class="form-control" id="equipo" aria-describedby="inputGroupPrepend"
                                        placeholder="EQUIPO A VENDER" disabled required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Cuota Inicial</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-dollar-sign"></i></span>

                                    <input type="number" class="form-control" id="incuota" name="incuota"
                                        placeholder="CUOTA INICIAL" aria-describedby="inputGroupPrepend" required
                                        onfocusout="convierteMoneda(this);" value="0"
                                        onfocus="quiteMonedaParaEditar(this);">

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Valor Cuota</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-dollar-sign"></i></span>

                                    <input type="number" class="form-control" id="valcuota" name="valcuota"
                                        style="text-transform: uppercase;" value="0" placeholder="VALOR CUOTA"
                                        aria-describedby="inputGroupPrepend" onfocusout="convierteMoneda(this);"
                                        required onfocus="quiteMonedaParaEditar(this);">

                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Total Cuotas</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-hand-holding-usd"></i></span>
                                    <input type="number" class="form-control" id="tcuotas" name="tcuotas"
                                        style="text-transform: uppercase;" placeholder="TOTAL CUOTAS"
                                        aria-describedby="inputGroupPrepend" required>
                                    <input type="hidden" id="proveedorEquipoAVender" name="proveedorEquipoAVender">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Simcard</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-sim-card"></i></span>

                                    <input type="number" value="0" class="form-control" id="simcard" name="simcard"
                                        style="text-transform: uppercase;" placeholder="SERIAL DE SIMCARD"
                                        aria-describedby="inputGroupPrepend" required
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        type="number" maxlength="17">

                                </div>

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Incremento</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-dollar-sign"></i></span>

                                    <input type="number" value="0" class="form-control" id="incremento"
                                        name="incremento" style="text-transform: uppercase;" placeholder="INCREMENTO"
                                        aria-describedby="inputGroupPrepend" onfocusout="convierteMoneda(this);"
                                        required onfocus="quiteMonedaParaEditar(this);">

                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Valor Sim</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-dollar-sign"></i></span>
                                    <input type="number" class="form-control" id="valsim" name="valsim"
                                        style="text-transform: uppercase;" placeholder="VALOR SIM"
                                        aria-describedby="inputGroupPrepend" onfocusout="convierteMoneda(this);"
                                        required onfocus="quiteMonedaParaEditar(this);" value="0">

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Plan</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-home" id="inputGroupPrepend"></span>

                                    <select name="tipoDocumento" id="tipoDocumento" class="form-control">
                                        <option>.::SELECCIONA::.</option>
                                        <option>PREPAGO</option>
                                        <option>REPOSICION</option>
                                        <option>PLAN Y EQUIPO</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3"> <label class="label" for="invalidCheck">
                                    * Campos Obligatorios.
                                </label>
                            </div>
                            <div class="col-md-4 mb-3 d-flex justify-content-end">
                                Total A Cobrar:

                            </div>
                            <div class="col-md-4 mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-dollar-sign"></i></span>

                                    <input tipe="number" value="0" class="form-control" placeholder="Total Cobrado"
                                        id="total" name="total" readonly>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">

                            <div class="form-check">
                            </div>
                        </div>
                        <div id="resultadoventafinanciado" class="container text-center " style="font-size: 1rem;">

                            <input type="hidden" name="idequipo" id="idequipo" />


                        </div>
                    </form>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Cancelar</button>
                    <button type="button" id="vendeequipo" name="vendeequipo" class="btn btn-success"
                        onclick="validaCamposFinanciado()"><i class="fa fa-shopping-cart"></i><img id="mi_imagen"
                            src=""> Vender Celular</button>
                </div>
            </div>

        </div>

    </div>


    <div id="ingresareferencia" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fas fa-plus"></i>

                        Agregar Referencia De Pago</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" method="POST" id="inserteref" name="inserteref">

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Documento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-id-card" id="inputGroupPrepend"></span>
                                    </div>
                                    <input type="number" class="form-control" id="docuref" name="docuref"
                                        placeholder="DOCUMENTO" maxlength="10" aria-describedby="inputGroupPrepend"
                                        required onfocusout="ConsultaIngresaRef();">

                                </div>
                            </div>
                            <div class="col-md-8 mb-2">
                                <label for="validationCustom01">*Nombres</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" aria-hidden="true" id="inputGroupPrepend"><i
                                            class="fas fa-user"></i></span>

                                    <input type="text" class="form-control" id="clientenombre" name="nombrecliente"
                                        placeholder="NOMBRE DEL CLIENTE" disabled>
                                </div>
                            </div>


                        </div>

                        <div class="form-row">

                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Imei</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text " id="inputGroupPrepend"><i
                                            class="fas fa-barcode"></i></span>
                                    <input type="number" name="imeiref" style="text-transform: uppercase;"
                                        class="form-control" id="imeiref" aria-describedby="inputGroupPrepend"
                                        placeholder="IMEI" required disabled>

                                </div>
                            </div>

                            <div class="col-md-8 mb-2">
                                <label for="validationCustomUsername">*Equipo </label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-mobile"></i></span>

                                    <input type="text" name="equiporef" style="text-transform: uppercase;"
                                        class="form-control" id="equiporef" aria-describedby="inputGroupPrepend"
                                        placeholder="EQUIPO A VENDIDO" disabled required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Referencia De Pago</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-file-invoice-dollar"></i></span>

                                    <input type="number" class="form-control" id="refpago" name="refpago"
                                        placeholder="REFERENCIA DE PAGO" aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Día De Pago</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-calendar-alt"></i></span>

                                    <input type="text" class="form-control" id="diapago" name="diapago"
                                        style="text-transform: uppercase;" placeholder="DÍA DE PAGO"
                                        aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>



                            <div class="col-md-4 mb-3"> <label class="label" for="invalidCheck">
                                    * Campos Obligatorios.
                                </label>



                            </div>

                        </div>

                        <div class="form-group">

                            <div class="form-check">
                            </div>
                        </div>
                        <div id="resultadoref" class="container text-center " style="font-size: 1rem;">

                        </div>
                        <input type="hidden" name="idref" id="idref" />
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Cancelar</button>
                    <button type="button" id="asignaref" name="asignaref" class="btn btn-success"><i
                            class="fas fa-plus"></i> Asignar Referencia</button>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="ingresaNuevoCelClaro"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> Agregar Nuevo Celular
                        Claro</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body ui-front">
                    <form class="needs-validation" method="POST" id="insertcelClaroform" name="insertcelClaroform">

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Marca</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fas fa-industry" id="inputGroupPrepend"></span>
                                    </div>
                                    <input type="text" class="form-control" id="marcacelclaro"
                                        style="text-transform: uppercase;"
                                        onkeyup="autoCompletar(this,'queHacer=autoCompleteMarcaCelClaro');"
                                        name="marcacelclaro" placeholder="MARCA" required>

                                </div>
                            </div>


                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Modelo</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fas fa-mobile" aria-hidden="true"
                                        id="inputGroupPrepend"></span>

                                    <input type="text" style="text-transform: uppercase;" class="form-control"
                                        onkeyup="autoCompletar(this,'queHacer=autoCompleteModeloCelClaro');"
                                        id="modelocelclaro" name="modelocelclaro" placeholder="MODELO" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">*Color</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input type="text" onkeyup="autoCompletar(this,'queHacer=autoCompletarColor');"
                                        style="text-transform: uppercase;" class="form-control" id="colorcelclaro"
                                        name="colorcelclaro" placeholder="COLOR" required>
                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Imei</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-calendar" id="inputGroupPrepend"></span>

                                    <input type="number" autocomplete="on" name="imeiNuevoCelClaro"
                                        style="text-transform: uppercase;" placeholder="IMEI" class="form-control"
                                        id="imeiNuevoCelClaro" aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Fecha Vencimiento</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-calendar" id="inputGroupPrepend"></span>

                                    <input type="date" autocomplete="on" name="fechavence"
                                        style="text-transform: uppercase;" class="form-control" id="fechavence"
                                        aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*incremento</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-phone-square" id="inputGroupPrepend"></span>

                                    <input type="number" autocomplete="on" class="form-control" id="incrementocel"
                                        name="incrementocel" placeholder="INCREMENTO"
                                        aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Distribuidor</label>
                                <div class="input-group-prepend">
                                    <span class="fa fa-map-marker input-group-text" id="inputGroupPrepend"></span>

                                    <input type="text" autocomplete="on" class="form-control" id="distribuidor"
                                        name="distribuidor" style="text-transform: uppercase;"
                                        placeholder="DISTRUBUIDOR" aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Almacen</label>
                                <div class="input-group-prepend">
                                    <span class="fa fa-map-marker input-group-text" id="inputGroupPrepend"></span>

                                    <input type="text" value="<?php echo $almacen; ?>" class="form-control" id="almacen"
                                        name="almacen" style="text-transform: uppercase;" placeholder="ALMACEN"
                                        aria-describedby="inputGroupPrepend" disabled required>

                                </div>

                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="hidden">
                                <div class="input-group-prepend">

                                    <label>* Campos Obligatorios</label>
                                </div>

                            </div>

                        </div>


                        <div class="modal-footer">

                            <button type="submit" id="saveCelClaro" onclick="validaCamposIngresaCelClaro();"
                                name="saveCelClaro" class="btn btn-success"><img id="esperaCelGuardar" src="">
                                <span class="fas fa-save" role="status" aria-hidden="true"></span>
                                Guardar Celular</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

                        </div>

                    </form>

                </div>
            </div>
        </div>




        <div id="nuevoImpuestoVhicular" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus "></i> <i class="fas fa-car"></i>
                            Nuevo Pago Impuesto Vehicular </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" method="POST" id="newImpuesto" name="newImpuesto">

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Placa</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text fa fa-id-card" id="inputGroupPrepend"></span>
                                        </div>
                                        <input type="text" class="form-control" id="placaimp" name="placaimp"
                                            placeholder="PLACA" aria-describedby="inputGroupPrepend" maxlength="10"
                                            required>

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Marca</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" aria-hidden="true" id="inputGroupPrepend"><i
                                                class="fas fa-user"></i></span>

                                        <input type="text" class="form-control" id="marcaImp" name="marcaImp"
                                            placeholder="MARCA" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom02">*Modelo</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" aria-hidden="true" id="inputGroupPrepend"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" style="text-transform: uppercase;"
                                            style="text-transform: uppercase;" class="form-control" id="modeloImp"
                                            name="modeloImp" placeholder="MODELO" required>
                                    </div>
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Modelo </label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-mobile"></i></span>

                                        <input type="text" name="modeloimp" style="text-transform: uppercase;"
                                            class="form-control" id="modeloimp" aria-describedby="inputGroupPrepend"
                                            placeholder="MODELO" required>

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Departamento</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-dollar-sign"></i></span>

                                        <input type="text" class="form-control" id="depimp" name="depimp"
                                            placeholder="DEPARTAMENTO" aria-describedby="inputGroupPrepend" required>

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Transito</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-dollar-sign"></i></span>

                                        <input type="text" autocomplete="yes" class="form-control" id="tranimp"
                                            name="tranimp" style="text-transform: uppercase;" placeholder="Transito"
                                            aria-describedby="inputGroupPrepend" required>

                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Valor</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-hand-holding-usd"></i></span>
                                        <input type="number" class="form-control" id="valorImp" name="valorImp"
                                            style="text-transform: uppercase;" placeholder="VALOR IMPUESTO"
                                            aria-describedby="inputGroupPrepend" required>

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Cobro Por Pago</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-sim-card"></i></span>

                                        <input type="number" value="0" class="form-control" id="totalImpC"
                                            name="totalImpC" placeholder="COBRO POR PAGO"
                                            aria-describedby="inputGroupPrepend" required
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            type="number" maxlength="17">

                                    </div>

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Año a pagar</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-sim-card"></i></span>

                                        <input type="number" class="form-control" id="anioAPagar" name="anioAPagar"
                                            placeholder="AÑO A PAGAR" aria-describedby="inputGroupPrepend" required
                                            type="number" maxlength="17">

                                    </div>

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Transito</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-sim-card"></i></span>

                                        <input type="text" class="form-control" id="transito" name="transito"
                                            placeholder="TRANSITO" aria-describedby="inputGroupPrepend" required
                                            maxlength="17">

                                    </div>

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Documento</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-sim-card"></i></span>

                                        <input type="number" class="form-control" id="docimpu" name="docimpu"
                                            placeholder="DOCUMENTO" aria-describedby="inputGroupPrepend" required
                                            maxlength="17">

                                    </div>

                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Nombre</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-sim-card"></i></span>

                                        <input type="text" class="form-control" id="nomcliimp" name="nomcliimp"
                                            placeholder="NOMBRES" aria-describedby="inputGroupPrepend" required
                                            maxlength="17">

                                    </div>

                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Apellidos</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-sim-card"></i></span>

                                        <input type="text" class="form-control" id="apecliimp" name="apecliimp"
                                            placeholder="APELLIDOS" aria-describedby="inputGroupPrepend" required
                                            maxlength="17">

                                    </div>

                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Tipo de vehiculo</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-sim-card"></i></span>
                                        <select name="tipoVehiculo" id="tipoVehiculo" class="form-control">
                                            <option>.::SELECCIONA::.</option>
                                            <option>MOTO</option>
                                            <option>CARRO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Total a cobrar</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="fas fa-dollar-sign"></i></span>
                                        <input tipe="number" value="0" class="form-control" placeholder="Total Cobrado"
                                            id="SumImp" name="SumImp" readonly>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-4 mb-3"> <label class="label" for="invalidCheck">
                                    * Campos Obligatorios.
                                </label>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-ban"></i>
                            Cancelar</button>

                        <button type="submit" onclick="validarCamposVacios(this);" id="vendeIMP" name="vendeIMP"
                            name="vendeIMP" class="btn btn-success" <i class="fa fa-shopping-cart"></i><img id="mi_img"
                                src=""> Generar
                            Recibo</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>



        <div class="modal fade bd-example-modal-lg" tabindex="-1" id="nuevaRepoSim" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="fas fa-sim-card"></i> </i><i
                                class="fas fa-exchange-alt"></i> <i class="fas fa-sim-card"></i> <i
                                class="fas fa-plus"></i>
                            Reposición De Simcard
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" method="POST" id="insertrepoSim" name="insertrepoSim">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Documento</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text fa fa-id-card" id="inputGroupPrepend"></span>
                                        </div>
                                        <input type="number" onfocusout="ValidaSiClienteExiste(this);"
                                            class="form-control" id="documentoSim" name="documentoSIm"
                                            placeholder="DOCUMENTO" aria-describedby="inputGroupPrepend" required>

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Nombres</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>

                                        <input type="text" style="text-transform: uppercase;" class="form-control"
                                            id="nombresSim" name="nombresSIm" placeholder="Nombres" disabled required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom02">*Apellidos</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" style="text-transform: uppercase;" disabled
                                            class="form-control" id="apellidosSim" name="apellidosSim"
                                            placeholder="Apellidos" required>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Número Recuperado</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-calendar" id="inputGroupPrepend"></span>

                                        <input type="numb" name="Numero" style="text-transform: uppercase;"
                                            class="form-control" id="Numero" aria-describedby="inputGroupPrepend"
                                            placeholder="# A RECUPERAR" required>

                                    </div>

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Simcard Nueva</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-calendar" id="inputGroupPrepend"></span>

                                        <input type="text" name="Simcard" style="text-transform: uppercase;"
                                            class="form-control" id="Simcard" aria-describedby="inputGroupPrepend"
                                            placeholder="NUEVA SIMCARD" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Valor Sim</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-phone-square" id="inputGroupPrepend"></span>

                                        <input type="number" class="form-control" id="valSimRepo" name="valSimRepo"
                                            placeholder="VALOR SIM" aria-describedby="inputGroupPrepend" required>

                                    </div>
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Plan</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-home" id="inputGroupPrepend"></span>

                                        <select name="PlanSimRepo" id="PlanSimRepo" class="form-control">
                                            <option>.::SELECCIONA::.</option>
                                            <option>PREPAGO</option>
                                            <option>POSTPAGO</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label" for="invalidCheck">
                                            * Todos los campos son obligatorios.
                                        </label>

                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="button" id="saveRepoSim" onclick="saveRepoSimClaro();" name="saveReposim"
                                    class="btn btn-success">
                                    <i id="saverep" class="fa fa-save"></i> Guardar Reposición</button>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade bd-example-modal-lg" tabindex="-1" id="nuevaSim" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"> <i class="fas fa-sim-card"></i> <i
                                class="fas fa-plus"></i>
                            Nueva Simcard Simcard </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" method="POST" id="insertSim" name="insertSim">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">*Distribuidor</label>
                                    <div class="input-group-prepend  text-center ">
                                        <span class="input-group-text d-block fas fa-store fa-lg"
                                            id="inputGroupPrepend"></span>
                                        <select name="distribuidorSim" id="distribuidorSim" class="form-control">
                                            <option>.::SELECCIONA::.</option>
                                            <?php while($row = $resultadoPro-> fetch_assoc()){ ?>
                                            <option><?php echo $row['Nombre']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Tipo</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>

                                        <select name="tipoSim" id="tipoSim" class="form-control">
                                            <option>.::SELECCIONA::.</option>
                                            <option>POSTPAGO</option>
                                            <option>CAMBIO DE SERVICIO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom02">*Costo</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="number" style="text-transform: uppercase;" class="form-control"
                                            id="costoSimD" name="costoSimD" placeholder="COSTO" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustomUsername">*Valor Público</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text fa fa-calendar" id="inputGroupPrepend"></span>

                                            <input type="numb" name="valSimC" style="text-transform: uppercase;"
                                                class="form-control" id="valSimC" aria-describedby="inputGroupPrepend"
                                                placeholder="VALOR" required>

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustomUsername">*Vence</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text fa fa-calendar" id="inputGroupPrepend"></span>

                                            <input type="date" name="SimVence" style="text-transform: uppercase;"
                                                class="form-control" id="SimVence" aria-describedby="inputGroupPrepend"
                                                required>

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustomUsername">*Cantidad</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text fa fa-phone-square"
                                                id="inputGroupPrepend"></span>

                                            <input type="number" class="form-control" id="cantSim" name="cantSim"
                                                placeholder="CANTIDAD" aria-describedby="inputGroupPrepend" required>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label" for="invalidCheck">
                                                * Todos los campos son obligatorios.
                                            </label>

                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="button" id="saveSim" onclick="validarCamposVacios(this);" name="saveSim"
                                    class="btn btn-success"><img id="esperaSimGuardar" src=""> Guardar Simcard</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>






    <div class="modal fade bd-example-modal-lg" tabindex="-1" id="cuadreDistribuidoresClaro" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> <i class="fas fa-sim-card"></i> <i
                            class="fas fa-plus"></i>
                        Cuadre Distribuidores Claro </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" method="POST" id="cuadreDistClaro" name="cuadreDistClaro">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Distribuidor</label>
                                <div class="input-group-prepend  text-center ">
                                    <span class="input-group-text d-block fas fa-store fa-lg"
                                        id="inputGroupPrepend"></span>
                                    <select name="distribuidorcuadre" id="distribuidorcuadre" class="form-control">
                                        <option>.::SELECCIONA::.</option>
                                        <?php while($row = $resultadoPro2-> fetch_assoc()){ ?>
                                        <option><?php echo $row['Nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Desde</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input class="form-control" type="date" id="desdecuadredist" name="desdecuadredist"
                                        required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">*Hasta</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input type="date" class="form-control" id="hastacuadredist" name="hastacuadredist"
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label" for="invalidCheck">
                                        * Todos los campos son obligatorios.
                                    </label>

                                </div>
                            </div>

                        </div>


                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="saveSi" onclick="consultarDeudaDistribuidor();" name="saveSi"
                        class="btn btn-success"><img id="esperaConsultaDistribuidor" src=""> Consultar</button>
                </div>
                </form>
            </div>
        </div>


    </div>
    </div>
    </div>






    <div class="modal fade bd-example-modal-lg" data-backdrop="static" tabindex="-1" data-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="equiposDisponibles">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></i> <i class="fas fa-home"></i>
                        Equipos Claro Disponibles </h4>

                    <button type="button" onclick="limpiarModal();" class="close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="controlesBuscaEquipos">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Distribuidor</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-home" id="inputGroupPrepend"></span>

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
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Marca</label>

                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-home" id="inputGroupPrepend"></span>

                                    <select name="marcaSelectEquipos" id="marcaSelectEquipos" class="form-control">
                                        <option>.::SELECCIONA::.</option>
                                        <option>PREPAGO</option>
                                        <option>REPOSICION</option>
                                        <option>PLAN Y EQUIPO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="todosLosEquiposResultado">
                        <div class="text-center">
                            <div class="spinner-border text-success" style="width: 6rem; height: 6rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>





                    </div>

                    <div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="limpiarModal();" data-dismiss="modal"><i
                            class="fas fa-times"></i> Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    </div>




    </div>
    </div>
    </div>

    <div class="modal fade bd-example-modal-lg clientesAdmin" data-backdrop="static" tabindex="-1" data-keyboard="false"
        role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="equiposDisponibles">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></i> <i class="fas fa-home"></i>
                        Administrar Clientes </h4>

                    <button type="button" onclick="limpiarModal();" class="close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="controlesBuscaEquipos">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Documento</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input type="number" class="form-control " placeholder="DOCUMENTO"
                                        name="docuclienteadmin" id="docuclienteadmin">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Nombres</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input type="text" class="form-control " placeholder="NOMBRES"
                                        name="nombreclienteadmin" id="nombreclienteadmin">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Apllidos</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input type="text" class="form-control " placeholder="APELLIDOS"
                                        name="apellidosclienteadmin" id="apellidosclienteadmin">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="resultadoClientes">
                    <div class="text-center">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="limpiarModal();" data-dismiss="modal"><i
                            class="fas fa-times"></i> Cerrar</button>

                </div>
            </div>
        </div>
    </div>



    <div class="modal fade bd-example-modal-lg clientesAdmin" data-backdrop="static" tabindex="-1" data-keyboard="false"
        role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="equiposDisponibles">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></i> <i class="fas fa-home"></i>
                        Administrar Clientes </h4>

                    <button type="button" onclick="limpiarModal();" class="close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="controlesBuscaEquipos">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Documento</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input type="number" class="form-control " placeholder="DOCUMENTO"
                                        name="docclienteAdmin" id="docclienteAdmin">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Nombres</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input type="text" class="form-control " placeholder="NOMBRES" name="fullnameadmin"
                                        id="fullnameadmin">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Apllidos</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input type="text" class="form-control " placeholder="APELLIDOS" name="apcliadmin"
                                        id="apcliadmin">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="resultadoClientes">
                    <div class="text-center">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="limpiarModal();" data-dismiss="modal"><i
                            class="fas fa-times"></i> Cerrar</button>

                </div>
            </div>
        </div>
    </div>









    <div class="modal fade bd-example-modal-lg facturacion" data-backdrop="static" tabindex="-1" data-keyboard="false"
        role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="facturacion">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></i> <i class="fas fa-home"></i>
                        Factura:&nbsp;</h4>

                    <h4 class="modal-title" id="numFac">
                        <h4 class="modal-title">&nbsp;Total:&nbsp;</h4>

                        <h4 class="modal-title" id="totalfacCobrar">

                        </h4>

                    </h4>

                    <button type="button" onclick="limpiarModal();" class="close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div id="formVender">
                        <form class="needs-validation" method="POST" id="ventaProductos">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <input type="hidden" name="numeroParaFactura" id="numeroParaFactura">
                                    <input type="hidden" name="barras2" id="barras2">
                                    <input type="hidden" name="garantia" id="garantia">
                                    <label for="validationCustom01">*Cliente</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="number" class="form-control "
                                            onfocusout="buscaClienteFactura(this.value);" placeholder="DOCUMENTO"
                                            name="docclientefactura" id="docclientefactura">
                                    </div>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <label for="validationCustom01">*Nombres Y Apellidos</label>
                                    <div class="input-group-prepend">
                                        <span id="iconCliente" class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" class="form-control " placeholder="NOMBRES Y APELLIDOS"
                                            name="nombreclientefac" id="nombreclientefac" disabled>
                                    </div>
                                </div>

                            </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">*Código De Barras</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text fa fa-user" aria-hidden="true"
                                    id="inputGroupPrepend"></span>
                                <input type="text" class="form-control " onkeyup="detectaKeys(event);"
                                    onfocusout="buscarProducto('facturacion',this.value);" disabled
                                    placeholder="CÓDIGO DE BARRAS" name="codigoBarrasfactura" id="codigoBarrasfactura">
                            </div>
                        </div>
                        <div class="col-md-8 mb-2">
                            <label for="validationCustom01">*Descripción Del Producto</label>
                            <div class="input-group-prepend">
                                <span id="iconProducto" class="input-group-text fa fa-user" aria-hidden="true"
                                    id="inputGroupPrepend"></span>
                                <input type="text" class="form-control " placeholder="DESCRIPCIÓN" name="descripcionfac"
                                    id="descripcionfac" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">*Cantidad</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text fa fa-user" aria-hidden="true"
                                    id="inputGroupPrepend"></span>
                                <input type="number" onfocusout="validaUnidadesAVender();" class="form-control "
                                    placeholder="CANTIDAD" name="cantidadfactura" disabled id="cantidadfactura">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">*Valor a Cobrar </label>
                            <div class="input-group-prepend">
                                <span class="input-group-text fa fa-user" aria-hidden="true"
                                    id="inputGroupPrepend"></span>
                                <input type="text" class="form-control " onfocusout="aMoneda(this);"
                                    onfocus="quiteMonedaParaEditar(this);" placeholder="VALOR" name="valorproducto"
                                    disabled id="valorproducto">
                                <input type="hidden" id="idProductoAVender" name="IdProducto">
                                <input type="hidden" id="valPro">
                                <input type="hidden" id="costo" name="Costo">
                                <input type="hidden" id="tipoPro" name=Tipo>
                                <input type="hidden" id="totalFac" name="totalFac">
                            </div>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">*Disponibles</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text fa fa-user" aria-hidden="true"
                                    id="inputGroupPrepend"></span>
                                <input type="text" class="form-control " placeholder="DISPONIBLES" name="dispopro"
                                    id="dispopro" disabled>
                                <input type="hidden" name="cantdisponibles" id="cantdisponibles">
                                <button type="button" id="btn-addpro" disabled
                                    onclick="verificarCampos('validarCamposParaAgregarProductosAFactura');"
                                    class="btn btn-success">
                                    <span id="btn-add-pro-fac" class="" role="status" aria-hidden="true"></span>

                                    <span class="fas fa-plus" role="status" aria-hidden="true"></span>


                                </button>
                            </div>
                        </div>
                    </div>


                    <div id="resultadoFacturacion">
                        <div class="text-center">

                            <div id="elementosFactura">
                                <h4>No Hay Productos Agregados....</h4>

                            </div>
                        </div>
                        </form>

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="limpiarModal();" data-dismiss="modal"><i
                            class="fas fa-times"></i> Cerrar</button>
                    <button type="button" onclick="validaSiHayProductosAfacturar(this);" id="saveFactura"
                        class="btn btn-warning"><i class="fas fa-save"></i> Guardar</button>
                    <button type="button" class="btn btn-success" id="imprimirFacturVenta"
                        onclick="validaSiHayProductosAfacturar(this);"><i class="fas fa-print"></i> Terminar e
                        imprimir</button>


                </div>
            </div>
        </div>
    </div>




    <div class="modal fade bd-example-modal-lg reimprimir" data-backdrop="static" tabindex="-1" data-keyboard="false"
        role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="reimprimir">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></i> <i class="fas fa-home"></i>
                        Reimprimir Facturas</h4>

                    <button type="button" onclick="limpiarModal();" class="close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div id="formVender">
                        <form class="needs-validation" method="POST" id="Reimprimir">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">

                                    <label for="validationCustom01">*Factura</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="number" class="form-control " onfocusout="" placeholder="FACTURA"
                                            name="facturaReimprimir" id="facturarReimprimir">
                                        <button type="button" class="btn btn-success" id="searchFacturaImprimir"
                                            onclick="buscarFactura(this);"><span class="fa fa-search"></span></button>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">

                                    <label for="validationCustom01">*Documento Cliente</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="number" class="form-control " onfocusout="" placeholder="DOCUMENTO"
                                            name="docReimprimir" id="docReimprimir">
                                        <button type="button" class="btn btn-success" id="searchdocFacturaImprimir"
                                            onclick="buscarFactura(this);"><span class="fa fa-search"></span></button>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Fecha</label>
                                    <div class="input-group-prepend">
                                        <input type="date" class="form-control" name="dateRePrint" id="dateRePrint"
                                            style="text-transform: UPPERCASE;" aria-describedby="buscarFechaFac">
                                        <button class="btn btn-success fa fa-search" onclick="buscarFactura(this);"
                                            type="button" id="buscarFechaFac"></button>
                                    </div>
                                </div>

                            </div>

                    </div>


                    <div id="elementosFactur">
                        <div class="text-center">

                            <div id="elementosFacture">
                                <h4>No Hay Facturas Encontradas....</h4>

                            </div>
                        </div>
                        </form>

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="limpiarModal();" data-dismiss="modal"><i
                            class="fas fa-times"></i> Cerrar</button>


                </div>
            </div>
        </div>
    </div>





    <div class="modal fade bd-example-modal-lg nuevoProducto" tabindex="-1" data-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="nuevoProducto">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></i> <i class="fas fa-home fas fa-plus"></i>
                        Nuevo Producto</h4>

                    <button type="button" onclick="limpiarModal();" class="close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div id="formNewProduct">
                        <form class="needs-validation" autocomplete="on" method="POST" id="newProduct">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Tipo</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required style="text-transform: UPPERCASE;"
                                            class="form-control " onfocusout="" placeholder="TIPO" name="tipoProduct"
                                            id="tipoProduct">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">

                                    <label for="validationCustom01">*Marca</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required style="text-transform: UPPERCASE;"
                                            class="form-control " onfocusout="" placeholder="MARCA" name="marcaProduct"
                                            id="marcaProduct">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Modelo</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required style="text-transform: UPPERCASE;"
                                            class="form-control " onfocusout="" placeholder="MODELO"
                                            name="modeloProduct" id="modeloProduct">
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Proveedor</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <select name="proveedorProduct" id="proveedorProduct" class="form-control">
                                            <option>.::SELECCIONA::.</option>
                                            <?php while($row5 = $resultadoPro4-> fetch_assoc()){ ?>
                                            <option><?php echo $row5['Nombre']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Costo</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-dollar-sign" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="number" required style="text-transform: UPPERCASE;"
                                            class="form-control " onfocusout="" placeholder="COSTO" name="costoProduct"
                                            id="costoProduct">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Valor</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-dollar-sign" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required style="text-transform: UPPERCASE;"
                                            class="form-control " onfocusout="" placeholder="VALOR" name="valorProduct"
                                            id="valorProduct">
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Unidades</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="number" required style="text-transform: UPPERCASE;"
                                            class="form-control " onfocusout="" placeholder="UNIDADES"
                                            name="unidProduct" id="unidProduct">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Código </label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-barcode" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="number" required style="text-transform: UPPERCASE;"
                                            class="form-control " onfocusout="" disabled placeholder="CODIGO"
                                            name="codigoProduct" id="codigoProduct">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3"> <label class="label" for="invalidCheck">
                                        * Campos Obligatorios.
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" onclick="limpiarModal();"
                                    data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                                <button type="submit" id="saveProduct" onclick="verificarCampos('guardarProductos');"
                                    class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>








    <div class="modal fade bd-example-modal-lg generaEtiquetas" tabindex="-1" data-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="generaEtiquetas">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></i> <i class="fas fa-barcode fas fa-file-excel"></i>
                        Generar Archivo Excel Para Etiquetas Zebra</h4>

                    <button type="button" onclick="" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div id="nuewfileEtiquetas">
                        <form class="needs-validation" autocomplete="on" method="POST" id="newFileEtiquetasExcel">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Desde</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-calendar" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="date" required style="text-transform: UPPERCASE;"
                                            class="form-control " name="desdeEtiqueta" id="desdeEtiqueta">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">

                                    <label for="validationCustom01">*Hasta</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-calendar" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="date" required style="text-transform: UPPERCASE;"
                                            class="form-control " onfocusout="" name="hastaEtiquetas"
                                            id="hastaEtiquetas">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Campos Obligatorios</label>
                                    <div class="input-group-prepend">

                                        <input type="button" class="btn btn-success" onclick="generarEtiquetas();"
                                            id="genereEtiqueta" value="Generar Archivo">
                                    </div>
                                </div>

                            </div>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" onclick="limpiarModal();"
                                    data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>













    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="nuevoCelularLibre"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> Agregar Nuevo Celular
                        Libre</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" autocomplete="on" method="POST" id="nuevoCelLibre"
                        name="nuevoCelLibre">

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Marca</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fas fa-industry" id="inputGroupPrepend"></span>
                                    </div>
                                    <input type="text" placeholder="MARCA" style="text-transform: uppercase;"
                                        autocomplete="on" class="form-control" id="marcaLibre" name="marcaLibre"
                                        aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">*Modelo</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fas fa-mobile" aria-hidden="true"
                                        id="inputGroupPrepend"></span>

                                    <input type="text" style="text-transform: uppercase;" class="form-control"
                                        id="modeloLibre" name="modeloLibre" placeholder="MODELO" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">*Color</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fas fa-palette" aria-hidden="true"
                                        id="inputGroupPrepend"></span>
                                    <input type="text" style="text-transform: uppercase;" class="form-control"
                                        id="colorLibre" name="colorLibre" placeholder="COLOR" required>
                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Distribuidor</label>
                                <div class="input-group-prepend  text-center ">
                                    <span class="input-group-text d-block fas fa-store fa-lg"
                                        id="inputGroupPrepend"></span>
                                    <select name="proveedorLibre" id="proveedorLibre" class="form-control">
                                        <option>.::SELECCIONA::.</option>
                                        <?php while($row1 = $resultadoProveesdores-> fetch_assoc()){ ?>
                                        <option><?php echo $row1['Nombre']; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Costo</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fas fa-dollar-sign" id="inputGroupPrepend"></span>

                                    <input type="number" name="costoLibre" style="text-transform: uppercase;"
                                        class="form-control" id="costoLibre" aria-describedby="inputGroupPrepend"
                                        autocomplete="on" placeholder="COSTO" required>

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Valor</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fas fa-dollar-sign" id="inputGroupPrepend"></span>

                                    <input type="number" class="form-control" id="valorLibre" name="valorLibre"
                                        placeholder="VALOR PÚBLICO" aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Doble SIm?</label>
                                <div class="col-sm-1 px-md-3 p-0 ">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                            id="myonoffswitch" unchecked>
                                        <label class="onoffswitch-label" for="myonoffswitch">
                                            <div class="onoffswitch-inner"></div>
                                            <div class="onoffswitch-switch"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Garantia</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text fas fa-dollar-sign" id="inputGroupPrepend"></span>

                                    <input type="number" class="form-control" id="garantialibre" name="garantialibre"
                                        placeholder="GARANTIA" aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>


                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">*Unidades</label>
                                <div class="input-group-prepend">
                                    <span class="fas fa-sort-amount-up input-group-text" id="inputGroupPrepend"></span>

                                    <input type="number" class="form-control" id="cantLibre" name="cantLibre"
                                        style="text-transform: uppercase;" placeholder="UNIDADES"
                                        aria-describedby="inputGroupPrepend" required>

                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label" for="invalidCheck">
                                    * Todos los campos son obligatorios.
                                </label>

                            </div>
                        </div>


                        <div class="modal-footer">

                            <button type="button" id="LL" onclick="addImeisLibre();" name="LL"
                                class="btn btn-success"><img id="esperaClienteGuardar" src=""> Guardar Cliente</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>








    <div class="modal fade bd-example-modal-lg " tabindex="-1" data-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="nuevoGasto">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="h4modal"></i> <i class=" fas fa-plus"></i>
                        Nuevo Gasto</h4>

                    <button type="button" onclick="" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div id="nuewgasto">
                        <form class="needs-validation" autocomplete="on" method="POST" id="newGastoForm">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Descripción</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-calendar" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required placeholder="DESCRIPCION"
                                            style="text-transform: UPPERCASE;" class="form-control "
                                            name="descripcionGasto" id="descripcionGasto">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">

                                    <label for="validationCustom01">*Valor</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-dollar" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="number" required placeholder="VALOR"
                                            style="text-transform: UPPERCASE;" class="form-control " onfocusout=""
                                            name="valorGasto" id="valorGasto">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Comentario</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-comments" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required placeholder="COMENTARIO"
                                            style="text-transform: UPPERCASE;" class="form-control" id="comentarioGasto"
                                            name="comentarioGasto">
                                    </div>
                                </div>

                            </div>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" onclick="limpiarModal();"
                                    data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                                <button type="button" class="btn btn-success" onclick="guardaGasto();"><i id="savega"
                                        class="fas fa-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>






    <div class="modal fade bd-example-modal-lg " tabindex="-1" data-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="productosDisponibles">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="h4modal"></i> <i class=" fas fa-plus"></i>
                        Productos Disponibles Almacen: <?php echo $almacen; ?></h4>

                    <button type="button" onclick="" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div id="dispo">
                        <form class="needs-validation" autocomplete="on" method="POST" id="productosDisponibles">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Tipo</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-calendar" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required placeholder="TIPO"
                                            style="text-transform: UPPERCASE;" class="form-control "
                                            name="tipoSearchProduct" id="tipoSearchProduct">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">

                                    <label for="validationCustom01">*Marca</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-dollar" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required placeholder="MARCA"
                                            style="text-transform: UPPERCASE;" class="form-control " onfocusout=""
                                            name="marcaSearchProduct" id="marcaSearchProduct">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Modelo</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-comments" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required placeholder="Modelo"
                                            style="text-transform: UPPERCASE;" class="form-control"
                                            id="modeloSearchProduct" name="modeloSearchProduct">
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Desde</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-comments" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="date" required placeholder="Modelo"
                                            style="text-transform: UPPERCASE;" class="form-control"
                                            id="desdeSearchProduct" name="desdeSearchProduct">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Hasta</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-comments" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="date" required placeholder="Modelo"
                                            style="text-transform: UPPERCASE;" class="form-control"
                                            id="hastaSearchProduct" name="hastaSearchProduct">
                                    </div>
                                </div>
                            </div>


                            <div id="resProduct">
                                <div class="text-center">
                                    <div class="spinner-border text-success" style="width: 6rem; height: 6rem;"
                                        role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" onclick="limpiarModal();"
                                    data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                                <button type="button" class="btn btn-success" onclick="guardaGasto();"><i id="savega"
                                        class="fas fa-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>






    <div class="modal fade bd-example-modal-lg " tabindex="-1" data-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="nuevoTramite">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="h4modal"></i> <i class=" fas fa-plus"></i>
                        Nuevo Trámite</h4>

                    <button type="button" onclick="" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div id="nuewg">
                        <form class="needs-validation" autocomplete="on" method="POST" id="newTramit">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Trámite</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-calendar" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required placeholder="TRAMITE"
                                            style="text-transform: UPPERCASE;" class="form-control " name="tramit"
                                            id="tramit">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">

                                    <label for="validationCustom01">*Costo</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-dollar" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="number" required placeholder="COSTO"
                                            style="text-transform: UPPERCASE;" class="form-control " onfocusout=""
                                            name="costTramite" id="costTramite">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Valor</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-comments" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="number" required placeholder="VALOR COBRADO"
                                            style="text-transform: UPPERCASE;" class="form-control" id="valorTramit"
                                            name="valorTramit">
                                    </div>
                                </div>

                            </div>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" onclick="limpiarModal();"
                                    data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                                <button type="button" class="btn btn-success" onclick="savetramit();"><i id="savetra"
                                        class="fas fa-save"></i> Guardar Trámite</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>










    <div class="modal fade bd-example-modal-lg nuevoDistribuidor " tabindex="-1" data-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="nuevoDistribuidor">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="h4modal"></i> <i class=" fas fa-plus"></i>
                        Nuevo Distribuidor</h4>

                    <button type="button" onclick="" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div id="nuewg">
                        <form class="needs-validation" autocomplete="on" method="POST" id="newDistri">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Nombre</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-users-cog" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required placeholder="NOMBRE"
                                            style="text-transform: UPPERCASE;" class="form-control " name="distriName"
                                            id="distriName">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">

                                    <label for="validationCustom01">*Ciudad</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-user" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="text" required placeholder="CIUDAD"
                                            style="text-transform: UPPERCASE;" class="form-control " onfocusout=""
                                            name="citydist" id="citydist">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Campos Obligatorios</label>
                                    <div class="input-group-prepend">

                                        <button type="button" onclick="saveDistri();"
                                            class="form-control btn btn-success" id="saveDist"><i id="saveDistIcon"
                                                class="fas fa-save"></i> Guardar</button>
                                    </div>
                                </div>

                            </div>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" onclick="limpiarModal();"
                                    data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>













    <div class="modal fade bd-example-modal-lg  " tabindex="-1" data-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="cajaStatus">
        <div class="modal-dialog modal-lg modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="h4modal"></i> <i class=" fas fa-cash-register"></i>
                        Informe Caja</h4>

                    <button type="button" onclick="" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div id="nuewg">
                        <form class="needs-validation" autocomplete="on" method="POST" id="cajaStatusForm">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Desde</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-calendar" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="date" required style="text-transform: UPPERCASE;"
                                            class="form-control " name="desdeCajaStatus" id="desdeCajaStatus">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">

                                    <label for="validationCustom01">*Hasta</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fa fa-calendar" aria-hidden="true"
                                            id="inputGroupPrepend"></span>
                                        <input type="date" required style="text-transform: UPPERCASE;"
                                            class="form-control " name="hastaCajaStatus" id="hastaCajaStatus">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">*Almacen</label>
                                    <div class="input-group-prepend">
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

                                        <button type="button" onclick="cajaCuadre();"
                                            class="btn btn-success my-2 my-sm-0" id="saveD"> <i id="saveDis"
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>

                            </div>


                            <div id="salesdiv" class="text-center">
                                <H4>SIN RESULTADOS.....</H4>

                            </div>




                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" onclick="limpiarModal();"
                                    data-dismiss="modal"> <i class="fas fa-times"></i> Cerrar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>























    <div class="modal fade bd-example-modal-xl" tabindex="-1" data-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="resultadosBusquedasModal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="h4modal"><i class="fas fa-database"></i>
                        Resultados de busquedas</h4>

                    <button type="button" onclick="" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="resultado" class="text-center" style="font-size: 0.7rem;"></div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="limpiarModal();" data-dismiss="modal"><i
                            class="fas fa-times"></i> Cerrar</button>


                </div>
            </div>
        </div>
    </div>
    </div>









    <footer class="site-footer seccion container">
        <div class="contenedor contenedor-footer">
            <h6 class="copyright" style="text-align: center;">Todos los Derechos Reservados Tecnoricel
                <?php $anio = date('Y'); echo $anio; ?> &copy; </h6>
        </div </footer>



        <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        </script>

        <script src="js/duvan.js"></script>
        <script src="js/app.js"></script>
        <script src="js/animated.js"></script>
        <script src="js/sweetalert2.all.min.js"></script>
        <srcipt src="js/InertEquiClaro.js"></srcipt>
</body>

</html>