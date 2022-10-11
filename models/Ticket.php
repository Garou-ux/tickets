<?php 
class Ticket extends Conectar{
    
    //Agrega un nuevo ticket
    public function AddTicket($Maestro){
        $conectar = parent::Conexion();
        parent::set_names();
                $sql = "call Ticket_AddTicket(?)";
                $sql=$conectar->prepare($sql);
                $sql->bindParam(1,$Maestro);
                $sql->execute();
                return $resultado =$sql->fetchAll();
    }

    //Retorna una lista de los tickets x usuario
    public function ListTicketsXUsuario ($UsuarioId){
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call Ticket_ListTicketsXUsuario(?)";
        $sql=$conectar->prepare($sql);
        $sql->bindParam(1,$UsuarioId);
        $sql->execute();
        return $resultado =$sql->fetchAll();
    }

    //Retorna un ticket en especifico
    public function GetTicketXId($TicketId){
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call Ticket_GetTicketXId(?)";
        $sql = $conectar->prepare($sql);
        $sql ->bindParam(1,$TicketId);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    //Retorna el detalle de un ticket en especifico
    public function GetTicketDetXId($TicketId){       
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call Ticket_GetTicketDetXId(?)";
        $sql=$conectar->prepare($sql);
        $sql->bindParam(1,$TicketId);
        $sql->execute();
        return $resultado =$sql->fetchAll();
        
    }

    //Agrega una respuesta a un ticket en especifico
 public function AddTicketRespuesta($Maestro){
    $conectar = parent::Conexion();
    parent::set_names();
            $sql = "call Ticket_AddTicketRespuesta(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindParam(1,$Maestro);
            $sql->execute();
            return $resultado =$sql->fetchAll();
 }

//Cierra un ticket
 public function CerrarTicket($TicketId, $UsuarioId){
     $conectar = parent::Conexion();
     parent::set_names();
     $sql = "call Ticket_CerrarTicket(?,?)";
     $sql = $conectar->prepare($sql);
     $sql->bindParam(1,$TicketId);
     $sql->bindParam(2,$UsuarioId);
     $sql->execute();
     return $resultado = $sql->fetchAll();
 }

    
//Obtiene los totales de los tickets por estatus, esto para la pantalla principal
public function GetTotalTicketsXEstatus($UsuarioId){
$conectar = parent::Conexion();
parent ::set_names();
$sql = "call Ticket_GetTotalTicketsXUsuario(?)";
$sql = $conectar->prepare($sql);
$sql->bindParam(1,$UsuarioId);
$sql->execute();
return $resultado = $sql->fetchAll();
    }

public function GetTotalTicketsXCategoriaGrafico($UsuarioId){
$conectar = parent::Conexion();
parent:: set_names();
$sql = "call Ticket_GetTotalTicketsXCategoriaGrafico(?)";
$sql = $conectar->prepare($sql);
$sql->bindParam(1,$UsuarioId);
$sql->execute();
return $resultado = $sql->fetchAll();
}

//Elimina un ticket
public function DeleteTicket($TicketId){
    $conectar = parent::Conexion();
    parent::set_names();
            $sql = "call Ticket_DeleteTicket(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindParam(1,$TicketId);
            $sql->execute();
          //  return $resultado =$sql->fetchAll();
}

//Setea un ticket a pagado
public function SetTicketPagado($TicketId){
$conectar = parent::Conexion();
parent::set_names();
$sql = "call Ticket_SetTicketPagado(?)";
$sql = $conectar->prepare($sql);
$sql->bindParam(1,$TicketId);
$sql->execute();
}


//Obtiene el solicitante del ticket
public function GetSolicitanteTicket($TicketId){
    $conectar = parent::Conexion();
    parent::set_names();
    $sql = "call Ticket_GetSolicitanteTicket(?)";
    $sql = $conectar->prepare($sql);
    $sql ->bindParam(1,$TicketId);
    $sql->execute();
    return $resultado = $sql->fetchAll();
}

//obtiene todas las columnas del ticket
public function GetAllDataTicketXId($TicketId){
    $conectar = parent::Conexion();
    parent::set_names();
    $sql = "call Ticket_GetAllDataTicketXId(?)";
    $sql = $conectar->prepare($sql);
    $sql ->bindParam(1,$TicketId);
    $sql->execute();
    return $resultado = $sql->fetchAll();
}
}
?>


