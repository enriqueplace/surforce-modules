<?php
require_once './application/tipos_gastos/models/Tipos_gastos.php';

class Tipos_gastos_IndexController extends Zsurforce_Generic_Controller{
	
	function indexAction()
	{
		$tipos_gastos = new Tipos_gastos();
		$where = array();
		$order = "id_tipos_gasto";
		$this->view->tipos_gasto = $tipos_gasto->fetchAll($where, $order);

		$this->view->base_path = Zend_Registry::get('base_path');

		$this->render();
	}

}
?>
