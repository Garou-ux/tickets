
<div id="ModalPagos" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="HeaderDegradado" class="modal-header" >
                <p  id= "pPagoId" style="color:white; display:none;"> Editar Pago # <small id= "smallpagoid"> </small></p>
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 style="color: white;" class="modal-title" id="ModalTitulo"></h4>
            </div>
                <form method="post" id="UsuarioForm">
                    <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id= "PagoId">
                        <label for="SelectPagos">Empleado a asignar Pago</label>
                        <input class="form-control" id="SelectPagos" type="text" placeholder="Nombre de a quien se Paga">
                        </select>
                        
                    </div>
                       
                    <div class="form-group">
                        <input type="hidden" id= "PagoId">
                        <label for="Descripcion">Descripción</label>
                        <textarea class="form-control" name="Descripcion" id="Descripcion" placeholder="Descripcion"></textarea>
                        </select>                       
                    </div>

                    <div class="form-group">
                        <label for="Pago"># Factura</label>
                        <input type="number" class="form-control" id="FacturaN" placeholder="$0.00">
                      </div>
                    <div class="form-group">
                        <label for="Pago">Cantidad a Pagar</label>
                        <input type="number" class="form-control" id="Pago" placeholder="$0.00">
           
                      </div>
                      <div class="form-group form-check">
                <input type="checkbox" class="form-control form-check-input" id="Pagado">
                <label class="form-check-label" for="Pagado">Pagado</label>
  </div>
                </form>
                </div> <!-- Fin modal body-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="BtnAddTicketFactura" type="button" onclick="AgregarEditarPago();"  class="btn btn-rounded btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cambios para pagos
1.Abajo del empleado, poner descripcion del servicio
2. en el grid de pagos poner estatus del pago Verde: Pendiente de pagar, Rojo Pagado
-->