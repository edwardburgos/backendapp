<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/administradores.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/subcategorias.controlador.php";
require_once "controladores/cabeceras.controlador.php";
require_once "controladores/perfiles.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/ordencompra.controlador.php";
require_once "controladores/proveedores.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventasecommerce.controlador.php";

require_once "modelos/administradores.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/subcategorias.modelo.php";
require_once "modelos/cabeceras.modelo.php";
require_once "modelos/mensajes.modelo.php";
require_once "modelos/perfiles.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/ordencompra.modelo.php";
require_once "modelos/proveedores.modelo.php";
require_once "modelos/ventasecommerce.modelo.php";

require_once "modelos/rutas.php";

$plantilla = new ControladorPlantilla();
$plantilla -> plantilla();