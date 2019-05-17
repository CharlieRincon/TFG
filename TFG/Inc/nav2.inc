<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-left" href="#"><img src='../img/logo.png' alt='cabecera' width='50px' height='50px'/></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="../vistas/vistaGeneral.php">Inicio</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../vistas/vistaGeneral.php">Amigos</a></li>
        <li><a href="../vistas/vistaGeneral.php">Peticiones de amistad</a></li>
        <?php
          echo "<li><a href='logout.php'>Cerrar Sesión</a></li>";
        ?>
      </ul>
    </div>
  </div>
</nav>