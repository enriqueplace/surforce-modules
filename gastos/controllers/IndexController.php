<?php
require_once './application/gastos/models/Gastos.php';

class Gastos_IndexController extends Zsurforce_Generic_Controller{
	
	function indexAction()
	{
		$gastos = new Gastos();
		$where = array();
		$order = "id_gasto";
		$this->view->gastos = $gastos->fetchAll($where, $order);

		$this->view->base_path = Zend_Registry::get('base_path');

		$this->render();
	}

}
?>
