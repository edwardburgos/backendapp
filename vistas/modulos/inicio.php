<!--=====================================
PÁGINA DE INICIO
======================================-->

<!-- content-wrapper -->
<div class="content-wrapper">

  <!-- content-header -->
  <section class="content-header">
    
    <h1>
    Tablero
    <small>Panel de Control</small>
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tablero</li>

    </ol>

  </section>
  <!-- content-header -->

  <!-- content -->
  <section class="content">
    
  <section class="content">

<div class="row">
  
<?php

if($_SESSION["perfil"] =="Administrador" || $_SESSION["perfil"] =="Vendedor"){

  include "inicio/cajas-superiores.php";

}

?>

</div> 

 <div class="row">
   
    <div class="col-lg-12">

      <?php

      if($_SESSION["perfil"] =="Administrador" || $_SESSION["perfil"] =="Vendedor"){
      
       include "reportes/grafico-ventas.php";

      }

      ?>

    </div>

    <div class="col-lg-6">

      <?php

      if($_SESSION["perfil"] =="Administrador" || $_SESSION["perfil"] =="Vendedor"){
      
       include "reportes/productos-mas-vendidos.php";

     }

      ?>

    </div>

     <div class="col-lg-6">

      <?php

      if($_SESSION["perfil"] =="Administrador" || $_SESSION["perfil"] =="Vendedor"){
       include "inicio/productos-recientes.php";

     }

      ?>

    </div>

     <div class="col-lg-12">
       
      <?php

      if($_SESSION["perfil"] =="Editor" || $_SESSION["perfil"] =="Vendedor"){

         echo '<div class="box box-success">

         <div class="box-header">

         <h1>Bienvenid@ ' .$_SESSION["nombre"].'</h1>

         </div>

         </div>';

      }

      ?>

     </div>

 </div>

 </section>
  <!-- content -->

</div>
<!-- content-wrapper -->

  