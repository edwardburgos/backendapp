<?php

require_once "../controladores/ordencompra.controlador.php";
require_once "../modelos/ordencompra.modelo.php";

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

require_once "../controladores/administradores.controlador.php";
require_once "../modelos/administradores.modelo.php";


class TablaOrdencompra
{

	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/

	public function mostrarTablaOrdencompra()
	{

		$item = null;
		$valor = null;


		$ordencompra = ControladorOrdencompra::ctrMostrarOrdencompra($item, $valor);


		$datosJson = '{
		  "data": [';

		for ($i = 0; $i < count($ordencompra); $i++) {


			$itemProveedor = "id";
			$valorProveedor= $ordencompra[$i]["id_proveedor"];
			
			$respuestaProveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);
			
			if($ordencompra[$i]["estado"] == 0){

				$colorEstado = "btn-danger";
				$textoEstado = "Por Recibir";
				$estadoProducto = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Recibido";
				$estadoProducto = 0;

			}

			$estado = "<button class='btn btn-xs btnActivar ".$colorEstado."' idProducto='".$ordencompra[$i]["id"]."' estadoProducto='".$estadoProducto."'>".$textoEstado."</button>";

			$empresa = $respuestaProveedor["nombre"] ;

			$itemtrabajador = "id";
			$trabajador = $ordencompra[$i]["id_trabajador"];
	
			$respuestatrabajador = ControladorAdministradores::ctrMostrarAdministradores($itemtrabajador, $trabajador);
	
			$trabajador=$respuestatrabajador["nombre"];

			$itemtrabajadorrecibe = "id";
			$trabajadorrecibe = $ordencompra[$i]["id_trabajadorrecibe"];

		   //var_dump($trabajadorrecibe);
		   
			$respuestatrabajadorrecibe = ControladorAdministradores::ctrMostrarAdministradores($itemtrabajadorrecibe, $trabajadorrecibe);
	
		
			$trabajadorrecibe=$respuestatrabajadorrecibe["nombre"]?? '';

			//$botones =  "<div class='btn-group'><button class='btn btn-primary agregarORden recuperarBoton' idOrden='" . $ordencompra[$i]["id"] . "'>Agregar</button></div>";
			$botones =  "<div class='btn-group'><button class='btn btn-success btnEditarOrden' idOrden='" . $ordencompra[$i]["id"] . "'><i class='fa fa-eye'></i></button><button class='btn btn-info btnImprimirOrden' codigoOrden='".$ordencompra[$i]['codigo']."'><i class='fa fa-print'></i></button><button class='btn btn-danger btnEliminarOrden' idOrden='" . $ordencompra[$i]["id"] . "'><i class='fa fa-times'></i></button></div>";
		

			$impuestoorden = "S/ ".number_format($ordencompra[$i]["impuesto"],2);
			$netoorden = "S/ ".number_format($ordencompra[$i]["neto"],2);
			$totalorden = "S/ ".number_format($ordencompra[$i]["total"],2);

			$datosJson .= '[
				"' . ($i + 1) . '",
				"' . $ordencompra[$i]["codigo"] . '",
				"' . $empresa . '",
				"' . $trabajador . '",
				"'.$estado.'",
				"' . $impuestoorden . '",
				"' . $netoorden . '",
				"' . $totalorden . '",
				"' . $ordencompra[$i]["fecha"] . '",
				"' . $trabajadorrecibe . '",
				"' . $ordencompra[$i]["fecharecibido"] . '",
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
$activarordencompras = new TablaOrdencompra();
$activarordencompras->mostrarTablaOrdencompra();
