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
      
      Administrar Proveedores
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar Proveedores</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="crear-proveedor">

          <button class="btn btn-primary">
            
            Agregar Proveedores

          </button>

        </a>


      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablasproveedores" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>RUC</th>
           <th>Proveedor</th>
           <th>Direccion</th>
           <th>Telefono</th>
           <th>Correo</th>
           <th>Acciones</th>

         </tr> 

        </thead>

     
       </table>

       <?php

$eliminarProveedor = new ControladorProveedores();
$eliminarProveedor -> ctrEliminarProveedor();

?>

      </div>

    </div>

  </section>

</div>




