<?php 

require_once "controladores/plantillaControlador.php";

require_once "controladores/UsuarioControlador.php";
require_once "modelos/UsuarioModelo.php";

require_once "controladores/categoriaControlador.php";
require_once "modelos/categoriaModelo.php";

require_once "controladores/productosControlador.php";
require_once "modelos/productosModelo.php";


require_once "controladores/clientesControlador.php";
require_once "modelos/ClientesModelo.php";

require_once "controladores/ventasControlador.php";
require_once "modelos/ventasModelo.php";


$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();