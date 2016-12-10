<?php

class hubsModel extends Model
{
	public function __construct(){
		parent::__construct();
	}

	public function listar()
	{
		$stmt = $this->_db->prepare("SELECT * FROM hubs;");
		$stmt->execute();
		$rpta = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rpta;
	}

	public function crear($nombre, $url)
	{
		$stmt = $this->_db->prepare("INSERT INTO  hubs (nombre, url) VALUES (:nombre, :url);");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':url', $url);
		$stmt->execute();

		return $this->id_generado();
	}

	public function editar($id, $nombre, $url)
	{
		$stmt = $this->_db->prepare("UPDATE  hubs SET nombre = :nombre, url = :url WHERE id = :id;");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':url', $url);
		$stmt->execute();
	}

	public function eliminar($id)
	{
		$stmt = $this->_db->prepare("DELETE FROM hubs WHERE id = :id;");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	public function listar_select()
	{
		$stmt = $this->_db->prepare("SELECT id, CONCAT(nombre, ', ', url) AS nombre FROM hubs;");
		$stmt->execute();
		$rpta = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rpta;
	}
}

?>