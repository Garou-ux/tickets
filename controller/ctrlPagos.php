<?php
require_once("../config/conexion.php");
require_once("../models/Pagos.php");
$Pagos = new Pagos();
        
        switch($_GET["op"]){
            case "ListaPagos" :
                $Datos     = $Pagos->ListaPagos();
                $DataTable = Array();
                foreach ($Datos as $row){
                    $sub_array   = array();
                    $sub_array[] = $row["PagoId"];
                    $sub_array[] = $row["Nombre"];
                    $sub_array[] = $row["Factura"];
                    $sub_array[] = $row["Total"];
                    $sub_array[] = $row["Activo"];
                    $sub_array[] = $row["created_at"];
                    $DataTable[] = $sub_array;
                }
                $DataTableProps = array(
                "sEcho"                => 1,
                "iTotalRecords"        => count($DataTable),
                "iTotalDisplayRecords" => count($DataTable),
                "aaData"               => $DataTable
                );
                echo json_encode($DataTableProps);
            break;
        
        
        }

?>