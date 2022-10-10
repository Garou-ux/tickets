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
							<h3>Pagos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Lista de Pagos</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<button type="button" id="BtnModalCategorias" class="btn btn-inline btn-primary">Nuevo Pago</button>
				<table id="GridCategorias" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
                        <th style="width: 10%;"># Factura</th>
							<th style="width: 10%;">Persona a quien se Pago</th>
                            <th style="width: 10%;">Total</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("ModalPagos.php");?>

	<?php require_once("../MainJs/js.php");?>
	
	<script type="text/javascript" src="ctrlPagos.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>