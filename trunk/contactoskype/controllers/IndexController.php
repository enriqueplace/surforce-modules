<?php
// FIXME!
require_once './application/contactoskype/models/Contactoskype.php';
require_once("Zend/Translate.php");

class Contactoskype_IndexController extends Zsurforce_Generic_Controller {
function init() {
		parent::init();
		
		$lenguage = Zend_Registry::get ( 'config_sys' )->regional->lenguage;
		try {
			$translate = new Zend_Translate ( 'csv', './application/contactoskype/views/lenguaje/' . $lenguage . '.csv', $lenguage );
		} catch ( Exception $e ) {
			// File not found, no adapter class...
			// General failure
			$lenguage = "es";
			$translate = new Zend_Translate ( 'csv', $this->view->base_path . '/application/contactoskype/views/lenguaje/' . $lenguage . '.csv', $lenguage );
		}
		//Construyo de forma dinámica los textos para mostrar en la vista 
		//de acuerdo a lo ingresado en el archivo de idioma
		foreach ( $translate->getAdapter ()->getMessageIds () as $identificador ) {
			$this->view->$identificador = $translate->_ ( $identificador, $lenguage );
		}
	}
	function indexAction() {
		$contactoskype = new Contactoskype ( );
		$where = array ( );
		$order = "id";
		$this->view->contactosskype = $contactoskype->fetchAll ( $where, $order );
		
		$this->view->base_path = Zend_Registry::get ( 'base_path' );
		$this->view->scriptJs = "prototype";
		
		
		//Código necesario para implementar la traduccion del sistema
		
		
	    
	    		
		$this->render ();
	}
	
	function dibujarAction() {
		$usuarioSkype = $this->_request->getParam ( 'usuarioskype' );
		$this->view->html = '<div id="divLlamada' . $usuarioSkype . '">
				<a href="skype:' . $usuarioSkype . '?call" onclick="return skypeCheck();">
				<img src="http://mystatus.skype.com/bigclassic/' . $usuarioSkype . '" 
				style="border: none;" width="182" height="44" alt="Estado online" /></a>
				</div>';
		$this->render ();
	}

}
?>
