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

      Recibir Orden de Compra

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Recibir Orden de Compra</li>

    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->

      <div class="col-lg-12 col-xs-12">

        <div class="box box-success">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioOrdenedi">

            <div class="box-body">

              <div class="box">

                <?php

                $item = "id";
                $valor = $_GET["idOrden"];

                $ordencompra = ControladorOrdencompra::ctrMostrarOrdencompra($item, $valor);

                $itemUsuario = "id";
                $valorUsuario = $ordencompra["id_trabajador"];

                $trabajador = ControladorAdministradores::ctrMostrarAdministradores($itemUsuario, $valorUsuario);

                $itemProveedor = "id";
                $valorProveedor = $ordencompra["id_proveedor"];
                $proveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);

                $porcentajeImpuesto = $ordencompra["impuesto"] * 100 / $ordencompra["neto"];


                ?>
                <input type="hidden" id="idOrden" name="idOrden" value="<?php echo $ordencompra["id"]; ?>">
                <!--=====================================
                ENTRADA DEL trabajador
                ======================================-->
                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control" id="nuevoTraba" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idTraba" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div>


                <!-- <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>  -->

                <input type="hidden" class="form-control" id="nuevoTrabajador" value="<?php echo $trabajador["nombre"]; ?>" readonly>

                <input type="hidden" name="edidTrabajador" value="<?php echo $trabajador["id"]; ?>">

                <!--  </div>

                </div> -->

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <input type="text" class="form-control" id="editarOrden" name="editarOrden" value="<?php echo $ordencompra["codigo"]; ?>" readonly>

                  </div>

                </div>

                <!--=====================================
                ENTRADA DEL PROVEEDOR
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control" id="nuevoProveedoredit" value="<?php echo $proveedor["nombre"]; ?>" readonly>

                    <input type="hidden" name="idProveedoredit" value="<?php echo $proveedor["id"]; ?>">

                  </div>

                </div>


                <!--=====================================
                ENTRADA DEL PROVEEDOR
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control" id="nuevorucc" value="<?php echo $proveedor["ruc"]; ?>" readonly>

                  </div>

                </div>

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>

                    <input type="text" class="form-control codigoprovee" id="codigoprovee" name="codigoprovee" placeholder="nro comprobante del proveedor" value="<?php echo $ordencompra["codigoprovee"]; ?>" required>

                  </div>

                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================-->

                <div class="form-group row nuevoProducto">
                  <table id="detalles" class="table centrar">
                    <thead>
                      <tr>

                        <th class="col-xs-4 centrarto">Producto</th>
                        <th class="col-xs-2 centrarto">Cantidad</th>
                        <th class="col-xs-2 centrarto">Precio Compra</th>
                        <th class="col-xs-2 centrarto">SubTotal</th>
                        <th class="col-xs-2 centrarto">ingreso</th>
                      </tr>
                    </thead>
                  </table>
                  <?php

                  $listaProducto = json_decode($ordencompra["productos"], true);

                  // var_dump($listaProducto);

                  foreach ($listaProducto as $key => $value) {

                    $item = "id";
                    $valor = $value["id"];
                    $orden = "id";

                    $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);


                    $stockAntiguo = $respuesta[0]["stock"] + $value["cantidad"];

                    echo '<div class="row" style="padding:5px 15px">
            
                        <div class="col-xs-4" style="padding-right:0px">
            
                     
                            <input type="text" class="form-control nuevaDescripcionProductoedi" idProducto="' . $value["id"] . '" name="agregarProducto" value="' . $value["descripcion"] . '" readonly required>

                       

                        </div>

                        <div class="col-xs-2">
              
                          <input type="number" class="form-control nuevaCantidadProductoedi" name="nuevaCantidadProductoedi" min="1" value="' . $value["cantidad"] . '" readonly  required>

                        </div>

                        <div class="col-xs-2 ingresoPrecioProveedoredi" style="padding-left:0px">

                          <div class="input-group">

                            <span class="input-group-addon">S/ </i></span>
                   
                            <input type="text" class="form-control ProveedorPrecioedi" name="ProveedorPrecioedi" value="' . $value["preciouni"] . '" readonly required>
   
                          </div>

                        </div>


                        <div class="col-xs-2 ingresoPrecioedi" style="padding-left:0px">

                          <div class="input-group">

                            <span class="input-group-addon">S/ </i></span>
                   
                            <input type="text" class="form-control nuevoPrecioProductoedi"  name="nuevoPrecioProductoedi"  value="' . $value["preciouni"] * $value["cantidad"] . '" readonly required>
   
                          </div>

                        </div>
                        <div class="col-xs-2">
              
                        <input type="number" class="form-control nuevaCantidadProveedoredi" name="edinuevaCantidadProveedoredi" min="1" value="' . $value["cantidadingreso"] . '"  required>

                      </div>
                      

                      </div>';
                  }


                  ?>

                </div>

                <input type="hidden" id="listaProductosOrdenedi" name="listaProductosOrdenedi">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <hr>

                <div class="row">

                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->
                  <div class="form-group col-xs-9">
                    <label for="exampleFormControlTextarea1">Algun Comentario</label>

                    <textarea class="form-control rounded-0" id="comentario" name="comentario" rows="10"><?php echo $ordencompra["comentario"]; ?></textarea>
                  </div>
                  <div class="col-xs-3 pull-right">

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

                          <td style="width: 0%">

                            <div class="input-group">

                              <input type="hidden" class="form-control input-lg" min="0" id="nuevoImpuestoOrdenedi" name="nuevoImpuestoOrdenedi" value="18" required>

                              <input type="hidden" name="nuevoPrecioImpuestoOrdenedi" id="nuevoPrecioImpuestoOrdenedi" value="<?php echo $ordencompra["impuesto"]; ?>" required>

                              <input type="hidden" name="nuevoPrecioNetoOrdenedi" id="nuevoPrecioNetoOrdenedi" value="<?php echo $ordencompra["neto"]; ?>" required>

                            </div>

                          </td>

                          <td style="width: 100%">

                            <div class="input-group">

                              <span class="input-group-addon">S/ </i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalOrdenedi" name="nuevoTotalOrdenedi" total="<?php echo $ordencompra["neto"]; ?>" value="<?php echo $ordencompra["total"]; ?>" readonly required>

                              <input type="hidden" name="totalOrdenedi" value="<?php echo $ordencompra["total"]; ?>" id="totalOrdenedi">


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

              <button type="submit" class="btn btn-primary pull-right" id="GuardarOrdenC">Recibir Orden</button>

            </div>

          </form>

          <?php

          $editarOrden = new ControladorOrdencompra();
          $editarOrden->ctrEditarOrden();

          ?>

        </div>

      </div>

      <!--=====================================
LA TABLA DE PRODUCTOS
======================================-->


    </div>

  </section>

</div>