<?php
include "ModelPagos.php";
class Pagos extends Conectar{


    private function ReadTabla($row) {
        $result = new TblPagos();
        $result->PagoId = $row["PagoId"];
        $result->UsuarioId = $row["UsuarioId"];
        $result->Factura = $row["Factura"];
        $result->Total = $row["Total"];
        $result->Activo = $row["Activo"];
        $result->created_at = $row["created_at"];
        $result->updated_at = $row["updated_at"];
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

}

?>