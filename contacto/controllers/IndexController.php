<?php
// FIXME!
require_once './application/contacto/models/Contacto.php';

class Contacto_IndexController extends Zsurforce_Generic_Controller{
	
	function indexAction()
	{
		$contacto = new Contacto();
		$where = array();
		$order = "id";
		$this->view->contactos = $contacto->fetchAll($where, $order);

		$this->view->base_path = Zend_Registry::get('base_path');

		$this->render();
	}

}
?>
