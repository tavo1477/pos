<?php

require_once '../../../controladores/ventasController.php';
require_once '../../../modelos/ventasModel.php';

require_once '../../../controladores/clientesController.php';
require_once '../../../modelos/clientesModel.php';

require_once '../../../controladores/usuariosController.php';
require_once '../../../modelos/usuariosModel.php';

require_once '../../../controladores/productosController.php';
require_once '../../../modelos/productosModel.php';

class ImprimirFactura{

public $codigo;

public function traerImpresionFactura(){

$itemVenta = "codigo";
$valorVenta = $this->codigo;

$respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

$fecha = substr($respuestaVenta["fecha"], 0,-8);
$productos = json_decode($respuestaVenta["productos"], true);
$neto = number_format($respuestaVenta["neto"],2);
$impuesto = number_format($respuestaVenta["impuesto"],2);
$total = number_format($respuestaVenta["total"],2);

// TRAER LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id";
$valorCliente = $respuestaVenta["id_cliente"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

// TRAER LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_vendedor"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);


require_once('tcpdf_include.php');


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetFont('dejavusans', '', 10);

$pdf->AddPage();

$bloque1 = '<table>
        
        <tr>
            
            <td style="width:150px"><img src="images/logo-negro-bloque.png"></td>

            <td style="background-color:white; width:140px">
                
                <div style="font-size:8.5px; text-align:right; line-height:15px;">
                    
                    <br>
                    NIT: 71.759.963-9

                    <br>
                    Dirección: Residencial Bosques y Fresales

                </div>

            </td>

            <td style="background-color:white; width:140px">

                <div style="font-size:8.5px; text-align:right; line-height:15px;">
                    
                    <br>
                    Teléfono: 506 8880 0561
                    
                    <br>
                    ventas@inventorysystem.com

                </div>
                
            </td>

            <td style="background-color:white; width:110px; text-align:center; color:red"><br><br>FACTURA N.<br>'.$valorVenta.'</td>

        </tr>

    </table>';

// output the HTML content
$pdf->writeHTML($bloque1, true, false, true, false, '');

$bloque2 = '<table style="font-size:10px; padding:5px 10px">
    
    <tr>

        <td style="border:1px solid #666; background:white; width:390px">
            
            Cliente: '.$respuestaCliente["nombre"].'

        </td>

        <td style="border:1px solid #666; background:white; width:150px; text-align:right">
            
            Fecha: '.$fecha.'

        </td>

    </tr>

    <tr>
        
        <td style="border:1px solid #666; background:white; width:540px;">

            Vendedor: '.$respuestaVendedor["nombre"].'

        </td>

    </tr>

</table>';

$pdf->writeHTML($bloque2, true, false, true, false, '');

$bloque3 = '<table style="font-size:10px; padding:5px 10px;">

        <tr>
        
        <td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Producto</td>
        <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Cantidad</td>
        <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Unit.</td>
        <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Total</td>

        </tr>

    </table>';

$pdf->writeHTML($bloque3, true, false, true, false, '');

foreach ($productos as $key => $item) {

$itemProducto = "descripcion"    ;
$valorProducto = $item["descripcion"];
$orden = null;

$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

$valorUnitario = number_format($respuestaProducto["precio_venta"], 2);

$precioTotal = number_format($item["total"], 2);

$bloque4 = '<table style="font-size:10px; padding:5px 10px;">

        <tr>
            
            <td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
                '.$item["descripcion"].'
            </td>

            <td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
                '.$item["cantidad"].'
            </td>

            <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
                '.$valorUnitario.'
            </td>

            <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
                '.$precioTotal.'
            </td>


        </tr>

    </table>';

$pdf->writeHTML($bloque4, true, false, true, false, '');

}

$bloque5 = '<table style="font-size:10px; padding:5px 10px">

    <tr>
        
        <td style="color:#333; background;white; width:340px; text-align:center"></td>

        <td style="border-bottom:1px solid #666; background:white; width:100px; text-align:center"></td>
        
        <td style="border-bottom:1px solid #666; color:#333; background:white; width:100px; text-align:center"></td>

    </tr>

    <tr>
        
         <td style="border-right:1px solid #666; color:#333; background:white; width:340px; text-align:center"></td>

         <td style="border:1px solid #666; background:white; width:100px; text-align:center">
            Neto:
         </td>

         <td style="border:1px solid #666; color:#333; background:white; width:100px; text-align:center">
           $ '.$neto.'
         </td>

    </tr>

    <tr>
        
         <td style="border-right:1px solid #666; color:#333; background:white; width:340px; text-align:center"></td>

         <td style="border:1px solid #666; background:white; width:100px; text-align:center">
            Impuesto:
         </td>

         <td style="border:1px solid #666; color:#333; background:white; width:100px; text-align:center">
           $ '.$impuesto.'
         </td>

    </tr>

    <tr>
        
         <td style="border-right:1px solid #666; color:#333; background:white; width:340px; text-align:center"></td>

         <td style="border:1px solid #666; background:white; width:100px; text-align:center">
            Total:
         </td>

         <td style="border:1px solid #666; color:#333; background:white; width:100px; text-align:center">
           $ '.$total.'
         </td>

    </tr>

</table>';

$pdf->writeHTML($bloque5, true, false, true, false, '');

$pdf->Output('factura.pdf', 'I');

}

}

$factura = new ImprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();