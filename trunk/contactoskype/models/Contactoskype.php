<?php
class Contactoskype extends Zend_Db_Table {
	
	//Indicamos el nombre de la tabla para que la gestione.
	//Se asume que la tabla tiene una PK Autoincrementable.
	protected $_name = 'contactoskype';
	
	function agregarContactoSkype($nombre, $usuarioskype) {
		
		$resultado = $this->insert ( array ('nombre' => $nombre, 'usuarioskype' => $usuarioskype ) );
		
		return $resultado;
	}
	
	function modificarContactoSkype($idContactoSkype, $nombre, $usuarioskype) {
		$where = 'id = ' . $idContactoSkype;
		$resultado = $this->update ( array ('nombre' => $nombre, 'usuarioskype' => $usuarioskype ), $where );
		
		return $resultado;
	}
	
	function eliminarContactoSkype($idContactoSkype) {
		
		$where = 'id = ' . $idContactoSkype;
		$this->delete ( $where );
	}

	function cambiarEstado ($idContactoSkype, $estado)
		{
			$where = 'id = '. $idContactoSkype;
			$resultado = $this->update ( array ('estado' => $estado), $where);
			return $resultado;
		}
	
		function buscarContactoSkype ($idContactoSkype)
			{
				$where = 'id = '. $idContactoSkype;
				$contactoSkype = $this->fetchRow($where);
				return $contactoSkype;
			}
}
?>
