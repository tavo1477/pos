<?php 

require_once "../controladores/productosControlador.php";
require_once "../modelos/productosModelo.php";

class AjaxProductos{

	/*=============================================
	GENERAR CÓDIGO A PARTIR DE ID CATEGORÍA
	=============================================*/	

	public $idCategoria;

	public function ajaxCrearCodigoProducto(){

		$item = "id_categoria";
		$valor = $this->idCategoria;

		$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	EDITAR PRODUCTO
	=============================================*/	

	public $idProducto;

	public function ajaxEditarProducto(){

		$item = "id";
		$valor = $this->idProducto;

		$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
GENERAR CÓDIGO A PARTIR DE ID CATEGORÍA
=============================================*/	

if (isset($_POST["idCategoria"])) {
	
	$codigoProducto = new AjaxProductos();
	$codigoProducto -> idCategoria = $_POST["idCategoria"];
	$codigoProducto -> ajaxCrearCodigoProducto();

}

/*=============================================
EDITAR PRODUCTO
=============================================*/

if (isset($_POST["idProducto"])) {

	$editarProducto = new AjaxProductos();
	$editarProducto -> idProducto = $_POST["idProducto"];
	$editarProducto -> ajaxEditarProducto();

}