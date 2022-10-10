<?php 

include "ProductoModel.php";
class Producto extends Conectar{


    private function read($row) {
        $result = new ProductoModel();
        $result->ProductoId = $row["ProductoId"];
        $result->ProductoConcat = $row["ProductoConcat"];
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
    parent::set_names();
    $query = "call Producto_ListProducto(?)";
    $query = $conectar->prepare($query);
    $query ->bindParam(1,$Caso);
    $query->execute();
    return $resultado = $query->fetchAll();
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