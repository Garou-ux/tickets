<?php
require_once("../../config/conexion.php"); 
if(isset($_SESSION["UsuarioId"])){ 
?>
<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>
<title>ConecTotal</title>
<style>
	.field{
 display:inline; 
}

.inputTotales {
	font-size: 0.9em;
  padding-top: 0.35rem;
  border: 2px solid lightgrey;
  border-style: groove;
  border-radius: 12px;
  padding: 5px;
}
</style>
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
<h3>Consultar Ticket</h3>
<ol class="breadcrumb breadcrumb-simple">
<li><a href="#">Home</a></li>
<li class="active">Consultar Ticket</li>
</ol>
</div>
</div>
</div>
</header>

<section class="tabs-section">
<div class="tabs-section-nav tabs-section-nav-inline">
<ul class="nav" role="tablist">
<li class="nav-item" >
<a class="nav-link" id="BotonRegresar" onclick="fnOcultarTabDetalle()">		
<i class="fa fa-arrow-left" aria-hidden="true"></i>
Regresar                            
</a>
</li>				
</ul>
</div>

<div class="tab-content" id="TabContentDet">
<!-- Tab General -->
<div class="box-typical box-typical-padding" id="TabGeneral">
<table id="GridTickets" class="table table-bordered table-striped table-vcenter js-dataTable-full">
<thead>
<tr>
<th style="width: 1%;">No.Ticket</th>
<th style="width: 1%;">Estatus</th>
<th class="d-none d-sm-table-cell" style="width: 3%;">Fecha</th>
<th class="d-none d-sm-table-cell" style="width: 1%;">Usuario</th>
<th class="d-none d-sm-table-cell" style="width: 2%;">Categoría</th>
<th style="width: 1%;">Soporte</th>
<th style="width: 1%;"># Factura</th>
<th class="text-center" style="width: 1%;">Responder Ticket</th>
<!-- solo los soporte tienen acceso a esta opcion -->
<?php if ($_SESSION["RolId"]==1){
	?>
	<th class="text-center" style="width: 2%;">Reporte de Servicio</th>
	<!-- Eliminar ticket -->
	<th class="text-center" style="width: 2%">Eliminar Ticket</th>
	<?php } ?>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
<!-- /Tab General -->
<!-- Panel del detalle del ticket -->					
<div class="box-typical box-typical-padding" id="TabDetalleTicket">

<div class="box-typical box-typical-padding">
<div class="tbl">
<div class="tbl-row">
<div class="tbl-cell">
<h3 id="NoTicket"></h3>
<div id="SpanEstatusTicket"></div>
<span class="label label-pill label-primary" id="SpanNombreUsuario"></span>
<span class="label label-pill label-default" id="SpanFechaCreacion"></span>
<ol class="breadcrumb breadcrumb-simple">
</ol>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-6">
<fieldset class="form-group">
<label class="form-label semibold" >Categoría</label>
<input id="DataCategoria"  type="text" class="form-control"   readonly>
</fieldset>
</div>
<div class="col-lg-6">
<fieldset class="form-group">
<label class="form-label semibold">Titulo</label>
<input id="DataTitulo"  type="text" class="form-control"  readonly>
</fieldset>
</div>
<div class="col-lg-12">
<fieldset class="form-group">
<label class="form-label semibold" >Descripción</label>


<div class="summernote-theme-1">
<textarea  class="summernote" id="DataDescripcion"  readonly></textarea>
</div>
</fieldset>
</div>
</div><!--.row-->
</div>
<section class="activity-line" id="DetalleTicket" >
</section>

<!-- Campos para responder al ticket -->
<div class="box-typical box-typical-padding" id="RowRespuesta">

<h5>Responder Ticket</h5>


<div class="row" >
<div class="col-lg-12">
<fieldset class="form-group">
<label class="form-label semibold" >Descripción</label>
<div class="summernote-theme-1">
<textarea  class="summernote" id="Respuesta" name="Respuesta"></textarea>
</div>
</fieldset>
</div>
<div class="col-lg-12">
<button type="button" id="BtnAddTicketRespuesta" class="btn btn-rounded btn-inline btn-success">Enviar</button>
<?php if ($_SESSION["RolId"]==1){
	?>
	<button type="button" id="BtnCerrarTicket" class="btn btn-rounded btn-inline btn-danger">Cerrar Ticket</button>

	<?php } ?>
</div>

</div><!--.row-->



</div>
<!-- /campos para responder al ticket -->


<!-- /Tab de Reporte de servicio -->
</div>
<!--/Panel del detalle del ticket -->
</div><!--.tab-content-->
</section><!--.tabs-section-->
<!-- Tab de Reporte de servicio -->
<div class="box-typical box-typical-padding" id="TabReporteServicio">
<div class="form-group">
<a class="nav-link" id="BotonRegresar" onclick="fnOcultarTabDetalle()">		
<i class="fa fa-arrow-left" aria-hidden="true"></i>
Regresar                            
</a> 
    </div>
        <section class="tabs-section">
			<form id="FormReporteServicioLimp">
				<div class="tabs-section-nav tabs-section-nav-inline">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" href="#tabs-4-tab-1" role="tab" data-toggle="tab">
								Datos Generales
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-4-tab-2" role="tab" data-toggle="tab">
								Descripción del Equipo
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-4-tab-3" role="tab" data-toggle="tab">
								Descripción del Servicio
							</a>
						</li>

					</ul>
				</div><!--.tabs-section-nav-->
                <div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="tabs-4-tab-1">
                    <div class="row">
					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label semibold" ># Ticket</label>
							<div class="form-control-wrapper form-control-icon-right">
								<input type="text" id="TicketIdReporte" class="form-control" placeholder="# De Ticket" disabled>
								<!-- <a id="BtnValidaTicket"><i class="fa fa-search"></i>
								</a> -->
							</div>
						</fieldset>
					</div>
					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label">Cliente</label>
							<input type="text" class="form-control" id="Cliente" disabled>
							<input type="hidden" class="form-control" id="ClienteIdReporte" disabled>
						</fieldset>
					</div>
					<!-- <div class="col-lg-4">
						<fieldset class="form-group">
                        <label class="form-label" >Fecha del Servicio</label>
						<input type="text" class="form-control" id="date-mask-input" placeholder="__/__/____">
								<small class="text-muted">Formato de Fecha: Dia/Mes/Año</small>
						</fieldset>
					</div> -->
                    <div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label" >Asesor</label>
							<input type="text" class="form-control" id="Soporte" disabled>
						</fieldset>
					</div>
				</div><!--.row-->

                    </div><!--.tab-pane-->

                    <!-- Tab 2 -->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-2">
                    <div class="row">
					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label semibold" >Marca</label>
							<input type="text" class="form-control" id="Marca" placeholder="Marca del equipo">
							<small class="text-muted"></small>
						</fieldset>
					</div>
					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label" >Modelo</label>
							<input type="text" class="form-control" id="Modelo" placeholder="Modelo del equipo" >
						</fieldset>
					</div>
					<div class="col-lg-4">
						<fieldset class="form-group">
                        <label class="form-label" >Serie</label>
							<input type="text" class="form-control" id="Serie" placeholder="Serie del equipo">
						</fieldset>
					</div>
				</div><!--.row-->

                <div class="row">
					<div class="col-md-4 col-sm-6">
						<fieldset class="form-group">
							<label class="form-label" >Otros</label>
							<input type="text" class="form-control" id="Otros" placeholder="">
						</fieldset>
					</div>
					<div class="col-md-8 col-sm-12">
						<fieldset class="form-group">
							<label class="form-label" >Inspección Visual</label>
							<input type="text" class="form-control" id="InspeccionVisual">
						</fieldset>
					</div>
	
				</div><!--.row-->
                    </div><!--.tab-pane-->
                    <!-- Tab 3  -->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-3">
                    <div class="row">
				
                <div class="card">
                    <div class="card-block">
                        <form>
                            <div class="form-group">
                                <div class="fl-flex-label">
                                <label class="form-label" >Categoria</label>
                                <input type="text"  class="form-control" id="CategoriaReporte" disabled>
								<input type="hidden" id="CategoriaIdReporte" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fl-flex-label">
                                <label class="form-label" >Falla Presentada</label>

                                    <textarea  class="form-control"  id="FallaPresentada" placeholder="Falla">
                                    </textarea>
                                </div>
                            </div>

							<!-- Tabla de Servicios utlizados -->
							<div class="table-responsive" >
							<h5>Servicios Utlizados</h5>			
                            <table class="table table-bordered" id="GridServicios">
							<tbody id="tbServicios">

							</tbody>
                            </table>			
                         </div>
                       <!-- /tabla servicios -->

								<!-- Tabla de materiales/prouctos utlizados -->
							<div class="table-responsive" >
							<h5>Material Utilizado</h5>
                            <table class="table table-bordered" id="GridMateriales">
							<tbody id="tbMateriales">

</tbody>
                     </table>
                         </div>
                       <!-- /tabla materiales/productos -->
                         
                    </div>
            
            </div>
				</div><!--.row-->
             
                    </div><!--.tab-pane-->
					
				</div><!--.tab-content-->
                <button type="button" id="BtnGuardaReporte" class="btn btn-rounded btn-inline btn-success">Guardar</button> 			
  <div class="field" >
	  <span>Totales</span>
  <input style="width: 150px;" placeholder="Servicio" class="inputTotales" id="TotalServicio"  size="30"  type="number">
</div>
<div class="field" >
<input style="width: 150px;" placeholder="Refacciones" class="inputTotales" id="TotalRefacciones" name="firstname"  type="number">
</div>
<div class="field" >
<input style="width: 150px;" placeholder="Viaticos/Otros" class="inputTotales" id="TotalViaticosOtros" name="firstname"  type="number">
</div>
  
<div class="field" >
	<span>Subtotal:</span>$<span id="SpanSubtotal"></span>
</div>
<div class="field" >
	<span>I.V.A.:</span>$<span id="SpanIVA"></span>
</div>

<div class="field" >
	<span>Total:</span>$<span id="SpanTotal"></span>
</div>

				</div> 
				</form>	
			</section><!--.tabs-section-->
			
</div>
</div><!--.container-fluid-->
</div> 
<!-- Contenido -->


<?php require_once("../MainJs/js.php");?>
<script type="text/javascript" src="ctrlConsultarTicket.js"></script>
</body>
</html>
<?php
} else {
header("Location:".Conectar::ruta()."index.php");
}
?>