<?php

class ReporteServicio extends Conectar{

    //Agrega un reporte de servicio
    public function AddReporteServicio($Maestro,$MaestroServicios,$MaestroMateriales){
        $conectar = parent::Conexion();
        parent::set_names();
                $sql = "call Servicio_AddReporteServicio(?,?,?)";
                $sql=$conectar->prepare($sql);
                $sql->bindParam(1,$Maestro);
                $sql->bindParam(2,$MaestroServicios);
                $sql->bindParam(3,$MaestroMateriales);
                $sql->execute();
                return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
                
    }

    //Obtiene el encabezado de un reporte de servicio x id
public function GetReporteServicio($ReporteServicioId){
$conectar = parent::Conexion();
parent::set_names();
$sql = "call Servicio_GetReporteServicio(?)";
$sql = $conectar->prepare($sql);
$sql->bindParam(1,$ReporteServicioId);
$sql->execute();
return $resultado = $sql->fetchAll();
}

//Obtiene los productos y servicios usados en un reporte de servicio
public function GetReporteServicioDet($ReporteServicioId){
$conectar = parent::Conexion();
parent::set_names();
$sql = "call Servicio_GetReporteServicioDet(?)";
$sql = $conectar->prepare($sql);
$sql->bindParam(1,$ReporteServicioId);
$sql->execute();
return $resultado = $sql->fetchAll();
}
}

?>