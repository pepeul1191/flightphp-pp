<?php
	
class cipher extends Controller{

	private $_securekey;
	private $_iv;

	public function __construct(){
        parent::__construct();
        $this->_securekey = hash('sha256',HASH_KEY,TRUE);
        $this->_iv = mcrypt_create_iv(16);
    }
    
    public function index(){

    }

    public function encrypt($input){
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->_securekey, $input, MCRYPT_MODE_ECB, $this->_iv));
    }

    public function decrypt($input){
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->_securekey, base64_decode($input), MCRYPT_MODE_ECB, $this->_iv));
    }
}
?>