<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

class TablaUsuarios{

 	/*=============================================
  	MOSTRAR LA TABLA DE USUARIOS
  	=============================================*/ 

	public function mostrarTabla(){	

		$item = null;
 		$valor = null;

 		$usuarios = ControladorClientes::ctrMostrarClientesuser($item, $valor);

 		$datosJson = '{
		 
	 	"data": [ ';

	 	for($i = 0; $i < count($usuarios); $i++){

	 

			/*=============================================
  			REVISAR ESTADO
  			=============================================*/

  			if($usuarios[$i]["modo"] == "directo"){

	  		
	  				$colorEstado = "btn-success";
	  				$textoEstado = "Activado";
	  				$estadoUsuario = 1;

	  			

	  			$estado = "<button class='btn btn-xs btnActivar ".$colorEstado."' idUsuario='". $usuarios[$i]["id"]."' estadoUsuario='".$estadoUsuario."'>".$textoEstado."</button>";

	  		}else{

	  			$estado = "<button class='btn btn-xs btn-info'>Activado</button>";

	  		}


	 		/*=============================================
			DEVOLVER DATOS JSON
			=============================================*/

			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$usuarios[$i]["nombre"].'",
					  "'.$usuarios[$i]["email"].'",
					  "'.$usuarios[$i]["direccion"].'",
				      "'.$usuarios[$i]["modo"].'",
				      "'.$estado.'",
				      "'.$usuarios[$i]["fecha"].'"    
				    ],';

	 	}

	 	$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']
			  
		}'; 

		echo $datosJson;

 	}

}

/*=============================================
ACTIVAR TABLA DE VENTAS
=============================================*/ 
$activar = new TablaUsuarios();
$activar -> mostrarTabla();



