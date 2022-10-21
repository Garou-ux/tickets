<?php
session_start();

class Conectar {
    protected $db;
    protected function Conexion(){
        try{
                     //local
          $conectar = $this ->db = 
    //   new PDO("mysql:host=173.201.190.12;dbname=conectotaldb", "AlejandroIslas", "9425Dcfnp!!qal30");
      new PDO("mysql:host=localhost;dbname=conectotaldb", "root", "Password1");
//server
//$conectar = $this ->db = 
  //new PDO("mysql:host=localhost;dbname=conectotaldb", "AlejandroIslas", "9425Dcfnp!!qal30");

            return $conectar;
        }catch(Exception $e){
print "Ocurrio un error al establecer conexión con la base de datos, intentelo de nuevo" . $e->getMessage(). "<br/>";
die();
        }
    }

    public function set_names(){
        return $this->db->query("SET NAMES 'utf8'");
    }


public static function ruta(){

    //server
  //return "http://ctnredes.com/";
    
    //local
    return "http://localhost:8010/tickets/";
}
}
?>