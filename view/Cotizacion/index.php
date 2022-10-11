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
							<h3>Cotizaciones</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Lista de Cotizaciones</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

            <section class="tabs-section">
				<div class="tabs-section-nav tabs-section-nav-icons">
					<div class="tbl">
						<ul class="nav" role="tablist">
							<li class="nav-item" id="TabListaCotizacion">
								<a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab">
									<span class="nav-link-in">
										<!-- <i class="font-icon font-icon-cogwheel"></i> -->
									Lista Cotizaciones
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
				<a id="BtnAddCotizacion" class="btn btn-inline btn-primary"  href="AddCotizacion.php?CotizacionId=0">Nueva Cotización</a>
				<table id="GridCotizaciones" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
                        <th style="width: 10%;"># Cotización</th>
							<th style="width: 10%;">Cliente</th>
                            <th style="width: 10%;">Subtotal</th>
                            <th style="width: 10%;">IVA</th>
                            <th style="width: 10%;">Total</th>
                            <th class="text-center" style="width: 5%;">Factura</th>
							<th class="text-center" style="width: 5%;"></th>
							<!-- <th class="text-center" style="width: 5%;">Acciones</th> -->
							
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>

                    </div><!--.tab-pane-->

                    <!-- /Panel grid productos -->

	
				</div><!--.tab-content-->
			</section><!--.tabs-section-->

		</div>
	</div>
	<!-- Contenido -->


	<?php require_once("../MainJs/js.php");?>
	<?php require_once("ModalFacturaCoti.php");?>
	<?php require_once("EditarCotizacion.php");?>
	<script type="text/javascript" src="ctrlCotizacion.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>