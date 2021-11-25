<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


class TablaProductosVentass
{

	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/

	public function mostrarTablaProductosVentass()
	{

		$item = null;
		$valor = null;


		$productos = ControladorProductos::ctrMostrar($item, $valor);


		$datosJson = '{
		  "data": [';

		for ($i = 0; $i < count($productos); $i++) {

			/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/

			$portada = "<img src='" . $productos[$i]["portada"] . "' width='40px'>";



			/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/

			$botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='" . $productos[$i]["id"] . "'>Agregar</button></div>";

			$datosJson .= '[
				"' . ($i + 1) . '",
				"' . $portada . '",
				"' . $productos[$i]["descripcion"] . '",
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
$activarProductosProveedores = new TablaProductosVentass();
$activarProductosProveedores->mostrarTablaProductosVentass();
