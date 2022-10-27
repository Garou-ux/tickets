
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"  id = "myModalResponderTicket">
<div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal body -->
        <div class="modal-body">
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
        </div>
      </div>
    </div>
  </div>