<?php

class ControladorVentasecommerce{

	/*=============================================
	MOSTRAR TOTAL VENTAS
	=============================================*/

	public function ctrMostrarTotalVentas(){

		$tabla = "pedidos";

		$respuesta = ModeloVentasecommerce::mdlMostrarTotalVentas($tabla);

		return $respuesta;

	}

	static public function ctrMostrarVentaseco($item, $valor)
	{

		$tabla = "pedidos";

		$respuesta = ModeloVentasecommerce::mdlMostrarVentaseco($tabla, $item, $valor);

		return $respuesta;
	}

	static public function ctrActualizar()
	{
		if (isset($_POST["GuardarVenta"])) {
			 $cod=$_POST["idpedi"];
             $estado="1";
			$respuesta = ModeloVentasecommerce::mdlActualizarPedido("pedidos","estado", $estado, $cod);
			//$respuesta = ModeloVentasecommerce::mdlActualizarVenta($tabla, $item, $valor);
	
				if ($respuesta == "ok") {
	
					echo  $estado;
				}

		}elseif(isset($_POST["Cancelar"])) {
			$cod=$_POST["idpedi"];
			$estado="3";
		   $respuesta = ModeloVentasecommerce::mdlActualizarPedido("pedidos","estado", $estado, $cod);
		   //$respuesta = ModeloVentasecommerce::mdlActualizarVenta($tabla, $item, $valor);
   
			   if ($respuesta == "ok") {
   
				   echo  $estado;
			   }
		}
		//$tabla = "pedidos";
	
		//return $respuesta;
	}

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	public function ctrMostrarVentas(){

		$tabla = "pedidos";

		$respuesta = ModeloVentasecommerce::mdlMostrarVentas($tabla);

		return $respuesta;

	}

}