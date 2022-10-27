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
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
<!-- /Tab General -->
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