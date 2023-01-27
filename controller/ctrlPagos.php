<?php
require_once("../config/conexion.php");
require_once("../models/Pagos.php");
require_once("../models/Modelusuario.php");
$Pagos = new Pagos();
$Usuario = new Usuario();
        
        switch($_GET["op"]){
            case "ListaPagos" :
                $Datos     = $Pagos->ListaPagos();
                $DataTable = Array();
                foreach ($Datos as $row){
                    $sub_array   = array();
                    $sub_array["PagoId"] = $row["PagoId"];
                    $sub_array["Nombre"] = $row["Nombre"];
                    $sub_array["Descripcion"] = $row["Descripcion"];
                    $sub_array["Factura"] = $row["Factura"];
                    $sub_array["Total"] = $row["Total"];
                    $sub_array["NombrePagado"] = $row["NombrePagado"];
                    $sub_array["FechaPago"] = $row["FechaPago"];
                    $sub_array["Btn"] = $row["PagoId"];
                    $sub_array["Pagado"] = $row["Pagado"];
                    $DataTable[] = $sub_array;
                }
                $DataTableProps = array(
                "sEcho"                => 1,
                "iTotalRecords"        => count($DataTable),
                "iTotalDisplayRecords" => count($DataTable),
                "aaData"               => $DataTable
                );
                // return response()->json($DataTableProps);
                echo json_encode($DataTableProps);
            break;

            case "GetListUsuarios":
                $Datos=$Usuario->ListaUsuariosClientes(1);
                //Validamos que se tengan datos
       if(is_array($Datos)== true and count($Datos)>0){
         $html = "<option></option>";
         foreach($Datos as $row){
         $html.="<option value='".$row["UsuarioId"]."'>".$row["RazonSocial"]."</option>";
         }
         echo $html;
         }
                break;

           case "AddEditPago":
                $Datos = $Pagos->AddEditPago($_POST["PagoId"], $_POST["UsuarioId"], $_POST["Factura"] ,$_POST["Total"], $_POST["Descripcion"], $_POST["Pagado"]);
                echo json_encode($Datos);
            break;

           case "GetDataPagoXId":
                $Datos = $Pagos->GetDataPagoXId($_POST["PagoId"]);
                echo json_encode($Datos);
           break;

           case "DesactivarPago":
                $Datos = $Pagos->DesactivarPago($_POST["PagoId"]);
                echo json_encode($Datos);
           break;
        
        
        }

?>