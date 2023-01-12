<?php 
//Modelo tabla productos
class tblproductos{
   public $ProductoId;//int
   public $Clave;//varchar
   public $Descripcion; //varchar   
   public $ClaveSat;//varchar
   public $ProdCategoriaId;//int
   public $FechaCreado;// datetime
   public $EsServicio; //integer Bandera
   public $Uso;//int Bandera
   public $ProductoConcat;
   public $Categoria;
}
?>