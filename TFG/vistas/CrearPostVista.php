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

<html>
<body>
<div class="createpost">
    <form method="post" action="../BBDD/upload.php" enctype="multipart/form-data">
      <h2>Crear un Post</h2>
      <hr>
      <span style="float:right; color:black">
      </span>
      Texto <span style="display:none;"> No puedes dejar a tu publicación sin un texto</span><br>
      <textarea name="descripcion" rows="6" ></textarea>
      <center><img src="" id="thumbnil" alt="image" style="max-width:580px; "></center>

      <input type="file" accept="image/" name="fileToUpload" id="fileToUpload" onchange="showMyImage(this)" />
      <br />
		
		
		
      <input type="submit" value="Subir Imagen" name="post">
  </div>
  </form>

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
	</body>
</html>