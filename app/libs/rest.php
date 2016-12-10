<?php

class Rest
{

   private $_rpta;
   private $_url;

    public function __construct($url)
    {
       $this->_url = $url;
    }

    public function get()
    {
       $this->_rpta = file_get_contents($this->_url);
       return $this->_rpta;
    }

    public function post()
    {
       $curl = curl_init($this->_url);
       $curl_post_data = array(
            );
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($curl, CURLOPT_POST, true);
       curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
       $this->_rpta = curl_exec($curl);
       curl_close($curl);

       return $this->_rpta;
    }
    
    public function get_rpta()
    {
       return $this->_rpta;
    }
}

?>