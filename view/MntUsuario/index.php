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
							<h3>Lista de Usuarios</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Lista de Usuarios</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<button type="button" id="BtnModalUsuario" class="btn btn-inline btn-primary">Nuevo Usuario</button>
				<table id="GridUsuarios" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
						<th style="width: 10%;"># Usuario</th>
							<th style="width: 10%;">Nombre</th>
							<th class="d-none d-sm-table-cell" style="width: 40%;">Correo</th>
							<th class="d-none d-sm-table-cell" style="width: 5%;">Contraseña</th>
							<th class="d-none d-sm-table-cell" style="width: 5%;">Rol</th>
							<th class="d-none d-sm-table-cell" style="width: 5%;">RFC</th>
							<th class="text-center" style="width: 5%;"></th>
							<th class="text-center" style="width: 5%;"></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("ModalUsuario.php");?>

	<?php require_once("../MainJs/js.php");?>
	
	<script type="text/javascript" src="ctrlMntUsuario.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>