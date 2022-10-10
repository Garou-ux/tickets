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
							<h3>Tickets Cerrados</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Tickets Cerrados</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<table id="GridTicketsFacturacion" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
						<th style="width: 2%;"># Ticket</th>
							<th style="width: 10%;">Cliente</th>
							<th class="d-none d-sm-table-cell" style="width: 7%;">RFC</th>
							<th class="d-none d-sm-table-cell" style="width: 5%;"></th>
							<th class="d-none d-sm-table-cell" style="width: 5%;"></th>
							<th class="d-none d-sm-table-cell" style="width: 5%;">PDF</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>

		</div>
	</div>
	<!-- Contenido -->


	<?php require_once("../MainJs/js.php");?>
	<?php require_once("ModalTicketFactura.php");?>
	<script type="text/javascript" src="ctrlFacturacion.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>