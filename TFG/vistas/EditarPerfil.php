<?php
	//Sesion
    session_start ();

    if(isset($_SESSION["logeado"])){
		header("Location: ../index.php");
	}
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Apartado de Registro -->
    <title>Registrate</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../CSS/layout.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
        /*registro*/
    #registro{
        text-align:center;
        background-color: white;
    }
    </style>
</head>
<!-- Cargar los iconos -->
<body>
    <div id="iconos">
        <?php
            include "../Inc/nav.inc";
        ?>
    </div>

	<!-- FORMULARIO DE REGISTRO -->
    <div id="registro">
        <h1>Editar Usuario</h1>
        <form action="uploadPerfil.php" method="POST" enctype="multipart/form-data">
		
            <label for="id_correo">Correo:*</label><br/>
            <input type="text" name="correo" id="id_correo" required /><br/><br/>

            <label for="id_pass">Contraseña:*</label><br/>
            <input type="password" name="passwd" id="id_pass" required /><br/><br/>

            <label for="nombre_usuario">Nombre de Usuario:*</label><br/>
            <input type="text" name="nombre_usuario" id="nombre_usuario" required /><br/><br/>

            <label for="numero">Telefono:*</label><br/>
            <input type="tel" name="numero" id="numero" required maxlength="9"/><br/><br/>

            <h2>Información Adicional</h2><br>

            <label for="impresora">Impresora:</label><br/>
            <input type="text" name="impresora" id="impresora"/><br/><br/>
			
		

      <h2>Subir Foto Perfil</h2>
      <hr>
      <span style="float:right; color:black">
      </span>
      <center><img src="" id="thumbnil" alt="image" style="max-width:580px; "></center>

      <input type="file" accept="image/" name="fileToUpload" id="fileToUpload" onchange="showMyImage(this)" />
      <br />
	
            <input type="submit" name="post" id="boton_registrar" value="Editar usuario" />
        </form>
		<br><br>

    </div>
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
  </script>
	
	
	<!-- FOOT -->
    <div id="pie">
        <?php
            include "../Inc/footer.inc";
        ?>
    </div>
</body>

</html>