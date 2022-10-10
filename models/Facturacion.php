<?php

class Facturacion extends Conectar{

    //funcion que obtiene la lista de los tickets cerrados listos para exportar a excel y facturarlos
    public function GetTicketsFacturacion(){
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call Facturacion_GetTicketsFacturacion()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function FacturaTicket($TicketId, $Factura){
        $conectar = parent::Conexion();
        parent::set_names();
        $sql= "call Ticket_FacturaTicket(?,?)";
        $sql =$conectar->prepare($sql);
        $sql->bindParam(1,$TicketId);
        $sql->bindParam(2,$Factura);
        $sql->execute();
        return $resultado =$sql->fetchAll();
    }
}

?>