/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/

// $.ajax({

// 	url: "ajax/datatable-ventas.ajax.php",
// 	success:function(respuesta){

// 		console.log("respuesta", respuesta);

// 	}

// })//

$(".tablaVentass").DataTable({
  ajax: "ajax/datatable-proveedores.ajax.php",
  deferRender: true,
  retrieve: true,
  processing: true,
  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },
});

$(".tablasproveedores").DataTable({
  ajax: "ajax/tablaproveedores.ajax.php",
  deferRender: true,
  retrieve: true,
  processing: true,
  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },
});

/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/

$(".tablaVentass tbody").on("click", "button.agregarProducto", function () {
  var idProducto = $(this).attr("idProducto");

  $(this).removeClass("btn-primary agregarProducto");

  $(this).addClass("btn-default");

  var datos = new FormData();
  datos.append("idProducto", idProducto);

  $.ajax({
    url: "ajax/productos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      //console.log("respuesta",respuesta[0]["entrega"]);
      var descripcion = respuesta[0]["descripcion"];

      /*=============================================
          	EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
          	=============================================*/

      /*if(entrega == 0){

      			swal({
			      title: "No hay Stock disponible",
			      type: "error",
			      confirmButtonText: "¡Cerrar!"
			    });

			    $("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");

			    return;
          	}*/

      $(".nuevoProducto").append(
        '<div class="row" style="padding:5px 20px">' +
          "<!-- Descripción del producto -->" +
          '<div class="col-xs-11" style="padding-right:0px">' +
          '<div class="input-group">' +
          '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' +
          idProducto +
          '"><i class="fa fa-times"></i></button></span>' +
          '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="' +
          idProducto +
          '" name="agregarProducto" value="' +
          descripcion +
          '" readonly required>' +
          "</div>" +
          "</div>" +
          "</div>"
      );

      // AGRUPAR PRODUCTOS EN FORMATO JSON

      listarProductoss();

      localStorage.removeItem("quitarProducto");
    },
  });
});

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaVentass").on("draw.dt", function () {
  if (localStorage.getItem("quitarProducto") != null) {
    var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));

    for (var i = 0; i < listaIdProductos.length; i++) {
      $(
        "button.recuperarBoton[idProducto='" +
          listaIdProductos[i]["idProducto"] +
          "']"
      ).removeClass("btn-default");
      $(
        "button.recuperarBoton[idProducto='" +
          listaIdProductos[i]["idProducto"] +
          "']"
      ).addClass("btn-primary agregarProducto");
    }
  }
});

/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProductoo = [];

localStorage.removeItem("quitarProducto");

$(".formularioProveedor").on("click", "button.quitarProducto", function () {
  $(this).parent().parent().parent().parent().remove();

  var idProducto = $(this).attr("idProducto");

  /*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/

  if (localStorage.getItem("quitarProducto") == null) {
    idQuitarProductoo = [];
  } else {
    idQuitarProductoo.concat(localStorage.getItem("quitarProducto"));
  }

  idQuitarProductoo.push({ idProducto: idProducto });

  localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProductoo));

  $("button.recuperarBoton[idProducto='" + idProducto + "']").removeClass(
    "btn-default"
  );

  $("button.recuperarBoton[idProducto='" + idProducto + "']").addClass(
    "btn-primary agregarProducto"
  );

  listarProductoss();
});

/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/
/*
var numProducto = 0;

$(".btnAgregarProducto").click(function(){

	numProducto ++;

	var datos = new FormData();
	datos.append("traerProductos", "ok");

	$.ajax({

		url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
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
	            
	             '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="0" entrega nuevoStock required>'+

	          '</div>' +

	          '<!-- Precio del producto -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon">S/ </i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioProducto" precioReal="" name="nuevoPrecioProducto" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>');


	        // AGREGAR LOS PRODUCTOS AL SELECT 

	         respuesta.forEach(funcionForEach);

	         function funcionForEach(item, index){

	         	if(item.entrega != 0){

		         	$("#producto"+numProducto).append(

						'<option idProducto="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'
		         	)

		         
		         }

		         

	         }

        	 // SUMAR TOTAL DE PRECIOS

    		sumarTotalPrecios()

    		// AGREGAR IMPUESTO
	        
	        agregarImpuesto()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 2);


      	}

	})

})

/*=============================================
SELECCIONAR PRODUCTO
=============================================*/

$(".formularioProveedor").on(
  "change",
  "select.nuevaDescripcionProducto",
  function () {
    var nombreProducto = $(this).val();

    var nuevaDescripcionProducto = $(this)
      .parent()
      .parent()
      .parent()
      .children()
      .children()
      .children(".nuevaDescripcionProducto");

    var nuevoPrecioProducto = $(this)
      .parent()
      .parent()
      .parent()
      .children(".ingresoPrecio")
      .children()
      .children(".nuevoPrecioProducto");

    var nuevaCantidadProducto = $(this)
      .parent()
      .parent()
      .parent()
      .children(".ingresoCantidad")
      .children(".nuevaCantidadProducto");

    var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);

    $.ajax({
      url: "ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
        $(nuevaCantidadProducto).attr("entrega", respuesta["entrega"]);
        $(nuevaCantidadProducto).attr(
          "nuevoStock",
          Number(respuesta["entrega"]) - 1
        );
        $(nuevoPrecioProducto).val(respuesta["precio"]);
        $(nuevoPrecioProducto).attr("precioReal", respuesta["precio"]);

        // AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductoss();
      },
    });
  }
);

/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductoss() {
  var listaProductoss = [];

  var descripcion = $(".nuevaDescripcionProducto");

  for (var i = 0; i < descripcion.length; i++) {
    listaProductoss.push({
      id: $(descripcion[i]).attr("idProducto"),
      descripcion: $(descripcion[i]).val(),
    });
  }

  $("#listaProductoss").val(JSON.stringify(listaProductoss));
}

/*=============================================
BOTON EDITAR proveedor
=============================================*/
$(".tablasproveedores").on("click", ".btnEditarProveedor", function () {
  var idProveedor = $(this).attr("idProveedor");

  window.location =
    "index.php?ruta=editar-proveedor&idProveedor=" + idProveedor;
});
/*=============================================
BOTON ORDEN proveedor
=============================================*/
$(".tablasproveedores").on("click", ".btnOrdenProveedor", function () {
  var idProveedor = $(this).attr("idProveedor");

  window.location =
    "index.php?ruta=crear-ordencompra&idProveedor=" + idProveedor;
});

/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarProductoo() {
  //Capturamos todos los id de productos que fueron elegidos en la venta
  var idProductos = $(".quitarProducto");

  //Capturamos todos los botones de agregar que aparecen en la tabla
  var botonesTabla = $(".tablaVentass tbody button.agregarProducto");

  //Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
  for (var i = 0; i < idProductos.length; i++) {
    //Capturamos los Id de los productos agregados a la venta
    var boton = $(idProductos[i]).attr("idProducto");

    //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
    for (var j = 0; j < botonesTabla.length; j++) {
      if ($(botonesTabla[j]).attr("idProducto") == boton) {
        $(botonesTabla[j]).removeClass("btn-primary agregarProducto");
        $(botonesTabla[j]).addClass("btn-default");
      }
    }
  }
}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$(".tablaVentass").on("draw.dt", function () {
  quitarAgregarProductoo();
});

/*=============================================
BORRAR VENTA
=============================================*/
$(".tablasproveedores").on("click", ".btnEliminarProveedor", function () {
  var idProveedor = $(this).attr("idProveedor");
  

  swal({
    title: "¿Está seguro de borrar al Proveedor?",
    text: "¡Si no lo está seguro puede cancelar la accíón!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Si, borrar Proveedor!!",
  }).then(function (result) {
    if (result.value) { 
      window.location = "index.php?ruta=proveedores&idProveedor=" + idProveedor;
    }
  });
});

/*=============================================
REVISAR SI EL PROVEEDOR YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoRUC").change(function () {
  $(".alert").remove();

  var proveedor = $(this).val();

  var datos = new FormData();
  datos.append("validarProveedor", proveedor);

  $.ajax({
    url: "ajax/proveedores.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        $("#nuevoRUC")
          .parent()
          .after('<div class="alert alert-warning">RUC Ya Registrado</div>');

        //$("#nuevoRUC").val("");
      } else {
        var ruc = document.getElementById("nuevoRUC").value;
        var nombre = document.getElementById("nuevoProveedor");
        var direccion = document.getElementById("nuevoDireccionn");
        var telfono = document.getElementById("nuevoTelefonoo");
        //console.log('https://dniruc.apisperu.com/api/v1/dni/'+dni+'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpvaG54ZHhkMDFAZ21haWwuY29tIn0.ZruhemgKkC4EJUsE_A5HhhIc69anmTnmcu2tYZpuW24');

        fetch(
          "https://dniruc.apisperu.com/api/v1/ruc/" +
            ruc +
            "?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpvaG54ZHhkMDFAZ21haWwuY29tIn0.ZruhemgKkC4EJUsE_A5HhhIc69anmTnmcu2tYZpuW24"
        )
          .then((response) => {
            if (response.ok) {
              return response.json();
            } else if (response.status === 404) {
              return Promise.reject("error 404");
            } else {
              return Promise.reject("error: " + response.status);
            }
          })
          .then(
            (data) => (
              (nombre.value = data.razonSocial),
              (direccion.value = data.direccion+ " - "+data.departamento)
            )
          )
          .catch(
            (error) =>
              $("#nuevoRUC")
                .parent()
                .after('<div class="alert alert-warning">RUC No Existe</div>'),
            $("#nuevoProveedor").val(""),
            $("#nuevoDireccionn").val("")
          );
      }
    },
  });
});
