<!DOCTYPE html>
<html lang="en">
<?php
  require_once "../BBDD/model.php";
  require_once "../BBDD/config.php";

  $conexion = new Model(Config::$host, Config::$user, Config::$pass, Config::$nombreBase);
	//Sesion
    session_start ();
    if(!isset($_SESSION["logeado"])){
		header("Location: ../index.php");
	}
?>
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

        #fotoPerfil {
            width: "150px";
            height: "auto";
        }
    </style>
</head>

<body>
    <div>
        <?php
            include "../Inc/nav2.inc";
        ?>
    </div>
    <?php
        $consulta = "SELECT * FROM post WHERE id_propietario=".$_SESSION['id_usuario']."";
        $resultadoPaginacion = $conexion->devolverConsultaArray($consulta);
        $consulta2 = "SELECT foto_perfil FROM usuarios WHERE id_usuario=".$_SESSION['id_usuario']."";
        $resultadoConsulta = $conexion->ejecutarConsulta($consulta2);
        $resultado = $resultadoConsulta->get_result();
        $productos = $resultado->fetch_array();
    ?>
    <div>
        <div class="container-fluid text-center" id="fotoPerfil">
        <?php
        if($productos['foto_perfil']==null){
            echo "<img src='../img/Foto-de-Perfil-en-WhatsApp-1024x768.jpg' style='width: 200px; height:200px; border-radius: 250px;'>";
        }else{
            echo "<img src='../data/images/perfil/".$productos['foto_perfil']."' style='width: 200px; height:200px; border-radius: 250px;'>";
        }
        ?>
        </div>
    </div>
    <?php
    echo "<div class='container'>    
            <div class='row'>";
    foreach($resultadoPaginacion as $post){
    echo "<div class='col-sm-4'>
            <img src='../data/images/posts/".$post['foto_post']."' alt='no se puede ver la foto' style='width: 300px; height:300px; margin-top:50px;'>
    </div>";

    }
    echo"</div>
    </div>";
    ?>
    <footer class="container-fluid footer-inverse text-center">
        <p>Footer Text</p>
    </footer>

</body>

</html>