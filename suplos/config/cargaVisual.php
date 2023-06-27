<?php


class cargaVisual
{

  public function contenido(string $contenido)
  {


    require_once "./vistas/estructura/header.php";

    require_once "./vistas/" . $contenido . ".php";

    require_once "./vistas/estructura/footer.php";


  }
}