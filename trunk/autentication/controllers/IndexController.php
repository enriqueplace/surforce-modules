<?php
// FIXME!
require_once './application/autentication/models/Autentication.php';

class Autentication_IndexController extends Zsurforce_Generic_Controller{
	public	function indexAction()
	{
		$autentication = new Autentication();
		$where = array();
		$order = "id_usuario";
		$this->view->Autentication = $autentication->fetchAll($where, $order);
		$this->view->base_path = Zend_Registry::get('base_path');
		$this->render();
	}
}
?>
