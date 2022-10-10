
<div id="ModalClientes" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="HeaderDegradado" class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 style="color: white;" class="modal-title" id="ModalTitulo"></h4>
            </div>
            <form method="POST" id="MaestroForm"><input type="hidden" name="Maestro" id="Maestro"></form>
            <form method="post" id="UsuarioForm">
                <div class="modal-body">
                    <input type="hidden" id="usu_id" name="usu_id">

                    <div class="form-group">
                        <label class="form-label" for="Usuario_Nombre">Nombre</label>
                        <input type="text" class="form-control" id="Usuario_Nombre" name="Usuario_Nombre" placeholder="Capture el nombre del Usuario" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="Usuario_RFC">RFC</label>
                        <input type="text" class="form-control" id="Usuario_RFC" name="Usuario_RFC" placeholder="Capture el RFC" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="Usuario_Correo">Correo</label>
                        <input type="email" class="form-control" id="Usuario_Correo" name="Usuario_Correo" placeholder="Capture el correo" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" >Razón Social</label>
                        <input type="text" class="form-control" id="Usuario_RazonSocial"  placeholder="Capture la Razón Social" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" >Telefono</label>
                        <input type="number" class="form-control" id="Usuario_Telefono"  placeholder="Capture el Telefono" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" >C.P.</label>
                        <input type="number" class="form-control" id="Usuario_CP"  placeholder="Codigo Postal" required>
                    </div>
                 
                    <div class="form-group">
                        <label class="form-label" >Contacto</label>
                        <input type="text" class="form-control" id="Usuario_Contacto"  placeholder="Contacto" required>
                    </div>
                  

        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="BtnAddCliente" type="button" class="btn btn-rounded btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>