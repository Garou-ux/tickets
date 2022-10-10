<?php 
require_once("../config/conexion.php");
require_once("../models/Facturacion.php");

$Facturacion = new Facturacion();

switch($_GET["op"]){

    //este caso se usa para llamar a la lista de los tickets cerrados
    case "GetTicketsFacturacion":
$Datos = $Facturacion->GetTicketsFacturacion();

//Validamos que se obtengan datos
if(is_array($Datos) and count($Datos)>0){

    $DataTable = Array();
    foreach ($Datos as $row){
    $sub_array = array();
    $sub_array[] = $row["TicketId"];   
    $sub_array[] = $row["Cliente"]; 
    $sub_array[] = $row["RFC"];    
  
    switch($row["TieneFactura"]){
        case "1":
        $sub_array[] = '<span class="label label-success">Facturado</span>';
        break;
    
        case "0":
        $sub_array[] =    '<span class="label label-warning">En Espera de Facturacion</span>';
        break;
       
        }

    if($row["TieneFactura"] == 1){
        $sub_array[] = '<button onClick="FacturaTicket('.$row["TicketId"].');" id="'.$row["TicketId"].'" class="btn btn-rounded btn-inline btn-secondary" title="Permite generar un reporte del servicio" disabled><div><i class="fa fa-plus"></div>';

    }else{
        $sub_array[] = '<button onClick="FacturaTicket('.$row["TicketId"].');" id="'.$row["TicketId"].'" class="btn btn-rounded btn-inline btn-secondary" title="Permite generar un reporte del servicio"><div><i class="fa fa-plus"></div>';

    }
    $sub_array[] = '<button onClick="fnMostrarPDFFactura('.$row["ReporteServicioId"].');" id="'.$row["ReporteServicioId"].'" class="btn btn-inline btn-danger btn-sm ladda-button" title="Imprime un pdf con la información de la factura"><div><i class="fa fa-file-pdf-o"></i></div>';

    $DataTable[] = $sub_array;

    }
    $DataTableProps = array(
    "sEcho"=>1,
    "iTotalRecords"=>count($DataTable),
    "iTotalDisplayRecords"=>count($DataTable),
    "aaData"=>$DataTable
    );
    echo json_encode($DataTableProps);
    
}
        break;

        case "UpdateTicketFactura":
            $Datos=$Facturacion->FacturaTicket($_POST["TicketId"], $_POST["Factura"]);
            break;
}

?>