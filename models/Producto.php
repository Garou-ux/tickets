<?php 

include "ModelProductos.php";
include "ModelProductosCategoria.php";
class Producto extends Conectar{

        
    private function ReadProductos($row) {
        $result                  = new tblproductos();
        $result->ProductoId      =  $row["ProductoId"];
        $result->ProductoConcat  =  $row["ProductoConcat"];
        $result->Clave           =  $row["Clave"];
        $result->ClaveSat        =  $row["ClaveSat"];
        $result->Cateogria       =  $row["Categoria"];
        $result->ProdCategoriaId =  $row["ProdCategoriaId"];
        $result->FechaCreado     =  $row["FechaCreado"];
        $result->EsServicio      =  $row["EsServicio"];
        $result->Uso             =  $row["Uso"];
        return $result;
    }

    private function ReadProductoXId($row){
        $result                  = new tblproductos();
        $result->ProductoId      =  $row["ProductoId"];
        $result->Clave           =  $row["Clave"];
        $result->Descripcion     =  $row["Descripcion"];
        $result->ClaveSat        =  $row["ClaveSat"];
        $result->ProdCategoriaId =  $row["ProdCategoriaId"];
        $result->FechaCreado     =  $row["FechaCreado"];
        $result->EsServicio      =  $row["EsServicio"];
        $result->Uso             =  $row["Uso"];

        return $result;
    }

    private function ReadProductoCategoria($row){
      $result = new tblproductocategoria();
      $result->ProdCategoriaId  = $row["ProdCategoriaId"];
      $result->Categoria        = $row["Categoria"];
      $result->Uso              = $row["Uso"];

      return $result;
    }

    //Esta funcion obtiene la lista de las categorias de los productos, se utiliza en dropdowns
    public function ListProductoCategoria() {
        $conectar = parent::Conexion();
        parent::set_names();
        $QueryProductos = "SELECT ProdCategoriaId,
         Categoria ,Uso
        FROM tblproductocategoria
        WHERE  Uso = :Uso";
        $Uso = 1;
        $q = $conectar->prepare($QueryProductos);
        $q ->bindParam(":Uso",$Uso);
        $q->execute();
        $rows = $q->fetchAll();
        $result = array();
    
        foreach ($rows as $row) {
            array_push($result, $this->ReadProductoCategoria($row));
        }
        return $result;
    }

//Esta funcion obtiene la lista de los productos
public function ListProducto($Caso = 0){
    $conectar = parent::Conexion();
    // $Caso = 1 ? $Caso = 0 : $Caso = 1;
    // echo $Caso;
    // return;
    parent::set_names();
    $QueryProductos = "SELECT p.ProductoId, p.Clave, p.ProdCategoriaId,
    p.FechaCreado,
    p.EsServicio,
    p.Uso,
    p.Descripcion, p.ClaveSat, concat(p.Clave, '| ', p.Descripcion) as ProductoConcat ,cat.Categoria 
    FROM tblproductos p INNER JOIN tblproductocategoria cat ON cat.ProdCategoriaId = p.ProdCategoriaId 
    WHERE  EsServicio = :EsServicio
    ORDER BY cat.ProdCategoriaId
    ";
    $Uso = 1;
    $q = $conectar->prepare($QueryProductos);
    // $q ->bindParam(":Uso",$Uso);
    $q ->bindParam(":EsServicio",$Caso);
    $q->execute();
    $rows = $q->fetchAll();
    $result = array();

    foreach ($rows as $row) {
        array_push($result, $this->ReadProductos($row));
    }
    // print_r($result);
    return $result;
}

//Esta funcion obtiene los datos de un producto x id
    public function GetProducto ($ProductoId){
        $conectar = parent::Conexion();
        parent::set_names();
        $QueryProductos = "SELECT 
        ProductoId, Clave, Descripcion, ClaveSat, ProdCategoriaId, FechaCreado, EsServicio, Uso
        FROM tblproductos 
        WHERE  ProductoId = :ProductoId";
        $Uso = 1;
        $q = $conectar->prepare($QueryProductos);
        $q ->bindParam(":ProductoId",$ProductoId);
        $q->execute();
        $rows = $q->fetchAll();
        $result = array();
    
        foreach ($rows as $row) {
            array_push($result, $this->ReadProductoXId($row));
        }
        return $result;
    }

    //esta funcion agrega/edita un producto/servicio x id
    public function AddProductoServicio($Maestro){
        date_default_timezone_set('America/Monterrey');
        $Bandera = false;
        $Mensaje = '';
        $Title   = '';
        $Type    = 'error'; 
        $conectar = parent::Conexion();
        $ProductoId =null;
        parent::set_names();
        $FechaActual = date('Y/m/d h:i:s');
        $MaestroArray = json_decode($Maestro, true);
            if($MaestroArray[0]["ProductoId"] >0){
                print_r("actualiza");
                $UpdateCotizacion = "UPDATE tblproductos 
                SET 
                           Clave = :Clave
                    ,Descripcion = :Descripcion
                       ,ClaveSat = :ClaveSat
                ,ProdCategoriaId = :ProdCategoriaId
                     ,EsServicio = :EsServicio
                            ,Uso = :Uso
                WHERE ProductoId = :ProductoId";
                $tblcotizacion = $conectar->prepare($UpdateCotizacion);
                $tblcotizacion->bindParam(":Clave", $MaestroArray[0]["Clave"]);
                $tblcotizacion->bindParam(":Descripcion", $MaestroArray[0]["Descripcion"]);
                $tblcotizacion->bindParam(":ClaveSat", $MaestroArray[0]["ClaveSat"]);
                $tblcotizacion->bindParam(":ProdCategoriaId", $MaestroArray[0]["ProdCategoriaId"]);
                $tblcotizacion->bindParam(":EsServicio", $MaestroArray[0]["EsServicio"]);
                $tblcotizacion->bindParam(":Uso", $MaestroArray[0]["Uso"]);
                $tblcotizacion->bindParam(':ProductoId', $MaestroArray[0]["ProductoId"]);
                $tblcotizacion->execute();
                // $this->db->commit();
            } else{
                print_r("Inserta");
                    $sqltblcotizacion = "INSERT INTO tblproductos (Clave, Descripcion, ClaveSat, ProdCategoriaId, FechaCreado, EsServicio, Uso) 
                    VALUES (:Clave, :Descripcion, :ClaveSat, :ProdCategoriaId, :FechaCreado, :EsServicio, :Uso)";
                    $tblcotizacion = $conectar->prepare($sqltblcotizacion);
                    $tblcotizacion->bindParam(":Clave", $MaestroArray[0]["Clave"]);
                    $tblcotizacion->bindParam(":Descripcion", $MaestroArray[0]["Descripcion"]);
                    $tblcotizacion->bindParam(":ClaveSat", $MaestroArray[0]["ClaveSat"]);
                    $tblcotizacion->bindParam(":ProdCategoriaId", $MaestroArray[0]["ProdCategoriaId"]);
                    $tblcotizacion->bindParam(":FechaCreado", $FechaActual);
                    $tblcotizacion->bindParam(":EsServicio", $MaestroArray[0]["EsServicio"]);
                    $tblcotizacion->bindParam(":Uso", $MaestroArray[0]["Uso"]);
                    $tblcotizacion->execute();
                    $ProductoId = $this->db->lastInsertId();

            }        
        return array(
           "Mensaje" => $Mensaje,
           'Bandera' => $Bandera,
             'Title' => $Title,
              'Type' => $Type,
        'ProductoId' => $ProductoId
        ); 
    }

    public function DesactivarProducto($ProductoId){
        $conectar = parent::Conexion();
        parent::set_names();
              $Uso = 0;
                $UpdateCotizacion = "UPDATE tblproductos 
                SET 
                  Uso = :Uso
                WHERE ProductoId = :ProductoId";
                $tblcotizacion = $conectar->prepare($UpdateCotizacion);
                $tblcotizacion->bindParam(":Uso", $Uso);
                $tblcotizacion->bindParam(':ProductoId', $ProductoId);
                $tblcotizacion->execute();
    }

    public function ListProductosGridCoti(){
        $conectar = parent::Conexion();
        // $Caso = 1 ? $Caso = 0 : $Caso = 1;
        // echo $Caso;
        // return;
        parent::set_names();
        $QueryProductos = "SELECT p.ProductoId, p.Clave, p.ProdCategoriaId,
        p.FechaCreado,
        p.EsServicio,
        p.Uso,
        p.Descripcion, p.ClaveSat, concat(p.Clave, '| ', p.Descripcion) as ProductoConcat ,cat.Categoria 
        FROM tblproductos p INNER JOIN tblproductocategoria cat ON cat.ProdCategoriaId = p.ProdCategoriaId";
        // -- WHERE  EsServicio = :EsServicio";
        $Uso = 1;
        $q = $conectar->prepare($QueryProductos);
        // $q ->bindParam(":Uso",$Uso);
        // $q ->bindParam(":EsServicio",$Caso);
        $q->execute();
        $rows = $q->fetchAll();
        $result = array();
    
        foreach ($rows as $row) {
            array_push($result, $this->ReadProductos($row));
        }
        // print_r($result);
        return $result;
    }
}
?>