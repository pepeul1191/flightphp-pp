<?php

class hubController extends Controller
{
    private $_hubs;
    private $_nombre;
    private $_url;

    public function __construct($peticion)
    {
        parent::__construct($peticion);
        $this->_hubs = $this->load_model('hubs');
    }

    public function listar()
    {
        echo json_encode($this->_hubs->listar());
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

                  $id_generado = $this->crear($nombre, $url);
                  array_push($array_nuevos, json_encode(array('temporal' => $temp_id, 'nuevo_id' => $id_generado)));
              }
           }

           if(!empty($editados)){
              foreach ($editados as $editado) {
                  $id = $editado->{'id'};
                  $nombre = $editado->{'nombre'};
                  $url = $editado->{'url'};

                  $this->editar($id, $nombre, $url);
              }
           }

           if(!empty($eliminados)){
              foreach ($eliminados as $id) {
                    $this->eliminar($id);
              }
           }

           $rpta = array('tipo_mensaje' => 'success', 'mensaje' => array("Se ha registrado los cambios en los hubs", $array_nuevos));
       } catch (Exception $e) {
           $rpta = array('tipo_mensaje' => 'error', 'mensaje' => array("Se ha producido un error en guardar la tabla de hubs", $e->getMessage()));
       }

       echo json_encode($rpta);
    }

    public function crear($nombre, $url)
    {
        $this->_hubs->crear($nombre, $url);
        return $this->_hubs->id_generado();
    }

    public function editar($id, $nombre, $url)
    {
        $this->_hubs->editar($id, $nombre, $url);
    }

    public function eliminar($id)
    {
        $this->_hubs->eliminar($id);
    }

    public function listar_select()
    {
        echo json_encode($this->_hubs->listar_select());
    }
}

?>