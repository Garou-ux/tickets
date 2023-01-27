<?php

class TblPagos {
    public $PagoId; //int
    public $UsuarioId; //int
    public $Nombre; //string
    public $Factura; //int
    public $Total; //decimal(12,2)
    public $Activo; //int
    public $created_at; //timestamp
    public $updated_at; //timestamp
    public $FechaPago;
    public $Descripcion;
    public $Pagado;
}

?>