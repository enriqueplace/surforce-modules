<?php
require_once './application/contacto/models/Contacto.php';
require_once 'Zend/Mail.php';
class Contacto_AdminController extends Zsurforce_Generic_Controller {
	public $config_app;
	function init() {
		parent::init ();
		Zend_Loader::loadClass ( 'Contacto' );
		$this->config_app = Zend_Registry::get ( "config_app" );
	}
	function indexAction() {
		//Obtenemos las etiquetas que necesitemos del archivo config.ini
		

		$this->view->buttonText = $this->config_app->personalizacion->sitio->contacto->agregar->buttonText;
		$this->view->subtitle = $this->config_app->personalizacion->sitio->contacto->agregar->titulo;
		$contacto = new Contacto ( );
	}
	function agregarAction() {
		// $this->view->subtitle = $this->info->sitio->contacto->agregar->titulo;
		if ($this->_request->isPost ()) {
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ( );
			$nombre = trim ( $filter->filter ( $this->_request->getPost ( 'nombre' ) ) );
			$email = trim ( $filter->filter ( $this->_request->getPost ( 'email' ) ) );
			$comentario = trim ( $filter->filter ( $this->_request->getPost ( 'comentario' ) ) );
			$telefono = trim ( $filter->filter ( $this->_request->getPost ( 'telefono' ) ) );
			$fecha = date ( "Y-m-d H:i:s" );
			if ($nombre != '' && $email != '' && $comentario != '' && $telefono != '') {
				$data = array ('nombre' => $nombre, 'email' => $email, 'comentario' => $comentario, 'telefono' => $telefono, 'fecha' => $fecha );
				$contacto = new contacto ( );
				$contacto->insert ( $data );
				//Enviamos el correo.
				

				$destinatario = $email;
				$asuntoRespuesta = $this->config_app->personalizacion->sitio->contacto->add->asuntoRespuesta;
				$mensajeRespuesta = $this->config_app->personalizacion->sitio->contacto->add->mensaje;
				$asuntoContacto = $this->config_app->personalizacion->sitio->contacto->add->asuntoContacto;
				$mensajeContacto = "$nombre" . " dice: " . "$comentario";
				$emailContacto = $this->config_app->personalizacion->sitio->contacto->add->emailContacto;
				$nombreContacto = $this->config_app->personalizacion->sitio->contacto->add->nombreContacto;
				
				$mailContacto = new Zend_Mail ();
				$mailContacto->setBodyText ( $mensajeContacto );
				$mailContacto->setFrom ( $destinatario, $nombre );
				$mailContacto->addTo ( $emailContacto, $nombreContacto );
				$mailContacto->setSubject ( $asuntoContacto );
				$mailContacto->send ();
				
				$mailRespuesta = new Zend_Mail ( );
				$mailRespuesta->setBodyText ( $mensajeRespuesta );
				$mailRespuesta->setFrom ( $emailContacto, $nombreContacto );
				$mailRespuesta->addTo ( $destinatario, $nombre );
				$mailRespuesta->setSubject ( $asuntoRespuesta );
				$mailRespuesta->send ();
				
			
				
				//mail("admin@localhost",$asunto,$cuerpo,$headers);
				

				$this->view->message = " El comentario fue enviado con exito ! Muchas gracias.";
				$this->view->buttonText = $this->config_app->personalizacion->sitio->contacto->agregar->buttonText;
				
				return;
			
			} else {
				$this->view->message = "Deben completar todos los campos";
			}
		}
		
		$this->view->contacto = new stdClass ( );
		$this->view->contacto->id = null;
		$this->view->contacto->nombre = '';
		$this->view->contacto->email = '';
		$this->view->contacto->comentario = '';
		$this->view->action = $this->config_app->personalizacion->sitio->contacto->agregar->action;
		$this->view->buttonText = $this->config_app->personalizacion->sitio->contacto->agregar->buttonText;
		$this->render ();
	}

}
?>
