<?php

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";


class Tablaproveedores
{

	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/

	public function mostrarTablaProveedores()
	{

		$item = null;
		$valor = null;


		$proveedores = ControladorProveedores::ctrMostrarProveedores($item, $valor);


		$datosJson = '{
		  "data": [';

		for ($i = 0; $i < count($proveedores); $i++) {

			/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/




			/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/

			$botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProveedor' idProveedor='". $proveedores[$i]["id"]."'><i class='fa fa-pencil'></i></button><button class='btn btn-primary btnOrdenProveedor' idProveedor='". $proveedores[$i]["id"]."'><i class='fa fa-shopping-cart'></i></button><button class='btn btn-danger btnEliminarProveedor' idProveedor='".$proveedores[$i]["id"]."'><i class='fa fa-times'></i></button></div>";
		      //$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarCategoria' idCategoria='".$proveedores[$i]["id"]."'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarCategoria' idCategoria='".$proveedores[$i]["id"]."'><i class='fa fa-times'></i></button></div>";
			$datosJson .= '[
				"'.($i+1).'",
				"'.$proveedores[$i]["ruc"].'",
				"'.$proveedores[$i]["nombre"].'",
				"'.$proveedores[$i]["direccion"].'",
				"'.$proveedores[$i]["telefono"].'",
				"'.$proveedores[$i]["email"].'",
				"' . $botones . '"
			  ],';
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .=   '] 

		 }';

		echo $datosJson;
	}
}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/
$activarProveedores = new Tablaproveedores();
$activarProveedores->mostrarTablaProveedores();
