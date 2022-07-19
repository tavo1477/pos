<?php 

require_once "conexion.php";

class ModeloVentas{

	/*=====================================
    ENTRADA DEL VENDEDOR
    ======================================*/

	static public function mdlMostrarVentas($tabla, $item, $valor){

		if ($item != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY fecha");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha");			

			$stmt -> execute();

			return $stmt -> fetchAll();

		}		

		$stmt -> close();

		$stmt = null;	
	
	}

	/*=====================================
    REGISTRO DE VENTA
    ======================================*/

    static public function mdlIngresarVenta($tabla, $datos){

    	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos, impuesto, neto, total, metodo_pago) VALUES(:codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago)");

    	$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
    	$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
    	$stmt -> bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
    	$stmt -> bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
    	$stmt -> bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
    	$stmt -> bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
    	$stmt -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
    	$stmt -> bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);

    	if ($stmt -> execute()) {
    		
    		return "ok";

    	} else {

    		return "error";

    	} 

    	$stmt -> close();

		$stmt = null;	

    }

}