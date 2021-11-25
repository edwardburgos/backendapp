<?php

if($_SESSION["perfil"] != "Administrador"){

echo '<script>

  window.location = "inicio";

</script>';

return;

}

?>

<div class="content-wrapper">
  
   <section class="content-header">
      
    <h1>
     Pedidos Ecommerce
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Pedidos Ecommerce</li>
      
    </ol>

  </section>


  <section class="content">

    <div class="box"> 


      <div class="box-body">

      
        
        <br>
        
        <table class="table table-bordered table-striped dt-responsive tablaVentasecommer" width="100%">
        
          <thead>
            
            <tr>
              
              <th style="width:10px">#</th>
              <th>Codigo</th>
              <th>Cliente</th>
              <th>Direccion</th>
              <th>Correo</th>
              <th>Estado</th>
              <th>Total</th>  
              <th>Fecha</th>
              <th>Acciones</th>

            </tr>

          </thead> 
          <tbody>
          <?php
           $item = null;
           $valor = null;

           $ventecom = ControladorVentasecommerce::ctrMostrarVentas();

           foreach ($ventecom as $key => $value){
            echo '<tr>
            <td>'.($key+1).'</td>';
            echo'<td>'.$value["id"].'</td>';
                 
            $itemCliente = "email";
            $valorCliente = $value["email"];
            $respuestaCliente = ControladorClientes::ctrMostrarClientesandroid($itemCliente, $valorCliente);
            echo '<td>'.$respuestaCliente["nombre"].'</td>';
            echo '<td>'.$value["direccion"].'</td>';
            echo '<td>'.$value["email"].'</td>';
            if($value["estado"] == 0 ){

              $envio ="<button class='btn btn-danger btn-xs btnEnvio' idVentaeco='".$value["id"]."' estado='0'>Despachando el producto</button>";

            }else if($value["estado"] == 1 ){
        
              $envio = "<button class='btn btn-warning btn-xs btnEnvio' idVentaeco='".$value["id"]."' estado='1'>Enviando el producto</button>";
        
            }elseif($value["estado"] == 2 ){
        
              $envio = "<button class='btn btn-success btn-xs btnEnvio' idVentaeco='".$value["id"]."' estado='2'>Producto entregado</button>";
        
            }else{
              $envio = "<button class='btn btn-info btn-xs btnEnvio' idVentaeco='".$value["id"]."' estado='3'>Pedido Cancelado</button>";
            }
            echo '<td>'.$envio.'</td>';
            echo '<td>S/ '.number_format($value["pago"],2).'</td>';
            echo '<td>'.$value["fecha"].'</td>

            <td>

            <div class="btn-group">
            ';
        
          
            echo ' 

              </button>';

              if($_SESSION["perfil"] == "Administrador"){

              echo '<button class="btn btn-warning btnEditarVentaeco" idVentaeco="'.$value["id"].'"><i class="fa fa-pencil"></i></button>

              <button class="btn btn-danger btnEliminarVentaeco" idVentaec="'.$value["id"].'"><i class="fa fa-times"></i></button>';

            }

            echo '</div>  

          </td>
          </tr>';
           }
          ?>
          </tbody>
        </table>


      </div>

    </div>

  </section>

</div>