<!--=====================================
MENU
======================================-->	

<ul class="sidebar-menu">

	<li class="active"><a href="inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li>

  <?php

  if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Editor"){
echo '

	<li class="treeview">
      
      <a href="#">
        <i class="fa fa-th"></i>
        <span>Gestor Categorías</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>

      <ul class="treeview-menu">
        
        <li><a href="categorias"><i class="fa fa-circle-o"></i> Categorías</a></li>
        <li><a href="subcategorias"><i class="fa fa-circle-o"></i> Subcategorías</a></li>
      
      </ul>

  </li>

  
  <li><a href="productos"><i class="fa fa-product-hunt"></i> <span>Gestor Productos</span></a></li>';

  echo '
    <li class="treeview">
        
        <a href="#">
        <i class="fa fa-truck"></i> 
          <span>Gestor Proveedores</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
  
        <ul class="treeview-menu">
          
          <li><a href="proveedores"><i class="fa fa-circle-o"></i> Proveedores</a></li>
          <li><a href="crear-proveedor"><i class="fa fa-circle-o"></i> Agregar Proveedor</a></li>
          <li><a href="ordencompra"><i class="fa fa-circle-o"></i>Ordenes de Compra</a></li>
        </ul>
  
    </li>';
  }
 
  ?>

	

  <?php





  if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){

 
    echo '<li>

      <a href="clientes">

        <i class="fa fa-users"></i>
        <span>Gestor Clientes</span>

      </a>

    </li>';

  }


  if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){

     echo '<li class="treeview">

    <a href="#">

      <i class="fa fa-shopping-cart"></i>
      
      <span>Gestor Ventas</span>
      
      <span class="pull-right-container">
      
        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">
      
      <li>

        <a href="ventas">
          
          <i class="fa fa-circle-o"></i>
          <span>Administrar ventas</span>

        </a>

      </li>

      <li>

        <a href="crear-venta">
          
          <i class="fa fa-circle-o"></i>
          <span>Crear venta</span>

        </a>

      </li>';

      if($_SESSION["perfil"] == "Administrador"){

      echo '<li>

        <a href="reportes">
          
          <i class="fa fa-circle-o"></i>
          <span>Reporte de ventas</span>

        </a>

      </li>';

        }

      

      echo '</ul>

    </li>';

  }

  if($_SESSION["perfil"] == "Administrador"){

    echo '<li><a href="perfiles"><i class="fa fa-key"></i> <span>Usuarios Trabajadores</span></a></li>
 
    ';
  

  }

  if($_SESSION["perfil"] == "Administrador"){

    echo '
    <li class="treeview">
        
        <a href="#">
        <i class="fa fa-shopping-cart"></i> 
          <span>Pedidos Ecommerce</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
  
        <ul class="treeview-menu">
        <li><a href="ventasecommerce"><i class="fa fa-truck"></i> <span>Gestor Ventas</span></a></li>
        <li><a href="usuarios"><i class="fa fa-users"></i> <span>Usuarios Clientes</span></a></li>
        </ul>
  
    </li>';

  }

  ?>

</ul>	