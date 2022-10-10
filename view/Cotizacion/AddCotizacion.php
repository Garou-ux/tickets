<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["UsuarioId"])){ 

    $CotizacionId = $_GET["CotizacionId"];
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<!-- <link href="http://js-grid.com/css/jsgrid.min.css" rel="stylesheet" /> -->
    <!-- <link href="http://js-grid.com/css/jsgrid-theme.min.css" rel="stylesheet" /> -->
	<title>ConecTotal</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>
    <!-- $GLOBALS["ReporteServicioId"] -->
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
								<li class="active" ><span id="TituloPagina"></span></li>
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
										<!-- <i class="font-icon font-icon-cogwheel"></i> -->
									General
									</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab">
									<span class="nav-link-in">
                                    <!-- <i class="fa fa-bolt" aria-hidden="true"></i> -->
										Detalle
									</span>
								</a>
							</li>
							
						</ul>
					</div>
				</div><!--.tabs-section-nav-->

				<div class="tab-content" id = "ContentCotizacion">
                    <!-- Panel Grid Productos -->
                    <form>
						
				
					<div role="tabpanel" class="tab-pane fade in active" id="tabs-1-tab-1">
                    <div class="box-typical box-typical-padding">
				
					<div class="row">
				
				<div class="col-lg-4">
					<fieldset class="form-group">
						<label class="form-label">Cliente</label>
						<select class="form-control" id="Cotizacion_ClienteId" onChange="GetUsuarioCliente()" required>
							<option>Seleccionar...</option>
						</select>
						
					</fieldset>
				</div>
			
				<div class="col-lg-4">
					<fieldset class="form-group">
						<label class="form-label" >Razón Social</label>
						<input type="text" class="form-control" id="Cotizacion_NombreCliente" disabled>
					</fieldset>
				</div>

				<div class="col-lg-4">
					<fieldset class="form-group">
						<label class="form-label" >Contacto</label>
						<input type="text" class="form-control" id="Cotizacion_Contacto" required >
					</fieldset>
				</div>

				
			</div><!--.row-->
			<div class="row">
			<div class="col-lg-4">
					<fieldset class="form-group">
						<label class="form-label" >Correo</label>
						<input type="text" class="form-control" id="Cotizacion_Correo" required >
					</fieldset>
				</div>
			</div>
			<div id="jsGrid" style="height:100%;"></div>
			</form>
			</div>

                    </div><!--.tab-pane-->
                    <!-- /Panel grid productos -->
                    <!-- Panel GridServicios -->
					<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2">
                    <div class="box-typical box-typical-padding">
									<!-- Tabla de materiales/prouctos utlizados -->
									<div class="table-responsive" >
							<h5>Productos</h5>
                            <table class="table table-bordered" id="GridMateriales">
							<tbody id="tbMateriales">

</tbody>
                     </table>
                         </div>
                       <!-- /tabla materiales/productos -->
			
			</div>
                    </div><!--.tab-pane-->
					<!-- /Panel Grid servicios -->
					<button type="button" id="BtnGuardaCotizacion" class="btn btn-rounded btn-inline btn-success">Guardar</button> 
					<div class="field" >
	<span STYLE="font-weight:bold">Subtotal: $</span><span STYLE="font-weight:bold"	 id="SpanSubtotal"></span>
</div>
<div class="field" >
	<span STYLE="font-weight:bold">I.V.A.: $</span><span STYLE="font-weight:bold" id="SpanIVA"></span>
</div>

<div class="field" >
	<span STYLE="font-weight:bold">Total: $</span><span STYLE="font-weight:bold" id="SpanTotal"></span>
</div>
				</div><!--.tab-content-->
			</section><!--.tabs-section-->

		</div>
	</div>
	<!-- Contenido -->


	<?php require_once("../MainJs/js.php");?>
	<!-- <script src="http://js-grid.com/js/jsgrid.min.js"></script> -->
	<script type="text/javascript" src="ctrlAddCotizacion.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>