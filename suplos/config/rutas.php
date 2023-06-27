<?php

class rute{

    public static function cargar(string $controlador, string $metodo ) {

        if(file_exists("./controlador/".$controlador."Controlador.php" )){
            require_once ("./controlador/". $controlador."Controlador.php");

            $controlador = $controlador."Controlador";
            if(class_exists($controlador)){

             $class = new $controlador();
            
             if(method_exists($class, $metodo)){
     
                   $class->$metodo();
             }else{
                echo "existe metodo 404";


             }

            }else{
                echo "no existe clase 404";
            }
            
        }else{
           header("Location: index.php");
        }

    }


}