<?php

require_once "../controladores/ventasecommerce.controlador.php";
require_once "../modelos/ventasecommerce.modelo.php";


class AjaxVentasecommerce{

	/*=============================================
	ACTUALIZAR PROCESO DE ENVÍO
	=============================================*/
	

  	public $idVenta;
  	public $etapa;

  	public function ajaxEnvioVenta(){

  		$respuesta = ModeloVentasecommerce::mdlActualizarPedido("pedidos", "estado", $this->etapa, $this->idVenta);

  		echo $respuesta;

	}

}

/*=============================================
ACTUALIZAR PROCESO DE ENVÍO
=============================================*/


if(isset($_POST["idVentaeco"])){

	$envioVenta = new AjaxVentasecommerce();
	$envioVenta -> idVenta = $_POST["idVentaeco"];
	$envioVenta -> etapa = $_POST["estado"];
	$envioVenta -> ajaxEnvioVenta();

}
