<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Orden de Compra
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar Orden de Compra</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="proveedores">

          <button class="btn btn-primary">
            
            Agregar Orden de Compra

          </button>

        </a>

        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
           
            <span>
              <i class="fa fa-calendar"></i> Rango de fecha
            </span>

            <i class="fa fa-caret-down"></i>

         </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablasordencompra" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Código </th>
           <th>Empresa</th>
           <th>Trabajador</th>
           <th>Estado</th>
           <th>Impuesto</th>
           <th>Neto</th>
           <th>Total</th> 
           <th>Fecha</th>
           <th>Recibio</th>
           <th>Fecha Recibido</th>
           <th>Acciones</th>

         </tr> 

        </thead>

       </table>

      </div>

    </div>

  </section>

</div>


<?php

  $eliminarOrden = new ControladorOrdencompra();
  $eliminarOrden -> ctrEliminarOrden();

?>

