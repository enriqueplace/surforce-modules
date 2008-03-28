<?php
// FIXME!
require_once './application/secciones/models/Secciones.php';

class Secciones_IndexController extends Zsurforce_Generic_Controller{
	
	function indexAction()
	{
		$secciones = new Secciones();
		$where = array();
		$order = "id_seccion";
		$this->view->secciones = $secciones->fetchAll($where, $order);

		$this->view->base_path = Zend_Registry::get('base_path');

		$this->render();
	}

}
?>
