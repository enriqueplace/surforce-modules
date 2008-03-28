<?php
require_once './application/tipos_gastos/models/Tipo_gastos.php';
require_once './application/usuarios/models/Usuarios.php';
require_once './application/conceptos/models/Conceptos.php';

class Tipos_gastos_AdminController extends Zsurforce_Generic_Controller 
{
	function preDispatch()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->usuarioLogueado = true;
		}else{
			$this->_redirect('/default/');
		}
		$this->view->base_path = Zend_Registry::get('base_path');
		$this->user = Zend_Auth::getInstance()->getIdentity();
	}
	public	function	indexAction() 
	{
		$tipos_gastos = new Tipo_gastos();
		$where = array();
		$order = "id_tipos_gasto";
		$conceptosInst	=	new	Conceptos();
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		
		$where = " estado=1 AND id_usuario=".$usuario->id_usuario;
		$order = "nombre";
		$conceptosRows	=	$conceptosInst->fetchAll($where, $order);
		
		$conceptosArray	=	array();
		/**
		 * Genero un array con todos los conceptos para despues 
		 * en la vista reemplazarlo con el concepto correspondiente a su id
		 */
		foreach($conceptosRows as $concepto){
			$conceptosArray[$concepto->id_concepto]	=	$concepto->nombre;
		}
		
		$this->view->conceptos	=	$conceptosArray;
	
		$where	=	array();
		$order	=	'nombre';
		$this->view->tipos_gastos = $tipos_gastos->fetchAll($where,$order);
		$this->render();
	}
	public	function agregarAction()
	{
		$this->view->action	=	$this->view->baseUrl.'/tipos_gastos/admin/agregar';
		$this->view->titulo	=	'Agregar Tipo de Gasto';
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		$tipos_gastos	=	new	Tipo_gastos();
		$conceptos	=	new	Conceptos();
		if ($this->_request->isPost()) {
			$request = $this->_getPostsFiltered();
			if(isset($request['nombre'])){
				$id_tipos_gasto = 
					$tipos_gastos->insert(array(
						'nombre'=>$request['nombre'],
						'id_concepto'=>$request['id_concepto']
					));
			}
			$this->_redirect('/tipos_gastos/admin/');
		}else{
			$where = " estado=1 ";
			$order = "nombre";
			$this->view->conceptos = $conceptos->fetchAll($where, $order);
		}
	}
	public	function modificarAction()
	{
		$this->view->action	=	$this->view->baseUrl.'/tipos_gastos/admin/modificar/';
		$this->view->titulo	=	'Modificar Tipo_gasto';
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		$tipos_gastos	=	new	Tipo_gastos();
		$conceptos	=	new	Conceptos();
		$request = $this->_getPostsFiltered();
		if ($this->_request->isPost()) {
			if(isset($request['nombre'])){
				$where	=	" id_tipos_gasto=".$request['id_tipos_gasto'];
				$tipos_gastos->update(array(
						'nombre'=>$request['nombre'],
						'id_concepto'=>$request['id_concepto']
					),$where);
			}
			$this->_redirect('/tipos_gastos/admin/');
		}else{
			$where = " id_tipos_gasto=".$request['id_tipos_gasto']." AND estado=1 ";
			$tipos_gasto = $tipos_gastos->fetchRow($where);
			$this->view->tipos_gasto_id_tipos_gasto	=	$tipos_gasto->id_tipos_gasto;
			$this->view->tipos_gasto_nombre	=	$tipos_gasto->nombre;
			$this->view->tipos_gasto_id_concepto	=	$tipos_gasto->id_concepto;
			$where = " estado=1 ";
			$order = "nombre";
			$this->view->conceptos = $conceptos->fetchAll($where, $order);

		}
	}
	public	function eliminarAction()
	{
	}
	private	function _getPostsFiltered(){
		$parmsPost = array();
		Zend_Loader::loadClass('Zend_Filter_StripTags');
		$f = new Zend_Filter_StripTags();
		foreach ($this->_request->getParams() as $key => $value){
			$parmsPost[$key]=$f->filter($value);
		}
		return $parmsPost;
	}
	private	function	_agregarTags($tags,$id_tipos_gasto)
	{
		if($id_tipos_gasto >0 && $tags!=''){
			$tipos_gastos_tags	=	new	Tipo_gastos_tags();
			$where	=	" id_tipos_gasto='$id_tipos_gasto'";
			$tipos_gastos_tags->delete($where);
			$tags	=	explode(',',$tags);
			foreach($tags as $tag){
				$tipos_gastos_tags->insert(array(
					'id_tipos_gasto'=>$id_tipos_gasto,
					'tag'=>trim($tag)
				));
			}
		}				
	}
}
