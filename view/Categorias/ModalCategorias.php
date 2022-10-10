
<div id="ModalCategorias" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="HeaderDegradado" class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 style="color: white;" class="modal-title" id="ModalTitulo"></h4>
            </div>
            <form method="POST" id="MaestroForm"><input type="hidden" name="Maestro" id="Maestro"></form>
            <form method="post" id="CategoriaForm">
                <div class="modal-body">
                    <input type="hidden" id="CategoriaId">

                    <div class="form-group">
                        
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="Categoria_Nombre"  placeholder="Capture el nombre de la categoria" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Uso</label>
                        <select id="Categoria_Uso" class="form-control">
	                    <option>Seleccionar..</option>
                        <option value="1">Activado</option>
                        <option value="0">Desactivado</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="BtnAddCategoria" type="button" class="btn btn-rounded btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>