<?php 
/*Librerias para el envio de correos */
require('class.phpmailer.php');
include('class.smtp.php');

require_once("../config/conexion.php");
require_once("../models/Ticket.php");

class EnvioCorreos extends PHPMailer{
   // protected $GestorCorreo = 'testconecttotal@gmail.com'; 
  //  protected $Pass = 'Bandit67!'; 
    // protected $GestorCorreo = 'testnotificaciones@ctnredes.com'; 
   // protected $Pass = 'wOYTNw2WqRUB'; 

     protected $GestorCorreo = 'ventas@ctnredes.com'; 
    protected $Pass = 'CTn3tw0rk@2022'; 
    //Esta funcion envia una notificacion por correo al usuario, indicandole su numero de ticket
    public function NotificacionTicketAbierto($TicketId) {
$Ticket = new Ticket();

$Datos = $Ticket->GetTicketXId($TicketId);
$DatosSolicitante = $Ticket->GetSolicitanteTicket($TicketId);
foreach ($Datos as $row){
    $NoTicket = $row["TicketId"];
    $Usuario = $row["Nombre"];
    $Titulo = $row["Titulo"];
    $Categoria = $row["Categoria"];
    $CorreoUsuario = $row["Correo"];
}

foreach($DatosSolicitante as $row2){
$Solicitante = $row2["NombreSolicitante"];
}
//dd($Solicitante);
$this->isSMTP();
$this->Host = "localhost"; //Servidor SMTP
$this->Port = 25;//Puerto
$this->SMTPAuth = false;
$this->Username = $this->GestorCorreo;
$this->Password = $this->Pass;
$this->isSendmail();
$this->From = $this->GestorCorreo;
//$this->SMTPSecure = 'tls';
$this->FromName = "Ticket Abierto";
$this->CharSet = 'UTF8';
$this->addAddress("conec.total@gmail.com");
$this->addAddress("pahr9894.kf@gmail.com");
$this->WordWrap = 80;
$this->isHTML(true);
$this->Subject = "Se ah generado el ticket No: $NoTicket";

$cuerpoCorreo = file_get_contents('../public/NuevoTicket.html');
//Parametros del template para reemplazar
$cuerpoCorreo = str_replace("xnroticket", $NoTicket, $cuerpoCorreo);
$cuerpoCorreo = str_replace("lblNomUsu", $Usuario, $cuerpoCorreo);
$cuerpoCorreo = str_replace("lblTitu", $Titulo, $cuerpoCorreo);
$cuerpoCorreo = str_replace("lblSoli", $Solicitante, $cuerpoCorreo);
$cuerpoCorreo = str_replace("lblCate", $Categoria, $cuerpoCorreo);


$this->Body = $cuerpoCorreo;

return $this->send();
    }


    //Esta funcion envia una notificacion por correo al usuario de soporte que se le asigno el ticket
public function NotificacionTicketAsignado($TicketId){
    $Ticket = new Ticket();

    $Datos = $Ticket->GetTicketXId($TicketId);
    
    foreach ($Datos as $row){
        $NoTicket = $row["TicketId"];
        $UsuarioSoporte = $row["Soporte"];
        $Titulo = $row["Titulo"];
        $Categoria = $row["Categoria"];
        $CorreoSoporte = $row["Soporte@ctnredes.com"];
        $Usuario = $row["Nombre"];
    }
    
    $this->isSMTP();
    $this->Host = "smtp.gmail.com"; //Servidor SMTP
    $this->Port = 587;//Puerto
    $this->SMTPAuth = true;
    $this->Username = $this->GestorCorreo;
    $this->Password = $this->Pass;
    $this->From = $this->GestorCorreo;
    $this->SMTPSecure = 'tls';
    $this->FromName = "Ticket Abierto";
    $this->CharSet = 'UTF8';
    $this->addAddress($CorreoSoporte);
    $this->WordWrap = 50;
    $this->isHTML(true);
    $this->Subject = "Se te ah asignado el ticket No: $NoTicket";
    
    $cuerpoCorreo = file_get_contents('../public/AsignarTicket.html');
    //Parametros del template para reemplazar
    $cuerpoCorreo = str_replace("xnroticket", $NoTicket, $cuerpoCorreo);
    $cuerpoCorreo = str_replace("xnombresoporte", $UsuarioSoporte, $cuerpoCorreo);
    $cuerpoCorreo = str_replace("lblNomUsu", $Usuario, $cuerpoCorreo);
    $cuerpoCorreo = str_replace("lblTitu", $Titulo, $cuerpoCorreo);
    $cuerpoCorreo = str_replace("lblCate", $Categoria, $cuerpoCorreo);
    
    
    $this->Body = $cuerpoCorreo;

return $this->send();
}

public function NotificacionTicketRespuesta($TicketId){

    }

    //Esta funcion envia una notificacion por correo indicando que el correo fue cerrado e invitando al usuario a contestar la encuesta de satisfaccion
    public function NotificacionTicketCerrado($TicketId){
        $Ticket = new Ticket();

        $Datos = $Ticket->GetTicketXId($TicketId);
        
        foreach ($Datos as $row){
            $NoTicket = $row["TicketId"];
            $Usuario = $row["Nombre"];
            $Titulo = $row["Titulo"];
            $Categoria = $row["Categoria"];
            $CorreoUsuario = $row["Correo"];
        }
        
        $this->isSMTP();
        $this->Host = "smtp.gmail.com"; //Servidor SMTP
        $this->Port = 587;//Puerto
        $this->SMTPAuth = true;
        $this->Username = $this->GestorCorreo;
        $this->Password = $this->Pass;
        $this->From = $this->GestorCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = "Ticket Cerrado";
        $this->CharSet = 'UTF8';
        // $this->addAddress($CorreoUsuario);
        $this->addAddress("Soporte@ctnredes.com");
        $this->WordWrap = 50;
        $this->isHTML(true);
        $this->Subject = "Se ah cerrado el ticket No: $NoTicket";
        
        $cuerpoCorreo = file_get_contents('../public/CerradoTicket.html');
        //Parametros del template para reemplazar
        $cuerpoCorreo = str_replace("xnroticket", $NoTicket, $cuerpoCorreo);
        $cuerpoCorreo = str_replace("lblNomUsu", $Usuario, $cuerpoCorreo);
        $cuerpoCorreo = str_replace("lblTitu", $Titulo, $cuerpoCorreo);
        $cuerpoCorreo = str_replace("lblCate", $Categoria, $cuerpoCorreo);
        
        
        $this->Body = $cuerpoCorreo;
        
        return $this->send();
    }

   

}
?>