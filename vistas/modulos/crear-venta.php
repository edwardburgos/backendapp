<?php

if ($_SESSION["perfil"] == "Especial") {

  echo '<script>

    window.location = "inicio";

  </script>';

  return;
}

?>


<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Crear venta

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Crear venta</li>

    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->

      <div class="col-lg-5 col-xs-12">

        <div class="box box-success">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioVenta">

            <div class="box-body">

              <div class="box">
                <div class="form-group">


                  <label class="btn btn-default"> <input type="Radio" name="comprob" id="comprobbol" value="Factura" checked> Boleta </label>
                  <label class="btn btn-default"> <input type="Radio" name="comprob" id="comprobfac" value="Boleta"> Factura</label>

                  <!-- ENTRADA PARA EL DOCUMENTO ID -->
                </div>
                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div>

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================-->

                <div class="form-group" id="idbol">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <?php

                    $item = null;
                    $valor = null;

                    $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
                 
                    if (!$ventas) {

                      echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="00001" readonly>';
                    } else {

                      foreach ($ventas as $key => $value) {
                      }
                      
                      $codigo = $value["codigo"] + 1;

                      if($codigo<10){
                        $codigo="0000".$codigo;
                       }else if($codigo<100){
                        $codigo="000".$codigo;
                       }else if($codigo<1000){
                        $codigo="00".$codigo;
                       }else if($codigo<10000){
                        $codigo="0".$codigo;
                       }else{
                        $codigo=$codigo;
                       }

                      echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="' . $codigo . '" readonly>';
                    }

                    ?>


                  </div>

                </div>

      <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================-->

                <div class="form-group" id="idfac">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <?php

                    $item = null;
                    $valor = null;

                    $ventas = ControladorVentas::ctrMostrarVentasfac($item, $valor);
                  
                    if (!$ventas) {

                      echo '<input type="text" class="form-control" id="nuevaVentaFac"" name="nuevaVentaFac" value="00001" readonly>';
                    } else {

                      foreach ($ventas as $key => $value) {
                      }
                     
                      $codigo = $value["codigofac"] + 1;
                     if($codigo<10){
                      $codigo="0000".$codigo;
                     }else if($codigo<100){
                      $codigo="000".$codigo;
                     }else if($codigo<1000){
                      $codigo="00".$codigo;
                     }else if($codigo<10000){
                      $codigo="0".$codigo;
                     }else{
                      $codigo=$codigo;
                     }
                      

                      echo '<input type="text" class="form-control" id="nuevaVentaFac"" name="nuevaVentaFac"" value="' . $codigo . '" readonly>';
                    }

                    ?>


                  </div>

                </div>

                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================-->

                <div class="form-group" id="dnicliente" >

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-users"></i></span>

                    <select class="form-control select2" id="seleccionarCliente" name="seleccionarCliente" data-placeholder="Seleccionar cliente" required>

                      <option value="" selected disabled hidden>Seleccione un Cliente </option>

                      <?php

                      $item = null;
                      $valor = null;

                      $clie = ControladorClientes::ctrMostrarClientes($item, $valor);

                      foreach ($clie as $key => $value) {

                        if($value["documento"]>0){
                          echo '<option value="' . $value["id"] . '">' . $value["nombre"] . " " . $value["documento"] . '</option>';
                        }
                    
                      }

                      ?>

                    </select>

                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button></span>

                  </div>

                </div>

               <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================-->

                <div class="form-group" id="ruccliente" style="display: table-column;">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-users"></i></span>

                    <select class="form-control select2" id="seleccionarClienteruc" name="seleccionarClienteruc" data-placeholder="Seleccionar cliente" required>

                      <option value="" selected disabled hidden>Seleccione un Cliente </option>

                      <?php

                      $item = null;
                      $valor = null;

                      $categorias = ControladorClientes::ctrMostrarClientes($item, $valor);

                      foreach ($categorias as $key => $value) {

                        if($value["ruc"]>0){
                          echo '<option value="' . $value["id"] . '">' . $value["nombre"] . " " . $value["ruc"] . '</option>';
                        
                        }
                    
                      }

                      ?>

                    </select>

                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button></span>

                  </div>

                </div>
                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================-->

                <div class="form-group row nuevoProducto">
                  <table id="detalles" class="table centrar">
                    <thead>
                      <tr>
                        <th class="col-xs-2">Eliminar </th>
                        <th class="col-xs-4 centrarto">Producto</th>
                        <th class="col-xs-3 centrarto">Cantidad</th>
                        <th class="col-xs-3 centrarto">SubTotal</th>
                      </tr>
                    </thead>
                  </table>

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

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

                              <input type="hidden" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="18" required>

                              <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" required>

                              <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>



                            </div>

                          </td>

                          <td style="width: 50%">

                            <div class="input-group">

                              <span class="input-group-addon">S/ </i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="0" readonly required>

                              <input type="hidden" name="totalVenta" id="totalVenta">


                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>

                <hr>

                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->

                <div class="form-group row">

                  <div class="col-xs-6" style="padding-right:0px">

                    <div class="input-group">

                      <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                        <option value="" selected disabled hidden>Seleccione método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="TC">Transaccion</option>
                        <option value="Paypal">Paypal</option>

                      </select>

                    </div>

                  </div>

                  <div class="cajasMetodoPago"></div>

                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">

                </div>

                <br>

              </div>

            </div>

            <div class="box-footer">

              <button type="submit" class="btn btn-primary pull-right" id="GuardarVenta">Guardar venta</button>


            </div>

          </form>

          <?php

          $guardarVenta = new ControladorVentas();
          $guardarVenta->ctrCrearVenta();

          ?>

        </div>

      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">

        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">

            <table class="table table-bordered table-striped dt-responsive tablaVentas">

              <thead>

                <tr>
                  <th style="width: 10px">#</th>
                  <th style="width: 40px">Imagen</th>

                  <th style="width: 80px">Descripcion</th>
                  <th style="width: 20px">Precio</th>
                  <th style="width: 20px">Stock</th>
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

<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoDocumentoId" id="nuevoDocumentoId" placeholder="Ingresar documento" data-inputmask="'mask':'99999999'" data-mask required>

              </div>

            </div>

            <!-- ENTRADA PARA EL EMAIL -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                <input type="email" class="form-control input-lg" name="nuevoEmail" id="mail" placeholder="Ingresar email" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha nacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

              </div>

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cliente</button>

        </div>

      </form>

      <?php

      $crearCliente = new ControladorClientes();
      $crearCliente->ctrCrearClientes();

      ?>

    </div>

  </div>

</div>