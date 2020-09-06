<?php
session_start();

date_default_timezone_set('America/Bogota');
$usuario = $_SESSION['username'];

if(!isset($_SESSION['username'])){
    
}else{
      header('location: index');
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ingreso Tecnoricel</title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.css?v=<?php echo(rand());?>">
    <script src="semantic/dist/semantic.js"></script>

    <link rel="stylesheet" href="css/estilito.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/animate.css">

    <style type="text/css">
    body {
        background-color: #DADADA;
    }

    body>.grid {
        height: 100%;
    }

    .image {
        margin-top: -100px;
    }

    .column {
        max-width: 450px;
    }
    </style>

</head>

<body>
    <div class="pusher">
        <div class="ui inverted menu stackable">
            <div class="header item button-left" style="cursor:pointer;">
                &nbsp; &nbsp; &nbsp; <a
                    style="font-size: 1.6rem; font-family: 'Quicksand', sans-serif;  font-weight: normal;" class="link"
                    href="/"><?php echo 'INVENTARIO' ?></a>
            </div>
        </div>
    </div>
    <!--finaliza la barra superirior-->


    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <h2 class="ui teal image header">

                <div class="content">
                    Inicio de sesión
                </div>
            </h2>
            <form type="POST" class="ui large form" id="login">
                <div class="ui stacked segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" id="email" name="email" placeholder="Correo" onkeyup="detectaKeys(event);">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" id="password" placeholder="Contraseña" onkeyup="detectaKeys(event);">
                        </div>
                    </div>
                    <div class="ui fluid large teal  button" onclick="validaUsuario();">Iniciar Sesión <img
                            id="mi_imagen" src=""></div>
                </div>

                <div class="ui error message"></div>

            </form>

            <div class="ui message">
                Todos los Derechos Reservados Tecnoricel <?php $anio = date('Y'); echo $anio; ?>
                &copy;
            </div>
        </div>
    </div>




    <script src="https://kit.fontawesome.com/b7c6930328.js" crossorigin="anonymous"></script>


    <script src="iniciosesion.js?v=<?php echo(rand());?>"></script>

</body>

</html>