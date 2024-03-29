<?php
include "ModelPagos.php";
class Pagos extends Conectar{


    private function ReadTabla($row) {
        $result = new TblPagos();
        $result->PagoId = $row["PagoId"];
        $result->Nombre = $row["Nombre"];
        $result->Factura = $row["Factura"];
        $result->Total = $row["Total"];
        $result->Activo = $row["Activo"];
        $result->created_at = $row["FechaPago"];
        $result->Descripcion = $row["Descripcion"];
        $result->Pagado = $row["Pagado"];
        // $result->updated_at = $row["updated_at"];
        return $result;
    }
   //Esta funcion obtiene la lista de las cotizaciones
   public function ListaPagos(){
    $conectar = parent::Conexion();
    parent::set_names();
    $query ="call Pagos_ListaPagos()";
    $query =$conectar->prepare($query);
    $query->execute();
    return $resultado =$query->fetchAll();
}

public function AddEditPago($PagoId,$UsuarioId, $Facura,$Total, $Descripcion, $Pagado){
    $error = '';
    try {
    date_default_timezone_set('America/Monterrey');
    $Bandera = false;
    $Mensaje = '';
    $Title   = '';
    $Type    = 'error';
    $resultado = null;
    $FechaActual = date('Y/m/d h:i:s');
    $conectar = parent::Conexion();
    parent::set_names();
    $Activo = 1;
    if($PagoId <= 0){
        $sqltblcotizacion = "INSERT INTO tblpagos (Nombre, Factura, Total, Activo, created_at, updated_at, Descripcion, Pagado) 
        VALUES (:Nombre, :Factura, :Total, :Activo, :created_at, :updated_at, :Descripcion, :Pagado)";
        $tblcotizacion = $this->db->prepare($sqltblcotizacion);
        $tblcotizacion->bindParam(":Nombre", $UsuarioId);
        $tblcotizacion->bindParam(":Factura", $Facura);
        $tblcotizacion->bindParam(":Total", $Total);
        $tblcotizacion->bindParam(":Activo", $Activo);
        $tblcotizacion->bindParam(":created_at", $FechaActual);
        $tblcotizacion->bindParam(":updated_at", $FechaActual);
        $tblcotizacion->bindParam(":Descripcion", $Descripcion);
        $tblcotizacion->bindParam(":Pagado", $Pagado);
        $tblcotizacion->execute();
        $Mensaje = 'Se Guardo Correctamente el Movimiento';
        $Bandera = 'true';
        $Type    = 'success';
        $Title   = 'Proceso Completado';
    }else{
        $UpdateCliente = "UPDATE tblpagos SET Nombre = :Nombre, Factura = :Factura, Total = :Total, updated_at = :updated_at, Descripcion = :Descripcion, Pagado = :Pagado WHERE PagoId = :PagoId";
        $stmt =$this->db->prepare($UpdateCliente);
        $stmt->bindParam(':Nombre', $UsuarioId);
        $stmt->bindParam(':Factura', $Facura);
        $stmt->bindParam(":Total", $Total);
        $stmt->bindParam(':updated_at', $FechaActual);
        $stmt->bindParam(':Descripcion', $Descripcion);
        $stmt->bindParam(':Pagado', $Pagado);
        $stmt->bindParam(":PagoId", $PagoId);
        $stmt->execute();
        $Mensaje = 'Se Guardo Correctamente el Movimiento';
        $Bandera = 'true';
        $Type    = 'success';
        $Title   = 'Proceso Completado';
        }
    } catch (\Exception $e) {
        //throw $th;
        $error = $e;
        echo($e);
        print_r($e);
    }
        return array(
            "Mensaje"   => $Mensaje,
            'Bandera'   => $Bandera,
            'Title'     => $Title,
            'Type'      => $Type,
            'error'     => $error
            );
}
/**
 *         $result->PagoId = $row["PagoId"];
        $result->UsuarioId = $row["UsuarioId"];
        $result->Factura = $row["Factura"];
        $result->Total = $row["Total"];
        $result->Activo = $row["Activo"];
        $result->created_at = $row["FechaPago"];
 */
public function GetDataPagoXId($PagoId){
    $conectar = parent::Conexion();
    parent::set_names();
    $sql = "SELECT PagoId,Nombre,Factura,Total, Activo, created_at as FechaPago, Descripcion, Pagado FROM tblpagos WHERE PagoId = :PagoId";
    $q = $this->db->prepare($sql);
    $q->bindParam(":PagoId", $PagoId);
    $q->execute();
    $rows = $q->fetchAll();

    $result = array();
    foreach($rows as $row) {
        array_push($result, $this->ReadTabla($row));
    }
    return $result;
}

public function DesactivarPago($PagoId){
    try {
        date_default_timezone_set('America/Monterrey');
        $FechaActual = date('Y/m/d h:i:s');
        $conectar = parent::Conexion();
        parent::set_names();
        $Activo = 0;
        $UpdateCliente = "UPDATE tblpagos SET Activo = :Activo, updated_at = :updated_at WHERE PagoId = :PagoId";
        $stmt =$this->db->prepare($UpdateCliente);
        $stmt->bindParam(':Activo', $Activo);
        $stmt->bindParam(':updated_at', $FechaActual);
        $stmt->bindParam(":PagoId", $PagoId);
        $stmt->execute();
        $Mensaje = 'El Registro se desactivo correctamente c:';
        $Bandera = 'true';
        $Type    = 'success';
        $Title   = 'Proceso Completado';
        return array(
            "Mensaje"   => $Mensaje,
            'Bandera'   => $Bandera,
            'Title'     => $Title,
            'Type'      => $Type
            );
    } catch (\Exception $th) {
        //throw $th;

        return array("Mensaje" => $th);
    }
}

}

?>