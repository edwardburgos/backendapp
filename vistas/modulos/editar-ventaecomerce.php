<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Realizar el Venta

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Realizar el Venta</li>

    </ol>

  </section>

  <section class="content">
    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->

      <div class="col-lg-9 col-xs-8">

        <div class="box box-success">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioVenta">

            <div class="box-body">

              <div class="box">

                <?php

                $item = "id";
                $valor = $_GET["idVentaeco"];
 
                $ventaeco = ControladorVentasecommerce::ctrMostrarVentaseco($item, $valor);

                // $itemUsuario = "id";
                //$valorUsuario = $venta["id_vendedor"];

                //$vendedor = ControladorAdministradores::ctrMostrarAdministradores($itemUsuario, $valorUsuario);

                $itemCliente = "email";
                $valorCliente = $ventaeco["email"];

                $cliente = ControladorClientes::ctrMostrarClientesuser($itemCliente, $valorCliente);

                // $porcentajeImpuesto = $ventaeco["pago"] * 100 / $ventaeco["pago"];


                ?>

               <input type="hidden" name="idpedi" value="<?php echo $valor; ?>">
                <div class="form-group" id="idbol">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <?php

                    $item = null;
                    $valor = null;

                    $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

                    if (!$ventas) {

                      echo '<input type="text" class="form-control" id="nuevaVentaeco" name="nuevaVentaeco" value="00001" readonly>';
                    } else {

                      foreach ($ventas as $key => $value) {
                      }

                      $codigo = $value["codigo"] + 1;

                      if ($codigo < 10) {
                        $codigo = "0000" . $codigo;
                      } else if ($codigo < 100) {
                        $codigo = "000" . $codigo;
                      } else if ($codigo < 1000) {
                        $codigo = "00" . $codigo;
                      } else if ($codigo < 10000) {
                        $codigo = "0" . $codigo;
                      } else {
                        $codigo = $codigo;
                      }

                      echo '<input type="text" class="form-control" id="nuevaVentaeco" name="nuevaVentaeco" value="' . $codigo . '" readonly>';
                    }

                    ?>


                  </div>

                </div>


                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control" id="nuevoVendedoreco" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idVendedoreco" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div>







                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-users"></i></span>


                    <input type="text" class="form-control" value="<?php echo $cliente["nombre"]; ?>" readonly>

                    <input type="hidden" name="ClienteId" value="<?php echo $cliente["id"]; ?>">



                    <!--<span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button></span>
                         -->
                  </div>

                </div>



                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================-->

                <div class="form-group row nuevoProducto">

                  <?php

                  $listaProducto = json_decode($ventaeco["productos"], true);

                  foreach ($listaProducto as $key => $value) {

                    $item = "id";
                    $valor = $value["cod_produc"];
                    $orden = "id";

                    $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                    $subtotalpro = $value["variant"] * $value["itemQuantity"];
                    $stockAntiguo = $respuesta[0]["stock"] + $value["itemQuantity"];
                    $stocknuev=$respuesta[0]["stock"] -  $value["itemQuantity"];

                    echo '<div class="row" style="padding:5px 15px">
            
                        <div class="col-xs-6" style="padding-right:0px">
            
                          <div class="input-group">
                
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' . $value["cod_produc"] . '"><i class="fa fa-times"></i></button></span>

                            <input type="text" class="form-control nuevaDescripcionProducto" idProducto="' . $value["cod_produc"] . '" name="agregarProducto" value="' . $value["product"] . '" readonly required>

                          </div>

                        </div>

                        <div class="col-xs-3">
              
                          <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="' . $value["itemQuantity"] . '" stock="' . $stockAntiguo . '" nuevoStock="' . $stocknuev . '" required>

                        </div>
                   
                        <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">

                          <div class="input-group">

                            <span class="input-group-addon">S/ </i></span>
                   
                            <input type="text" class="form-control nuevoPrecioProducto" precioReal="' . $respuesta[0]["precio"] . '" name="nuevoPrecioProducto" value="' . $subtotalpro . '" readonly required>
   
                          </div>
               
                        </div>

                      </div>';
                  }


                  ?>

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->


                <div class="row">

                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->

                  <div class="col-xs-8 pull-right">

                    <table class="table">

                      <thead>

                        <tr>
                          <th>
                            <!--Impuesto-->
                          </th>
                          <th>Total</th>
                        </tr>

                      </thead>


                      <tbody>

                        <tr>

                          <td style="width: 50%">

                            <div class="input-group">

                              <input type="hidden" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="18" required>

                              <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="<?php $imp = $ventaeco["pago"] * 0.18;
                                                                                                              echo $imp; ?>" required>

                              <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="<?php echo $ventaeco["pago"] - $imp; ?>" required>

                            </div>

                          </td>

                          <td style="width: 50%">

                            <div class="input-group">

                              <span class="input-group-addon">S/ </i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo $ventaeco["pago"] - $imp; ?>" value="<?php echo $ventaeco["pago"]; ?>" readonly required>

                              <input type="hidden" name="totalVenta" value="<?php echo $ventaeco["pago"]; ?>" id="totalVenta">


                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>


              </div>

            </div>

            <div class="box-footer">
            <button type="submit" class="btn btn-warning" id="Cancelar" name="Cancelar"  value="3">Cancelar Pedido</button>
              <button type="submit" class="btn btn-primary pull-right" id="GuardarVenta" name="GuardarVenta" value="1">Confirmar Pedido</button>

            </div>

          </form>

          <?php

          $crearventaecom = new ControladorVentas();
          $crearventaecom->ctrCrearVentaeco();
          $actualizaresta = new ControladorVentasecommerce();
          $actualizaresta->ctrActualizar();

          ?>

        </div>

      </div>


      <div class="col-lg-3 hidden-md hidden-sm hidden-xs">

        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">
            <?php
            $idfoto = $_GET["idVentaeco"];
            echo '<td><img src="vistas/img/pagos/' . $idfoto . '.png" class="img-thumbnail" width="300px" ></td>';

            ?>
          </div>

        </div>


      </div>
    </div>

  </section>

</div>