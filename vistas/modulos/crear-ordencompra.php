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
    <?php

    $item = "id";
    $valor =  $_GET["idProveedor"];

    $proveedor = ControladorProveedores::ctrMostrarProveedores($item, $valor);
    $nombre = $proveedor["nombre"];
    ?>
    <h1>
      <?php
      echo 'Crear Orden de Compra para ' . $proveedor["nombre"] . '';

      ?>
    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Crear Orden de Compra</li>

    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->

      <div class="col-lg-8 col-xs-12">

        <div class="box box-success">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioOrden">

            <div class="box-body">

              <div class="box">

                <!--=====================================
                ENTRADA DEL Trabajador
                ======================================-->

              <!--  <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>-->

                    <input type="hidden" class="form-control" id="nuevoTrabajador" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idTrabajador" value="<?php echo $_SESSION["id"]; ?>">

                 <!--   </div>

                </div>-->

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <?php

                    $item = null;
                    $valor = null;

                    $orden = ControladorOrdencompra::ctrMostrarOrdencompra($item, $valor);

                    if (!$orden) {

                      echo '<input type="text" class="form-control" id="nuevaOrden" name="nuevaOrden" value="10001" readonly>';
                    } else {

                      foreach ($orden as $key => $value) {
                      }

                      $codigo = $value["codigo"] + 1;



                      echo '<input type="text" class="form-control" id="nuevaOrden" name="nuevaOrden" value="' . $codigo . '" readonly>';
                    }

                    ?>


                  </div>

                </div>

                <!--=====================================
                ENTRADA DEL PROVEEDOR
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-users"></i></span>

                    <input type="text" class="form-control" id="nuevoProveedor" value="<?php echo $proveedor["nombre"]; ?>" readonly>

                    <input type="hidden" name="idProveedor" value="<?php echo $proveedor["id"]; ?>">

            
                  </div>

                </div>
   <!--=====================================
                ENTRADA DEL PROVEEDOR
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <input type="text" class="form-control" id="nuevoRucc" value="<?php echo $proveedor["ruc"]; ?>" readonly>
 
            
                  </div>

                </div>


                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================-->

                <div class="form-group row nuevoProducto">

                <table  id="detalles" class="table centrar">
               <thead>
                <tr>
                <th class="col-xs-2">Eliminar </th>
                    <th class="col-xs-4 centrarto">Producto</th>
                    <th class="col-xs-2 centrarto">Precio Compra</th>
                    <th class="col-xs-2 centrarto">Cantidad</th>
                    <th class="col-xs-2 centrarto">SubTotal</th>
                </tr>
            </thead>
                </table>

                </div>

                <input type="hidden" id="listaProductosOrden" name="listaProductosOrden">


                <!--=====================================
BOTÓN PARA AGREGAR PRODUCTO
======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <hr>

                <div class="row">

                  <!--=====================================
  ENTRADA IMPUESTOS Y TOTAL
  ======================================-->

                  <div class="col-xs-8 pull-right">

                    <table class="table">

                      <thead>

                        <tr>
                          <th>
                            <!--impuesto -->
                          </th>
                          <th>TOTAL</th>
                        </tr>

                      </thead>

                      <tbody>

                        <tr>

                          <td style="width: 50%">

                            <div class="input-group">

                              <input type="hidden" class="form-control input-lg" min="0" id="nuevoImpuestoOrden" name="nuevoImpuestoOrden" value="18" required>

                              <input type="hidden" name="nuevoPrecioImpuestoOrden" id="nuevoPrecioImpuestoOrden" required>

                              <input type="hidden" name="nuevoPrecioNetoOrden" id="nuevoPrecioNetoOrden" required>



                            </div>

                          </td>

                          <td style="width: 50%">

                            <div class="input-group">

                              <span class="input-group-addon">S/ </i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalOrden" name="nuevoTotalOrden" total="" placeholder="0" readonly required>

                              <input type="hidden" name="totalOrden" id="totalOrden">


                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>
                <br>

              </div>

            </div>




            <div class="box-footer">

              <button type="submit" class="btn btn-primary pull-right" id="GuardarOrden">Guardar Orden de Compra</button>

            </div>

          </form>

          <?php

          $odencomprap = new ControladorOrdencompra();
          $odencomprap->ctrCrearOrden();

          ?>

        </div>

      </div>

      <!--=====================================
LA TABLA DE PRODUCTOS
======================================-->

      <div class="col-lg-4 hidden-md hidden-sm hidden-xs">

        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">

            <table class="table table-bordered table-striped dt-responsive tablaProductosProveedors" id="tablaProductosProveedors">

              <thead>
                <tr>
                  <th style="width: 10px">#</th>

                  <th style="width: 80px">Descripcion</th>
                  <th style="width: 20px">Acciones</th>
                </tr>

              </thead>
              <tbody>

                <?php

                $item = "id";
                $valor =  $_GET["idProveedor"];

                $proveedor = ControladorProveedores::ctrMostrarProveedores($item, $valor);

                ?>
                <?php

                $listaProductosOrden = json_decode($proveedor["productos"], true);

                foreach ($listaProductosOrden as $key => $value) {

                  $item = "id";
                  $valor = $value["id"];
                  $orden = "id";

                  $respuesta = ControladorProductos::ctrMostrar($item, $valor, $orden);

                  echo ' <tr>
              <td>' . ($key + 1) . '</td>
              <td>' . $value["descripcion"] . '</td>';
                  echo '<td><div class="btn-group"><button class="btn btn-primary agregarProducto recuperarBoton" idProducto="' . $value["id"] . '">Agregar</button></div></td>';
                }


                ?>


              </tbody>
            </table>

          </div>

        </div>


      </div>

    </div>

  </section>

</div>