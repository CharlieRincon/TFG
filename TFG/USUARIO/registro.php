<?php
    require_once "../BBDD/config.php";
    require_once "../BBDD/model.php";
    
    session_start();
	//Inicio de sesion
    if(isset($_SESSION['logeado'])){
		header("Location: ../index.php");
    }
    //Se pilla los datos del formulario post
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $passwd = $_POST['passwd'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $numero = $_POST['numero'];
    $impresora = $_POST['impresora'];
	//Se comprueba para el login
    if(empty($nombre) || empty($apellidos) || empty($correo) || empty($passwd) || empty($nombre_usuario) || empty($numero)){
        echo "<br/><h2>Alguno de los campos esta vacio.</h2><br />";
        echo "<a href='registroFormulario.php'>Por favor rellene todos los campos.</a>";
    } else {

        //PARA ENCRIPTAR CONTRASEÑA (CONSULTAR A MJ) o a (David Beato)
        //$hash = password_hash($form_pass, PASSWORD_BCRYPT);
		
		//Apartado David Beato : 
		// $hashed_password = hash('sha512', $_POST['password']);
		// INSERT INTO users (username, password, email) VALUES ('$_POST[username]', '$hashed_password', '$_POST[email]');
		// $escaped_username = mysqli_real_escape_string( $con, $_POST['username'] );
		// $escaped_email = mysqli_real_escape_string( $con, $_POST['email'] );

        $conexion = new Model(Config::$host, Config::$user, Config::$pass, Config::$nombreBase);

        $conexion->registrarUsuario($nombre,$apellidos,$correo,$passwd,$nombre_usuario,$numero,$impresora);
    }

    $conexion->desconectar();
?>