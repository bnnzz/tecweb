<?php
namespace TECWEB\MyApi;
abstract class DataBase {
    protected $conexion; // Cambiado a protected según UML

    public function __construct($user, $pass, $db) {
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