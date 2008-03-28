<?php
require_once './application/conceptos/models/Conceptos.php';

class Conceptos_IndexController extends Zsurforce_Generic_Controller{
	
	function indexAction()
	{
		$conceptos = new Conceptos();
		$where = array();
		$order = "id_noticia";
		$this->view->noticias = $noticias->fetchAll($where, $order);

		$this->view->base_path = Zend_Registry::get('base_path');

		$this->render();
	}

}
?>
