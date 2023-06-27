<?php


class documentos{
    
    private  int $id;	
    private  string $titulo_documento;	
    private  string $descriptcion_documento;
    private  string $nombre_documento;
    private  string $ubicacion_documento;

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getTitulo_documento(){
		return $this->titulo_documento;
	}

	public function setTitulo_documento($titulo_documento){
		$this->titulo_documento = $titulo_documento;
	}

	public function getDescriptcion_documento(){
		return $this->descriptcion_documento;
	}

	public function setDescriptcion_documento($descriptcion_documento){
		$this->descriptcion_documento = $descriptcion_documento;
	}

	public function getNombre_documento(){
		return $this->nombre_documento;
	}

	public function setNombre_documento($nombre_documento){
		$this->nombre_documento = $nombre_documento;
	}

	public function getUbicacion_documento(){
		return $this->ubicacion_documento;
	}

	public function setUbicacion_documento($ubicacion_documento){
		$this->ubicacion_documento = $ubicacion_documento;
	}
}
?>
