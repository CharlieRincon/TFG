<?php 
require 'functions/functions.php';
session_start();
ob_start();
// Compruebe si el usuario ha iniciado sesión o no
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
// Establecer conexión de base de datos
$conn = connect();
?>

<?php
if(isset($_GET['id']) && $_GET['id'] != $_SESSION['user_id']) {
    $current_id = $_GET['id'];
    $flag = 1;
} else {
    $current_id = $_SESSION['user_id'];
    $flag = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>NozzlePrint3D</title>
    <link rel="stylesheet" type="text/css" href="resources/css/main.css">
    <style>
    .post{
        margin-right: 50px;
        float: right;
        margin-bottom: 18px;
    }
    .profile{
        margin-left: 50px;
        background-color: white;
        box-shadow: 0 0 5px #4267b2;
        width: 220px;
        padding: 20px;
    }
    input[type="file"]{
        display: none;
    }
    label.upload{
        cursor: pointer;
        color: white;
        background-color: #4267b2;
        padding: 8px 12px;
        display: inline-block;
        max-width: 80px;
        overflow: auto;
    }
    label.upload:hover{
        background-color: #23385f;
    }
    .changeprofile{
        color: #23385f;
        font-family: Fontin SmallCaps;
    }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'includes/navbar.php'; ?>
        <h1>Perfil</h1>
        <?php
        $postsql;
        if($flag == 0) { // Tu Propio Perfil      
            $postsql = "SELECT posts.post_caption, posts.post_time, users.user_firstname, users.user_lastname,
                                posts.post_public, users.user_id, users.user_gender, users.user_nickname,
                                users.user_birthdate, users.user_hometown, users.user_status, users.user_about, 
                                posts.post_id
                        FROM posts
                        JOIN users
                        ON users.user_id = posts.post_by
                        WHERE posts.post_by = $current_id
                        ORDER BY posts.post_time DESC";
            $profilesql = "SELECT users.user_id, users.user_gender, users.user_hometown, users.user_status, users.user_birthdate,
                                 users.user_firstname, users.user_lastname
                          FROM users
                          WHERE users.user_id = $current_id";
            $profilequery = mysqli_query($conn, $profilesql);
        } else { // Otro perfil ---> Recuperar datos de usuario y estado de amistad
            $profilesql = "SELECT users.user_id, users.user_gender, users.user_hometown, users.user_status, users.user_birthdate,
                                    users.user_firstname, users.user_lastname, userfriends.friendship_status
                            FROM users
                            LEFT JOIN (
                                SELECT friendship.user1_id AS user_id, friendship.friendship_status
                                FROM friendship
                                WHERE friendship.user1_id = $current_id AND friendship.user2_id = {$_SESSION['user_id']}
                                UNION
                                SELECT friendship.user2_id AS user_id, friendship.friendship_status
                                FROM friendship
                                WHERE friendship.user1_id = {$_SESSION['user_id']} AND friendship.user2_id = $current_id
                            ) userfriends
                            ON userfriends.user_id = users.user_id
                            WHERE users.user_id = $current_id";
            $profilequery = mysqli_query($conn, $profilesql);
            $row = mysqli_fetch_assoc($profilequery);
            mysqli_data_seek($profilequery,0);
            if(isset($row['friendship_status'])){// O un amigo o solicitado como amigo
                if($row['friendship_status'] == 1){ //Amigo
                    $postsql = "SELECT posts.post_caption, posts.post_time, users.user_firstname, users.user_lastname,
                                        posts.post_public, users.user_id, users.user_gender, users.user_nickname,
                                        users.user_birthdate, users.user_hometown, users.user_status, users.user_about, 
                                        posts.post_id
                                FROM posts
                                JOIN users
                                ON users.user_id = posts.post_by
                                WHERE posts.post_by = $current_id
                                ORDER BY posts.post_time DESC";
                }
                else if($row['friendship_status'] == 0){ 
// Solicitado como amigo
                    $postsql = "SELECT posts.post_caption, posts.post_time, users.user_firstname, users.user_lastname,
                                        posts.post_public, users.user_id, users.user_gender, users.user_nickname,
                                        users.user_birthdate, users.user_hometown, users.user_status, users.user_about, 
                                        posts.post_id
                                FROM posts
                                JOIN users
                                ON users.user_id = posts.post_by
                                WHERE posts.post_by = $current_id AND posts.post_public = 'Y'
                                ORDER BY posts.post_time DESC";
                }
            } else { // No es Amigo
                $postsql = "SELECT posts.post_caption, posts.post_time, users.user_firstname, users.user_lastname,
                                    posts.post_public, users.user_id, users.user_gender, users.user_nickname,
                                    users.user_birthdate, users.user_hometown, users.user_status, users.user_about, 
                                    posts.post_id
                            FROM posts
                            JOIN users
                            ON users.user_id = posts.post_by
                            WHERE posts.post_by = $current_id AND posts.post_public = 'Y'
                            ORDER BY posts.post_time DESC";
            }
        }
        $postquery = mysqli_query($conn, $postsql);    
        if($postquery){
            // Posts
            $width = '40px'; 
            $height = '40px';
            if(mysqli_num_rows($postquery) == 0){ // No Posts
                if($flag == 0){ 
// Mensaje mostrado si es tu propio perfil.
                    echo '<div class="post">';
                    echo 'No creaste ningún Post Animate!';
                    echo '</div>';
                } else { // Mensaje mostrado si se trata de otro perfil que no sea el tuyo
                    echo '<div class="post">';
                    echo 'No hay publicaciones públicas para mostrar.';
                    echo '</div>';
                }
                include 'includes/profile.php';
            } else {
                while($row = mysqli_fetch_assoc($postquery)){
                    include 'includes/post.php';
                }
                // Información de Perfil
                include 'includes/profile.php';
                ?>
                <br>
                <?php if($flag == 0){?>
                <div class="profile">
                    <center class="changeprofile">Cambiar imagen de Perfil</center>
                    <br>
                    <form action="" method="post" enctype="multipart/form-data">
                        <center>
                            <label class="upload" onchange="showPath()">
                                <span id="path" style="color: white;">... Seleccionar</span>
                                <input type="file" name="fileUpload" id="selectedFile">
                            </label>
                        </center>
                        <br>
                        <input type="submit" value="Upload Image" name="profile">
                    </form>
                </div>
                <br>
                <div class="profile">
                    <center class="changeprofile">Añadir numero de teléfono</center>
                    <br>
                    <form method="post" onsubmit="return validateNumber()">
                        <center>
                            <input type="text" name="number" id="phonenum">
                            <div class="required"></div>
                            <br>
                            <input type="submit" value="Submit" name="phone">
                        </center>
                    </form>
                </div>
                <br>
                <?php } ?>
                <?php
            }
        }
        ?>
    </div>
</body>
<script>
function showPath(){
    var path = document.getElementById("selectedFile").value;
    path = path.replace(/^.*\\/, "");
    document.getElementById("path").innerHTML = path;
}
function validateNumber(){
    var number = document.getElementById("phonenum").value;
    var required = document.getElementsByClassName("required");
    if(number == ""){
        required[0].innerHTML = "Debe escribir su número";
        return false;
    } else if(isNaN(number)){
        required[0].innerHTML = "Gracioso su numero de telefono solo puede tener numeros."
        return false;
    }
    return true;
}
</script>
</html>
<?php include 'functions/upload.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Se publica un formulario.
    if (isset($_POST['request'])) { // Enviar peticion de amistad
        $sql3 = "INSERT INTO friendship(user1_id, user2_id, friendship_status)
                 VALUES ({$_SESSION['user_id']}, $current_id, 0)";
        $query3 = mysqli_query($conn, $sql3);
        if(!$query3){
            echo mysqli_error($conn);
        }
    } else if(isset($_POST['remove'])) { // Quitarla
        $sql3 = "DELETE FROM friendship
                 WHERE ((friendship.user1_id = $current_id AND friendship.user2_id = {$_SESSION['user_id']})
                 OR (friendship.user1_id = {$_SESSION['user_id']} AND friendship.user2_id = $current_id))
                 AND friendship.friendship_status = 1";
        $query3 = mysqli_query($conn, $sql3);
        if(!$query3){
            echo mysqli_error($conn);
        }
    } else if(isset($_POST['phone'])) { // Añadir  numero de telefono a tu perfil
        $sql3 = "INSERT INTO user_phone(user_id, user_phone) VALUES ({$_SESSION['user_id']},{$_POST['number']})";
        $query3 = mysqli_query($conn, $sql3);
        if(!$query3){
            echo mysqli_error($conn);
        } 
    }
    sleep(4);
}
?>
