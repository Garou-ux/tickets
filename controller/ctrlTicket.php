    <?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");

    $Ticket = new Ticket();

    switch($_GET["op"]){

    //Se utiliza para agregar/actualizar un ticket
    case "Add":  

    $Datos = $Ticket->AddTicket($_POST["Maestro"]);

    //Obtenemos el ticketid retornado
    if(is_array($Datos)==true and count($Datos)>0){
        foreach($Datos as $row)
        {
            $output["TicketId"] = $row["TicketId"];
        }
        echo json_encode($output);
    }
    break;

    //Agrega una respuesta al ticket
    case "AddTicketRespuesta":  
    $Datos = $Ticket->AddTicketRespuesta($_POST["Maestro"]);
    break;

    //Da por terminado el ticket
    case "CerrarTicket":  

        $Datos = $Ticket->CerrarTicket($_POST["TicketId"],$_POST["UsuarioId"]);
        break;

    //Se utiliza para llenar el datatable del listado de tickets
    case "ListTicketUsuario":
    $Datos=$Ticket->ListTicketsXUsuario($_POST["UsuarioId"]);
    $DataTable = Array();
    foreach ($Datos as $row){
    $sub_array = array();
    $sub_array[] = $row["TicketId"];
    switch($row["EstatusId"]){
    case "1":
    $sub_array[] = '<span class="label label-success">Abierto</span>';
    break;

    case "2":
    $sub_array[] =    '<span class="label label-warning">En Resolución</span>';
    break;
    case "3":
    $sub_array[] = '<span class="label label-danger">Cerrado</span>';
    break;
    }

    $sub_array[] =  date("d/m/Y H:i:s", strtotime($row["FechaCreado"]));
    $sub_array[] = $row["Usuario"];
    $sub_array[] = $row["Categoria"];
    $sub_array[] = '<span class="label label-info">'.$row["UsuarioSoporte"].'</span>';
    // si esta pagado muetra el span azul y sin la funcion
    if($row["Pagado"] == 1){
        $sub_array[] = '<span id="'.$row["TicketId"].'" title="Ticket Pagado" class="label label-danger">'.$row["Factura"].'</span>';
    }else{
        $sub_array[] = '<span onClick="SetTicketPagado('.$row["TicketId"].');" id="'.$row["TicketId"].'" class="label label-success">'.$row["Factura"].'</span>';
    }
    
    
    //Acciones
    if ($_SESSION["RolId"]==1){
    if($row["TieneServicio"] != 1){
        $sub_array[] = '
        <div class="btn-group">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Acciones
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn btn-primary" title="Permite mostrar las respuestas y detalle del ticket"  onClick="fnVerTicket('.$row["TicketId"].');" id="'.$row["TicketId"].'" ><div>Responder Ticket<i class="fa fa-edit"></i></div></a>
          <a class="dropdown-item btn btn-secondary" title="Permite generar un reporte del servicio" onClick="fnReporteServicio('.$row["TicketId"].');" id="'.$row["TicketId"].'" ><div>Reporte de Servicio<i class="fa fa-plus"></i></div></a>
          <a class="dropdown-item btn btn-danger" title="Elimina la Cotizacion Seleccionada" onClick="fnEliminarTicket('.$row["TicketId"].');" id="'.$row["TicketId"].'"><div>Eliminar Ticket <i class="fa fa-trash"></i></div></a>
      </div>
        ';
    }else{
        $sub_array[] = '
        <div class="btn-group">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Acciones
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn btn-primary" title="Permite mostrar las respuestas y detalle del ticket"  onClick="fnVerTicket('.$row["TicketId"].');" id="'.$row["TicketId"].'" ><div>Responder Ticket<i class="fa fa-edit"></i></div></a>
          <a class="dropdown-item btn btn-danger" title="Elimina la Cotizacion Seleccionada" onClick="fnEliminarTicket('.$row["TicketId"].');" id="'.$row["TicketId"].'"><div>Eliminar Ticket <i class="fa fa-trash"></i></div></a>
      </div>
        ';
    }
    }else if( $_SESSION["RolId"]==2){
    // a los cerrados pues ya no se contestan
    if($row["EstatusId"] != 3){
        $sub_array[] = '
        <div class="btn-group">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Acciones
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn btn-primary" title="Permite mostrar las respuestas y detalle del ticket"  onClick="fnVerTicket('.$row["TicketId"].');" id="'.$row["TicketId"].'" ><div>Responder Ticket <i class="fa fa-edit"></i></div></a>
      </div>
        ';
    }
    }
    $DataTable[] = $sub_array;

    }

    $DataTableProps = array(
    "sEcho"=>1,
    "iTotalRecords"=>count($DataTable),
    "iTotalDisplayRecords"=>count($DataTable),
    "aaData"=>$DataTable
    );
    echo json_encode($DataTableProps);

    break;

    //Se utiliza para llenar el detalle del ticket(Respuestas, etc)
    case "GetTicketDetXId":
    $Datos=$Ticket->GetTicketDetXId($_POST["TicketId"]);
    ?>
    <?php
        foreach($Datos as $row){
            ?>
                <article class="activity-line-item box-typical">
                    <div class="activity-line-date">
                        <?php echo date("d/m/Y", strtotime($row["FechaRespuesta"]));?>
                    </div>
                    <header class="activity-line-item-header">
                        <div class="activity-line-item-user">
                            <div class="activity-line-item-user-photo">
                                <a href="#">
                                    <img src="../../public/<?php echo $row['RolId'] ?>.jpg" alt="">
                                </a>
                            </div>
                            <div class="activity-line-item-user-name"><?php echo $row['Nombre'];?></div>
                            <div class="activity-line-item-user-status">
                                <?php 
                                    if ($row['RolId']==1){
                                        echo 'Soporte';
                                    }else{
                                        echo 'Usuario';
                                    }
                                ?>
                            </div>
                        </div>
                    </header>
                    <div class="activity-line-action-list">
                        <section class="activity-line-action">
                            <div class="time"><?php echo date("H:i:s", strtotime($row["FechaRespuesta"]));?></div>
                            <div class="cont">
                                <div class="cont-in">
                                    <p>
                                        <?php echo $row["Respuesta"];?>
                                    </p>
                                </div>
                            </div>
                        </section>
                    </div>
                </article>
            <?php
        }
    ?>
    <?php
    break;

    //Obtiene el encabezado de un ticket especifico
    case "GetTicketXId";
    $Datos=$Ticket->GetTicketXId($_POST["TicketId"]);  
    if(is_array($Datos)==true and count($Datos)>0){
    foreach($Datos as $row)
    {
        $output["TicketId"] = $row["TicketId"];
        $output["UsuarioId"] = $row["UsuarioId"];
        $output["CategoriasId"] = $row["CategoriasId"];

        $output["Titulo"] = $row["Titulo"];
        $output["Descripcion"] = $row["Descripcion"];

        switch ($row["Estatus"]){
            case "Abierto" :
                $output["Estatus"] = '<span class="label label-pill label-success">Abierto</span>';
                break;
                case "Cerrado":
                $output["Estatus"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    break;
                    
        }

        $output["TicketEstatus"] = $row["Estatus"];

        $output["FechaCreado"] = date("d/m/Y H:i:s", strtotime($row["FechaCreado"]));
        $output["Nombre"] = $row["Nombre"];
        $output["Categoria"] = $row["Categoria"];
        $output["Soporte"] = $row["Soporte"];
        $output["Correo"] = $row["Correo"];
        $output["CorreoUsuarioAsignado"] = $row["CorreoUsuarioAsignado"];
    }
    echo json_encode($output);
    }   
    break;

    //Obtiene los totales de los tickets por estatus, esto para la pantalla principal
    case "GetTotalTicketsXEstatus":
$Datos=$Ticket->GetTotalTicketsXEstatus($_POST["UsuarioId"]);
if(is_array($Datos)==true and count($Datos)>0){
    foreach($Datos as $row)
    {
        $output["Totales"]       = $row["Totales"];
        $output["TotalAbiertos"] = $row["TotalAbiertos"];
        $output["TotalCerrados"] = $row["TotalCerrados"];
    }
    echo json_encode($output);
}
        break;

    case "GetTotalTicketsXCategoriaGrafico";
    $Datos=$Ticket->GetTotalTicketsXCategoriaGrafico($_POST["UsuarioId"]);  
    echo json_encode($Datos);
    break;

//Elimina un ticket
case "DeleteTicket":
    $Datos = $Ticket->DeleteTicket($_POST["TicketId"]);
   break;
   
   //Setea un ticket a pagado
case "SetTicketPagado":
    $Datos = $Ticket->SetTicketPagado($_POST["TicketId"]);
break;

case "GetAllDataTicketXId":
    $Datos = $Ticket->GetAllDataTicketXId($_POST["TicketId"]);
    echo json_encode($Datos);
break;
    }


    ?>

