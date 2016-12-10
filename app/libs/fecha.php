<?php

class fecha{
	private $_dia;
	private $_mes;
	private $_anio;

	public function __construct() {

	}

	public function constructor_DDMMYYY($string_fecha = false){
		if(!$string_fecha){
			$string_fecha = date("d/m/Y");
		}

		if(!$this->countSlash($string_fecha)){
			$mensaje['tipoMensajeControl'] = "text-error";
		                $mensaje['mensajeControl'] = "Error en el separador de fecha";
		                echo json_encode($mensaje); exit();
		}

		if(strlen($string_fecha)!=10){
			$mensaje['tipoMensajeControl'] = "text-error";
		                $mensaje['mensajeControl'] = "Longitud de la fecha inválida.";
		                echo json_encode($mensaje); exit();
		}

		$this->_dia = substr($string_fecha,0,2);
		$this->_mes = substr($string_fecha, 3,2);
		$this->_anio = substr($string_fecha, 6,4);
	}

	public function dias_transcurridos($string_primero,$string_ultimo=false){
		if(!$string_ultimo){
			$string_ultimo = date("Y-m-d");
		}
		
		$dia = substr($string_primero,0,2);
		$mes = substr($string_primero, 3,2);
		$anio = substr($string_primero, 6,4);

		$primero = date_create($mes."/".$dia."/".$anio);
		$ultimo = date_create($string_ultimo);
		//$primero=date_create("2013-03-15");
		//$ultimo=date_create("2013-12-12");
		//var_dump("primero");var_dump($primero);var_dump("ultimo");var_dump($ultimo);var_dump("......................");exit();

		$diferencia = date_diff($primero,$ultimo);
		return $diferencia;
	}

    	public function string_a_mysql_date(){		
		return $this->_anio."-".$this->_mes."-".$this->_dia;
	}

	public function string_html(){
		return $this->_dia."/".$this->_mes."/".$this->_anio;
	}

	public function get_anio(){
		return $this->_anio;
	}

	private function countSlash($param){
		$num = 0;
		$result = false;
		for($x=0;$x<strlen($param);$x++){
			if($param[$x]=="/"){
			$num++;
			}
		}
		if($num==2){
			$result = true;
		}
		return $result;
	}

}

?>