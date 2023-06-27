<?php

interface procesoDao{

	public function crear($proceso):bool;
	public function totalCantidadProcesos():int;
	public function obtenerDatosPaginacion($pagina, $limite):array;
	public function cantidadProcesosConsulta( $busquedas):int;
	public function datosProcesosConsulta($pagina, $limite, $busqueda):array;
	public function borrar($procesos):bool;
	public function obtenerSelectorActividades():array;
	public function obtenerDatosActualizables($proceso);
	public function datosActualizacion($proceso);

	public function subirDocumento($documento, $proceso);
}

?>