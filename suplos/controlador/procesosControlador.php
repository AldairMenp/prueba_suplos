<?php
require_once "./config/cargaVisual.php";
require_once "./implementDao/procesoImplement.php";
require_once "./model/documentos.php";
require_once "./model/procesos.php";


class procesosControlador
{



    private object $instanciaCargaVisual;
    private object $instanciaProcesoImplement;

    public function __construct()
    {
        $this->instanciaProcesoImplement = new procesoImplement();
        $this->instanciaCargaVisual = new cargaVisual();
    }

    public function panelInicial()
    {
        $this->instanciaCargaVisual->contenido("procesos/inicio");
    }
    public function panelAcciones()
    {
        $this->instanciaCargaVisual->contenido("procesos/acciones");
    }
    public function frmCrear()
    {
        $this->instanciaCargaVisual->selectorActividades = $this->instanciaProcesoImplement->obtenerSelectorActividades();
        $this->instanciaCargaVisual->contenido("procesos/frmCrear");
    }

    public function crear()
    {
        if (isset($_POST["objetivo"]) && isset($_POST["objetivo"])) {

            $procesos = new procesos();
            $procesos->setObjeto($_POST["objetivo"]);
            $procesos->setDescripcion($_POST["descripcion"]);
            $procesos->setMoneda($_POST["moneda"]);
            $procesos->setPresupuesto($_POST["presupuesto"]);
            $procesos->setFechaInicio($_POST["fechaInicio"]);
            $procesos->setHoraInicio($_POST["horaInicio"]);
            $procesos->setFechaFin($_POST["fechaFin"]);
            $procesos->setHoraFin($_POST["horaFin"]);
            $procesos->setActividades_id($_POST["actividad"]);
            $procesos->setNombre_responsable($_POST["nombreResponsable"]);

            $respuesta = $this->instanciaProcesoImplement->crear($procesos);

            if ($respuesta) {
                echo json_encode(["code" => 200, "estado" => "OK", "msg" => "Insertado correctamente"]);
            }
        } else {
            echo json_encode(["code" => 200, "estado" => "Error", "msg" => "Faltan campos requeridos"]);
        }
    }
    public function frmConsultar()
    {
        $limite = 5;
        $total = $this->instanciaProcesoImplement->totalCantidadProcesos();

        $this->instanciaCargaVisual->total = $total;

        if ($total > $limite) {
            $secciones = ceil($total / $limite);
        } else {
            $secciones = 1;
        }
        if (isset($_GET["pagina"]) && is_numeric($_GET["pagina"])) {
            $pagina = $_GET["pagina"];
        } else {
            $pagina = 0;
        }

        $paguinaActual = ($pagina / $limite) + 1;

        $this->instanciaCargaVisual->datosPaginados =
            $this->instanciaProcesoImplement->obtenerDatosPaginacion($pagina, $limite);

        if ($secciones > 1) {

            $this->instanciaCargaVisual->pagina = "";
            for ($i = 1; $i <= $secciones; $i++) {
                if ($i != $paguinaActual) {
                    $this->instanciaCargaVisual->pagina .= "<a class='paginar' href='?controlador=procesos&metodo=frmConsultar&pagina=" . ($limite * ($i - 1)) . "'> " . $i . " </a> ";
                } else {
                    $this->instanciaCargaVisual->pagina .= "<a class='active'> " . $i . " </a>";
                }
            }
        } else {
            $this->instanciaCargaVisual->pagina = "";
        }

        $this->instanciaCargaVisual->contenido("procesos/frmConsultar");
    }

    public function consultar()
    {

        $busquedaID = str_replace(' ', '', $_POST["busquedaID"]);
        $busquedaDescipcion = str_replace(' ', '', $_POST["busquedaDescripcion"]);
        $comprador = str_replace(' ', '', $_POST["comprador"]);
        $estadoSelector = str_replace(' ', '', $_POST["estadoSelector"]);


        $busqueda = [
            "busquedaID" => $busquedaID,
            "busquedaDescripcion" => $busquedaDescipcion,
            "comprador" => $comprador,
            "estadoSelector" => $estadoSelector,
        ];

        $busquedaElaces = "busquedaID=" . $busquedaID .
            "&busquedaDescripcion=" . $busquedaDescipcion .
            "&comprador=" . $comprador .
            "&estadoSelector=" . $estadoSelector;

        $limite = 5;
        $total = $this->instanciaProcesoImplement->cantidadProcesosConsulta($busqueda);

        if ($total > 0) {


            if ($total > $limite) {
                $secciones = ceil($total / $limite);
            } else {
                $secciones = 1;
            }

            if (isset($_GET["pagina"]) && is_numeric($_GET["pagina"])) {
                $pagina = $_GET["pagina"];
            } else {
                $pagina = 0;
            }

            $paguinaActual = ($pagina / $limite) + 1;
            $arrayDatosObtenidos = $this->instanciaProcesoImplement->datosProcesosConsulta($pagina, $limite, $busqueda);

            $tabla = "";


            $tabla .= '<table class="table">
            <thead class="thead" class="border">
               
                <h4>Numero de procesos / Eventos listado<?= $total; ?></h4>
                <tr>
                    <th scope="col" >Id</th>
                    <th scope="col" >Ronda</th>
                    <th scope="col" >Objeto</th>
                    <th scope="col" >Descripcion</th>
                    <th scope="col" >Fecha inicio</th>
                    <th scope="col" >Fecha cierre</th>
                    <th scope="col" >Estado</th>
                    <th scope="col" >Responsable del evento</th>
                    <th scope="col" >Acciones</th>
                </tr>
            </thead>
            <thbody>';
            foreach ($arrayDatosObtenidos as $valor) {
                $tabla .= "<tr>";
                $tabla .= "
            <td>" . $valor["id"] . "</td> 
            <td>" . $valor["id"] . "</td> 
            <td>" . $valor["objeto"] . "</td> 
            <td>" . $valor["descripcion"] . "</td> 
            <td>" . $valor["fecha_inicio"] . "</td> 
            <td>" . $valor["fecha_fin"] . "</td> 
            <td>" . $valor["estado"] . "</td> 
            <td>" . $valor["nombre_responsable"] . "</td> 
            <td> 
            <a href='?controlador=procesos&metodo=frmEditar&id=" . $valor["id"] . "'>EDITAR</a>
            <a class='eliminar-proceso' href='?controlador=procesos&metodo=borrar&id=" . $valor["id"] . "'  >BORRAR</a>
             </td>  ";


                $tabla .= "</tr>";
            }
            $tabla .= '</thbody>
             </table>';

            if ($secciones > 1) {
                $paginacion = "";
                for ($i = 1; $i <= $secciones; $i++) {
                    if ($i != $paguinaActual) {

                        $paginacion .= "<a  href='?controlador=procesos&metodo=consultar&pagina=" . ($limite * ($i - 1)) . "' class='paginacion paginar' data-parametro='" . $busquedaElaces . "''>" . $i . "</a> ";
                    } else {
                        $paginacion .= "<a class='active'>" . $i . "</a>";
                    }
                }
            } else {
                $paginacion = "";
            }
        } else {
            $tabla = '
                <br>
                <br>
                <center><h1>Proceso no existe</h1></center>
                <br>
            ';
            $paginacion = "";
        }
        echo json_encode([
            "paginacion" => $paginacion,
            "tabla" => $tabla,
            "msg" => "Datos mandados",
            "status" => 200
        ]);
    }


    public function frmEditar()
    {
        $proceso = new procesos();
        $proceso->setId($_GET["id"]);
        $this->instanciaCargaVisual->selectorActividades = $this->instanciaProcesoImplement->obtenerSelectorActividades();
        $this->instanciaCargaVisual->datosActualizacion = $this->instanciaProcesoImplement->obtenerDatosActualizables($proceso);
        $this->instanciaCargaVisual->objeto = $proceso->getObjeto();
        $this->instanciaCargaVisual->nombre_responsable = $proceso->getNombre_responsable();
        $this->instanciaCargaVisual->descripcion = $proceso->getDescripcion();
        $this->instanciaCargaVisual->moneda = $proceso->getMoneda();
        $this->instanciaCargaVisual->presupuesto = $proceso->getPresupuesto();
        $this->instanciaCargaVisual->estado = $proceso->getEstado();
        $this->instanciaCargaVisual->fecha_inicio = $proceso->getFechaInicio();
        $this->instanciaCargaVisual->hora_inicio = $proceso->getHoraInicio();
        $this->instanciaCargaVisual->fecha_fin = $proceso->getFechaFin();
        $this->instanciaCargaVisual->hora_fin = $proceso->getHoraFin();
        $this->instanciaCargaVisual->actividades_id = $proceso->getActividades_id();
        $this->instanciaCargaVisual->id = $proceso->getId();
        $this->instanciaCargaVisual->contenido("procesos/frmEditar");
    }


    public function actualizar()
    {


        $procesos = new procesos();
        $procesos->setId($_POST["id"]);
        $procesos->setObjeto($_POST["objetivo"]);
        $procesos->setDescripcion($_POST["descripcion"]);
        $procesos->setMoneda($_POST["moneda"]);
        $procesos->setPresupuesto($_POST["presupuesto"]);
        $procesos->setFechaInicio($_POST["fechaInicio"]);
        $procesos->setHoraInicio($_POST["horaInicio"]);
        $procesos->setFechaFin($_POST["fechaFin"]);
        $procesos->setHoraFin($_POST["horaFin"]);
        $procesos->setActividades_id($_POST["actividad"]);
        $procesos->setNombre_responsable($_POST["nombreResponsable"]);

        $respuesta = $this->instanciaProcesoImplement->datosActualizacion($procesos);

        echo json_encode(["status" => 200, "msg" => "Actualizado correctamente"]);
    }

    public function borrar()
    {
        $procesos = new procesos();
        $procesos->setId($_GET["id"]);
        $response = $this->instanciaProcesoImplement->borrar($procesos);

        if ($response) {
            echo json_encode(["status" => 200, "msg" => "Proceso eliminado"]);
        }
    }

    public function frmDocumentos()
    {
       $this->instanciaCargaVisual->dataConsulta =  $this->instanciaProcesoImplement->obtenerDocumentos($_GET["id"]);
        $this->instanciaCargaVisual->contenido("procesos/frmDocumentos");

    }

    public function subirDocumento()
    {

        if (isset($_FILES["file"]["tmp_name"]) && $_FILES["file"]["name"] != "") {
            $nombre = date("His") . $_FILES["file"]["name"];
            // $nombre =date("H:i:s").$_FILES["file"]["name"];
            $tmp = $_FILES["file"]["tmp_name"];

            if (move_uploaded_file($tmp, "./public/archivos/" . $nombre)) {


                $documento = new documentos();
                $proceso = new procesos();
                $documento->setTitulo_documento($_POST["titulo"]);
                $documento->setDescriptcion_documento($_POST["descipcion"]);
                $documento->setNombre_documento($nombre);
                $documento->setUbicacion_documento("./public/archivos/" . $nombre);
                $proceso->setId($_POST["idProceso"]);

                $this->instanciaProcesoImplement->subirDocumento($documento,$proceso);

                echo json_encode(array("mensaje" => "archivo cargado")); //correcto
            } else {
                echo json_encode(array("mensaje" => "Error al subir")); //error
            }
        }
    }
}