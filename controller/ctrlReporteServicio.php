<?php 
    require_once("../config/conexion.php");
    require_once("../models/ReporteServicio.php");

    $ReporteServicio =  new ReporteServicio();

    switch($_GET["op"]){

        //Manda los parametros al modelo para agregar un nuevo reporte
        case "AddReporteServicio":
               $Datos = $ReporteServicio->AddReporteServicio($_POST["Maestro"],$_POST["Detalle"]);
                echo json_encode($Datos);
//  //Obtenemos el ReporteServicioId
//  if(is_array($Datos)==true and count($Datos)>0){
//     foreach($Datos as $row)
//     {
//         $output["ReporteServicioId"] = $row["ReporteServicioId"];
//     }
//     echo json_encode($output);
// }
            break;

            //Obtiene el encabezado de un reporte de servicio x id
            case "GetReporteServicio":
                $Datos = $ReporteServicio->GetReporteServicio($_POST["ReporteServicioId"]);
                if(is_array($Datos)==true and count($Datos)>0){
                    foreach($Datos as $row)
                    {
                        $output["Folio"] = $row["Folio"];
                        $output["TicketId"] = $row["TicketId"];
                        $output["Cliente"] = $row["Cliente"];
                        $output["Colonia"] = $row["Colonia"];
                        $output["Empresa"] = $row["Empresa"];
                        $output["Ciudad"] = $row["Ciudad"];
                        $output["Telefono"] = $row["Telefono"];
                        $output["Clave"] = $row["Clave"];
                        $output["RFC"] = $row["RFC"];
                        $output["Fecha"] = date("d/m/Y H:i:s", strtotime($row["Fecha"]));
                        $output["CodigoPostal"] = $row["CodigoPostal"];
                        $output["Marca"] = $row["Marca"];
                        $output["Modelo"] = $row["Modelo"];
                        $output["Serie"] = $row["Serie"];
                        $output["Otros"] = $row["Otros"];
                        $output["InspeccionVisual"] = $row["InspeccionVisual"];
                        $output["FallaPresentada"] = $row["FallaPresentada"];
                        $output["Servicio"] = $row["Servicio"];
                        $output["Refacciones"] = $row["Refacciones"];
                        $output["ViaticosOtros"] = $row["ViaticosOtros"];
                        $output["SubTotal"] = $row["SubTotal"];
                        $output["IVA"] = $row["IVA"];
                        $output["Total"] = $row["Total"];
                        

                    }
                    echo json_encode($output);
                    }   

                break;

    }
?>