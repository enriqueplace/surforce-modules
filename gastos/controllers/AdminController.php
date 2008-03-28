<?php
require_once './application/gastos/models/Gastos.php';
require_once './application/usuarios/models/Usuarios.php';
require_once './application/tipos_gastos/models/Tipo_gastos.php';
require_once './application/conceptos/models/Conceptos.php';
require_once './application/gastos/models/Monedas.php';

class Gastos_AdminController extends Zsurforce_Generic_Controller 
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
		$gastos = new Gastos();
		$where = array();
		$order = "id_gasto";
		$this->view->gastos = $gastos->fetchAll($where, $order);
		$this->render();
	}
	public	function agregarAction()
	{
		$this->view->action	=	$this->view->baseUrl.'/gastos/admin/agregar';
		$this->view->titulo	=	'Agregar Gasto';
		$this->user = Zend_Auth::getInstance()->getIdentity();
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		$gastos	=	new	Gastos();
		if ($this->_request->isPost()) {
			$request = $this->_getPostsFiltered();
			if(isset($request['nombre'])){
				$id_gasto = 
					$gastos->insert(array(
						'nombre'=>$request['nombre'],
						'id_usuario'=>$usuario->id_usuario
					));
			}
			$this->_redirect('/gastos/admin/');
		}else{
			$conceptos	=	new	Conceptos();
			$monedas	=	new	Monedas();
			$tipos_gastos	=	new	Tipo_Gastos();
			$where = " estado=1 ";
			$order = "nombre";
			$this->view->conceptos = $conceptos->fetchAll($where, $order);
			$this->view->tipos_gastos	= $tipos_gastos->fetchAll($where, $order);
			$this->view->monedas	= $monedas->fetchAll($where);						
		}
	}
	public	function modificarAction()
	{
		$this->view->action	=	$this->view->baseUrl.'/gastos/admin/modificar/';
		$this->view->titulo	=	'Modificar Gasto';
		$this->user = Zend_Auth::getInstance()->getIdentity();
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		$gastos	=	new	Gastos();
		$request = $this->_getPostsFiltered();
		if ($this->_request->isPost()) {
			if(isset($request['nombre'])){
				$where	=	" id_gasto=".$request['id_gasto'];
				$gastos->update(array(
						'nombre'=>$request['nombre']
					),$where);
			}
			$this->_redirect('/gastos/admin/');
		}else{
			$where = " id_gasto=".$request['id_gasto']." AND estado=1 ";
			$gasto = $gastos->fetchRow($where);
			$this->view->gasto_id_gasto	=	$gasto->id_gasto;
			$this->view->gasto_nombre	=	$gasto->nombre;
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
	private	function	_agregarTags($tags,$id_gasto)
	{
		if($id_gasto >0 && $tags!=''){
			$gastos_tags	=	new	Gastos_tags();
			$where	=	" id_gasto='$id_gasto'";
			$gastos_tags->delete($where);
			$tags	=	explode(',',$tags);
			foreach($tags as $tag){
				$gastos_tags->insert(array(
					'id_gasto'=>$id_gasto,
					'tag'=>trim($tag)
				));
			}
		}				
	}
}
