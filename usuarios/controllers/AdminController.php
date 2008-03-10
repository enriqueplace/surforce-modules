<?php
require_once './application/usuarios/models/Usuarios.php';
require_once ("Zend/Translate.php");
class Usuarios_AdminController extends Zsurforce_Generic_Controller {
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
		if ($auth->hasIdentity()) {
		$this->view->usuarioLogueado = true;
		}else{
	   die( $this->view->restrictedaccess);
	 }
	}
	
	function indexAction() {
		
		$usuarios = new Usuarios ( );
		$this->view->usuarios = $usuarios->fetchAll ();
		$this->render ();
	}
	
	function agregarAction() {
		
		if ($this->_request->isPost ()) {
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ( );
			$usuario = trim ( $filter->filter ( $this->_request->getPost ( 'usuario' ) ) );
			$password = trim ( $filter->filter ( $this->_request->getPost ( 'password' ) ) );
			$nombre = trim ( $filter->filter ( $this->_request->getPost ( 'nombre' ) ) );
			$apellido = trim ( $filter->filter ( $this->_request->getPost ( 'apellido' ) ) );
			$mail = trim ( $filter->filter ( $this->_request->getPost ( 'mail' ) ) );
			$estado = "1";
			$creado = date ( "Y-m-d H:i:s" );
			$usuario = new Usuarios ( );
			
			if ($usuario != '' && $password != '' && $nombre != '' && $apellido != '' && $mail != '') {
				if ($usuario->agregarUsuario ( $usuario, $password, $nombre, $apellido, $mail )) {
					$this->_redirect ( '/usuarios/admin/' );
					return;
				} else {
					$this->view->message = "Deben llenarse todos los campos";
				}
			
			} else {
				$this->view->message = "Deben llenarse todos los campos";
			}
		}
		$this->view->usuario = new stdClass ( );
		$this->view->usuario->id = null;
		$this->view->usuario->usuario = '';
		$this->view->usuario->password = '';
		$this->view->usuario->nombre = '';
		$this->view->usuario->apellido = '';
		$this->view->usuario->mail = '';
		$this->view->action = "agregar";
		$this->render ();
	}
	
	function modificarAction() {
		//$info = Zend_Registry::get('personalizacion');
		

		$eUsuario = new Usuarios ( );
		if ($this->_request->isPost ()) {
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ( );
			$id = ( int ) $this->_request->getPost ( 'id' );
			$usuario = trim ( $filter->filter ( $this->_request->getPost ( 'usuario' ) ) );
			$password = trim ( $filter->filter ( $this->_request->getPost ( 'password' ) ) );
			$nombre = trim ( $filter->filter ( $this->_request->getPost ( 'nombre' ) ) );
			$apellido = trim ( $filter->filter ( $this->_request->getPost ( 'apellido' ) ) );
			$mail = trim ( $filter->filter ( $this->_request->getPost ( 'mail' ) ) );
			
			if ($id !== false) {
				
				if ($usuario != '' && $password != '' && $nombre != '' && $apellido != '' && $mail != '') {

					if ($eUsuario->modificarUsuario ( $id, $usuario, $password, $nombre, $apellido, $mail )) {
						$this->_redirect ( '/usuarios/admin/' );
						return;
					}else
						{
							$this->view->message = "Deben llenarse todos los campos";
						}
										
				} else {
					$this->view->usuario = $eUsuario->fetchRow ( 'id=' . $id );
					$this->view->message = "Deben llenarse todos los campos";
				}
			}
		} else {
			$id = ( int ) $this->_request->getParam ( 'id', 0 );
			if ($id > 0) {
				$this->view->usuario = $eUsuario->fetchRow ( 'id=' . $id );
			}
		}
		$this->view->action = "modificar";
		$this->render ();
	}
	
	function eliminarAction() {
		//$info = Zend_Registry::get('personalizacion');
	
		$usuario = new Usuarios ( );
		if ($this->_request->isPost ()) {
			Zend_Loader::loadClass ( 'Zend_Filter_Alpha' );
			$filter = new Zend_Filter_Alpha ( );
			$id = ( int ) $this->_request->getPost ( 'id' );
			$del = $filter->filter ( $this->_request->getPost ( 'del' ) );
			if ($del == 'Si' && $id > 0) {
				
				$rows_affected = $usuario->eliminarUsuario($id);
			}
		} else {
			$id = ( int ) $this->_request->getParam ( 'id' );
			if ($id > 0) {
				$this->view->usuario = $usuario->fetchRow ( 'id=' . $id );
				if ($this->view->usuario->id > 0) {
					$this->render ();
					return;
				}
			}
		}
		$this->_redirect ( '/usuarios/admin/' );
	}
	
	function verAction() {
		//$info = Zend_Registry::get('personalizacion');
		

		$usuario = new Usuarios ( );
		$id = ( int ) $this->_request->getParam ( 'id', 0 );
		if ($id > 0) {
			$this->view->usuario = $usuario->fetchRow ( 'id=' . $id );
		}
		$this->render ();
	}

}
?>
