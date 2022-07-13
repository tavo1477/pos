<?php 

require_once "../controladores/categoriaControlador.php";;
require_once "../modelos/categoriaModelo.php";

class AjaxCategorias{

	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/

	public $idCategoria;

	public function ajaxEditarCategoria(){

		$item = "id";
		$valor = $this->idCategoria;

		$respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
EDITAR CATEGORÍA
=============================================*/

if (isset($_POST["idCategoria"])) {
	
	$editarCategoria = new AjaxCategorias();
	$editarCategoria -> idCategoria = $_POST["idCategoria"];
	$editarCategoria -> ajaxEditarCategoria();

}