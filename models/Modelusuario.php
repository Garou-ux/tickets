<?php

class Usuario extends Conectar{
    
    public function login(){
        $conectar=parent::Conexion();
        parent::set_names();
        if(isset($_POST["enviar"])){
            $correo = $_POST["Datos_Correo"];
            $pass = $_POST["Datos_Pass"];
            if(empty($correo) and empty($pass)){
                header("Location:".conectar::ruta()."index.php?m=2");
                exit();
            }else{
                $sql = "call Usuarios_Login(?,?)";
                $stmt = $conectar->prepare($sql);
                $stmt->bindParam(1,$correo);
                $stmt->bindParam(2,$pass);

          
                $stmt->execute();
                $resultado  = $stmt->fetch();
                if(is_array($resultado) && count($resultado)>0 ){
                    $_SESSION["UsuarioId"] = $resultado["UsuarioId"];
                    $_SESSION["Nombre"] = $resultado["Nombre"];
                    $_SESSION["Correo"] = $resultado["Correo"];
                    $_SESSION["RolId"] = $resultado["RolId"];
                    header("Location:".conectar::ruta()."view/Home/");
                    exit();
                }else{
                    header("Location:".conectar::ruta()."index.php?m=1");
                exit();
                }
            }
        }
    }

    public function LoadDetCotiXId($CotizacionId){
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT CotizacionDetId,CotizacionId,ProductoId,Descripcion,Cantidad,Precio,Total FROM tblcotizaciondet WHERE CotizacionId = :CotizacionId";
        $q = $this->db->prepare($sql);
        $q->bindParam(":CotizacionId", $CotizacionId);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->readDetalle($row));
        }
        return $result;
    }

    public function ListaUsuarios(){
        $conectar = parent::Conexion();
        parent::set_names();
        $sql="call Usuarios_ListaUsuarios()";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado =$sql->fetchAll();
    }

    //Obtiene la lista de usuarios de tipo cliente
    public function ListaUsuariosCliente($RolId = 2){
        $conectar = parent::Conexion();
        parent::set_names();
        $sql="call Usuarios_ListaUsuariosCliente(?)";
        $sql=$conectar->prepare($sql);
        $sql->bindParam(1,$RolId);
        $sql->execute();
        return $resultado =$sql->fetchAll();
    }
    //Crea o actualiza un usuario
    public function AddUsuario($Maestro){
        $conectar = parent::Conexion();
        parent::set_names();
        $sql= "call Usuarios_AddUsuario(?)";
        $sql =$conectar->prepare($sql);
        $sql->bindParam(1,$Maestro);
        $sql->execute();
        return $resultado =$sql->fetchAll();
    }
    
    //Obtiene un usuario en especifico
    public function GetUsuario($UsuarioId){
$conectar = parent::Conexion();
parent::set_names();
$sql = "call Usuarios_GetUsuario(?)";
$sql = $conectar->prepare($sql);
$sql->bindParam(1,$UsuarioId);
$sql->execute();
return $resultado = $sql->fetchAll();
    }

    //Obtiene la lista de los roles, esto se usara para llenar el select de rol
    public function ListaUsuarioRol(){
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call Usuarios_ListaUsuarioRol()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    //obtiene la lista de usuarios de tipo cliente

    public function ListaUsuariosClientes(){
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call Usuario_ListaUsuariosClientes()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    //crea o actualiza un usuario de tipo cliente
        //Crea o actualiza un usuario
        public function AddUsuarioCliente($Maestro){
            $conectar = parent::Conexion();
            parent::set_names();
            $sql= "call Usuarios_AddUsuarioCliente(?)";
            $sql =$conectar->prepare($sql);
            $sql->bindParam(1,$Maestro);
            $sql->execute();
            return $resultado =$sql->fetchAll();
        }
}
?>