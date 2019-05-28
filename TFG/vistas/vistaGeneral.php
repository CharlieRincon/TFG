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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
        <div class="cols-sm-12">
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
        if(mysqli_num_rows($query) == 0){
            echo '<div class="post">';
            echo 'No tenemos Post que Mostrarte.';
            echo '</div>';
        }
        else{
            $width = '40px'; //Redimensionar imagen perfil
            $height = '40px';
            while($row = mysqli_fetch_assoc($query)){
                include 'includes/post.php';
                echo '<br>';
            }
        }
        ?>
        <br><br><br>
        </div>
        </div>
    </div>
	
    <!--< Script para visualizar la imagen >-->
    <script>
        function showMyImage(fileInput) {
        var files = fileInput.files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var imageType = /image.*/;
            if (!file.type.match(imageType)) {
            continue;
            }
            var img = document.getElementById("thumbnil");
            img.file = file;
            var reader = new FileReader();
            reader.onload = (function (aImg) {
            return function (e) {
                aImg.src = e.target.result;
            };
            })(img);
            reader.readAsDataURL(file);
        }
        }
        // Validación de formularios
        function validatePost(){
            var required = document.getElementsByClassName("required");
            var caption = document.getElementsByTagName("textarea")[0].value;
            required[0].style.display = "none";
            if(caption == ""){
                required[0].style.display = "initial";
                return false;
            }
            return true;
        }
    </script>
</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') { // Formulario es publicado
    // Asignar Variables
    $caption = $_POST['caption'];
    if(isset($_POST['public'])) {
        $public = "Y";
    } else {
        $public = "N";
    }
    $poster = $_SESSION['user_id'];
    // Insertar Query
    $sql = "INSERT INTO posts (post_caption, post_public, post_time, post_by)
            VALUES ('$caption', '$public', NOW(), $poster)";
    $query = mysqli_query($conn, $sql);
    // Acción en la consulta exitosa
    if($query){
        // Subir imagen de publicación Si se eligió un archivo
        if (!empty($_FILES['fileUpload']['name'])) {
            echo 'Mierda..';
            // Recuperar ID de publicación
            $last_id = mysqli_insert_id($conn);
            include 'functions/upload.php';
        }
        header("location: home.php");
    }
}
?>