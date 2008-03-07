<?php

// FIXME!
require_once './application/contactoskype/models/Contactoskype.php';
require_once ("Zend/Translate.php");
class Contactoskype_AdminController extends Zsurforce_Generic_Controller {
	
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
	
	public function indexAction() {
		$contactoskype = new Contactoskype ( );
		$where = array ( );
		$order = "id";
		$this->view->contactosskype = $contactoskype->fetchAll ( $where, $order );
		
		$this->view->base_path = Zend_Registry::get ( 'base_path' );
		
		$this->render ();
	}
	
	function agregarAction() {
		if ($this->_request->isPost ()) {
			$p = $this->getPostsFiltered ();
			
			$contactosskype = new Contactoskype ( );
			
			if (isset ( $p ['nombre'] ) && isset ( $p ['usuarioskype'] )) {
				
				$resultado = $contactosskype->agregarContactoSkype ( $p ['nombre'], $p ['usuarioskype'] );
			
			}
			
			echo $resultado;
		}
	}
	function modificarAction() {
		$idContactoSkype = ( int ) $this->_request->getParam ( 'id' );
		if ($this->_request->isPost ()) {
			$p = $this->getPostsFiltered ();
			$contactosskype = new Contactoskype ( );
			//echo $p['idContactoSkype'];
			//die();
			if (isset ( $p ['nombre'] ) && isset ( $p ['usuarioskype'] )) {
				
				$contactosskype->modificarContactoSkype ( $p ['idContactoSkype'], $p ['nombre'], $p ['usuarioskype'] );
			
			}
			
			$this->_redirect ( './contactoskype/admin' );
		} else {
			echo $idContactoSkype;
			$contactoskype = new Contactoskype ( );
			$this->view->contactoSkype = $contactoskype->fetchRow ( 'id = ' . $idContactoSkype );
		
		}
	}
	function eliminarAction() {
		
		$idContactoSkype = ( int ) $this->_request->getParam ( 'id' );
		$contactosskype = new Contactoskype ( );
		$contactosskype->eliminarContactoSkype ( $idContactoSkype );
		$this->_redirect ( './contactoskype/admin' );
	
	}
	
	function getPostsFiltered() {
		
		$parmsPost = array ( );
		
		Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
		$f = new Zend_Filter_StripTags ( );
		
		foreach ( $this->_request->getParams () as $key => $value ) {
			$parmsPost [$key] = $f->filter ( $value );
		}
		
		return $parmsPost;
	}
}
