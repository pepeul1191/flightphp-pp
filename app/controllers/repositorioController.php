<?php

class repositorioController extends Controller
{
    private $_id;
    private $_nombre;
    private $_url;
    private $_trunk;
    private $_hub_id;

    public function __construct($peticion)
    {
        parent::__construct($peticion);
        $this->_repositorios = $this->load_model('repositorios');
    }

    public function listar()
    {
        echo json_encode($this->_repositorios->listar());
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
                  $nombre = $nuevo->{'nombre'};
                  $url = $nuevo->{'url'};
                  $trunk = $nuevo->{'trunk'};
                  $hub_id = $nuevo->{'hub_id'};

                  $id_generado = $this->crear($nombre, $url, $trunk, $hub_id);
                  array_push($array_nuevos, json_encode(array('temporal' => $temp_id, 'nuevo_id' => $id_generado)));
              }
           }

           if(!empty($editados)){
              foreach ($editados as $editado) {
                  $id = $editado->{'id'};
                  $nombre = $editado->{'nombre'};
                  $url = $editado->{'url'};
                  $trunk = $editado->{'trunk'};
                  $hub_id = $editado->{'hub_id'};

                  $this->editar($id, $nombre, $url, $trunk, $hub_id);
              }
           }

           if(!empty($eliminados)){
              foreach ($eliminados as $id) {
                    $this->eliminar($id);
              }
           }

           $rpta = array('tipo_mensaje' => 'success', 'mensaje' => array("Se ha registrado los cambios en el registro de repositorios", $array_nuevos));
       } catch (Exception $e) {
           $rpta = array('tipo_mensaje' => 'error', 'mensaje' => array("Se ha producido un error en guardar la tabla de en el registro de repositorios", $e->getMessage()));
       }

       echo json_encode($rpta);
    }

    public function crear($nombre, $url, $trunk, $hub_id)
    {
        $this->_repositorios->crear($nombre, $url, $trunk, $hub_id);
        return $this->_repositorios->id_generado();
    }

    public function editar($id, $nombre, $url, $trunk, $hub_id)
    {
        $this->_repositorios->editar($id, $nombre, $url, $trunk, $hub_id);
    }

    public function eliminar($id)
    {
        $this->_repositorios->eliminar($id);
    }

    public function listar_select()
    {
        echo json_encode($this->_repositorios->listar_select());
    }
}

?>