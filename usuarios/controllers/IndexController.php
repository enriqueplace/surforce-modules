<?php
require_once './application/usuarios/models/Usuarios.php';
require_once ("Zend/Translate.php");
class Usuarios_IndexController extends Zsurforce_Generic_Controller {
	function init() {
		parent::init ();
		Zend_Loader::loadClass ( 'Usuarios' );
		$lenguage = Zend_Registry::get ( 'config_sys' )->regional->lenguage;
		try {
			$translate = new Zend_Translate ( 'csv', './application/usuarios/views/lenguage/' . $lenguage . '.csv', $lenguage );
		} catch ( Exception $e ) {
			// File not found, no adapter class...
			// General failure
			$lenguage = "es";
			$translate = new Zend_Translate ( 'csv', $this->view->base_path . '/application/usuarios/views/lenguage/' . $lenguage . '.csv', $lenguage );
		}
		//Construyo de forma din�mica los textos para mostrar en la vista 
		//de acuerdo a lo ingresado en el archivo de idioma
		foreach ( $translate->getAdapter ()->getMessageIds () as $identificador ) {
			$this->view->$identificador = $translate->_ ( $identificador, $lenguage );
		}
	}
	function preDispatch() {
		$auth = Zend_Auth::getInstance ();
		
	// if ($auth->hasIdentity()) {
	//    $this->view->usuarioLogueado = true;
	//}else{
	//  die( "Acceso Restringido");
	//}
	}
	
	function indexAction() {
		$usuarios = new Usuarios ( );
		$this->view->usuarios = $usuarios->fetchAll ();
		$this->render ();
	}
	
	
}
?>