<?php

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

class AjaxProveedores{

	/*=============================================
	EDITAR CLIENTE
	=============================================*/	

	public $idProveedor;

	public function ajaxEditarProveedor(){

		$item = "id";
		$valor = $this->idProveedor;

		$respuesta = ControladorProveedores::ctrMostrarProveedores($item, $valor);

		echo json_encode($respuesta);


	}


		/*=============================================
	VALIDAR NO REPETIR USUARIO
	=============================================*/	

	public $validarProveedor;

	public function ajaxValidarProveedor(){

		$item = "ruc";
		$valor = $this->validarProveedor;

		$respuesta = ControladorProveedores::ctrMostrarProveedores($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/

if(isset( $_POST["validarProveedor"])){

	$valProveedor = new AjaxProveedores();
	$valProveedor -> validarProveedor = $_POST["validarProveedor"];
	$valProveedor -> ajaxValidarProveedor();

}