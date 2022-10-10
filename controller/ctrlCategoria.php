<?php
require_once("../config/conexion.php");
require_once("../models/Categorias.php");

$categoria = new Categorias();

switch($_GET["op"]){
case "combo":
$datos = $categoria->ListCategorias();
//Validamos que se tengan datos
if(is_array($datos)== true and count($datos)>0){
$html = "<option></option>";
foreach($datos as $row){
$html.="<option value='".$row["CategoriasId"]."'>".$row["Nombre"]."</option>";
}
echo $html;
}
    break;

    //este caso se llama la misma funcion, pero los datos se alistan para cargarlos en un datatable
    case "ListaCategorias":
        $Datos = $categoria->ListCategoriasGrid();
        if(is_array($Datos) and count($Datos)>0){

            $DataTable = Array();
            foreach ($Datos as $row){
            $sub_array = array();
            $sub_array[] = $row["CategoriasId"];   
            $sub_array[] = $row["Nombre"]; 
            switch($row["Uso"]){
                case "1":
                $sub_array[] = '<span class="label label-success">Activado</span>';
                break;
            
                case "0":
                $sub_array[] = '<span class="label label-warning">Desactivado</span>';
                break;
                }
            $sub_array[] = '<button onClick="fnEditarCategoria('.$row["CategoriasId"].',1);" id="'.$row["CategoriasId"].'" class="btn btn-inline btn-primary btn-sm ladda-button" title="Permite editar una categoria"><div><i class="fa fa-edit"></div>';
        $sub_array[] = '<button onClick="fnEditarCategoria('.$row["CategoriasId"].',2);" id="'.$row["CategoriasId"].'" class="btn btn-inline btn-danger btn-sm ladda-button" title="Elimina la categoria seleccionada"><div><i class="fa fa-trash"></div>';
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
            
            //Este caso agrega/edita una categoria
            case "AddCategoria":
$Datos = $categoria->AddCategoria($_POST["Maestro"]);
                break;

                 //Obtiene una categoria x id
        case "GetCategoria":
            $Datos=$categoria->GetCategoria($_POST["CategoriasId"]);  
            if(is_array($Datos)==true and count($Datos)>0){
            foreach($Datos as $row)
            {
                $output["CategoriasId"] = $row["CategoriasId"];
                $output["Nombre"] = $row["Nombre"];
                $output["Uso"] = $row["Uso"];
            }
            echo json_encode($output);
          }
            break;
}

?>