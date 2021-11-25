// $.ajax({

// 	url: "ajax/datatable-ventas.ajax.php",
// 	success:function(respuesta){

// 		console.log("respuesta", respuesta);

// 	}

// })//
$(".tablasclientes").DataTable({
  ajax: "ajax/tablaClientes.ajax.php",
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
EDITAR CLIENTE
=============================================*/

$(".tablasclientes").on("click", ".btnEditarCliente", function () {
  var idCliente = $(this).attr("idCliente");

  var datos = new FormData();
  datos.append("idCliente", idCliente);

  $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idCliente").val(respuesta["id"]);
      $("#editarCliente").val(respuesta["nombre"]);
      $("#editarDocumentoId").val(respuesta["documento"]);
      $("#editarEmail").val(respuesta["email"]);
      $("#editarTelefono").val(respuesta["telefono"]);
      $("#editarDireccion").val(respuesta["direccion"]);
      $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);
    },
  });
});

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablasclientes").on("click", ".btnEliminarCliente", function () {
  var idCliente = $(this).attr("idCliente");

  swal({
    title: "¿Está seguro de borrar el cliente?",
    text: "¡Si no lo está seguro puede cancelar la acción!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Si, borrar cliente!",
  }).then(function (result) {
    if (result.value) {
      window.location = "index.php?ruta=clientes&idCliente=" + idCliente;
    }
  });
});

/*=============================================
REVISAR SI EL CLIENTE YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoDocumentoId").change(function () {
  $(".alert").remove();

  var cliente = $(this).val();

  var datos = new FormData();
  datos.append("validarCliente", cliente);

  $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        $("#nuevoDocumentoId")
          .parent()
          .after(
            '<div class="alert alert-warning">Este Documento ya existe</div>'
          );

        // $("#nuevoDocumentoId").val("");
      } else {
        var dni = document.getElementById("nuevoDocumentoId").value;
        var nombre = document.getElementById("nuevoCliente");
        //console.log('https://dniruc.apisperu.com/api/v1/dni/'+dni+'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpvaG54ZHhkMDFAZ21haWwuY29tIn0.ZruhemgKkC4EJUsE_A5HhhIc69anmTnmcu2tYZpuW24');

        fetch("https://dni.optimizeperu.com/api/persons/" + dni)
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
            (data) =>
              (nombre.value =
                data.name + " " + data.first_name + " " + data.last_name)
          )
          .catch(
            (error) =>
              $("#nuevoDocumentoId")
                .parent()
                .after('<div class="alert alert-warning">DNI No Existe</div>'),
            $("#nuevoCliente").val("")
          );
      }
    },
  });
});

//document.getElementById("dni").onchange = function() {myFunction()};
function myFunction() {
  document.getElementById("dni").style.borderColor = "red";
}

$("#docu").change(function () {
  cambiaDocu();

  var rad = document.myForm.myRadios;
  var prev = null;
  for (var i = 0; i < rad.length; i++) {
    rad[i].addEventListener("change", function () {
      prev ? console.log(prev.value) : null;
      if (this !== prev) {
        prev = this;
      }
      console.log(this.value);
    });
  }
});


function cambiaDocu() {
  var x = document.getElementById("tdocudni");
  if ((x.checked)) {
  //  console.log("dni");
  } else {
    //console.log("ruc");
  }
}


    $(window).ready(function() {
      $('#tdocuruc').closest('label').click(function() { 
       document.getElementById("midni").style.display="none";
       document.getElementById("cumple").style.display="none";
       document.getElementById("nuevaDireccion").readOnly = true;
       document.getElementById("miruc").style.display="block";
       $("#nuevoDocumentoRuc").val("");
       $("#nuevoCliente").val("");

      });
  });

  $(window).ready(function() {
    $('#tdocudni').closest('label').click(function() { 
      document.getElementById("midni").style.display="block";
      document.getElementById("miruc").style.display="none";
      document.getElementById("cumple").style.display="block";
      document.getElementById("nuevaDireccion").readOnly = false;
      $("#nuevoDocumentoId").val("");
      $("#nuevoCliente").val("");
      $("#nuevaDireccion").val("")
    });
});

$("#nuevoDocumentoRuc").change(function () {
  $(".alert").remove();

  var clienteruc= $(this).val();

  var datoss = new FormData();
  datoss.append("validarClienteruc", clienteruc);

  $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datoss,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        $("#nuevoDocumentoRuc")
          .parent()
          .after('<div class="alert alert-warning">RUC Ya Registrado</div>');

        //$("#nuevoRUC").val("");
      } else {
        var rucc = document.getElementById("nuevoDocumentoRuc").value;
        var nombree = document.getElementById("nuevoCliente");
        var direccionn = document.getElementById("nuevaDireccion");
        var telfono = document.getElementById("nuevoTelefonoo");
        //console.log('https://dniruc.apisperu.com/api/v1/dni/'+dni+'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpvaG54ZHhkMDFAZ21haWwuY29tIn0.ZruhemgKkC4EJUsE_A5HhhIc69anmTnmcu2tYZpuW24');

        fetch(
          "https://dniruc.apisperu.com/api/v1/ruc/" +
            rucc +
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
              (nombree.value = data.razonSocial),
              (direccionn.value = data.direccion+ " - "+data.departamento)
            )
          )
          .catch(
            (error) =>
              $("#nuevoDocumentoRuc")
                .parent()
                .after('<div class="alert alert-warning">RUC No Existe</div>'),
            $("#nuevoCliente").val(""),
            $("#nuevaDireccion").val("")
          );
      }
    },
  });
});
