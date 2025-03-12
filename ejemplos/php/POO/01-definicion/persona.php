<?php   

class Persona{

    private $nombre;




    public function inicializar($nombre){
        $this->nombre=$nombre;

    }


    public function mostrar(){
        echo '<p>'. $this->nombre .'</p>';
       
    }


}




?>