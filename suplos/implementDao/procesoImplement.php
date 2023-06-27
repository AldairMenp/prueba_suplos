<?php

require_once "./dao/procesoDao.php";
require_once "./model/procesos.php";
require_once "./config/conexion.php";



class procesoImplement implements procesoDao
{


	private object $conexion;
	function __construct()
	{
		$this->conexion = new conexion();
	}


	public function crear($proceso): bool
	{


		$preparar = $this->conexion->conectarse()->prepare("INSERT INTO procesos
		
		 VALUES (?, ?, ?, ?, ? , ? ,?, ?, ?, ?, ?,?) ");

		$preparar->execute(
			[
				null,
				$proceso->getObjeto(),
				$proceso->getNombre_responsable(),
				$proceso->getDescripcion(),
				$proceso->getMoneda(),
				$proceso->getPresupuesto(),
				'Y',
				$proceso->getFechaInicio(),
				$proceso->getHoraInicio(),
				$proceso->getFechaFin(),
				$proceso->getHoraFin(),
				$proceso->getActividades_id()
			]
		);


		return true;
	}

	public function totalCantidadProcesos(): int
	{


		$consulta = $this->conexion->conectarse()->prepare("SELECT * FROM procesos  ");

		$consulta->execute();
		return $consulta->rowCount();
	}


	public function obtenerDatosPaginacion($pagina, $limite): array
	{
		$consulta = $this->conexion->conectarse()->prepare("SELECT *
		 FROM procesos   LIMIT $pagina, $limite   ");

		$consulta->execute();
		return $consulta->fetchAll();
	}


	public function cantidadProcesosConsulta($busquedas): int
	{

		$sql = "SELECT * FROM procesos  ";


		$contador = 0;
		$where = "WHERE";

		if (!empty($busquedas["busquedaID"])) {


			$where .= $contador == 0 ? " id LIKE  '%" . $busquedas["busquedaID"] . "%' "
				: " OR id LIKE  '%" . $busquedas["busquedaID"] . "%'  ";

			$contador += 1;
		}

		if (!empty($busquedas["busquedaDescripcion"])) {
			$where .= $contador == 0 ? " objeto LIKE  '%" . $busquedas["busquedaDescripcion"] . "%'  OR  descripcion LIKE  '%" . $busquedas["busquedaDescripcion"] . "%' "
				: " OR  descripcion LIKE  '%" . $busquedas["busquedaDescripcion"] . "%' OR objeto LIKE  '%" . $busquedas["busquedaDescripcion"] . "%'  ";

			$contador += 1;
		}

		if (!empty($busquedas["comprador"])) {
			$where .= $contador == 0 ? " nombre_responsable  LIKE  '%" . $busquedas["comprador"] . "%' "
				: " OR  nombre_responsable LIKE  '%" . $busquedas["comprador"] . "%'  ";
			$contador += 1;
		}

		if (!empty($busquedas["estadoSelector"]) && $busquedas["estadoSelector"] != "none") {
			$where .= $contador == 0 ? " estado LIKE  '%" . $busquedas["estadoSelector"] . "%' "
				: " OR estado LIKE  '%" . $busquedas["estadoSelector"] . "%'  ";

			$contador += 1;
		}


		if ($contador > 0) {


			$sql = $sql . $where;
		}




		$consulta = $this->conexion->conectarse()->prepare($sql);
		$consulta->execute();

		return $consulta->rowCount();
	}
	public function datosProcesosConsulta($pagina, $limite, $busquedas): array
	{

		$sql = "SELECT * FROM procesos  ";

		$contador = 0;
		$where = "WHERE";

		if (!empty($busquedas["busquedaID"])) {


			$where .= $contador == 0 ? " id LIKE  '%" . $busquedas["busquedaID"] . "%' "
				: " OR id LIKE  '%" . $busquedas["busquedaID"] . "%'  ";

			$contador += 1;
		}

		if (!empty($busquedas["busquedaDescripcion"])) {
			$where .= $contador == 0 ? " objeto LIKE  '%" . $busquedas["busquedaDescripcion"] . "%'  OR  descripcion LIKE  '%" . $busquedas["busquedaDescripcion"] . "%' "
				: " OR  descripcion LIKE  '%" . $busquedas["busquedaDescripcion"] . "%' OR objeto LIKE  '%" . $busquedas["busquedaDescripcion"] . "%'  ";

			$contador += 1;
		}


		if (!empty($busquedas["comprador"])) {
			$where .= $contador == 0 ? " nombre_responsable  LIKE  '%" . $busquedas["comprador"] . "%' "
				: " OR  nombre_responsable LIKE  '%" . $busquedas["comprador"] . "%'  ";
			$contador += 1;
		}

		if (!empty($busquedas["estadoSelector"]) && $busquedas["estadoSelector"] != "none") {
			$where .= $contador == 0 ? " estado LIKE  '%" . $busquedas["estadoSelector"] . "%' "
				: " OR estado LIKE  '%" . $busquedas["estadoSelector"] . "%'  ";
			$contador += 1;
		}

		if ($contador > 0) {
			$sql = $sql . $where . " LIMIT " . $pagina . "," . $limite;
		} else {

			$sql = $sql . " LIMIT " . $pagina . "," . $limite;
		}
		$consulta = $this->conexion->conectarse()->prepare($sql);
		$consulta->execute();
		return $consulta->fetchAll();
	}



	public function borrar($procesos): bool
	{
		$consulta = $this->conexion->conectarse()->prepare("DELETE FROM procesos WHERE id = ? ");
		$consulta->execute([$procesos->getId()]);
		return true;
	}


	public function obtenerSelectorActividades(): array
	{
		$consulta = $this->conexion->conectarse()->prepare("SELECT id,nombre_segmento FROM actividades  ");
		$consulta->execute();
		return $consulta->fetchAll();
	}
	public function obtenerDatosActualizables($proceso)
	{
		$consulta = $this->conexion->conectarse()->prepare("SELECT *  FROM procesos WHERE id = ?  ");
		$consulta->execute([$proceso->getId()]);
		$array = $consulta->fetch();
		$proceso->setId($array["id"]);
		$proceso->setObjeto($array["objeto"]);
		$proceso->setNombre_responsable($array["nombre_responsable"]);
		$proceso->setDescripcion($array["descripcion"]);
		$proceso->setMoneda($array["moneda"]);
		$proceso->setPresupuesto($array["presupuesto"]);
		$proceso->setEstado($array["estado"]);
		$proceso->setFechaInicio($array["fecha_inicio"]);
		$proceso->setHoraInicio($array["hora_inicio"]);
		$proceso->setFechaFin($array["fecha_fin"]);
		$proceso->setHoraFin($array["hora_fin"]);
		$proceso->setActividades_id($array["actividades_id"]);
	}

	public function datosActualizacion($proceso)
	{
		$sql = "
		UPDATE procesos SET  
		objeto = ?,
		nombre_responsable = ?,
		descripcion = ?,
		moneda =  ?,
		presupuesto = ?,
		fecha_inicio = ?,
		hora_inicio = ?,
		fecha_fin = ?,
		hora_fin = ?,
		actividades_id = ?
		WHERE  id = ? ";
		$preparar = $this->conexion->conectarse()->prepare($sql);
		$preparar->execute(
			[
				$proceso->getObjeto(),
				$proceso->getNombre_responsable(),
				$proceso->getDescripcion(),
				$proceso->getMoneda(),
				$proceso->getPresupuesto(),
				$proceso->getFechaInicio(),
				$proceso->getHoraInicio(),
				$proceso->getFechaFin(),
				$proceso->getHoraFin(),
				$proceso->getActividades_id(),
				$proceso->getId(),
			]
		);

		return true;
	}


	public function subirDocumento($documento, $proceso)
	{
		$preparar = $this->conexion->conectarse()->prepare("INSERT INTO documentos
	
		 VALUES (?,?,?,?,?) ");

		$preparar->execute(
			[
				null,
				$documento->getTitulo_documento(),
				$documento->getDescriptcion_documento(),
				$documento->getNombre_documento(),
				$documento->getUbicacion_documento()
			]
		);

		$prepararSql2 = $this->conexion->conectarse()->prepare(" SELECT max(id) as id FROM documentos  ");
		$prepararSql2->execute();
		$idDocumento = $prepararSql2->fetch();
		$prepararSql3 = $this->conexion->conectarse()->prepare("INSERT INTO doc_procesos VALUES (?,?,?) ");
		$prepararSql3->execute([null,$proceso->getId(), $idDocumento["id"]]);
		return false;
	}

	function obtenerDocumentos($id){
		$sql = " SELECT * FROM doc_procesos dp
		INNER JOIN documentos d  ON  d.id = dp.id_documentos  WHERE dp.id_proceso  = '".$id."' " ;
		$prepare = $this->conexion->conectarse()->prepare($sql);


		$prepare->execute();
		return $prepare->fetchAll();
	
	}
}