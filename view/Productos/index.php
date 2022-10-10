<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["UsuarioId"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>ConecTotal</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>
    
    <?php require_once("../MainNav/nav.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Productos/Servicios</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Lista de Productos/Servicios</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

            <section class="tabs-section">
				<div class="tabs-section-nav tabs-section-nav-icons">
					<div class="tbl">
						<ul class="nav" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab">
									<span class="nav-link-in">
										<i class="font-icon font-icon-cogwheel"></i>
									Productos
									</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab">
									<span class="nav-link-in">
                                    <i class="fa fa-bolt" aria-hidden="true"></i>
										Servicios
									</span>
								</a>
							</li>
							
						</ul>
					</div>
				</div><!--.tabs-section-nav-->

				<div class="tab-content">
                    <!-- Panel Grid Productos -->
					<div role="tabpanel" class="tab-pane fade in active" id="tabs-1-tab-1">
                    <div class="box-typical box-typical-padding">
				
					<button type="button" id="BtnModalProductoServicio" class="btn btn-inline btn-primary">Nuevo Producto</button>
				<table id="GridProductos" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
                        <th style="width: 10%;"># Producto</th>
							<th style="width: 10%;">Clave</th>
                            <th style="width: 10%;">Descripción</th>
                            <th style="width: 10%;">Clave SAT</th>
                            <th style="width: 10%;">Categoria</th>
                            <th style="width: 10%;">Uso</th>
							<th class="text-center" style="width: 5%;"></th>
							<th class="text-center" style="width: 5%;"></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>

                    </div><!--.tab-pane-->
                    <!-- /Panel grid productos -->
                    <!-- Panel GridServicios -->
					<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2">
                    <div class="box-typical box-typical-padding">
				<button type="button" id="BtnModalProductoServicio" class="btn btn-inline btn-primary">Nuevo Servicio</button>
				<table id="GridServicios" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
						<th style="width: 10%;"># Producto</th>
							<th style="width: 10%;">Clave</th>
                            <th style="width: 10%;">Descripción</th>
                            <th style="width: 10%;">Clave SAT</th>
                            <th style="width: 10%;">Categoria</th>
                            <th style="width: 10%;">Uso</th>
							<th class="text-center" style="width: 5%;"></th>
							<th class="text-center" style="width: 5%;"></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
                    </div><!--.tab-pane-->
					<!-- /Panel Grid servicios -->
				</div><!--.tab-content-->
			</section><!--.tabs-section-->

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("ModalProductos.php");?>

	<?php require_once("../MainJs/js.php");?>
	
	<script type="text/javascript" src="ctrlProductos.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>