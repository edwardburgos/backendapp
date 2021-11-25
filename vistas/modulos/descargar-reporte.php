<?php

require_once "../../controladores/ventas.controlador.php";
require_once "../../modelos/ventas.modelo.php";
require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";
require_once "../../controladores/administradores.controlador.php";
require_once "../../modelos/administradores.modelo.php";

$reporte = new ControladorVentas();
$reporte -> ctrDescargarReporte();