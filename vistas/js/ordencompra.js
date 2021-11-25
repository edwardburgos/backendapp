/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/

// $.ajax({

// 	url: "ajax/datatable-ventas.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })// 

$('.tablasordencompra').DataTable( {
    "ajax": "ajax/tablaordencompra.ajax.php",
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

} );


/*=============================================
LISTAR PRODUCTOS POR PROVEEDOR
=============================================*/
$('#seleccionarProveedor').change(function(){

	var codd=$('#seleccionarProveedor').val();

//	console.log(codd);
	$("#tablaProductosProveedors").dataTable().fnDestroy();
});


/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/
$(".tablaProductosProveedors tbody").on("click", "button.agregarProducto", function(){

	var idProducto = $(this).attr("idProducto");

	$(this).removeClass("btn-primary agregarProducto");

	$(this).addClass("btn-default");

	var datos = new FormData();
    datos.append("idProducto", idProducto);

     $.ajax({

     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
     // console.log("respuesta",respuesta[0]["stock"]);
      	    var descripcion = respuesta[0]["descripcion"];
          	var stock = respuesta[0]["stock"];
          	var precio = respuesta[0]["precio"];


          	$(".nuevoProducto").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del producto -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+

	              '<input type="text" class="form-control nuevaDescripcionProductoP" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+

	            '</div>'+

			  '</div>'+
			  '<!-- Precio del producto -->'+

	          '<div class="col-xs-2 ingresoPrecioProveedor">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon">S/ </span>'+
	                 
	              '<input type="text" class="form-control ProveedorPrecio"  name="ProveedorPrecio" id="ProveedorPrecio" value="00" required>'+
	 
	            '</div>'+
	             
	          '</div>'+
			
	          '<!-- Cantidad del producto -->'+

	          '<div class="col-xs-2 ingresoCantidadProveedor" value="150">'+
	            
	             '<input type="number" class="form-control nuevaCantidadProveedor" name="nuevaCantidadProveedor" id="nuevaCantidadProveedor min="1" value="1" required>'+

	          '</div>' +

	          '<!-- Precio del producto -->'+

	          '<div class="col-xs-2 ingresoPrecioP" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon">S/ </span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioProductoP"  name="nuevoPrecioProductoP" id="nuevoPrecioProductoP" value="00" readonly required>'+
	 
	            '</div>'+
	             
			  '</div>'+
		

	        '</div>') 

	        // SUMAR TOTAL DE PRECIOS

	        sumarTotalPreciosP()


		agregarImpuestoP()
	        // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductosP()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProductoP").number(true, 2);

			//$(".ProveedorPrecio").number(true, 2);
			localStorage.removeItem("quitarProducto");

      	}

     })

});

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaProductosProveedors").on("draw.dt", function(){

	if(localStorage.getItem("quitarProducto") != null){

		var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));

		for(var i = 0; i < listaIdProductos.length; i++){

			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');
			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');

		}


	}


})


/*$(".formularioOrden").on("change", "input#ProveedorPrecio", function(){

	var precio=$('#ProveedorPrecio').val();
	//console.log(precio);
	$("#nuevoPrecioProductoP").val(precio);
});*/
/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProducto = [];

localStorage.removeItem("quitarProducto");

$(".formularioOrden").on("click", "button.quitarProducto", function(){

	$(this).parent().parent().parent().parent().remove();

	var idProducto = $(this).attr("idProducto");

	/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/

	if(localStorage.getItem("quitarProducto") == null){

		idQuitarProducto = [];
	
	}else{

		idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

	}

	idQuitarProducto.push({"idProducto":idProducto});

	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

	$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');

	$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');

	if($(".nuevoProducto").children().length == 0){

		//$("#nuevoImpuestoVenta").val(0);
		$("#nuevoTotalOrden").val(0);
		$("#totalOrden").val(0);
		$("#nuevoTotalOrden").attr("total",0);

	}else{

		// SUMAR TOTAL DE PRECIOS

    	sumarTotalPreciosP()


		agregarImpuestoP()
        // AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductosP()

	}

})


/*=============================================
SELECCIONAR PRODUCTO
=============================================*/

$(".formularioOrden").on("change", "select.nuevaDescripcionProductoP", function(){

	var nombreProducto = $(this).val();

	var nuevaDescripcionProductoP = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionProductoP");

	var nuevoPrecioProductoP = $(this).parent().parent().parent().children(".ingresoPrecioP").children().children(".nuevoPrecioProductoP");

	var nuevaCantidadProveedor = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProveedor");


	var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);


	  $.ajax({

     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	     $(nuevaDescripcionProductoP).attr("idProducto", respuesta["id"]);
      	    $(nuevaCantidadProveedor).attr("stock", respuesta["stock"]);
      	    $(nuevaCantidadProveedor).attr("nuevoStock", Number(respuesta["stock"])-1);
      	    $(nuevoPrecioProductoP).val(respuesta["precio"]);
      	    $(nuevoPrecioProductoP).attr("precioReal", respuesta["precio"]);

  	      // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductosP()

      	}

      })
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioOrden").on("change", "input.nuevaCantidadProveedor", function(){
	var precio = $(this).parent().parent().children(".ingresoPrecioProveedor").children().children(".ProveedorPrecio");

	var precioo = $(this).parent().parent().children(".ingresoPrecioP").children().children(".nuevoPrecioProductoP");

	var precioFinal = $(this).val() * precio.val();
	//console.log(precioFinal);
	precioo.val(precioFinal);

	var nuevoStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("nuevoStock", nuevoStock);

	// SUMAR TOTAL DE PRECIOS
	sumarTotalPreciosP()

	agregarImpuestoP()
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductosP()

})



$(".formularioOrdenedi").on("change", "input.nuevaCantidadProveedoredi", function(){
	
	var precio = $(this).parent().parent().children(".ingresoPrecioProveedoredi").children().children(".ProveedorPrecioedi");

	var precioo = $(this).parent().parent().children(".ingresoPrecioedi").children().children(".nuevoPrecioProductoedi");

	var precioFinal = $(this).val() * precio.val();
	//console.log(precio);
	//console.log(precioo);
	precioo.val(precioFinal);

	var nuevoStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("nuevoStock", nuevoStock);

	// SUMAR TOTAL DE PRECIOS
	sumarTotalPreciosedi()

	agregarImpuestoedi()

	listarProductosedi()

	
})


$(".formularioOrdenedi").on("change", "input#codigoprovee", function(){



listarProductosedi()

})


$(".formularioOrden").on("change", "input#ProveedorPrecio", function(){
	//$("#ProveedorPrecio").change(function(){
	var preci = $(this).parent().parent().parent().children(".ingresoCantidadProveedor").children(".nuevaCantidadProveedor");

	var prec = $(this).parent().parent().parent().children(".ingresoPrecioP").children().children(".nuevoPrecioProductoP");
	
	//console.log(preci.val());
	var precioF = $(this).val() * preci.val();

	prec.val(precioF);
	var nuevoStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("nuevoStock", nuevoStock);

	// SUMAR TOTAL DE PRECIOS
	sumarTotalPreciosP()

	agregarImpuestoP()
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductosP()

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPreciosP(){

	var precioItem = $(".nuevoPrecioProductoP");
	
	var arraySumaPrecio = [];  

	for(var i = 0; i < precioItem.length; i++){

		 arraySumaPrecio.push(Number($(precioItem[i]).val()));
		
		 
	}

	function sumaArrayPrecios(total, numero){

		return total + numero;

	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	
	$("#nuevoTotalOrden").val(sumaTotalPrecio);
	$("#totalOrden").val(sumaTotalPrecio);
	$("#nuevoTotalOrden").attr("total",sumaTotalPrecio);


}

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPreciosedi(){

	var precioItem = $(".nuevoPrecioProductoedi");
	
	var arraySumaPrecio = [];  

	for(var i = 0; i < precioItem.length; i++){

		 arraySumaPrecio.push(Number($(precioItem[i]).val()));
		
		 
	}

	function sumaArrayPrecios(total, numero){

		return total + numero;

	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	
	$("#nuevoTotalOrdenedi").val(sumaTotalPrecio);
	$("#totalOrdenedi").val(sumaTotalPrecio);
	$("#nuevoTotalOrdenedi").attr("total",sumaTotalPrecio);


}

/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/

function agregarImpuestoedi(){

	var impuesto = $("#nuevoImpuestoOrdenedi").val();
	var precioTotal = $("#nuevoTotalOrdenedi").attr("total");

	var precioImpuesto = Number(precioTotal * impuesto/100);
	var precioSinImpuesto = Number(precioTotal-(precioTotal * impuesto/100));
	var totalConImpuesto =  Number(precioTotal);
	
	$("#nuevoTotalOrdenedi").val(totalConImpuesto );

	$("#totalOrdenedi").val(totalConImpuesto);

	$("#nuevoPrecioImpuestoOrdenedi").val(precioImpuesto);

	$("#nuevoPrecioNetoOrdenedi").val(precioSinImpuesto);

}

/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/

function agregarImpuestoP(){

	var impuesto = $("#nuevoImpuestoOrden").val();
	var precioTotal = $("#nuevoTotalOrden").attr("total");

	var precioImpuesto = Number(precioTotal * impuesto/100);
	var precioSinImpuesto = Number(precioTotal-(precioTotal * impuesto/100));
	var totalConImpuesto =  Number(precioTotal);
	
	$("#nuevoTotalOrden").val(totalConImpuesto );

	$("#totalOrden").val(totalConImpuesto);

	$("#nuevoPrecioImpuestoOrden").val(precioImpuesto);

	$("#nuevoPrecioNetoOrden").val(precioSinImpuesto);

}

/*=============================================
CUANDO CAMBIA EL IMPUESTO
=============================================*/

$("#nuevoImpuestoOrden").change(function(){

	agregarImpuestoP();

});


/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/

$("#nuevoTotalOrden").number(true, 2);

/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/

$("#nuevoMetodoPago").change(function(){

	var metodo = $(this).val();

	if(metodo == "Efectivo"){

		$(this).parent().parent().removeClass("col-xs-6");

		$(this).parent().parent().addClass("col-xs-4");

		$(this).parent().parent().parent().children(".cajasMetodoPago").html(

			 '<div class="col-xs-4">'+ 

			 	'<div class="input-group">'+ 

			 		'<span class="input-group-addon" id="dolar">S/ </i></span>'+ 

			 		'<input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="000000" required>'+
					 
				 '</div>'+
				 '<th><p id="error" style="color:red;">Monto Menor al Total </p></th>'+

			 '</div>'+

			 '<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">'+

			 	'<div class="input-group">'+

			 		'<span class="input-group-addon">S/ </i></span>'+

			 		'<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>'+

				 '</div>'+
				 '<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Vuelto </p>'+

			 '</div>'

		 )

		// Agregar formato al precio

		$('#nuevoValorEfectivo').number( true, 2);
      	$('#nuevoCambioEfectivo').number( true, 2);


      	// Listar método en la entrada
      	listarMetodos()

	}else{

		$(this).parent().parent().removeClass('col-xs-4');

		$(this).parent().parent().addClass('col-xs-6');

		 $(this).parent().parent().parent().children('.cajasMetodoPago').html(

		 	'<div class="col-xs-6" style="padding-left:0px">'+
                        
                '<div class="input-group">'+
                     
                  '<input type="number" min="0" class="form-control" id="nuevoCodigoTransaccion" placeholder="Código transacción"  required>'+
                       
                  '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
                  
                '</div>'+

              '</div>')

	}

	

})





/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductosP(){

	var listaProductosOrden = [];

	var descripcion = $(".nuevaDescripcionProductoP");

	var cantidad = $(".nuevaCantidadProveedor");

	var precio = $(".nuevoPrecioProductoP");

	var preciouni = $(".ProveedorPrecio");

	var cantidadingreso =$(".nuevaCantidadProveedor");

	for(var i = 0; i < descripcion.length; i++){

		listaProductosOrden.push({ "id" : $(descripcion[i]).attr("idProducto"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "preciouni" : $(preciouni[i]).val(),
							  "cantidadingreso" :  $(cantidadingreso[i]).val(),
							  "precio" : $(precio[i]).attr("precioReal"),
							  "total" : $(precio[i]).val()})

	}

	$("#listaProductosOrden").val(JSON.stringify(listaProductosOrden)); 

}


function listarProductosedi(){

	var listaProductosOrden = [];

	var descripcion = $(".nuevaDescripcionProductoedi");

	var cantidad = $(".nuevaCantidadProductoedi");

	var precio = $(".nuevoPrecioProductoedi");

	var preciouni = $(".ProveedorPrecioedi");

	var cantidadingreso = $(".nuevaCantidadProveedoredi");

	for(var i = 0; i < descripcion.length; i++){

		listaProductosOrden.push({ "id" : $(descripcion[i]).attr("idProducto"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "preciouni" : $(preciouni[i]).val(),
							  "cantidadingreso" :  $(cantidadingreso[i]).val(),
							  "precio" : $(precio[i]).attr("precioReal"),
							  "total" : $(precio[i]).val()})

	}

	$("#listaProductosOrdenedi").val(JSON.stringify(listaProductosOrden)); 


	
}


/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablasordencompra").on("click", ".btnEditarOrden", function(){

	var idOrden = $(this).attr("idOrden");

	window.location = "index.php?ruta=editar-ordencompra&idOrden="+idOrden;

})

/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarProducto(){

	//Capturamos todos los id de productos que fueron elegidos en la venta
	var idProductos = $(".quitarProducto");

	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaProductosProveedors tbody button.agregarProducto");

	//Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
	for(var i = 0; i < idProductos.length; i++){

		//Capturamos los Id de los productos agregados a la venta
		var boton = $(idProductos[i]).attr("idProducto");
		
		//Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
		for(var j = 0; j < botonesTabla.length; j ++){

			if($(botonesTabla[j]).attr("idProducto") == boton){

				$(botonesTabla[j]).removeClass("btn-primary agregarProducto");
				$(botonesTabla[j]).addClass("btn-default");

			}
		}

	}
	
}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaProductosProveedors').on( 'draw.dt', function(){

	quitarAgregarProducto();

})


/*=============================================
BORRAR VENTA
=============================================*/


$(".tablasordencompra").on("click", ".btnEliminarOrden", function(){

	var idOrden = $(this).attr("idOrden");
  
	swal({
		  title: '¿Está seguro de borrar la Orden?',
		  text: "¡Si no lo está seguro puede cancelar la accíón!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  cancelButtonText: 'Cancelar',
		  confirmButtonText: 'Si, borrar Orden!'
		}).then(function(result){
		  if (result.value) {
			
			  window.location = "index.php?ruta=ordencompra&idOrden="+idOrden;
		  }
  
	})
  
  })

/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablasordencompra").on("click", ".btnImprimirOrden", function(){

	var codigoOrden = $(this).attr("codigoOrden");

	window.open("extensiones/tcpdf/pdf/ordencompra.php?codigo="+codigoOrden, "_blank");

})

/*=============================================
RANGO DE FECHAS
=============================================*/

$('#daterange-btn').daterangepicker(
  {
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');

    var fechaFinal = end.format('YYYY-MM-DD');

    var capturarRango = $("#daterange-btn span").html();
   
   	localStorage.setItem("capturarRango", capturarRango);

   	window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

  }

)

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("capturarRango");
	localStorage.clear();
	window.location = "ventas";
})

/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click", function(){

	var textoHoy = $(this).attr("data-range-key");

	if(textoHoy == "Hoy"){

		var d = new Date();
		
		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();

		if(mes < 10){

			var fechaInicial = año+"-0"+mes+"-"+dia;
			var fechaFinal = año+"-0"+mes+"-"+dia;

		}else if(dia < 10){

			var fechaInicial = año+"-"+mes+"-0"+dia;
			var fechaFinal = año+"-"+mes+"-0"+dia;

		}else if(mes < 10 && dia < 10){

			var fechaInicial = año+"-0"+mes+"-0"+dia;
			var fechaFinal = año+"-0"+mes+"-0"+dia;

		}else{

			var fechaInicial = año+"-"+mes+"-"+dia;
	    	var fechaFinal = año+"-"+mes+"-"+dia;

		}	

    	localStorage.setItem("capturarRango", "Hoy");

    	window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

	}

})




