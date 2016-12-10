<?php

class tecnologiasModel extends Model
{

	public function __construct(){
		parent::__construct();
	}

	public function listar()
	{
		$stmt = $this->_db->prepare("SELECT * FROM tecnologias;");
		$stmt->execute();
		$rpta = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rpta;
	}

	public function crear($nombre, $url, $descripcion)
	{
		$stmt = $this->_db->prepare("INSERT INTO  tecnologias (nombre, url, descripcion) VALUES (:nombre, :url, :descripcion);");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':url', $url);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->execute();

		return $this->id_generado();
	}

	public function editar($id, $nombre, $url, $descripcion)
	{
		$stmt = $this->_db->prepare("UPDATE  tecnologias SET nombre = :nombre, url = :url, descripcion = :descripcion WHERE id = :id;");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':url', $url);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->execute();
	}

	public function eliminar($id)
	{
		$stmt = $this->_db->prepare("DELETE FROM tecnologias WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	public function listar_select()
	{
		$stmt = $this->_db->prepare("SELECT id, nombre FROM tecnologias;");
		$stmt->execute();
		$rpta = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rpta;
	}
}

?>