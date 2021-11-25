<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

class Tablaclientes
{

	/*=============================================
  	MOSTRAR LA TABLA DE USUARIOS
  	=============================================*/

	public function mostrarTablaclientes()
	{

		$item = null;
		$valor = null;

		$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

		$datosJson = '{
		 
	 	"data": [ ';

		for ($i = 0; $i < count($clientes); $i++) {

              if($clientes[$i]["documento"]>0){
				 $midoc=$clientes[$i]["documento"];
				 $tipdoc="Dni";
			  }else{
				$midoc=$clientes[$i]["ruc"];
				$tipdoc="Ruc";
			  }
	
			/*=============================================
			DEVOLVER DATOS JSON
			=============================================*/
			$botones =  "<div class='btn-group'> <button class='btn btn-warning btnEditarCliente' data-toggle='modal' data-target='#modalEditarCliente' idCliente='".$clientes[$i]["id"]."'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarCliente' idCliente='".$clientes[$i]["id"]."'><i class='fa fa-times'></i></button></div>";
		 
			$datosJson .= '[
				      "'.($i + 1) . '",
				      "'.$clientes[$i]["nombre"].'",
					  "'.$midoc.'",
					  "'.$tipdoc.'",
				      "'.$clientes[$i]["email"].'",
					  "'.$clientes[$i]["telefono"].'",  
					  "'.$clientes[$i]["direccion"].'",
					  "'.$clientes[$i]["fecha_nacimiento"].'",  
					  "'.$clientes[$i]["compras"].'", 
					  "'.$clientes[$i]["ultima_compra"].'",
					  "'.$clientes[$i]["fecha"].'",
					  "'.$botones.'" 
					],';
			
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .=  ']
			  
		}';

		echo $datosJson;
	}
}

/*=============================================
ACTIVAR TABLA DE VENTAS
=============================================*/
$activarclientes = new Tablaclientes();
$activarclientes->mostrarTablaclientes();
