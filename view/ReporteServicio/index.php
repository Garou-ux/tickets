<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["UsuarioId"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<title>ConecTotal</title>
	
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>
    
    <?php require_once("../MainNav/nav.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">
        <div class="form-group">
		<button type="button" id="GuardaReporte" class="btn btn-rounded btn-inline btn-secondary">Guardar</button>  
    </div>
        <section class="tabs-section">
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
								<input type="text" id="TicketId" class="form-control" placeholder="# De Ticket" onkeypress="return isNumber(event)">
								<a id="BtnValidaTicket"><i class="fa fa-search"></i>
								</a>
							</div>
						</fieldset>
					</div>
					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label">Cliente</label>
							<input type="text" class="form-control" id="Cliente" disabled>
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
                                <label class="form-label" >Tipo de Servicio</label>
                                <select id="CategoriaId" name="CategoriaId" class="form-control" disabled>
	                            <option value="">Seleccionar..</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fl-flex-label">
                                <label class="form-label" >Falla Presentada</label>

                                    <textarea  class="form-control"  id="FallaPresentada" placeholder="Falla">
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fl-flex-label">
                                <label class="form-label" >Diagnostico o Servicio Realizado</label>

                                    <textarea  class="form-control"  id="DiagnosticoOServicio" placeholder="Falla">
                                    </textarea>
                                </div>
                            </div>
                       
                            <div class="form-group">
                                <div class="fl-flex-label">
                                <label class="form-label">Material Utilizado</label>
                                <textarea  class="form-control"  id="DiagnosticoOServicio" placeholder="Falla">
                                    </textarea>
                                </div>
                            </div>
                         
                    </div>
            
            </div>
				</div><!--.row-->
             
                    </div><!--.tab-pane-->
					
				</div><!--.tab-content-->
			</section><!--.tabs-section-->
	
			
		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>

	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script type="text/javascript" src="ctrlReporteServicio.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>