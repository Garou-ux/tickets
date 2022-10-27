
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"  id = "myModalReporteServicio">
<div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal body -->
        <div class="modal-body">
        <section class="card card-blue-fill">
				<header class="card-header">
				<h4 class="modal-title">Reporte de Servicio para Ticket # <span id= "SpanModalTicketId"></h4>
          <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
				</header>
				<div class="card-block">
				<section class="tabs-section">
				<div class="tabs-section-nav tabs-section-nav-icons">
					<div class="tbl">
						<ul class="nav" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab" aria-expanded="true">
									<span class="nav-link-in">
										<i class="font-icon font-icon-cogwheel"></i>
										Datos Generales
									</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab" aria-expanded="false">
									<span class="nav-link-in">
									<i class="fa fa-desktop"></i>
										Descripcion del Equipo
									</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tabs-1-tab-3" role="tab" data-toggle="tab">
									<span class="nav-link-in">
										<i class="fa fa-server"></i>
										Detalles del Servicio
									</span>
								</a>
							</li>
						</ul>
					</div>
				</div><!--.tabs-section-nav-->

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade active in" id="tabs-1-tab-1" aria-expanded="true">
					<form id="FormGeneral">
					<div class="row">
					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label">Cliente</label>
							<input type="text" class="form-control" id="Cliente" disabled>
							
							<input type="hidden" class="form-control" id="ClienteIdReporte" disabled>
							<input type="hidden" class="form-control" id="CategoriaIdTicket" disabled>
						</fieldset>
					</div>
				
					<!-- <div class="col-lg-4">
						<fieldset class="form-group">
                        <label class="form-label" >Fecha del Servicio</label>
						<input type="text" class="form-control" id="date-mask-input" placeholder="__/__/____" required>
								<small class="text-muted">Formato de Fecha: Dia/Mes/Año</small>
						</fieldset>
					</div> -->
                    <div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label" >Asesor</label>
							<input type="text" class="form-control" id="Soporte" disabled>
						</fieldset>
					</div>
                    </form>
				</div><!--.row-->
					</div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2" aria-expanded="false">
					<form id="FormDescripcionEquipo">
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
				</form>
					</div><!--.tab-pane Materiales/servicios -->
					<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-3">
					<form id="FormProductosServicios">
						  <div class="form-group">
						    <label for="formGroupExampleInput">Categoria</label>
						    <input type="text" class="form-control" id="Categoria" disabled>
						  </div>
						  <div class="form-group">
						    <label for="formGroupExampleInput2">Falla Presentada</label>
						    <input type="text" class="form-control" id="FallaPresentada" placeholder="Describa la Falla">
						  </div>
						  <div class="form-group">
						  <label for="jsGridReporteServicio">Materiales/Servicios Utilizados</label>
						  <div id="jsGridReporteServicio" style="height:100%;"></div>
						  </div>
		            </form>
					</div><!--.tab-pane-->
				    </div><!--.tab-content-->
			    </section>
				</div>
				<div class="modal-footer">
                    <div class="field" >
	                   <span STYLE="font-weight:bold">Subtotal: $</span><span STYLE="font-weight:bold"	 id="SpanSubtotal"></span>
                    </div>
		            <div class="field" >
				       <span STYLE="font-weight:bold">I.V.A.: $</span><span STYLE="font-weight:bold" id="SpanIVA"></span>
		            </div>
		            <div class="field" >
			          <span STYLE="font-weight:bold">Total: $</span><span STYLE="font-weight:bold" id="SpanTotal"></span>
		            </div>
                    <br>
                   <button type="button" id="BtnGuardarReporteServicio" class="btn btn-success">Guardar</button>
                   <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               </div>
			</section>
        </div>
      </div>
    </div>
  </div>
</div>