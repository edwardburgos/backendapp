<?php

class ControladorOrdencompra
{

	/*=============================================
	MOSTRAR Ordencompra
	=============================================*/

	static public function ctrMostrarOrdencompra($item, $valor)
	{

		$tabla = "ordencompra";

		$respuesta = ModeloOrdencompra::mdlMostrarOrdencompra($tabla, $item, $valor);

		return $respuesta;
	}

	public function ctrMostrarTotalOrdencompra()
	{

		$tabla = "ordencompra";

		$respuesta = ModeloOrdencompra::mdlMostrarTotalOrdencompra($tabla);

		return $respuesta;
	}
	/*=============================================
	CREAR VENTA
	=============================================*/

	static public function ctrCrearOrden()
	{

		if (isset($_POST["nuevaOrden"])) {

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/

			if ($_POST["listaProductosOrden"] == "") {

				echo '<script>

				swal({
					  type: "error",
					  title: "La Orden no se ha ejecuta si no hay productos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ordencompra";

								}
							})

				</script>';

				return;
			}


			$listaProductosOrden = json_decode($_POST["listaProductosOrden"], true);

			$totalProductosComprados = array();

			date_default_timezone_set('America/Bogota');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b_2 = $fecha . ' ' . $hora;

			$esta = "0";
			$coment = "";
			$codigo = "";

			/*=============================================
			GUARDAR LA ORDEN
			=============================================*/

			$tabla = "ordencompra";

			$datos = array(
				"id_proveedor" => $_POST["idProveedor"],
				"id_trabajador" => $_POST["idTrabajador"],
				"codigo" => $_POST["nuevaOrden"],
				"productos" => $_POST["listaProductosOrden"],
				"impuesto" => $_POST["nuevoPrecioImpuestoOrden"],
				"neto" => $_POST["nuevoPrecioNetoOrden"],
				"total" => $_POST["totalOrden"],
				"estado" => $esta,
				"comentario" => $coment,
				"codigoprovee" => $codigo,
				"fecha" => $valor1b_2
			);

			//var_dump($datos);

			$respuesta = ModeloOrdencompra::mdlIngresarOrdencompra($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La orden ha sido guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ordencompra";

								}
							})

				</script>';
			}
		}
	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function ctrEditarOrden()
	{

		if (isset($_POST["editarOrden"])) {

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "ventas";

			$item = "codigo";
			$valor = $_POST["editarOrden"];

			$traerOrden = ModeloOrdencompra::mdlMostrarOrdencompra($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/

			if ($_POST["listaProductosOrdenedi"] == "") {

				$listaProductosOrden = $traerOrden["productos"];
				$cambioProducto = false;
			} else {

				$listaProductosOrden = $_POST["listaProductosOrdenedi"];
				$cambioProducto = true;
			}

			if ($cambioProducto) {

				$productos =  json_decode($listaProductosOrden, true);

				$totalProductosComprados = array();

				foreach ($productos as $key => $value) {

					array_push($totalProductosComprados, $value["cantidad"]);

					$tablaProductos = "productos";

					$item = "id";
					$valor = $value["id"];
					$orden = "id";

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);


					$item1b = "stock";
					$valor1b = $value["cantidadingreso"] + $traerProducto[0]["stock"];

					$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
				}


				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha . ' ' . $hora;
			}

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/

			$esta = "1";

			/*=============================================
		GUARDAR LA ORDEN
		=============================================*/

			$tabla = "ordencompra";

			$datos = array(
				"id" => $_POST["idOrden"],
				"id_proveedor" => $_POST["idProveedoredit"],
				"id_trabajadorrecibe" => $_POST["idTraba"],
				"codigo" => $_POST["editarOrden"],
				"productos" => $listaProductosOrden,
				"impuesto" => $_POST["nuevoPrecioImpuestoOrdenedi"],
				"neto" => $_POST["nuevoPrecioNetoOrdenedi"],
				"total" => $_POST["nuevoTotalOrdenedi"],
				"estado" => $esta,
				"comentario" => $_POST["comentario"],
				"codigoprovee" => $_POST["codigoprovee"],
				"fecharecibido" => $valor1b_2
			);
         //var_dump($datos);

			$respuesta = ModeloOrdencompra::mdlEditarOrdencompra($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La Orden ha sido recibida correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "ordencompra";

								}
							})

				</script>';
			}
		}
	}


	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function ctrEliminarOrden()
	{

		if (isset($_GET["idOrden"])) {

			$tabla = "ordencompra";

			$item = "id";
			$valor = $_GET["idOrden"];

			/*=============================================
			ELIMINAR ORDEN
			=============================================*/

			$respuesta = ModeloOrdencompra::mdlEliminarOden($tabla, $_GET["idOrden"]);

			if ($respuesta == "ok") {

				echo '<script>

				swal({
					  type: "success",
					  title: "La Orden ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ordencompra";

								}
							})

				</script>';
			}
		}
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/

	static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal)
	{

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte()
	{

		if (isset($_GET["reporte"])) {

			$tabla = "ventas";

			if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

				$ventas = ModeloVentas::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);
			} else {

				$item = null;
				$valor = null;

				$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
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

			foreach ($ventas as $row => $item) {

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
	SUMA TOTAL VENTAS
	=============================================*/

	public function ctrSumaTotalVentas()
	{

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

		return $respuesta;
	}
}
