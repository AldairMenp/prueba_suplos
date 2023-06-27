<?php
/**
 * clase que maneja la conexion 
 */
class conexion{
    private $conexion;

    /**
     * metodo que lleva la conexion
     */
    public function __construct(){
        try {
            $this->conexion = new PDO("mysql:host=localhost;dbname=prueba_suplos","root","");
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage();
        }
    }
    /**
     * funcion que conecta
     */
    public function conectarse(){
        if($this->conexion instanceof PDO){
            return $this->conexion;
        }
    }
}

?>