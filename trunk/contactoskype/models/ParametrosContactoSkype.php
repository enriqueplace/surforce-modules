<?php
class ParametrosContactoSkype extends Zend_Db_Table {
	
	//Indicamos el nombre de la tabla para que la gestione.
	//Se asume que la tabla tiene una PK Autoincrementable.
	protected $_name = 'parametroscontactoskype';
	
	function updateIdAsignado($ultimoId, $id) {
		$where = 'idskypeasignado = ' . $ultimoId;
		$resultado = $this->update ( array ('idskypeasignado' => $id ), $where );
		
		return $resultado;
	}
	
	
}
?>
