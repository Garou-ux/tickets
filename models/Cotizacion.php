<?php
include "ModelCotizacionDet.php";
class Cotizacion extends Conectar{



    private function readDetalle($row) {
        $result = new tblcotizaciondet();
        $result->CotizacionDetId = $row["CotizacionDetId"];
        $result->CotizacionId = $row["CotizacionId"];
        $result->ProductoId = $row["ProductoId"];
        $result->Descripcion = $row["Descripcion"];
        $result->Cantidad = $row["Cantidad"];
        $result->Precio = $row["Precio"];
        $result->Total = $row["Total"];
        // $result->created_at = $row["created_at"];
        // $result->updated_at = $row["updated_at"];
        return $result;
    }

    //Esta funcion obtiene la lista de las cotizaciones
    public function ListaCotizacion(){
        $conectar = parent::Conexion();
        parent::set_names();
        $query ="call Cotizacion_ListCotizacion()";
        $query =$conectar->prepare($query);
        $query->execute();
        return $resultado =$query->fetchAll();
    }

    //esta funcion agrega/edita una cotizacion
    public function AddCotizacion($Maestro, $Detalle){
        date_default_timezone_set('America/Monterrey');
        $Bandera = false;
        $Mensaje = '';
        $Title   = '';
        $Type    = 'error'; 
        $conectar = parent::Conexion();
        $resultado = null;
        $this->db->beginTransaction();
        parent::set_names();
        $FechaActual = date('Y/m/d h:i:s');
        $MaestroArray = json_decode($Maestro, true);
        $sqltblcotizacion = "INSERT INTO tblcotizacion (ClienteId, SubTotal, IVA, Total, Fecha, Contacto, created_at, updated_at) 
        VALUES (:ClienteId, :SubTotal, :IVA, :Total, :Fecha, :Contacto, :created_at, :updated_at)";
        $tblcotizacion = $this->db->prepare($sqltblcotizacion);
        try{
            
           
            $tblcotizacion->bindParam(":ClienteId", $MaestroArray[0]["ClienteId"],PDO::PARAM_INT);
            $tblcotizacion->bindParam(":SubTotal", $MaestroArray[0]["SubTotal"]);
            $tblcotizacion->bindParam(":IVA", $MaestroArray[0]["IVA"]);
            $tblcotizacion->bindParam(":Total", $MaestroArray[0]["Total"]);
            $tblcotizacion->bindParam(":Fecha", $FechaActual);
            $tblcotizacion->bindParam(":Contacto", $MaestroArray[0]["Contacto"]);
            $tblcotizacion->bindParam(":created_at", $FechaActual);
            $tblcotizacion->bindParam(":updated_at", $FechaActual);
            $tblcotizacion->execute();
            $CotizacionId = $this->db->lastInsertId();
            $array = json_decode($Detalle, true);
            foreach($array as $row){
                $sql = "INSERT INTO tblcotizaciondet (CotizacionId, ProductoId, Descripcion, Cantidad, Precio, Total) VALUES (:CotizacionId, :ProductoId, :Descripcion, :Cantidad, :Precio, :Total)";
                $q = $this->db->prepare($sql);
                $ProductoId = intval($row["ProductoId"]);
                $Cantidad   = intval($row["Cantidad"]);
                $Precio     = $row["Precio"];
                $Total      = $row["Total"];
                $Descripcion = $row["Descripcion"];
                $q->bindParam(":CotizacionId",$CotizacionId);
                $q->bindParam(":ProductoId",$ProductoId, PDO::PARAM_INT);
                $q->bindParam(":Descripcion", $Descripcion);
                $q->bindParam(":Cantidad", $Cantidad, PDO::PARAM_INT);
                $q->bindParam(":Precio",  $Precio );
                $q->bindParam(":Total", $Total);
                $q->execute();
            ;
            }
            
            //Se actualiza el correo del cliente
            $UpdateCliente = "UPDATE tblusuarios SET Correo = :Correo WHERE UsuarioId = :UsuarioId";
            $UsuarioId =  $MaestroArray[0]["ClienteId"];
            $stmt =$this->db->prepare($UpdateCliente);
            $stmt->bindParam(':Correo', $MaestroArray[0]["Correo"]);
            $stmt->bindParam(':UsuarioId', $UsuarioId);
            $stmt->execute();
            
            $this->db->commit();
            $Mensaje = 'Se Guardo Correctamente el Movimiento';
            $Bandera = 'true';
            $Type    = 'success';
            $Title   = 'Proceso Completado';
          //  $resultado = $this->ReporteCotizacion($CotizacionId);
          //print_r($this->ReporteCotizacion($CotizacionId));
        }catch(\Exception $e){
            $this->db->rollback();
            $Mensaje = "Error al guardar movimiento". $e. " Intente de nuevo";
            $Bandera = 'false';
            $Type    = 'error';
            $Title   = 'Error al guardar movimiento';
            return array(
                "Mensaje"=> $Mensaje,
                'Bandera'=> $Bandera,
                'Title'  => $Title,
                'Type'      => $Type,
                'CotizacionId' => $CotizacionId
                ); //$Detalle;
        }
        
        return array(
        "Mensaje"   => $Mensaje,
        'Bandera'   => $Bandera,
        'Title'     => $Title,
        'Type'      => $Type,
        'CotizacionId' => $CotizacionId
        ); //$Detalle;
    // return $resultado = $query->fetchAll();
    }

    
    public function GetCotizacion($CotizacionId){
        $conectar = parent::Conexion();
        parent::set_names();
        $query = "call Cotizacion_GetCotizacion(?)";
        $query = $conectar->prepare($query);
        $query->bindParam(1,$CotizacionId);
        $query->execute();
        return $resultado = $query->fetchAll();
    }

    
    //obtiene la cotizacion x id
    public function getById($id) {
        $sql = "SELECT * FROM tblcotizacion WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }
    
    //obtiene los datos para el encabezado del reporte
    public function ReporteCotizacion($CotizacionId){
$conectar = parent::Conexion();
parent::set_names();
$query = "call Cotizacion_ReporteCotizacion(?)";
$query = $conectar->prepare($query);
$query->bindParam(1,$CotizacionId);
$query->execute();
return $resultado = $query->fetchAll();
    }

    //Obtiene los datos para el detalle del reporte
    public function ReporteCotizacionDet($CotizacionId){
 $conectar = parent::Conexion();
 parent::set_names();
 $query = "call Cotizacion_ReporteCotizacionDet(?)";
 $query = $conectar->prepare($query);
 $query->bindParam(1,$CotizacionId);
 $query->execute();
 return $resultado = $query->fetchAll();
    }
    
    
    //setea la factura a la cotizacion
public function SetCotiFactura($CotizacionId, $Factura){
    $conectar         = parent::Conexion();
    parent::set_names();
    $query            = "call Cotizacion_SetCotiFactura(?,?)";
    $query            = $conectar->prepare($query);
    $query->bindParam(1,$CotizacionId);
    $query->bindParam(2,$Factura);
    $query->execute();
    return $resultado = $query->fetchAll();

}
    //setea la cotizacion a pagada
    public function SetCotiPagado($CotizacionId){
    $conectar = parent::Conexion();
    parent::set_names();
    $query = "call Cotizacion_SetCotiPagado(?)";
    $query = $conectar->prepare($query);
    $query->bindParam(1,$CotizacionId);
    $query->execute();
    return $resultado = $query->fetchAll();
    
    }
    
    //da de baja la cotizacion
    public function EliminarCotizacion($CotizacionId){
           //Se actualiza el correo del cliente
           $conectar = parent::Conexion();
           parent::set_names();
           $UpdateCotizacion = "UPDATE tblcotizacion SET Uso = :Uso WHERE CotizacionId = :CotizacionId";
           $Uso = 0 ;
           $stmt =$this->db->prepare($UpdateCotizacion);
           $stmt->bindParam(':Uso', $Uso);
           $stmt->bindParam(':CotizacionId', $CotizacionId);
           $stmt->execute();
           
           return $resultado = $this->ReporteCotizacion($CotizacionId);
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
    
    //obtiene los datos de la cotizacion x id
    public function LoadCotizacionXId($CotizacionId){
        $conectar = parent::Conexion();
        parent::set_names();
        $query = "call Cotizacion_ReporteCotizacion(?)";
        $query = $conectar->prepare($query);
        $query->bindParam(1,$CotizacionId);
        $query->execute();
        $cotiza = $query->fetchAll();
       
         //print_r($det);
         $resultado = array(
         "Cotizacion"    => $cotiza,
         "CotizacionDet" =>  $this->LoadDetCotiXId($CotizacionId)
         );       
          return $resultado; 
    }
    
       //esta funcion agrega/edita una cotizacion
       public function EditarCotizacion($Maestro, $Detalle){
        date_default_timezone_set('America/Monterrey');
        $Bandera = false;
        $Mensaje = '';
        $Title   = '';
        $Type    = 'error'; 
        $conectar = parent::Conexion();
        $resultado = null;
        $CotId = 0;
        $this->db->beginTransaction();
        parent::set_names();
        $FechaActual = date('Y/m/d h:i:s');
        $MaestroArray = json_decode($Maestro, true);
        $UpdateCotizacion = "UPDATE tblcotizacion 
        SET 
        ClienteId          = :ClienteId
        ,SubTotal          = :SubTotal
        ,IVA               = :IVA
        ,Total             = :Total
        ,Contacto          = :Contacto
        ,updated_at        = :updated_at
        WHERE CotizacionId = :CotizacionId";
        $tblcotizacion = $this->db->prepare($UpdateCotizacion);
        try{
            $tblcotizacion->bindParam(":ClienteId", $MaestroArray[0]["ClienteId"],PDO::PARAM_INT);
            $tblcotizacion->bindParam(":SubTotal", $MaestroArray[0]["SubTotal"]);
            $tblcotizacion->bindParam(":IVA", $MaestroArray[0]["IVA"]);
            $tblcotizacion->bindParam(":Total", $MaestroArray[0]["Total"]);
            $tblcotizacion->bindParam(":Contacto", $MaestroArray[0]["Contacto"]);
            $tblcotizacion->bindParam(":updated_at", $FechaActual);
            $tblcotizacion->bindParam(':CotizacionId', $MaestroArray[0]["CotizacionId"]);
            $tblcotizacion->execute();
           // $CotizacionId = $this->db->lastInsertId();
            $array = json_decode($Detalle, true);
          //  print_r($array);
            
           // return 'dd';
            foreach($array as $row){
                $CotId = intval($row["CotizacionId"]);
            if(intval($row["CotizacionDetId"])> 0){
            $updateDet  = "UPDATE tblcotizaciondet
            SET
            ProductoId            = :ProductoId,
            Descripcion           = :Descripcion,
            Cantidad              = :Cantidad,
            Precio                = :Precio,
            Total                 = :Total,
            updated_at            = :updated_at
            WHERE CotizacionDetId = :CotizacionDetId
            ";
             $ProductoId = intval($row["ProductoId"]);
             $Cantidad   = intval($row["Cantidad"]);
             $Precio     = $row["Precio"];
             $Total      = $row["Total"];
             $Descripcion = $row["Descripcion"];
             $CotizacionDetId = intval($row["CotizacionDetId"]);
             $upd = $this->db->prepare($updateDet);
             $upd->bindParam(":ProductoId",$ProductoId, PDO::PARAM_INT);
             $upd->bindParam(":Descripcion",$Descripcion);
             $upd->bindParam(":Cantidad",$Cantidad, PDO::PARAM_INT);
             $upd->bindParam(":Precio",$Precio);
             $upd->bindParam(":Total",$Total);
             $upd->bindParam(":updated_at",$FechaActual);
             $upd->bindParam(":CotizacionDetId",$CotizacionDetId);
             $upd->execute();
            }else{
            
                $sql = "INSERT INTO tblcotizaciondet (CotizacionId, ProductoId, Descripcion, Cantidad, Precio, Total) VALUES (:CotizacionId, :ProductoId, :Descripcion, :Cantidad, :Precio, :Total)";
                $q = $this->db->prepare($sql);
                $ProductoId = intval($row["ProductoId"]);
                $Cantidad   = intval($row["Cantidad"]);
                $Precio     = $row["Precio"];
                $Total      = $row["Total"];
                $Descripcion = $row["Descripcion"];
                $q->bindParam(":CotizacionId",$CotId, PDO::PARAM_INT);
                $q->bindParam(":ProductoId",$ProductoId, PDO::PARAM_INT);
                $q->bindParam(":Descripcion", $Descripcion);
                $q->bindParam(":Cantidad", $Cantidad, PDO::PARAM_INT);
                $q->bindParam(":Precio",  $Precio );
                $q->bindParam(":Total", $Total);
                $q->execute();
            ;
            }
            }
            
            //Se actualiza el correo del cliente
            $UpdateCliente = "UPDATE tblusuarios SET Correo = :Correo WHERE UsuarioId = :UsuarioId";
            $UsuarioId =  $MaestroArray[0]["ClienteId"];
            $stmt =$this->db->prepare($UpdateCliente);
            $stmt->bindParam(':Correo', $MaestroArray[0]["Correo"]);
            $stmt->bindParam(':UsuarioId', $UsuarioId);
            $stmt->execute();
            
            $this->db->commit();
            $Mensaje = 'Se Guardo Correctamente el Movimiento';
            $Bandera = 'true';
            $Type    = 'success';
            $Title   = 'Proceso Completado';
          //  $resultado = $this->ReporteCotizacion($CotizacionId);
          //print_r($this->ReporteCotizacion($CotizacionId));
        }catch(\Exception $e){
            $this->db->rollback();
            $Mensaje = "Error al guardar movimiento". $e. " Intente de nuevo";
            $Bandera = 'false';
            $Type    = 'error';
            $Title   = 'Error al guardar movimiento';
            return array(
                "Mensaje"=> $Mensaje,
                'Bandera'=> $Bandera,
                'Title'  => $Title,
                'Type'      => $Type,
                'CotizacionId' => $CotId
                ); //$Detalle;
        }
        
        return array(
        "Mensaje"   => $Mensaje,
        'Bandera'   => $Bandera,
        'Title'     => $Title,
        'Type'      => $Type,
        'CotizacionId' => $CotId
        ); //$Detalle;
    // return $resultado = $query->fetchAll();
    }
}
    ?>