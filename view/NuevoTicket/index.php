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
<form  id="TicketMaestroForm">
<input type="hidden" name="Maestro" id="Maestro" >
</form>
<div class="tbl">
<div class="tbl-row">
<div class="tbl-cell">
<h3>Nuevo Ticket</h3>
<ol class="breadcrumb breadcrumb-simple">
<li><a href="#">Home</a></li>

<li class="active">Nuevo Ticket</li>
</ol>
</div>
</div>
</div>
</header>
<div class="box-typical box-typical-padding">


<form method="post" id="TicketForm" name="TicketForm">
<div class="row">
<input type="hidden" name="UsuarioId" id="UsuarioId" value=<?php echo $_SESSION["UsuarioId"] ?> >
<div class="col-lg-6">
<fieldset class="form-group">
<label class="form-label semibold" >Categoría</label>
<select id="CategoriaId" name="CategoriaId" class="form-control">
	<option value="">Seleccionar..</option>
</select>

</fieldset>
</div>
<div class="col-lg-6">
<fieldset class="form-group">
<label class="form-label semibold">Titulo</label>
<input id="Titulo" name="Titulo" type="text" class="form-control"  placeholder="Titulo">
</fieldset>
</div>
<!-- Nombre del usuario a requerir el soporte -->
<div class="col-lg-12">
<label class="form-label semibold">Nombre</label>
<input type="text" id="NombreReq" name="NombreReq" class="form-control" placeholder="Nombre del Solicitante" required>
</div>
<div class="col-lg-12">
<fieldset class="form-group">
<label class="form-label semibold" >Descripción</label>
<div class="summernote-theme-1">
<textarea  class="summernote" id="Descripcion" name="Descripcion"></textarea>
</div>
</fieldset>
</div>
<div class="col-lg-12">
<button type="submit" class="btn btn-rounded btn-inline btn-primary" id="Btnguar">Guardar</button>
</div>

</div><!--.row-->


</form>
</div>
</div>
</div>
<!-- Fin Contenido -->


	<?php require_once("../MainJs/js.php");?>
	
	<script type="text/javascript" src="ctrlNuevoTicket.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>