<?php
// FIXME!
require_once './application/contactoskype/models/Contactoskype.php';
require_once './application/contactoskype/models/ParametrosContactoSkype.php';
require_once ("Zend/Translate.php");

class Contactoskype_IndexController extends Zsurforce_Generic_Controller {
	function init() {
		parent::init ();
		$this->view->scriptJs = "prototype";
		$lenguage = Zend_Registry::get ( 'config_sys' )->regional->lenguage;
		try {
			$translate = new Zend_Translate ( 'csv', './application/contactoskype/views/lenguage/' . $lenguage . '.csv', $lenguage );
		} catch ( Exception $e ) {
			// File not found, no adapter class...
			// General failure
			$lenguage = "es";
			$translate = new Zend_Translate ( 'csv', $this->view->base_path . '/application/contactoskype/views/lenguage/' . $lenguage . '.csv', $lenguage );
		}
		//Construyo de forma din�mica los textos para mostrar en la vista 
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
		
		//C�digo necesario para implementar la traduccion del sistema
		

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
	
	function asignaoperadorAction() {
		
		$contactosSkype = new Contactoskype ( );
		$parametroContactoSkype = new ParametrosContactoSkype ( );
		$ultimoId = $parametroContactoSkype->fetchRow ()->idskypeasignado;
		$where = "id <> " . $ultimoId . " AND estado <> 'ocupado'";
		//Traigo todos menos el último asignado
		$disponibles = $contactosSkype->fetchAll ( $where );
		
		foreach ( $disponibles as $usuario ) {
			
			$remote_status = fopen ( 'http://mystatus.skype.com/' . $usuario->usuarioskype . '.num', 'r' );
			if (! $remote_status) {
				return '0';
				exit ();
			}
			while ( ! feof ( $remote_status ) ) {
				
				$value = fgets ( $remote_status, 1024 );
				
				if ($value == 2) {
					$html = $this->view->avaliableoperator . ": " . $usuario->nombre;
					$llamada = '<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT">
									window.location ="skype:' . $usuario->usuarioskype . '?call";
	 							</SCRIPT>';
					
					$parametroContactoSkype->updateIdAsignado ( $ultimoId, $usuario->id );
					
					$this->view->llamada = $llamada;
					return $this->view->retorno = $html;
				
				} else {
					$parametroContactoSkype->updateIdAsignado ( $ultimoId, 0 );
					$this->view->retorno = $this->view->notavaliableoperator;
				}
			
			}
			fclose ( $remote_status );
		
		}
		
		$this->render ();
	}
	function cambiarestadoAction() {
		
		$this->_helper->viewRenderer->setNoRender ();
		$operador = $this->_request->getParam ( 'id', "" );
		$estado = $this->_request->getParam ( 'estado', "" );
		
		$contactoSkype = new Contactoskype ( );
		$contactoSkype->cambiarEstado ( $operador, $estado );
		
		if ($estado == "ocupado") {
			$estado = $this->view->busy;
		}
		if ($estado == "libre") {
			
			$estado = $this->view->avaliable;
		}
		
		$response = $estado;
		
		$this->_response->appendBody ( $response );
	
	}
	
	function operadorAction() {
		$idContactoSkype = $this->_request->getParam ( 'id', "" );
		$contactoSkype = new Contactoskype ( );
		$this->view->contactoSkype = $contactoSkype->buscarContactoSkype ( $idContactoSkype );
		if ($this->view->contactoSkype->estado == "ocupado") {
			$this->view->showstatus = $this->view->busy;
		}
		if ($this->view->contactoSkype->estado == "libre") {
			$this->view->showstatus = $this->view->avaliable;
		}
		$this->render ();
	}
}
?>
