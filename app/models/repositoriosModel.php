<?php

class repositoriosModel extends Model
{
	public function __construct(){
		parent::__construct();
	}

	public function listar()
	{
		$stmt = $this->_db->prepare("SELECT * FROM repositorios;");
		$stmt->execute();
		$rpta = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rpta;
	}

	public function crear($nombre, $url, $trunk, $hub_id)
	{
		$stmt = $this->_db->prepare("INSERT INTO  repositorios (nombre, url, trunk, hub_id) VALUES (:nombre, :url, :trunk, :hub_id);");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':url', $url);
		$stmt->bindParam(':trunk', $trunk);
		$stmt->bindParam(':hub_id', $hub_id);
		$stmt->execute();

		return $this->id_generado();
	}

	public function editar($id, $nombre, $url, $trunk, $hub_id)
	{
		$stmt = $this->_db->prepare("UPDATE  repositorios SET nombre = :nombre, url = :url, trunk = :trunk, hub_id = :hub_id WHERE id = :id;");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':url', $url);
		$stmt->bindParam(':trunk', $trunk);
		$stmt->bindParam(':hub_id', $hub_id);
		$stmt->execute();
	}

	public function eliminar($id)
	{
		$stmt = $this->_db->prepare("DELETE FROM repositorios WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	public function listar_select()
	{
		$stmt = $this->_db->prepare("SELECT R.id, CONCAT(R.nombre, ' - ',H.nombre) AS nombre FROM repositorios R INNER JOIN hubs H ON R.hub_id = H.id;");
		$stmt->execute();
		$rpta = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rpta;
	}
}

?>