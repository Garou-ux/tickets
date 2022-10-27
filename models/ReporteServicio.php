<?php

class ReporteServicio extends Conectar{

    //Agrega un reporte de servicio
    // public function AddReporteServicio($Maestro,$MaestroServicios,$MaestroMateriales){
    //     $conectar = parent::Conexion();
    //     parent::set_names();
    //             $sql = "call Servicio_AddReporteServicio(?,?,?)";
    //             $sql=$conectar->prepare($sql);
    //             $sql->bindParam(1,$Maestro);
    //             $sql->bindParam(2,$MaestroServicios);
    //             $sql->bindParam(3,$MaestroMateriales);
    //             $sql->execute();
    //             return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);      
    // }
    
    
     //esta funcion agrega/edita una cotizacion
     public function AddReporteServicio($Maestro, $Detalle){
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
        $sqltblreporteservicio = "INSERT INTO tblreporteservicio (
        TicketId,
        ClienteId, 
        Marca,
        Modelo,
        Serie,
        Otros,
        InspeccionVisual,
        Fecha,
        CategoriaId,
        FallaPresentada,
        SubTotal,
        IVA,
        Total,
        created_at,
        updated_at
        ) 
        VALUES (
        :TicketId,
        :ClienteId, 
        :Marca,
        :Modelo,
        :Serie,
        :Otros,
        :InspeccionVisual,
        :Fecha,
        :CategoriaId,
        :FallaPresentada,
        :SubTotal,
        :IVA,
        :Total,
        :created_at,
        :updated_at
        )";
        $tblreporteservicio = $this->db->prepare($sqltblreporteservicio);
        try{
            $tblreporteservicio->bindParam(":TicketId",          $MaestroArray[0]["TicketId"],PDO::PARAM_INT);
            $tblreporteservicio->bindParam(":ClienteId",         $MaestroArray[0]["ClienteId"],PDO::PARAM_INT);
            $tblreporteservicio->bindParam(":Marca",             $MaestroArray[0]["Marca"]);
            $tblreporteservicio->bindParam(":Modelo",            $MaestroArray[0]["Modelo"]);
            $tblreporteservicio->bindParam(":Serie",             $MaestroArray[0]["Serie"]);
            $tblreporteservicio->bindParam(":Otros",             $MaestroArray[0]["Otros"]);
            $tblreporteservicio->bindParam(":InspeccionVisual",  $MaestroArray[0]["InspeccionVisual"]);
            $tblreporteservicio->bindParam(":Fecha",             $FechaActual);
            $tblreporteservicio->bindParam(":CategoriaId",       $MaestroArray[0]["CategoriaId"]);
            $tblreporteservicio->bindParam(":FallaPresentada",   $MaestroArray[0]["FallaPresentada"]);
            // $tblreporteservicio->bindParam(":Servicio",          $MaestroArray[0]["Servicio"]);
            // $tblreporteservicio->bindParam(":Refacciones",       $MaestroArray[0]["Refacciones"]);
            // $tblreporteservicio->bindParam(":ViaticosOtros",     $MaestroArray[0]["ViaticosOtros"]);
            $tblreporteservicio->bindParam(":SubTotal",          $MaestroArray[0]["SubTotal"]);
            $tblreporteservicio->bindParam(":IVA",               $MaestroArray[0]["IVA"]);
            $tblreporteservicio->bindParam(":Total",             $MaestroArray[0]["Total"]);
            $tblreporteservicio->bindParam(":created_at",        $FechaActual);
            $tblreporteservicio->bindParam(":updated_at",        $FechaActual);
            $tblreporteservicio->execute();
            $ReporteServicioId = $this->db->lastInsertId();
            $array = json_decode($Detalle, true);
            foreach($array as $row){
                $sql = "INSERT INTO tblreporteserviciodetalle 
                (
                ReporteServicioId,
                ProductoId, 
                Cantidad,
                Precio,
                Total,
                Comentarios,
                created_at
                ) 
                VALUES (
                :ReporteServicioId,
                :ProductoId,
                :Cantidad,
                :Precio,
                :Total,
                :Comentarios,
                :created_at
                )";
                $q = $this->db->prepare($sql);
                $ProductoId   = intval($row["ProductoId"]);
                $Cantidad     = intval($row["Cantidad"]);
                $Precio       = $row["Precio"];
                $Total        = $row["Total"];
                $Comentarios  = $row["Comentarios"];
                $q->bindParam(":ReporteServicioId", $ReporteServicioId);
                $q->bindParam(":ProductoId",        $ProductoId, PDO::PARAM_INT);
                $q->bindParam(":Cantidad",          $Cantidad);
                $q->bindParam(":Precio",            $Precio );
                $q->bindParam(":Total",             $Total);
                $q->bindParam(":Comentarios",       $Comentarios);
                $q->bindParam(":created_at",        $FechaActual);
                $q->execute();
          }
          //Se actualiza el ticket a tiene servicio
          
          $UpdateTicket = "UPDATE tbltickets SET TieneServicio = :TieneServicio WHERE TicketId = :TicketId";
          $TicketId =  $MaestroArray[0]["TicketId"];
          $TieneServicio = 1;
          $stmt =$this->db->prepare($UpdateTicket);
          $stmt->bindParam(':TieneServicio', $TieneServicio);
          $stmt->bindParam(':TicketId',      $TicketId);
          $stmt->execute();
            //se ejecutan los comandos
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
                "Mensaje"           => $Mensaje,
                'Bandera'           => $Bandera,
                'Title'             => $Title,
                'Type'              => $Type,
                'ReporteServicioId' => $ReporteServicioId
                ); //$Detalle;
     }
            return array(
            "Mensaje"           => $Mensaje,
            'Bandera'           => $Bandera,
            'Title'             => $Title,
            'Type'              => $Type,
            'ReporteServicioId' => $ReporteServicioId
            ); 
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
            public function GetReporteServicioDet($ReporteServicioId){$conectar = parent::Conexion();
            parent::set_names();
            $sql = "call Servicio_GetReporteServicioDet(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$ReporteServicioId);
            $sql->execute();
            return $resultado = $sql->fetchAll();
            }
            }

?>