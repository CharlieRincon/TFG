<?php
    require_once "../BBDD/config.php";
    require_once "../BBDD/model.php";
    //require_once "../CLASES/cesta.php";
    //Iniciar la Sesion
    session_start();
    //Iniciar la sesion logeada cargar la VisionGeneral
    if (isset($_SESSION['logeado'])) {
        header("Location: ../vistas/vistaGeneral.html");
    }
    //Se recoge los datos del formulari y se recogen en la variable
    $correo = $_POST['correo'];
    $passwd = $_POST['passwd'];
    
    //Se ve si correo y password desde el formulario pasan vacios o llenos
    if (empty($correo) || empty($passwd)) {
        //En el caso de que este vacio se remitira al cformulario otrra vez y aparace que deben cargarlo
        echo "<br/><h2>Alguno de los campos esta vacio.</h2><br />";
        echo "<a href='registroFormulario.php'>Por favor rellene todos los campos.</a>";
    } else {
        //En caso de si contener usuario y contraseñ ase llama al modelo para realizar la conexion
        $conexion = new Model(Config::$host, Config::$user, Config::$pass, Config::$nombreBase);
        //Se pasa el correo y l acontraseña para ver si se conecta
        $conexion->iniciarSesionUsuario($correo, $passwd);
    }
    //Se cierrra la conexion
    $conexion->desconectar();