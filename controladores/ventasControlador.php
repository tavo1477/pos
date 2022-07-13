<?php 

class ControladorVentas{

	/*=====================================
    ENTRADA DEL VENDEDOR
    ======================================*/

	static public function ctrMostrarVentas($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

		return $respuesta;

	}

}