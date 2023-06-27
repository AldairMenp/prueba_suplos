
<?php

require_once ("./config/rutas.php");

if(isset($_GET["controlador"]) && isset($_GET["metodo"]) ){
   $controlador =  $_GET["controlador"];
   $metodo =  $_GET["metodo"];

}else{
    $controlador = "procesos";
    $metodo =  "panelInicial";

}

 rute::cargar($controlador,$metodo);

