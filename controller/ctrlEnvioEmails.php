<?php
require_once("../config/conexion.php");
require_once("../models/EnvioEmails.php");

$Envio = new EnvioCorreos();


switch($_GET["op"]){

    case "NotificacionTicketAbierto":
$Envio->NotificacionTicketAbierto($_POST["TicketId"]);
        break;

            case "NotificacionTicketAsignado":
$Envio->NotificacionTicketAsignado($_POST["TicketId"]);
        break;

        case "NotificacionTicketCerrado":
            $Envio->NotificacionTicketCerrado($_POST["TicketId"]);
            break;
}
?>