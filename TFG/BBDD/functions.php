<?php
//Conectarse a la BBDD
//Cambiar nombre BBDD 
function connect() {
    static $conn;
    if ($conn === NULL){ 
        $conn = mysqli_connect('localhost','root','','tfgT');
    }
    return $conn;
}

?>