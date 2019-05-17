<?php
    session_start ();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nozzleprint3D</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }

        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content {
            height: 450px
        }

        /* Set gray background color and 100% height */
        .sidenav {
            padding-top: 20px;
            background-color: #f1f1f1;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }

            .row.content {
                height: auto;
            }
        }

        .logo {
            color: black;
        }

        .logo:hover {
            color: black;
        }

        .enlace {
            color: black;
        }

        .enlace:hover {
            color: black;
            background-color: lightgrey;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand logo" href="#">Nozzleprint3D</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                        if(isset($_SESSION['logeado'])){
                            echo "<li><a class='enlace' href='USUARIO/logout.php'>Cerrar Sesión <span class='glyphicon glyphicon-log-out'></span></a></li>";
                        }else{
                            echo "<li><a class='enlace' href='USUARIO/sesionFormulario.php'>Iniciar Sesión <span class='glyphicon glyphicon-log-in'></span></a></li>";            
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid text-center">
        <div class="row content">
            <div class="col-sm-12 text-center">
                <h1>Bienvenido a Nozzleprint3D</h1>
                <p>Bienvenido a la mejor red social que hay de modelos de objetos de impresoras 3D, aqui tendrás lo mejor de cada producto.</p>
            </div>
        </div>
    </div>

    <footer class="container-fluid footer-inverse text-center">
        <p>Pagina creada por David Beato y Carlos Rincón</p>
    </footer>

</body>

</html>