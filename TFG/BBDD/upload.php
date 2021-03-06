<?php

require_once "model.php";
require_once "config.php";

  $conexion = new Model(Config::$host, Config::$user, Config::$pass, Config::$nombreBase);
    //Sesion
    session_start ();
    if(!isset($_SESSION["logeado"])){
        header("Location: ../index.php");
    }

    $id = $_SESSION['id_usuario'];

$target_dir = "../data/images/posts/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$des = $_POST['descripcion'];


if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "El Fichero es una imagen- " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "El Fichero no es una imagen";
        $uploadOk = 0;
    }
}

if (file_exists($target_file)) {
    echo "El fichero ya existe";
    $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 5000000000) {
    echo "El tamaño es muy grande";
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Solo se acepta, only JPG, JPEG, PNG & GIF ";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "No se subio.";

} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$nombre = basename( $_FILES["fileToUpload"]["name"]);
		//REALIZAR UN INSERT de LA RUTA EN EL USUARIO
        $conexion->insertarPost($id, $des, $nombre);
		header("Location: ../vistas/vistaGeneral.php");
    } else {
        echo "No pudo subirse.";
    }
}
//https://www.w3schools.com/php/php_file_upload.asp
?>
