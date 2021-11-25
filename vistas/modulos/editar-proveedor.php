<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Editar Proveedor

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Editar Proveedor</li>

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

                <?php

                $item = "id";
                $valor = $_GET["idProveedor"];

                $proveedor = ControladorProveedores::ctrMostrarProveedores($item, $valor);


                ?>

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <input type="text" class="form-control" id="editarRUC" name="editarRUC" value="<?php echo $proveedor["ruc"]; ?>" required>
                    <input type="hidden" id="idProveedor" name="idProveedor" value="<?php echo $proveedor["id"]; ?>" required>
                  </div>

                </div>
                <!-- ENTRADA PARA EL NOMBRE -->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control input-lg" name="editarProveedor"  id="editarProveedor"  value="<?php echo $proveedor["nombre"]; ?>" required>

                  </div>

                </div>



                <!-- ENTRADA PARA EL EMAIL -->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                    <input type="text" class="form-control input-lg" name="editarDireccionn" placeholder="Ingresar Direccion" id="editarDireccionn"  value="<?php echo $proveedor["direccion"]; ?>" required>

                  </div>

                </div>

                <!-- ENTRADA PARA EL TELÉFONO -->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                    <input type="text" class="form-control input-lg" name="editarTelefonoo" id="editarTelefonoo" value="<?php echo $proveedor["telefono"]; ?>" required>

                  </div>

                </div>
                <!-- ENTRADA PARA EL EMAIL -->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                    <input type="email" class="form-control input-lg" name="editarEmaill"  id="editarEmaill"  value="<?php echo $proveedor["email"]; ?>" required>

                  </div>

                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================-->

                <div class="form-group row nuevoProducto">

                  <?php

                  $listaProductoss = json_decode($proveedor["productos"], true);

                  foreach ($listaProductoss as $key => $value) {

                    $item = "id";
                    $valor = $value["id"];
                    $orden = "id";

                    $respuesta = ControladorProductos::ctrMostrar($item, $valor, $orden);


                    echo '<div class="row" style="padding:5px 40px">
            
                        <div class="col-xs-9" style="padding-right:0px">
            
                          <div class="input-group">
                
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' . $value["id"] . '"><i class="fa fa-times"></i></button></span>

                            <input type="text" class="form-control nuevaDescripcionProducto" idProducto="' . $value["id"] . '" name="agregarProducto" value="' . $value["descripcion"] . '" readonly required>

                          </div>

                        </div>

                        

                      </div>';
                  }


                  ?>

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

              <button type="submit" class="btn btn-primary pull-right">Guardar cambios</button>

            </div>

          </form>

          <?php

          $editarProveedor = new ControladorProveedores();
          $editarProveedor->ctrEditarProveedor();

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
