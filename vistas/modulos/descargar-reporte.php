<?php 

require_once "../../controladores/ventasControlador.php";
require_once "../../modelos/ventasModelo.php";
require_once "../../controladores/clientesControlador.php";
require_once "../../modelos/ClientesModelo.php";
require_once "../../controladores/UsuarioControlador.php";
require_once "../../modelos/UsuarioModelo.php";

$reporte = new ControladorVentas();
$reporte -> ctrDescargarReporte();



