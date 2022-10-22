
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"  id = "myModal">
<div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Editar Cotizacion # <span id= "SpanModalCotizacionId"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <div class="tab-content">
                    <!-- Panel Grid Productos -->
                    <form>
						<input type="hidden" name="CotizacionModId" id ="CotizacionModId">
				
					<div role="tabpanel" class="tab-pane fade in active" id="tabs-1-tab-1">
                    <div class="box-typical box-typical-padding">
				
					<div class="row">
				
				<div class="col-lg-4">
					<fieldset class="form-group">
						<label class="form-label">Cliente</label>
						<select class="form-control" id="Cotizacion_ClienteId" onChange="GetUsuarioCliente()" required>
							<option>Seleccionar...</option>
						</select>
						
					</fieldset>
				</div>
			
				<div class="col-lg-4">
					<fieldset class="form-group">
						<label class="form-label" >Razón Social</label>
						<input type="text" class="form-control" id="Cotizacion_NombreCliente" disabled>
					</fieldset>
				</div>

				<div class="col-lg-4">
					<fieldset class="form-group">
						<label class="form-label" >Contacto</label>
						<input type="text" class="form-control" id="Cotizacion_Contacto" required >
					</fieldset>
				</div>

				
			</div><!--.row-->
			<div class="row">
			<div class="col-lg-4">
					<fieldset class="form-group">
						<label class="form-label" >Correo</label>
						<input type="text" class="form-control" id="Cotizacion_Correo" required >
					</fieldset>
				</div>
			</div>
			<div id="jsGridEditarCotizacion" style="height:100%;"></div>
			</form>
			</div>
            <!-- <button type="button" id="BtnGuardaCotizacion" class="btn btn-rounded btn-inline btn-success">Guardar</button>  -->
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
            <button type="button" id="BtnEditarcotizacion" class="btn btn-success">Guardar Cotizacion</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
		
                    </div><!--.tab-pane-->
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <!-- <button type="button" class="btn btn-success">Guardar Cotizacion</button> -->
          <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
        </div>
        
      </div>
    </div>
  </div>
  
</div>