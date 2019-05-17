<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-left" href="#"><img src='../IMAGENES/pelota.png' alt='cabecera' width='50px' height='50px'/></a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <?php
            if(isset($_SESSION['admin'])){
                echo "<li><a href='logout.php'><span class='glyphicon glyphicon-log-out'></span></a></li>";
            }
        ?>
      </ul>
    </div>
  </div>
</nav>