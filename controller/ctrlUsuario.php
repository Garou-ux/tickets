<?php 
  require_once("../config/conexion.php");
  require_once("../models/Modelusuario.php");
  $Usuario = new Usuario();

  switch($_GET["op"]){

    //Agrega/Actualiza un usuario
    case "AddUsuario":
$Datos=$Usuario->AddUsuario($_POST["Maestro"]);
        break;
    //Llena el datatable con la lista de los usuarios activos
    case "ListaUsuarios":
        $Datos=$Usuario->ListaUsuarios();
        $DataTable = Array();
        foreach ($Datos as $row){
        $sub_array = array();
        $sub_array[] = $row["UsuarioId"];   
        $sub_array[] = $row["Nombre"]; 
        $sub_array[] = $row["Correo"];  
        $sub_array[] = $row["Pass"];    
        if ($row["RolId"]=="1"){
          $sub_array[] = '<span class="label label-pill label-secondary">Soporte</span>';
      }else{
          $sub_array[] = '<span class="label label-pill label-info">Usuario</span>';
      }  
        $sub_array[] = $row["RFC"];
        $sub_array[] = '<button onClick="fnEditarUsuario('.$row["UsuarioId"].',1);" id="'.$row["UsuarioId"].'" class="btn btn-inline btn-primary btn-sm ladda-button" title="Permite editar un usuario"><div><i class="fa fa-edit"></div>';
        $sub_array[] = '<button onClick="fnEditarUsuario('.$row["UsuarioId"].',2);" id="'.$row["UsuarioId"].'" class="btn btn-inline btn-danger btn-sm ladda-button" title="Elimina el usuario seleccionado"><div><i class="fa fa-trash"></div>';
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

        //Obtiene un usuario en especifico
        case "GetUsuario":
          $Datos=$Usuario->GetUsuario($_POST["UsuarioId"]);  
          if(is_array($Datos)==true and count($Datos)>0){
          foreach($Datos as $row)
          {
              $output["UsuarioId"] = $row["UsuarioId"];
              $output["Nombre"] = $row["Nombre"];
      
              $output["Correo"] = $row["Correo"];
              $output["Pass"] = $row["Pass"];
      
              $output["Uso"] = $row["Uso"];
              $output["RolId"] = $row["RolId"];
              $output["RFC"] = $row["RFC"];
              $output["RazonSocial"] = $row["RazonSocial"];
              $output["Colonia"] = $row["Colonia"];
              $output["Ciudad"] = $row["Ciudad"];
              $output["CodigoPostal"] = $row["CodigoPostal"];
              $output["Estado"] = $row["Estado"];
              $output["Pais"] = $row["Pais"];
              $output["Telefono"] = $row["Telefono"];
              $output["Contacto"] = $row["Contacto"];
              $output["Rol"] = $row["Rol"];
          }
          echo json_encode($output);
        }
          break;

          case "ListaUsuarioRol":
            $Datos = $Usuario->ListaUsuarioRol();
            //Validamos que se tengan datos
            if(is_array($Datos)== true and count($Datos)>0){
            $html = "<option></option>";
            foreach($Datos as $row){
            $html.="<option value='".$row["RolId"]."'>".$row["Rol"]."</option>";
            }
            echo $html;
            }
                break;

                //Lista de usuarios de tipo cliente
                case "ListaUsuariosClientes":
                  $Datos=$Usuario->ListaUsuariosClientes();
                     //Validamos que se tengan datos
            if(is_array($Datos)== true and count($Datos)>0){
              $html = "<option></option>";
              foreach($Datos as $row){
              $html.="<option value='".$row["UsuarioId"]."'>".$row["RazonSocial"]."</option>";
              }
              echo $html;
              }
                  break;

                  //Obtiene la lista de usuarios de tipo cliente
                  case "ListaGridUsuariosClientes":
                    $Datos=$Usuario->ListaUsuariosCliente();
                    $DataTable = Array();
                    foreach ($Datos as $row){
                    $sub_array = array();
                  
                    $sub_array[] = $row["UsuarioId"];   
                    $sub_array[] = $row["Nombre"]; 
                    $sub_array[] = $row["Correo"];  
                    $sub_array[] = $row["RFC"];    
                    $sub_array[] = $row["RazonSocial"];  
                    $sub_array[] = '<button onClick="fnEditarCliente('.$row["UsuarioId"].',1);" id="'.$row["UsuarioId"].'" class="btn btn-inline btn-primary btn-sm ladda-button" title="Permite editar un usuario"><div><i class="fa fa-edit"></div>';
                    $sub_array[] = '<button onClick="fnEditarCliente('.$row["UsuarioId"].',2);" id="'.$row["UsuarioId"].'" class="btn btn-inline btn-danger btn-sm ladda-button" title="Elimina el usuario seleccionado"><div><i class="fa fa-trash"></div>';
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

                       //Agrega/Actualiza un usuario de tipo cliente
    case "AddUsuarioCliente":
      $Datos=$Usuario->AddUsuarioCliente($_POST["Maestro"]);
              break;

        case "getClients" :
             $Datos = $Usuario->getClients();
             echo json_encode($Datos);
          break;


  }
?>