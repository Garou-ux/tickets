<?php
class Categorias extends Conectar{
    //esta funcion retorna la lista de las categorias, se usa en los selects de categorias
    public function ListCategorias(){
        $conectar = parent::Conexion();
        parent::set_names();
        $query ="call Categorias_ListCategorias()";
        $query =$conectar->prepare($query);
        $query->execute();
        return $resultado =$query->fetchAll();
    }

    //funcion que retorna las categorias, se usa para llenar grids

    public function ListCategoriasGrid(){
        $conectar = parent::Conexion();
        parent::set_names();
        $query = "call Categorias_ListCategoriasGrid()";
        $query = $conectar->prepare($query);
        $query->execute();
        return $resultado = $query->fetchAll();
    }

    //funcion que agrega/edita una categoria
    public function AddCategoria($Maestro){
        $conectar = parent::Conexion();
        parent::set_names();
        $query = "call Categorias_AddCategoria(?)";
        $query =$conectar->prepare($query);
        $query->bindParam(1,$Maestro);
        $query->execute();
        return $resultado =$query->fetchAll();
    }

    //funcion que obtiene una categoria x id
    public function GetCategoria($CategoriasId){
        $conectar = parent::Conexion();
        parent::set_names();
        $query = "call Categorias_GetCategoria(?)";
        $query= $conectar->prepare($query);
        $query->bindParam(1,$CategoriasId);
        $query->execute();
        return $resultado = $query->fetchAll();
    }
}
?>