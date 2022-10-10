
<div id="ModalProductosServicios" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="HeaderDegradado" class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 style="color: white;" class="modal-title" id="ModalTitulo"></h4>
            </div>
            <form method="POST" id="MaestroForm"><input type="hidden" name="Maestro" id="Maestro"></form>
            <form method="post" id="ProductoServicioForm">
                <div class="modal-body">
                    <input type="hidden" id="usu_id" name="usu_id">

                    <div class="form-group">
                        <label class="form-label">Clave</label>
                        <input type="text" class="form-control" id="ProductoServicio_Clave"  placeholder="Captura la clave" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" >Descripción</label>
                        <input type="text" class="form-control" id="ProductoServicio_Descripcion"  placeholder="Descripción del Producto/Servicio" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" >Clave SAT</label>
                        <input type="text" class="form-control" id="ProductoServicio_ClaveSat"  placeholder="Clave SAT" required>
                    </div>

              
                 

                    <div class="form-group">
                        <label class="form-label">Categoria</label>
                        <select id="ProductoServicio_Categoria"  class="form-control">
	                     <option>Seleccionar..</option>
                          </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">¿Es Servicio?</label>
                        <select id="ProductoServicio_EsServicio"  class="form-control">
	                    <option>Seleccionar..</option>
                        <option value="1">Si</option>
                        <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Uso</label>
                        <select id="ProductoServicio_Uso"  class="form-control">
	                    <option>Seleccionar..</option>
                        <option value="1">Activado</option>
                        <option value="0">Desactivado</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="BtnAddProductoServicio" type="button" class="btn btn-rounded btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>