<?php
class Model{
	protected $_db;
	private $_id;
	private $_error;
	private $_messageError;
    
	public function __construct() {
	   $this->_db = new Database();
	   $this->_id = NULL;
		$this->_messageError = NULL;
		$this->_error = false;
	}

	public function id_generado()
	{
		return $this->_db->lastInsertId();
	}

}

?>
