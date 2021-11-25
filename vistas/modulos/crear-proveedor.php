<?php

if ($_SESSION["perfil"] == "Especial") {

  echo '<script>

    window.location = "inicio";

  </script>';

  return;
}

?>
<script>
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>

<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Crear Proveedor

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Crear Proveedor</li>

    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->

      <div class="col-lg-6 col-xs-12">

        <div class="box box-success">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioProveedor">

            <div class="box-body">

              <div class="box">

                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
                <div class="form-group">

      

                </div>
                <div class="modal-body">

                  <div class="box-body">
                    <!-- ENTRADA PARA EL DOCUMENTO ID -->

                    <div class="form-group">

                      <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-key"></i></span>

                        <input type="text" class="form-control input-lg" name="nuevoRUC" id="nuevoRUC" placeholder="Ingresar RUC" data-inputmask="'mask':'99999999'" data-mask required>

                      </div>

                    </div>
                    <!-- ENTRADA PARA EL NOMBRE -->

                    <div class="form-group">

                      <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" class="form-control input-lg" name="nuevoProveedor" placeholder="Ingresar nombre" id="nuevoProveedor" required readonly>

                      </div>

                    </div>



                    <!-- ENTRADA PARA EL EMAIL -->

                    <div class="form-group">

                      <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                        <input type="text" class="form-control input-lg" name="nuevoDireccionn" placeholder="Ingresar Direccion" id="nuevoDireccionn" required readonly>

                      </div>

                    </div>

                    <!-- ENTRADA PARA EL TELÉFONO -->

                    <div class="form-group">

                      <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                        <input type="text" class="form-control input-lg" name="nuevoTelefonoo" id="nuevoTelefonoo" placeholder="Ingresar teléfono" required>

                      </div>

                    </div>
                    <!-- ENTRADA PARA EL EMAIL -->

                    <div class="form-group">

                      <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                        <input type="email" class="form-control input-lg" name="nuevoEmaill" placeholder="Ingresar email" id="nuevoEmaill" required>

                      </div>

                    </div>



                  </div>

                </div>
                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================-->






                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================-->

                <div class="form-group row nuevoProducto"> 
                <table  id="detalles" class="table centrarr" style="margin-left:15px" >
               <thead>
                <tr>
                <th class="col-xs-2">Eliminar </th>
                    <th class="col-xs-10 centrarto">Producto</th>

                </tr>
            </thead>
                </table>


                </div>

                <input type="hidden" id="listaProductoss" name="listaProductoss">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <hr>

                <br>

              </div>

            </div>

            <div class="box-footer">

              <button type="submit" class="btn btn-primary pull-right" id="GuardarProveedor">Guardar Proveedor</button>


            </div>

          </form>

          <?php

          $GuardarProveedor = new ControladorProveedores();
          $GuardarProveedor->ctrCrearProveedor();

          ?>

        </div>

      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-6 hidden-md hidden-sm hidden-xs">

        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">

            <table class="table table-bordered table-striped dt-responsive tablaVentass">

              <thead>

                <tr>
                  <th style="width: 10px">#</th>
                  <th style="width: 40px">Imagen</th>
                  <th style="width: 80px">Descripcion</th>
                  <th style="width: 20px">Acciones</th>
                </tr>

              </thead>

            </table>

          </div>

        </div>


      </div>

    </div>

  </section>

</div>

