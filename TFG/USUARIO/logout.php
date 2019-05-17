<?php 
	//Inciar la sesion
    session_start();
    unset($_SESSION['logeado']);
	
	//Cerrar la Sesion
    session_destroy();
	//Hacia donde va? Cambiarlo!
    header('Location: ../index.php');
?>