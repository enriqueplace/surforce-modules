<?php
require_once './application/conceptos/models/Conceptos.php';
require_once './application/usuarios/models/Usuarios.php';

class Conceptos_AdminController extends Zsurforce_Generic_Controller 
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
	}
	public	function	indexAction() 
	{
		$conceptos = new Conceptos();
		$where = array();
		$order = "id_concepto";
		$this->view->conceptos = $conceptos->fetchAll($where, $order);
		$this->render();
	}
	public	function agregarAction()
	{
		$this->view->action	=	$this->view->baseUrl.'/conceptos/admin/agregar';
		$this->view->titulo	=	'Agregar Concepto';
		$this->user = Zend_Auth::getInstance()->getIdentity();
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		$conceptos	=	new	Conceptos();
		if ($this->_request->isPost()) {
			$request = $this->_getPostsFiltered();
			if(isset($request['nombre'])){
				$id_concepto = 
					$conceptos->insert(array(
						'nombre'=>$request['nombre'],
						'id_usuario'=>$usuario->id_usuario
					));
			}
			$this->_redirect('/conceptos/admin/');
		}
	}
	public	function modificarAction()
	{
		$this->view->action	=	$this->view->baseUrl.'/conceptos/admin/modificar/';
		$this->view->titulo	=	'Modificar Concepto';
		$this->user = Zend_Auth::getInstance()->getIdentity();
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		$conceptos	=	new	Conceptos();
		$request = $this->_getPostsFiltered();
		if ($this->_request->isPost()) {
			if(isset($request['nombre'])){
				$where	=	" id_concepto=".$request['id_concepto'];
				$conceptos->update(array(
						'nombre'=>$request['nombre']
					),$where);
			}
			$this->_redirect('/conceptos/admin/');
		}else{
			$where = " id_concepto=".$request['id_concepto']." AND estado=1 ";
			$concepto = $conceptos->fetchRow($where);
			$this->view->concepto_id_concepto	=	$concepto->id_concepto;
			$this->view->concepto_nombre	=	$concepto->nombre;
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
	private	function	_agregarTags($tags,$id_concepto)
	{
		if($id_concepto >0 && $tags!=''){
			$conceptos_tags	=	new	Conceptos_tags();
			$where	=	" id_concepto='$id_concepto'";
			$conceptos_tags->delete($where);
			$tags	=	explode(',',$tags);
			foreach($tags as $tag){
				$conceptos_tags->insert(array(
					'id_concepto'=>$id_concepto,
					'tag'=>trim($tag)
				));
			}
		}				
	}
}
