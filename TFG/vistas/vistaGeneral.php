<?php 
require 'functions/functions.php';
session_start();
// Compruebe si el usuario ha iniciado sesión o no
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
$temp = $_SESSION['user_id'];
session_destroy();
session_start();
$_SESSION['user_id'] = $temp;
ob_start(); 
// Establecer conexión de base de datos
$conn = connect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>NoozlePrint3D</title>
    <link rel="stylesheet" type="text/css" href="resources/css/main.css">
</head>
<body>
    <div class="container">
        <?php include 'includes/navbar.php'; ?>
        <br>
        <div class="createpost">
            <form method="post" action="" onsubmit="return validatePost()" enctype="multipart/form-data">
                <h2>Crear un Post</h2>
                <hr>
                <span style="float:right; color:black">
                <input type="checkbox" id="public" name="public">
                <label for="public">Publico</label>
                </span>
                Texto <span class="required" style="display:none;"> *No puedes dejar a tu publicación sin un texto</span><br>
                <textarea rows="6" name="caption"></textarea>
                <center><img src="" id="thumbnil" style="max-width:580px;"></center>
                <div class="createpostbuttons">
                    <!--<form action="" method="post" enctype="multipart/form-data" id="imageform">-->
                    <label>
                        <img src="images/photo.png">
                        <input type="file" name="fileUpload" id="imagefile" onchange="showMyImage(this)">
                        <!--<input type="submit" style="display:none;">-->
                    </label>
                    <input type="submit" value="Post" name="post">
                    <!--</form>-->
                </div>
            </form>
        </div>
        <h1>Noticias</h1>
        <?php 
        // Post Publicos, Post de Amigos , Posts Privados
        $sql = "SELECT posts.post_caption, posts.post_time, posts.post_public, users.user_firstname,
                        users.user_lastname, users.user_id, users.user_gender, posts.post_id
                FROM posts
                JOIN users
                ON posts.post_by = users.user_id
                WHERE posts.post_public = 'Y' OR users.user_id = {$_SESSION['user_id']}
                UNION
                SELECT posts.post_caption, posts.post_time, posts.post_public, users.user_firstname,
                        users.user_lastname, users.user_id, users.user_gender, posts.post_id
                FROM posts
                JOIN users
                ON posts.post_by = users.user_id
                JOIN (
                    SELECT friendship.user1_id AS user_id
                    FROM friendship
                    WHERE friendship.user2_id = {$_SESSION['user_id']} AND friendship.friendship_status = 1
                    UNION
                    SELECT friendship.user2_id AS user_id
                    FROM friendship
                    WHERE friendship.user1_id = {$_SESSION['user_id']} AND friendship.friendship_status = 1
                ) userfriends
                ON userfriends.user_id = posts.post_by
                WHERE posts.post_public = 'N'
                ORDER BY post_time DESC";
        $query = mysqli_query($conn, $sql);
        if(!$query){
            echo mysqli_error($conn);
        }
<!DOCTYPE html>

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
<!DOCTYPE html>
<html lang="en">
<head>
  <title>NozzlePrint3D</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
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
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>
<div> 
    <?php
        include "../Inc/nav2.inc";
    ?>
</div>
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <?php
        echo "<p>".$_SESSION['nombre']." ".$_SESSION['apellidos']."</p>";
      ?>
      <ul class="nav nav-pills nav-stacked">
        <li id="perfil"><a href="../vistas/vistaUsuario.php">Perfil</a></li>
        <li id="perfil"><a href="../vistas/CrearPostVista.php">Subir foto</a></li>
		    <li id="perfil"><a href="../vistas/EditarPerfil.php">Editar Perfil</a></li>
      </ul><br>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Blog..">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </div>

    <div class="col-sm-9">
      <h4><small>RECENT POSTS</small></h4>
      <hr>
      <?php
      //recogemos los amigos del usuario de la sesion
        $amigos = $conexion->amigo($_SESSION['id_usuario']);
        $nombresAmigos = $conexion->sacarNombre($amigos);
        foreach ($nombresAmigos as $nombre) {
          $cosasPost = $conexion->mostrarPost($nombre['id_usuario']);
          foreach($cosasPost as $cosaPost){
            if($cosaPost['foto_post'] != null || $cosaPost['descripcion'] != null){
              echo "<p>".$nombre['nombre_usuario']."</p>";
              echo "<img src='../data/images/posts/".$cosaPost['foto_post']."' alt='imagen'>";
              echo "<p>".$cosaPost['descripcion']."</p>";
            }
          }
        }
      ?>
    </div>
  </div>
</div>

<footer class="container-fluid">
  <p>Copyright NozzlePrint3D</p>
</footer>

</body>
</html>