<?php
	//Se inicia la sesion
    session_start ();
	//Sobre Index  (CAMBIAR LOCALIZACION)
    if(isset($_SESSION["logeado"])){
		header("Location: ../index.php");
	}
?>
<!DOCTYPE html>
<html>

<head>
	<!-- Boton de Iniciar la sesion -->
    <title>Iniciar Sesion</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../CSS/layout.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
        /*registro*/
        #sesion{
            text-align:center;
            background-color: white;
        }
    </style>
</head>

<!-- Ahora el body -->
<body>
	<!-- Se llama a los iconos que no carga ninguno -->
    <div id="iconos">
        <?php
            include "../Inc/nav.inc";
        ?>
    </div>
	<!-- LOGIN -->
	<!-- Iniciar la sesion, Que tienen Correo y Contraseña -->
    <div id="sesion">
        <h1>Inicio de sesion de usuario</h1>
        <form action="login.php" method="POST" enctype="multipart/form-data">
            <label for="id_correo">Email:*</label><br>
            <input type="text" name="correo" id="id_correo" required>
            <br><br>
            <label for="id_pass">Contraseña:*</label><br>
            <input type="password" name="passwd" id="id_pass" required>
            <br><br>
            <input type="submit" value="Iniciar Sesion" name="sesion" id="boton_sesion">
        </form>
		<br><br>
        <p>Si no esta registrado pulse <a href="registroFormulario.php">aqui</a> para registrarse</p>
    </div>

	<!-- PIE -->
    <div id="pie">
        <?php
            include "../Inc/footer.inc";
        ?>
    </div>
</body>

</html>