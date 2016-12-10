<?php

class tecnologiaController extends Controller
{
    private $_id;
    private $_nombre;
    private $_url;
    private $_descripcion;

    public function __construct($peticion)
    {
        parent::__construct($peticion);
        $this->_tecnologias = $this->load_model('tecnologias');
    }

    public function listar()
    {
        echo json_encode($this->_tecnologias->listar());
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
                  $descripcion = $nuevo->{'descripcion'};

                  $id_generado = $this->crear($nombre, $url, $descripcion);
                  array_push($array_nuevos, json_encode(array('temporal' => $temp_id, 'nuevo_id' => $id_generado)));
              }
           }

           if(!empty($editados)){
              foreach ($editados as $editado) {
                  $id = $editado->{'id'};
                  $nombre = $editado->{'nombre'};
                  $url = $editado->{'url'};
                  $descripcion = $editado->{'descripcion'};

                  $this->editar($id, $nombre, $url, $descripcion);
              }
           }

           if(!empty($eliminados)){
              foreach ($eliminados as $id) {
                    $this->eliminar($id);
              }
           }

           $rpta = array('tipo_mensaje' => 'success', 'mensaje' => array("Se ha registrado los cambios en el registro de tecnologías", $array_nuevos));
       } catch (Exception $e) {
           $rpta = array('tipo_mensaje' => 'error', 'mensaje' => array("Se ha producido un error en guardar la tabla de en el registro de tecnologías", $e->getMessage()));
       }

       echo json_encode($rpta);
    }

    public function crear($nombre, $url, $descripcion)
    {
        $this->_tecnologias->crear($nombre, $url, $descripcion);
        return $this->_tecnologias->id_generado();
    }

    public function editar($id, $nombre, $url, $descripcion)
    {
        $this->_tecnologias->editar($id, $nombre, $url, $descripcion);
    }

    public function eliminar($id)
    {
        $this->_tecnologias->eliminar($id);
    }

    public function listar_select()
    {
        echo json_encode($this->_tecnologias->listar_select());
    }
}

?>