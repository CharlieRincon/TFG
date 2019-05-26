<?php
    class Model {
		//Creación de varible Conexion
        private $conexion;

		////////////////////CONSTRUCTOR///////////////////////////////
		//El contructor de la case pedira un Host : Server
		//Un usuarios de la BBDD
		//Una contraseña de la BBDD
		//Y una base a la que conectarse
        function __construct ($host, $user, $pass, $idBase){
            $this->conexion = new mysqli($host, $user, $pass);
			//Si la conexion da error saltara error
            if($this->conexion->connect_error){
                die("Error de conexion (".$this->conexion->connection_error.") ".$this->conexion->connection_error);
            }
			//Si da error Saldra el error de la conexion a la BBDD 
            if(!($this->conexion->select_db($idBase))){
                echo "No se ha podido conectar";
            }
        }
		////////////////////DESCONECTAR///////////////////////////////
		//Funcion desconectar
        public function desconectar(){
			//Esta conexion se cerrara
            $this->conexion->close();
        }

		////////////////////EJECUTAR CONSULTA///////////////////////////////
		//Funcion Ejecutar Consulta  //Pasaremos una consulta de tipo String
        public function ejecutarConsulta($consulta){
			//Se pone la variable de la sql en nulo
            $resultado = null;
            //Si se tiene una conexion activa
            if(isset($this->conexion)){
				//El resultado sera  el stament que se pase por esta conexion
                $resultado = $this->conexion->stmt_init();
				//Preparamos y la consulta par ser lanzada
                $resultado->prepare($consulta);
				//Se ejecuta la consulta
                $resultado->execute();
            }
			//Devuelve el Resultado
            return $resultado;
        }

		////////////////////DEVOLVER CONSULTA ARRAY///////////////////////////////
		//Le pasaremos una consulta  a la funcion
        public function devolverConsultaArray($consulta){
			//El resultado de la consulta llama a la funcion Ejecutar Consulta y se le pasa el string de consulta
            $resultadoConsulta = $this->ejecutarConsulta($consulta);
			//La variable que contendra un Array se deja en Nulo
            $productos = null;
			//Resultado es igual al resultado de la consulta  al que lanzaremos un getResult para sacar el array entero
            $resultado = $resultadoConsulta->get_result();
			//Si resultado se llena y tiene valor
            if($resultado){
				//Recorreremos cada resultado y lo meteremos en la variable fila
                $fila = $resultado->fetch_array();
				//Si Fila es diferente a nulo
                while ($fila != null){
					//Meteremos el resultado de esa fila en Productos[]
                    $productos[] = $fila;
					//Sacamos del resultado la fila puesta
                    $fila = $resultado->fetch_array();
                }
				//Devolvemos los productos
                return $productos;
            }
        }

		////////////////////REGISTRAR USUARIO///////////////////////////////
		//Se usara para registrar un usuario en la BBDD
		//Se pasan todas las cosas necesarias para la creación de un usuario
        public function registrarUsuario($nombre,$apellidos,$correo,$passwd,$nombre_usuario,$telefono,$impresora){
			//Se prepara la sentencia para ver si existe  y se lanza
            $consulta = "SELECT * FROM USUARIOS WHERE correo_usuario = '$correo' AND nombre_usuario = '$nombre_usuario'";
            $resultadoConsulta = $this->ejecutarConsulta($consulta);
            $resultado = $resultadoConsulta->get_result();
            $existeUsuario = mysqli_num_rows($resultado);
			
			//Si la sentencia da algún resultado
            if ($existeUsuario == 1) {
                echo "<br/><h2>El usuario ya existe.</h2><br />";
                echo "<a href='../USUARIOS/registroFormulario.php'>Por favor elige otro id.</a>";
			//En caso de que no exista se creara
            } else {
				//Se crea el INSERT para la creación del usuario
                $sql = "INSERT INTO usuarios (nombre, apellidos, correo_usuario, pass_usuario, nombre_usuario, telefono, impresora) VALUES ('$nombre', '$apellidos', '$correo', '$passwd', '$nombre_usuario', '$telefono', '$impresora')";
				//Se ejecuta la consulta de inserccion y acto seguido se llama a la SesionFormulario para que entre
                if ($this->ejecutarConsulta($sql)) {
                    echo "<br/><h2>Usuario registrado correctamente.</h2>";
                    echo "<h4>Bienvenido: " . $nombre . " " . $apellidos . "</h4><br/><br/>";
					//Aqui se dara la bienvenida y se Logea
                    echo "<h5><a href='sesionFormulario.php'>Iniciar sesion</a></h5>"; 
                } else {
					//En caso de error saltara
                    echo "<h2>Error al crear el usuario." . $sql . "</h2><br/>";
                    echo "<h5><a href='registroFormulario.php'>Intentelo de nuevo</a></h5>"; 
                }
            }
        }

		////////////////////INSERTAR POST/////////////////////////////// AÑADIR a UPDATe.PHP
		//esto insertara un post en este caso tendra una id , una id de propiertario, categoria , precio , existencia , foto
        public function insertarPost($id_propietario, $descripcion, $foto_post){
			//PARA INSERTAR POST
            $consulta = "INSERT INTO post (id_propietario, descripcion, foto_post) VALUES ('$id_propietario', '$descripcion', '$foto_post')";
            $resultado = $this->ejecutarConsulta($consulta);
        }
		
		/////Busqueda por usuario ////
        public function busquedaNombre($Busqueda){

            $busqueda = explode(" ", $Busqueda);
            $nombre = $busqueda[0];
            $apellido = $busqueda[1];

            if (($apellido === NULL)&&($nombre != null)){
                $consulta = "SELECT nombre,apellidos,foto_perfil FROM Usuarios WHERE nombre LIKE '$nombre'";
            }else if (($nombre === NULL)&&($apellido === NULL)){
                $consulta = "SELECT nombre,apellidos,foto_perfil FROM Usuarios";
            }else if (($nombre != NULL)&&($apellido != NULL)){ 
                $consulta = "SELECT nombre,apellidos,foto_perfil FROM Usuarios WHERE nombre LIKE '$nombre' AND apellidos LIKE '$apellidos' ";
            }
            $resultado = $this->devolverConsultaArray($sql);
            return $resultado;
        }
		
		//esto insertara perfil foto
        public function insertarPerfil($id_propietario, $fotoPerfil){
			//PARA INSERTAR POST
            $consulta = "UPDATE usuarios SET foto_perfil='$fotoPerfil' WHERE id_usuario = '$id_propietario'";
            $resultado = $this->ejecutarConsulta($consulta);
        }
		//MODIFICAR PERFIL
		public function modificarPerfil($id,$correo,$passwd,$numero,$impresora){
			$consulta = "Update usuarios SET correo_usuario='$correo' ,pass_usuario='$passwd,telefono = '$numero',impresora ='$impresora' WHERE id_usuario = '$id' ";
			$resultado = $this->ejecutarConsulta($consulta);
		}

	    ////////////////////EDITAR POST///////////////////////////////
		//Editar Articulo POST 
        public function editarArticulo($codigo, $id, $id_propietario, $categoria, $precio, $existencias, $foto){
           //Cambiar lo de PRODUCTOS -- PARA INSERTAR POST
		   $consulta = "UPDATE productos SET id_producto = '$id', id_propietario_producto = '$id_propietario', categoria_producto = '$categoria', precio_producto = $precio, existencias_producto = $existencias, foto_producto = '$foto' WHERE codigo_producto = $codigo";
           $resultado = $this->ejecutarConsulta($consulta);
        }
		
		////////////////////BORRAR POST///////////////////////////////
		//Borrara un POST
        public function borrarArticulo($codigo){
			//Cambiar lo de PRODUCTOS -- PARA INSERTAR POST
            $consulta = "DELETE FROM post WHERE id_propietario = $codigo";
            $resultado = $this->ejecutarConsulta($consulta);
        }

		//////////////////Iniciar la Sesion ////////////////////////
		//Iniciar se sion se le pasa el idpropietario en e sun correo y la contraseña
        public function iniciarSesionUsuario($correo,$passwd){
			//Se saca la toda la informacion del usuario por el email
            $consulta = "SELECT * FROM usuarios WHERE correo_usuario = '$correo' ";
            $resultadoConsulta = $this->ejecutarConsulta($consulta);
            $resultado = $resultadoConsulta->get_result();
            $existeUsuario = mysqli_num_rows($resultado);
            $columnas = $resultado->fetch_assoc();
			
			//Se lanza la consulta si el usuario existe?
            if ($existeUsuario >= 1) {
				//Se pilla la columna de la contraseña y si coincide con la pass pasada Se logueara
                if ($columnas['pass_usuario'] == $passwd) {
                    $_SESSION['logeado'] = $correo;
                    $_SESSION['id_usuario'] = $columnas['id_usuario'];
                    $_SESSION['nombre'] = $columnas['nombre'];
                    $_SESSION['apellidos'] = $columnas['apellidos'];
                    $_SESSION['nombreCompleto'] = $columnas['nombre']+" "+$columnas['apellidos'];
                    header("Location: ../vistas/vistaGeneral.php");
                } else {
					//En el caso de que el usuario no coincida con la contraseña  no sera valido
                    echo "<br/><h2>La contraseña es incorrecta, por favor introduzca una contraseña válida.</h2>";
                    echo "<h4>Volver al <a href='sesionFormulario.php'>formulario</a></h4>";
                }
            } else {
				//El en caso de que el correo no este registrado no coincide con nada
                echo "<br/><h2>El usuario no existe, por favor introduzca un usuario válido.</h2>";
                echo "<h4>Volver al <a href='sesionFormulario.php'>formulario</a></h4>";
            }
        }
		
		
		//////////////////INICIAR SESION DE ADMIN////////////////////////
		//Se usara para iniciar como admin 
		//HABRA QUE HACER UNA REVISION
        public function iniciarSesionAdmin($id_propietario,$passwd){
            $consulta = "SELECT * FROM administrador WHERE id_propietario_admin = '$id_propietario' ";

            $resultadoConsulta = $this->ejecutarConsulta($consulta);

            $resultado = $resultadoConsulta->get_result();
            $existeAdmin = mysqli_num_rows($resultado);
            $columnas = $resultado->fetch_assoc();

            if ($existeAdmin >= 1) {
                if ($columnas['pass_admin'] == $passwd) {
                    $_SESSION['admin'] = $id_propietario;
                    header("Location: ../ADMINISTRADOR/articulosAdmin.php");
                } else {
                    echo "<br/><h2>La contraseña es incorrecta, por favor introduzca una contraseña válida.</h2>";
                    echo "<h4>Volver al <a href='sesionFormulario.php'>formulario</a></h4>";
                }
            } else {
                echo "<br/><h2>El usuario no existe, por favor introduzca un usuario válido.</h2>";
                echo "<h4>Volver al <a href='sesionFormulario.php'>formulario</a></h4>";
            }
        }

		
		
		
		//////////////////////////////////////////////////////////////////
		//////////////////VISUALIZACION DE POST///////////////////////////
		/// Sacara los Amigos //1 
        public function amigo($id_usuarioSesion){
            $sql = "SELECT id_amigo FROM amigos WHERE id_usuario = '$id_usuarioSesion' ORDER BY RAND()";
            $amigos = $this->devolverConsultaArray($sql);
            return $amigos;
        }
		
		
        public function mostrarPost($fila){
            $post;
			$sql = "SELECT id_post, descripcion , foto_post FROM post WHERE id_propietario = '$fila' ORDER BY id_post DESC";
            $post = $this->devolverConsultaArray($sql);
            return $post;
        }
		//Sacar el nombre del id
		// 3;
		public function sacarNombre($amigos){
            $nombre;
            $nombresArray = [];
			foreach($amigos as $fila) {
				$id = $fila[0];
				$sql = "SELECT id_usuario, nombre_usuario FROM usuarios WHERE id_usuario = '$id'";
                $resultadoConsulta = $this->ejecutarConsulta($sql);
                $resultado = $resultadoConsulta->get_result();
                $nombre = $resultado->fetch_array();
				array_push($nombresArray, $nombre);
			}
            return $nombresArray;
        }


		//////////////////Busqueda de Post // Tendra que ser Por usuario? ////////////////////////
        public function visualizarProductosBusqueda($busqueda){
            $sql = "SELECT * FROM productos WHERE id_producto LIKE '%$busqueda%'";
            $productos = $this->devolverConsultaArray($sql);
            return $productos;
        }
		
	     //////////////////Visualizar producto de codigos ////////////////////////
        public function visualizarProductosCodigo($codigo){
            $sql = "SELECT * FROM productos WHERE codigo_producto = $codigo";
            $resultadoConsulta = $this->ejecutarConsulta($sql);
            $resultado = $resultadoConsulta->get_result();
            $productos = $resultado->fetch_array();
            return $productos;
        }
		
		

    }
?>