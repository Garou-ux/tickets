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
<th class="text-center" style="width: 1%;">Acciones</th>
<!-- solo los soporte tienen acceso a esta opcion -->
  <?php //if ($_SESSION["RolId"]==1){
	?>
	<!-- <th class="text-center" style="width: 2%;">Reporte de Servicio</th> -->
	<!-- Eliminar ticket -->
	<!-- <th class="text-center" style="width: 2%">Eliminar Ticket</th> -->
	<?php /*} */ ?>  
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
<span class="label label-pill label-primary">Solicitante : <span id="SpanSolicitante"></span></span>
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
</div>
</div><!--.container-fluid-->
</div> 
<!-- Contenido -->
<?php require_once("../MainJs/js.php");?>
<?php require_once("ModalReporteServicio.php");?>
<?php require_once("ModalResponderTicket.php");?>
<script type="text/javascript" src="ctrlConsultarTicket.js"></script>
</body>
</html>
<?php
} else {
header("Location:".Conectar::ruta()."index.php");
}
?>