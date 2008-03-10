<?php
class Usuarios extends Zend_Db_Table {
	
	protected $_name = 'usuarios';
	
	function agregarUsuario($username, $password, $nombre, $apellido, $emnail) {
		if ($usuario != '' && $password != '' && $nombre != '' && $apellido != '' && $email != '') {
			$data = array ('usuario' => $usuario, 'password' => $password, 'nombre' => $nombre, 'apellido' => $apellido, 'mail' => $mail, 'estado' => $estado, 'creado' => $creado );
			$this->insert ( $data );
			return true;
		} else {
			return false;
		}
	}
	
	function modificarUsuario($id, $username, $password, $nombre, $apellido, $email) {
		if ($username != '' && $password != '' && $nombre != '' && $apellido != '' && $email != '') {
			$data = array ('usuario' => $username, 'password' => $password, 'nombre' => $nombre, 'apellido' => $apellido, 'mail' => $email );
			$where = 'id = ' . $id;
			$this->update ( $data, $where );
			return true;
		}else
			{
				return false;
			}
	}
	function eliminarUsuario ($id)
		{
			$where = 'id = ' . $id;
			return $this->delete ( $where ); 
			
		}
}
?>
