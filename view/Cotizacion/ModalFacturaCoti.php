
<div id="ModalTicketFactura" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <input type="hidden" id="Factura_TicketId" >
                    <div class="form-group">
                        <label class="form-label" for="Usuario_Nombre"># Factura</label>
                        <input type="number" class="form-control" id="Ticket_Factura"  placeholder="Capture el numero de factura" required>
                    </div>

                
                  

        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="BtnAddTicketFactura" type="button" class="btn btn-rounded btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>