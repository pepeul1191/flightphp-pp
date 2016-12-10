<?php

class componentesModel extends Model
{
  public function __construct(){
    parent::__construct();
  }

  public function listar()
  {
    $stmt = $this->_db->prepare("SELECT * FROM componentes;");
    $stmt->execute();
    $rpta = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $rpta;
  }

  public function crear($repositorio_id, $tecnologia_id, $repositorio_version)
  {
    $stmt = $this->_db->prepare("INSERT INTO  componentes (repositorio_id, tecnologia_id, repositorio_version) VALUES (:repositorio_id, :tecnologia_id, :repositorio_version);");
    $stmt->bindParam(':repositorio_id', $repositorio_id);
    $stmt->bindParam(':tecnologia_id', $tecnologia_id);
    $stmt->bindParam(':repositorio_version', $repositorio_version);
    $stmt->execute();

    return $this->id_generado();
  }

  public function editar($id, $repositorio_id, $tecnologia_id, $repositorio_version)
  {
    $stmt = $this->_db->prepare("UPDATE  componentes SET repositorio_id = :repositorio_id, tecnologia_id = :tecnologia_id, repositorio_version = :repositorio_version WHERE id = :id;");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':repositorio_id', $repositorio_id);
    $stmt->bindParam(':tecnologia_id', $tecnologia_id);
    $stmt->bindParam(':repositorio_version', $repositorio_version);
    $stmt->execute();
  }

  public function eliminar($id)
  {
    $stmt = $this->_db->prepare("DELETE FROM componentes WHERE id = :id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
  }
}

?>