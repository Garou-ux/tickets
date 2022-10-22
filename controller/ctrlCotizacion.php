<?php 
require_once("../config/conexion.php");
require_once("../models/Cotizacion.php");

$Cotizacion = new Cotizacion();

switch($_GET["op"]){

    //Obtiene los datos para llenar el grid de listacotizacion
    case "ListaCotizacion" :
        $Datos = $Cotizacion->ListaCotizacion();
        $DataTable = Array();
        foreach ($Datos as $row){
        $sub_array = array();
        $sub_array[] = $row["CotizacionId"];
        $sub_array[] = $row["Nombre"];
        $sub_array[] = $row["SubTotal"];
        $sub_array[] = $row["IVA"];
        $sub_array[] = $row["Total"];
          // si esta pagado muetra el span azul y sin la funcion
    if($row["factura"] > 0 && $row["pagado"] == 0){
        $sub_array[] = '<span onClick="SetCotiPagado('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'" title="Cotizacion Con Factura" class="label label-primary">'.$row["factura"].'</span>';
    }else if($row["factura"] == 0 && $row["pagado"] == 0){
        $sub_array[] = '<span onClick="ModalCotiFactura('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'" title="Cotizacion Creada" class="label label-success">'.$row["factura"].'</span>';
    }
    if($row["pagado"] > 0 ){
        $sub_array[] = '<span  id="'.$row["CotizacionId"].'" title="Cotizacion Pagada"  class="label label-danger">'.$row["factura"].'</span>';
        $sub_array[] = '
        <div class="btn-group">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Acciones
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn btn-danger"  onClick="fnMostrarPDFCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'" ><div>PDF <i class="fa fa-file-pdf-o"></i></div></a>
          <a class="dropdown-item btn btn-warning" onClick="fnEliminarCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'"><div>Eliminar Cotizacion <i class="fa fa-trash"></i></div></a>
      </div>
        ';
    }else{
        $sub_array[] = '
        <div class="btn-group">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Acciones
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn btn-danger"  onClick="fnMostrarPDFCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'" ><div>PDF <i class="fa fa-file-pdf-o"></i></div></a>
          <a class="dropdown-item btn btn-primary" onClick="fnEditarCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'"><div>Editar Cotizacion <i class="fa fa-edit"></i></div></a>
          <a class="dropdown-item btn btn-warning" onClick="fnEliminarCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'"><div>Eliminar Cotizacion <i class="fa fa-trash"></i></div></a>
      </div>
        ';
    
    }
    
        // $sub_array[] = '<button onClick="fnMostrarPDFCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'" class="btn btn-inline btn-danger btn-sm ladda-button" title="Imprime un pdf con la información de la cotización"><div><i class="fa fa-file-pdf-o"></i></div>';
        
        // $sub_array[] = '<button onClick="fnEditarCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'" class="btn btn-inline btn-danger btn-sm ladda-button" title="Permite Editar la cotizacion"><div><i class="fa fa-edit"></div>';

    //     $sub_array[] = '
    //     <div class="btn-group">
    //     <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    //       Acciones
    //     </button>
    //     <div class="dropdown-menu">
    //       <a class="dropdown-item btn btn-danger"  onClick="fnMostrarPDFCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'" ><div>PDF <i class="fa fa-file-pdf-o"></i></div></a>
    //       <a class="dropdown-item btn btn-primary" onClick="fnEditarCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'"><div>Editar Cotizacion <i class="fa fa-edit"></i></div></a>
    //       <a class="dropdown-item btn btn-warning" onClick="fnEliminarCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'"><div>Eliminar Cotizacion <i class="fa fa-trash"></i></div></a>
    //   </div>
    //     ';
        $DataTable[] = $sub_array;
    //          <a class="dropdown-item btn btn-primary" onClick="fnEditarCotizacion('.$row["CotizacionId"].');" id="'.$row["CotizacionId"].'"><div>Editar Cotizacion <i class="fa fa-edit"></i></div></a>

        }
    
        $DataTableProps = array(
        "sEcho"=>1,
        "iTotalRecords"=>count($DataTable),
        "iTotalDisplayRecords"=>count($DataTable),
        "aaData"=>$DataTable
        );
        echo json_encode($DataTableProps);
        break;


        //Agrega/Edita una cotizacion
        case "AddCotizacion":
           $Datos = $Cotizacion->AddCotizacion($_POST["Maestro"], $_POST["Detalle"]);
           echo json_encode($Datos);
        
            break;
            
            //Agrega la factura a una cotizacion
            case "SetCotiFactura":
            $Datos = $Cotizacion->SetCotiFactura($_POST["CotizacionId"], $_POST["Factura"]);
            break;
            
            //setea la cotizacion a pagada
            case "SetCotiPagado":
            $Datos = $Cotizacion->SetCotiPagado($_POST["CotizacionId"]);
            break;
            
            //da de baja la cotizacion
            case "EliminarCotizacion":
                $Datos = $Cotizacion->EliminarCotizacion($_POST["CotizacionId"]);
            break;
            
            //obtiene los datos de la cotizacion x id
            case "LoadCotizacionXId":
            $Datos = $Cotizacion->LoadCotizacionXId($_POST["CotizacionId"]);
            header("Content-Type: application/json");
            echo json_encode($Datos);
            break;
            
            case "LoadCotizacionDetXId":
                $Datos = $Cotizacion->LoadDetCotiXId($_POST["CotizacionId"]);
                header("Content-Type: application/json");
                echo json_encode($Datos);
            break;
            
            case "EditarCotizacion":
                $Datos = $Cotizacion->EditarCotizacion($_POST["Maestro"], $_POST["Detalle"]);
                echo json_encode($Datos);
            break;
}

?>