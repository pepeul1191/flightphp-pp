<?php

class componenteController extends Controller
{
	private $_id;
	private $_repositorio_id;
	private $_tecnologia_id;
	private $_repositorio_version;

	public function __construct($peticion)
    {
        parent::__construct($peticion);
        $this->_componentes = $this->load_model('componentes');
    }

    public function listar()
    {
        echo json_encode($this->_componentes->listar());
    }

    public function guardar()
    {
        $data = json_decode($this->get_param('data'));
        $nuevos = $data->{'nuevos'};
        $editados = $data->{'editados'};
        $eliminados = $data->{'eliminados'};

        try {
           $array_nuevos = array();

           if(!empty($nuevos)){
              foreach ($nuevos as $nuevo) {
                  $temp_id = $nuevo->{'id'};
                  $repositorio_id  = $nuevo->{'repositorio_id'};
                  $tecnologia_id = $nuevo->{'tecnologia_id'};
                  $repositorio_version = $nuevo->{'repositorio_version'};

                  $id_generado = $this->crear($repositorio_id, $tecnologia_id, $repositorio_version);
                  array_push($array_nuevos, json_encode(array('temporal' => $temp_id, 'nuevo_id' => $id_generado)));
              }
           }

           if(!empty($editados)){
              foreach ($editados as $editado) {
                  $id = $editado->{'id'};
                  $repositorio_id  = $editado->{'repositorio_id'};
                  $tecnologia_id = $editado->{'tecnologia_id'};
                  $repositorio_version = $editado->{'repositorio_version'};

                  $this->editar($id, $repositorio_id, $tecnologia_id, $repositorio_version);
              }
           }

           if(!empty($eliminados)){
              foreach ($eliminados as $id) {
                    $this->eliminar($id);
              }
           }

           $rpta = array('tipo_mensaje' => 'success', 'mensaje' => array("Se ha registrado los cambios en los componentes", $array_nuevos));
       } catch (Exception $e) {
           $rpta = array('tipo_mensaje' => 'error', 'mensaje' => array("Se ha producido un error en guardar la tabla de componentes", $e->getMessage()));
       }

       echo json_encode($rpta);
    }

    public function crear($repositorio_id, $tecnologia_id, $repositorio_version)
    {
        $this->_componentes->crear($repositorio_id, $tecnologia_id, $repositorio_version);
        return $this->_componentes->id_generado();
    }

    public function editar($id, $repositorio_id, $tecnologia_id, $repositorio_version)
    {
        $this->_componentes->editar($id, $repositorio_id, $tecnologia_id, $repositorio_version);
    }

    public function eliminar($id)
    {
        $this->_componentes->eliminar($id);
    }
}

?>