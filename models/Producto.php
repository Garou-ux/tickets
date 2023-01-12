<?php 

include "ModelProductos.php";
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

    //Esta funcion obtiene la lista de las categorias de los productos, se utiliza en dropdowns
    public function ListProductoCategoria() {
        $conectar = parent::Conexion();
        parent::set_names();
        $query ="call Producto_ListProductoCategoria()";
        $query =$conectar->prepare($query);
        $query->execute();
        //return $resultado =$query->fetchAll();
        
        $rows = $query->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

//Esta funcion obtiene la lista de los productos
public function ListProducto($Caso = 0){
    $conectar = parent::Conexion();
    $Caso = 1 ? $Caso = 0 : $Caso = 1;
    // echo $Caso;
    // return;
    parent::set_names();
    $QueryProductos = "SELECT p.ProductoId, p.Clave, p.ProdCategoriaId,
    p.FechaCreado,
    p.EsServicio,
    p.Uso,
    p.Descripcion, p.ClaveSat, concat(p.Clave, '| ', p.Descripcion) ProductoConcat ,cat.Categoria 
    FROM tblproductos p INNER JOIN tblproductocategoria cat ON cat.ProdCategoriaId = p.ProdCategoriaId 
    WHERE  EsServicio = :EsServicio";
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
    return $result;
}

//Esta funcion obtiene los datos de un producto x id
    public function GetProducto ($ProductoId){
        $conectar = parent::Conexion();
        parent::set_names();
        $query = "call Producto_GetProducto(?)";
        $query = $conectar->prepare($query);
        $query->bindParam(1,$ProductoId);
        $query->execute();
        return $resultado = $query->fetchAll();
    }

    //esta funcion agrega/edita un producto/servicio x id
    public function AddProductoServicio($Maestro){
        $conectar = parent::Conexion();
        parent::set_names();
        $query = "call Producto_AddProductoServicio(?)";
        $query = $conectar->prepare($query);
        $query->bindParam(1,$Maestro);
        $query->execute();
        return $resultado = $query->fetchAll();
    }
}
?>