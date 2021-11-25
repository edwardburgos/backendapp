<?php

class ControladorProveedores
{

	/*=============================================
	MOSTRAR Proveedores
	=============================================*/

	static public function ctrMostrarProveedores($item, $valor)
	{

		$tabla = "proveedores";

		$respuesta = ModeloProveedores::mdlMostrarProveedores($tabla, $item, $valor);

		return $respuesta;
	}

	public function ctrMostrarTotalProveedores()
	{

		$tabla = "proveedores";

		$respuesta = ModeloProveedores::mdlMostrarTotalProveedores($tabla);

		return $respuesta;
	}
	/*=============================================
	CREAR Proveedor
	=============================================*/

	static public function ctrCrearProveedor()
	{

		if (isset($_POST["nuevoRUC"])) {

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS Proveedores DE LOS PRODUCTOS
			=============================================*/

			if ($_POST["listaProductoss"] == "") {

				echo '<script>

				swal({
					  type: "error",
					  title: "El Proveedor no se ha ejecuta si no hay productos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "proveedores";

								}
							})

				</script>';

				return;
			}


			$listaProductoss = json_decode($_POST["listaProductoss"], true);

			$totalProductosComprados = array();



			/*=============================================
			GUARDAR LA COMPRA
			=============================================*/

			$tabla = "proveedores";

			$datos = array(
				"ruc" => $_POST["nuevoRUC"],
				"nombre" => $_POST["nuevoProveedor"],
				"direccion" => $_POST["nuevoDireccionn"],
				"telefono" => $_POST["nuevoTelefonoo"],
				"email" => $_POST["nuevoEmaill"],
				"productos"=>$_POST["listaProductoss"],
			);

			$respuesta = ModeloProveedores::mdlIngresarProveedor($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La Proveedor ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "proveedores";

								}
							})

				</script>';
			}
		}
	}

	/*=============================================
	EDITAR Proveedor
	=============================================*/

	static public function ctrEditarProveedor()
	{

		if (isset($_POST["editarRUC"])) {

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "proveedores";

			$item = "id";
			$valor = $_POST["idProveedor"];

			$traerProveedor = ModeloProveedores::mdlMostrarProveedores($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/

			if ($_POST["listaProductoss"] == "") {

				$listaProductoss = $traerProveedor["productos"];
				$cambioProducto = false;
			} else {

				$listaProductoss = $_POST["listaProductoss"];
				$cambioProducto = true;
			}
	

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/

			$datos = array(
				"id" => $_POST["idProveedor"],
				"ruc" => $_POST["editarRUC"],
				"nombre" => $_POST["editarProveedor"],
				"direccion" => $_POST["editarDireccionn"],
				"telefono" => $_POST["editarTelefonoo"],
				"email" => $_POST["editarEmaill"],
				"productos"=>$listaProductoss
			);


			$respuesta = ModeloProveedores::mdlEditarProveedor($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La Proveedor ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "proveedores";

								}
							})

				</script>';
			}
		}
	}


	/*=============================================
	ELIMINAR Proveedor
	=============================================*/

	static public function ctrEliminarProveedor()
	{

		if (isset($_GET["idProveedor"])) {

			$tabla = "proveedores";

			$item = "id";
			$datos = $_GET["idProveedor"];


			var_dump($datos);
			echo ($datos);
			/*=============================================
			ELIMINAR Proveedor
			=============================================*/

			$respuesta = ModeloProveedores::mdlEliminarProveedor("proveedores", $datos);

			if ($respuesta == "ok") {

				echo '<script>

				swal({
					  type: "success",
					  title: "La Proveedor ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "proveedores";

								}
							})

				</script>';
			
			}
		}
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/

	static public function ctrRangoFechasProveedores($fechaInicial, $fechaFinal)
	{

		$tabla = "Proveedores";

		$respuesta = ModeloProveedores::mdlRangoFechasProveedores($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte()
	{

		if (isset($_GET["reporte"])) {

			$tabla = "Proveedores";

			if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

				$Proveedores = ModeloProveedores::mdlRangoFechasProveedores($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);
			} else {

				$item = null;
				$valor = null;

				$Proveedores = ModeloProveedores::mdlMostrarProveedores($tabla, $item, $valor);
			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"] . '.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate");
			header('Content-Description: File Transfer');
			header('Last-Modified: ' . date('D, d M Y H:i:s'));
			header("Pragma: public");
			header('Content-Disposition:; filename="' . $Name . '"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($Proveedores as $row => $item) {

				$cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
				$vendedor = ControladorAdministradores::ctrMostrarAdministradores("id", $item["id_vendedor"]);

				echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>" . $item["codigo"] . "</td> 
			 			<td style='border:1px solid #eee;'>" . $cliente["nombre"] . "</td>
			 			<td style='border:1px solid #eee;'>" . $vendedor["nombre"] . "</td>
			 			<td style='border:1px solid #eee;'>");

				$productos =  json_decode($item["productos"], true);

				foreach ($productos as $key => $valueProductos) {

					echo utf8_decode($valueProductos["cantidad"] . "<br>");
				}

				echo utf8_decode("</td><td style='border:1px solid #eee;'>");

				foreach ($productos as $key => $valueProductos) {

					echo utf8_decode($valueProductos["descripcion"] . "<br>");
				}

				echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>S/ " . number_format($item["impuesto"], 2) . "</td>
					<td style='border:1px solid #eee;'>S/ " . number_format($item["neto"], 2) . "</td>	
					<td style='border:1px solid #eee;'>S/ " . number_format($item["total"], 2) . "</td>
					<td style='border:1px solid #eee;'>" . $item["metodo_pago"] . "</td>
					<td style='border:1px solid #eee;'>" . substr($item["fecha"], 0, 10) . "</td>		
		 			</tr>");
			}


			echo "</table>";
		}
	}


	/*=============================================
	SUMA TOTAL Proveedores
	=============================================*/

	public function ctrSumaTotalProveedores()
	{

		$tabla = "proveedores";

		$respuesta = ModeloProveedores::mdlSumaTotalProveedores($tabla);

		return $respuesta;
	}
}
