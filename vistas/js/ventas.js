/*=============================================
CARGAMOS LA TABLA DINÁMICA DE VENTAS
=============================================*/

// $.ajax({

// 	url: "ajax/datatable-ventas.ajax.php",
// 	success:function(respuesta){

// 		console.log("respuesta", respuesta);

// 	}

// })

$('.tablaVentas').DataTable({
    ajax: 'ajax/datatable-ventas.ajax.php',
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}
	}

})

/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/

$(".tablaVentas tbody").on("click", "button.agregarProducto", function(){

	var idProducto = $(this).attr("idProducto")	

	$(this).removeClass("btn-primary agregarProducto")

	$(this).addClass("btn-default")

	var datos = new FormData()
	datos.append("idProducto", idProducto)

	$.ajax({

		url: "ajax/productos.ajax.php"	,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			var descripcion = respuesta["descripcion"]
			var stock = respuesta["stock"]
			var precio = respuesta["precio_venta"]

			/*=============================================
			EVITAR AGREGAR PRODUCTO CUANDO EL STOCK ESTÁ EN CERO
			=============================================*/

			if (stock == 0) {

				swal({
					title: "No hay stock disponible",
					type: "error",
					confirmButtonText: "¡Cerrar!"
				})

				$("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto")

				return

			}

			$(".nuevoProducto").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del producto -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+

	              '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del producto -->'+

	          '<div class="col-xs-3">'+
	            
	             '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock="'+stock+'" nuevoStock="'+Number(stock-1)+'" required>'+

	          '</div>' +

	          '<!-- Precio del producto -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioProducto" precioReal="'+precio+'" name="nuevoPrecioProducto" value="'+precio+'" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>') 

	        // SUMAR TODOS LOS PRECIOS

	        sumarTotalPrecios()

	        // AGREGAR IMPUESTO

	        agregarImpuesto()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 2)
		}

	})

})

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaVentas").on("draw.dt", function(){

	if(localStorage.getItem("quitarProducto") != null){

		var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));

		for(var i = 0; i < listaIdProductos.length; i++){

			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');
			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');

		}


	}


})

/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProducto = []

localStorage.removeItem("quitarProducto")

$(".formularioVenta").on("click", "button.quitarProducto", function(){

	$(this).parent().parent().parent().parent().remove()

	var idProducto = $(this).attr("idProducto")

	/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/

	if(localStorage.getItem("quitarProducto") == null){

		idQuitarProducto = []
	
	}else{

		idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

	}

	idQuitarProducto.push({"idProducto":idProducto});

	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto))

	$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default')

	$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto')

	if ($(".nuevoProducto").children().length == 0) {

		$("#nuevoImpuestoVenta").val(0)
		$("#nuevoTotalVenta").val(0)
		$("#nuevoTotalVenta").attr("total", 0)

	} else {

		// SUMAR TODOS LOS PRECIOS

		sumarTotalPrecios()

		// AGREGAR IMPUESTO

	    agregarImpuesto()

	}

})

/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/

var numProducto = 0

$(".btnAgregarProducto").click(function(){

	numProducto++ 

	var datos = new FormData()
	datos.append("traerProductos", "ok")

	$.ajax({

		url: "ajax/productos.ajax.php"	,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			$(".nuevoProducto").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del producto -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>'+

	              '<select class="form-control nuevaDescripcionProducto" id="producto'+numProducto+'" idProducto name="nuevaDescripcionProducto" required>'+

	              	'<option>Seleccione el producto</option>'+

	              '</select>'+

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del producto -->'+

	          '<div class="col-xs-3 ingresoCantidad">'+
	            
	             '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock nuevoStock required>'+

	          '</div>' +

	          '<!-- Precio del producto -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioProducto" precioReal name="nuevoPrecioProducto" value="" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>') 

	        // AGREGAR LOS PRODUCTOS AL SELECT

	        respuesta.forEach(funcionForEach)

	        function funcionForEach(item, index){

	        	if (item.stock != 0) {

	        		$("#producto"+numProducto).append(

	        			'<option idProducto="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'

	        		)

	        	} 

	        	// SUMAR TODOS LOS PRECIOS

	       		sumarTotalPrecios()	

	       		// AGREGAR IMPUESTO

	        	agregarImpuesto()

	        	// PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        	$(".nuevoPrecioProducto").number(true, 2)
	        	
	        }

		}			

	})

})

/*=============================================
SELECCIONAR PRODUCTO
=============================================*/

$(".formularioVenta").on("change", "select.nuevaDescripcionProducto", function(){

	var nombreProducto = $(this).val()

	var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto")

	var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto")


	var datos = new FormData()
	datos.append("nombreProducto", nombreProducto)

	$.ajax({

		url: "ajax/productos.ajax.php"	,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			$(nuevaCantidadProducto).attr("stock", respuesta["stock"])
			$(nuevoPrecioProducto).val(respuesta["precio_venta"])
			$(nuevoPrecioProducto).attr("precioReal", respuesta["precio_venta"])
		}	

	})

})


/*=============================================
MODIFICAR CANTIDAD
=============================================*/

$(".formularioVenta").on("change", "input.nuevaCantidadProducto", function(){

    var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto")
    
	var precioFinal = $(this).val() * precio.attr("precioReal")
	
	precio.val(precioFinal)

	if (Number($(this).val()) > Number($(this).attr("stock"))) {

		$(this).val(1)

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INCIALES
		=============================================*/

		var precioFinal = $(this).val() * precio.attr("precioReal")

		precio.val(precioFinal)

		sumarTotalPrecios()

		swal({
			title: "No hay stock disponible",
			text: "¡Solo hay "+$(this).attr("stock")+" unidades!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		})

	}

	// SUMAR TODOS LOS PRECIOS

	 sumarTotalPrecios()

	// AGREGAR IMPUESTO

    agregarImpuesto()	

})

/*=============================================
SUMAR TODOS LOS PRODUCTOS
=============================================*/

function sumarTotalPrecios(){

	var precioItem = $(".nuevoPrecioProducto")

	arraySumaPrecio = []

	for(var i = 0; i < precioItem.length; i++){

		arraySumaPrecio.push(Number($(precioItem[i]).val()))		

	}

	function sumaaArrayPrecios(total, numero){

		return total + numero

	}

	var sumarTotalPrecio = arraySumaPrecio.reduce(sumaaArrayPrecios)

	$("#nuevoTotalVenta").val(sumarTotalPrecio)
	$("#nuevoTotalVenta").attr("total", sumarTotalPrecio)

}

/*=============================================
FUNCION AGREGAR IMPUESTO
=============================================*/

function agregarImpuesto(){

	var impuesto = $("#nuevoImpuestoVenta").val()
	var precioTotal = $("#nuevoTotalVenta").attr("total")

	var precioImpuesto = Number(precioTotal * impuesto/100)

	var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal)

	$("#nuevoTotalVenta").val(totalConImpuesto)

	$("#nuevoPrecioImpuesto").val(precioImpuesto)

	$("#nuevoPrecioNeto").val(precioTotal)

}

/*=============================================
CUANDO CAMBIE EL IMPUESTO
=============================================*/

$("#nuevoImpuestoVenta").change(function(){

	agregarImpuesto()	

})

/*=============================================
FORMATO Al PRECIO FINAL
=============================================*/

$("#nuevoTotalVenta").number(true, 2)

/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/

$("#nuevoMetodoPago").change(function(){

	var metodo = $(this).val()

	if (metodo == "efectivo") {

		$(this).parent().parent().removeClass("col-xs-6")

		$(this).parent().parent().addClass("col-xs-4")

		$(this).parent().parent().parent().children(".cajasMetodoPago").html(

			'<div class="col-xs-4">'+

				'<div class="input-group">'+

					'<span class="input-group-addon"><i class="ion-social-usd"></i></span>'+

					'<input type="text" class="form-control nuevoValorEfectivo" placeholder="0000" required>'+

				'</div>'+

			'</div>'+

			'<div class="col-xs-4 capturarCambioEfectivo" style="padding-left: 0">'+

				'<div class="input-group">'+

					'<span class="input-group-addon"><i class="ion-social-usd"></i></span>'+

					'<input type="text" class="form-control nuevoCambioEfectivo" placeholder="0000" readonly required>'+

				'</div>'+

			'</div>'

		)

		// AGREGAR FORMATO Al PRECIO

		$('.nuevoValorEfectivo').number(true, 2)
		$('.nuevoCambioEfectivo').number(true, 2)

	} else {

		$(this).parent().parent().removeClass("col-xs-4")

		$(this).parent().parent().addClass("col-xs-6")

		$(this).parent().parent().parent().children(".cajasMetodoPago").html(

			'<div class="col-xs-6" style="padding-left:0px">'+
                        
                '<div class="input-group">'+
                     
                  '<input type="text" class="form-control" id="nuevoCodigoTransaccion" name="nuevoCodigoTransaccion" placeholder="Código transacción"  required>'+
                       
                  '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
                  
                '</div>'+

              '</div>')

	}

})

/*=============================================
CAMBIO EN EFECTIVO
=============================================*/

$(".formularioVenta").on("change", "input.nuevoValorEfectivo", function(){

	var efectivo = $(this).val()

	var cambio = Number(efectivo) - Number($('#nuevoTotalVenta').val())

	var nuevoCambioEfectivo = $(this).parent().parent().parent().children(".capturarCambioEfectivo").children().children(".nuevoCambioEfectivo")

	nuevoCambioEfectivo.val(cambio)

})