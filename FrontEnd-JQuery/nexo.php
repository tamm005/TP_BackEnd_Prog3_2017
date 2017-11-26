<?php 
require_once("clases/AccesoDatos.php");
require_once("clases/usuario.php");
require_once("clases/vehiculo.php");
$queHago=$_POST['queHacer'];

switch ($queHago) {
	case "MostrarLogin":
		include("partes/login.php");
		break;
	case "MostrarVehiculos":
		include("partes/tablaVehiculos.php");
		break;
	case 'MostrarFormAlta':
		include("partes/altaVehiculo.php");
		break;
	case 'MostrarUsuarios':
		include("partes/tablaUsuarios.php");
		break;
	case 'FormAltaUsuario':
		include("partes/altaUsuario.php");
		break;
	case 'MostrarPerfil':
		include("partes/perfil.php");
		break;
	
	//--------------------ABM Vehiculos-----------------------------//

	case "Agregar":
			$unVehiculo = new Vehiculo();
			$unVehiculo->nombre = $_POST["nombre"];
			$unVehiculo->porcentaje = $_POST["porcentaje"];

			if($_POST["id"] == "0") // AGREGAR
			{
				$idInsertado = $unVehiculo->InsertarVehiculo();
				echo $idInsertado;
			}
			else   // MODIFICAR
			{
				$unVehiculo->id = $_POST["id"];
				echo $unVehiculo->ModificarVehiculo();
			}
			break;
	case "Modificar":
			$unVehiculo = Vehiculo::TraerUnVehiculo($_POST["id"]);
			echo json_encode($unVehiculo);
			break;

	case 'eliminar':
		$unVehiculo = new Vehiculo();
		$unVehiculo->id = $_POST['id'];
		$unVehiculo->BorrarVehiculo();
		break;

	case 'editar':
		$user = new Vehiculo();
		$user->nombre = $_POST['nombre'];
		$user->porcentaje = $_POST['password'];
		$user->id = $_POST['id'];
		$user->ModificarVehiculo();
		break;
	//--------------------ABM USUARIO--------------------//
	case "GuardarUsuario":
		// include("partes/altaUsuario.php");
		// echo $cantidad; //me retorna el ultimo ok5
		// break;
			$usuario = new usuario();
			$usuario->nombre = $_POST["name"];
			$usuario->correo = $_POST["correo"];
			$usuario->clave = $_POST["clave1"];
			$usuario->tipo = "comprador";   //puedo poner usuario,comprador,vendedor,etc
			$usuario->foto = "img/".$usuario->nombre.".jpg";

			if($_POST["id"] == "0") // AGREGAR
			{
				$idInsertado = $usuario->InsertarUsuario();
				echo $idInsertado;
			}
			else   // MODIFICAR
			{
				$usuario->id = $_POST["id"];
				echo $usuario->ModificarUsuario();
			}

			move_uploaded_file($_FILES["foto"]["tmp_name"], $usuario->foto);
			break;
	case 'eliminarUsuario':
		$user = new usuario();
		$user->id = $_POST['id'];
		$user->BorrarUsuario();
		break;

	case "ModificarUsuario":
			$unVehiculo = usuario::TraerUsuario($_POST["id"]);
			//var_dump($unVehiculo);
			echo json_encode($unVehiculo);
			break;
	case 'BorrarCookie':
		setcookie("usuarioCookie", "", time()-60, '/');
		break;

}//fin switch
	

?>