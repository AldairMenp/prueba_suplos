<?php

class procesos
{

	private int $id;
	private string $objeto;
	private string $descripcion;
	private string $moneda;
	private float $presupuesto;

	private string $fechaInicio;
	private string $horaInicio;
	private string $fechaFin;
	private string $horaFin;
	private string $nombre_responsable;

	private  $estado;

	private int $actividades_id;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getObjeto()
	{
		return $this->objeto;
	}

	public function setObjeto($objeto)
	{
		$this->objeto = $objeto;
	}

	public function getDescripcion()
	{
		return $this->descripcion;
	}

	public function setDescripcion($descripcion)
	{
		$this->descripcion = $descripcion;
	}


	public function getMoneda()
	{
		return $this->moneda;
	}

	public function setMoneda($moneda)
	{
		$this->moneda = $moneda;
	}

	public function getPresupuesto()
	{
		return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
		$this->presupuesto = $presupuesto;
	}
	public function getFechaInicio()
	{
		return $this->fechaInicio;
	}

	public function setFechaInicio($fechaInicio)
	{
		$this->fechaInicio = $fechaInicio;
	}

	public function getHoraInicio()
	{
		return $this->horaInicio;
	}

	public function setHoraInicio($horaInicio)
	{
		$this->horaInicio = $horaInicio;
	}

	public function getFechaFin()
	{
		return $this->fechaFin;
	}

	public function setFechaFin($fechaFin)
	{
		$this->fechaFin = $fechaFin;
	}

	public function getHoraFin()
	{
		return $this->horaFin;
	}

	public function setHoraFin($horaFin)
	{
		$this->horaFin = $horaFin;
	}

	public function getActividades_id()
	{
		return $this->actividades_id;
	}

	public function setActividades_id($actividades_id)
	{
		$this->actividades_id = $actividades_id;
	}

	public function getNombre_responsable()
	{
		return $this->nombre_responsable;
	}

	public function setNombre_responsable($nombre_responsable)
	{
		$this->nombre_responsable = $nombre_responsable;
	}

	public function getEstado()
	{
		return $this->estado;
	}

	public function setEstado($estado)
	{
		$this->estado = $estado;
	}
}
