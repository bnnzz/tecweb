<?php
namespace TECWEB\MyApi;
abstract class DataBase {
    protected $conexion; // Cambiado a protected según UML

    public function __construct($db, $user, $pass) {
        $this->conexion = @mysqli_connect(
            'localhost',
             $user, 
             $pass,
              $db
            );
        
      
        if (!$this->conexion) {
            die('¡Base de datos NO conectada! Error: ' );
        }
    }
}

?>