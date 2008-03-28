<?php
require_once './application/secciones/models/Secciones.php';
require_once './application/usuarios/models/Usuarios.php';

class Secciones_AdminController extends Zsurforce_Generic_Controller 
{
	function preDispatch()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->usuarioLogueado = true;
		}
		$this->view->base_path = Zend_Registry::get('base_path');
	}
	public	function	indexAction() 
	{
		$secciones = new Secciones();
		$where = array();
		$order = "id_seccion";
		$this->view->secciones = $secciones->fetchAll($where, $order);
		$this->render();
	}
	public	function agregarAction()
	{
		$this->view->action	=	$this->view->baseUrl.'/secciones/admin/agregar';
		$this->view->titulo	=	'Agregar Seccion';
		$this->user = Zend_Auth::getInstance()->getIdentity();
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		$secciones	=	new	Secciones();
		if ($this->_request->isPost()) {
			$request = $this->_getPostsFiltered();
			if(isset($request['nombre'])){
				$id_seccion = 
					$secciones->insert(array(
						'nombre'=>$request['nombre']
					));
			}
			$this->_redirect('/secciones/admin/');
		}else{
			$where = " estado=1 ";
			$order = "nombre";
			$this->view->secciones = $secciones->fetchAll($where, $order);
		}
	}
	public	function modificarAction()
	{
		
		$this->view->action	=	$this->view->baseUrl.'/secciones/admin/modificar/';
		$this->view->titulo	=	'Modificar Seccion';
		$this->user = Zend_Auth::getInstance()->getIdentity();
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		$secciones	=	new	Secciones();
		$request = $this->_getPostsFiltered();
		if ($this->_request->isPost()) {
			if(isset($request['nombre'])){
				$where	=	" id_seccion=".$request['id_seccion'];
				$secciones->update(array(
						'nombre'=>$request['nombre'],
					),$where);
			}
			$this->_redirect('/secciones/admin/');
		}else{
			$where = " estado=1 ";
			$order = "nombre";
			$this->view->secciones = $secciones->fetchAll($where, $order);
			$where = " id_seccion=".$request['id_seccion'];
			$seccion = $secciones->fetchRow($where);
			$this->view->seccion_id_seccion	=	$seccion->id_seccion;
			$this->view->seccion_nombre	=	$seccion->nombre;
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
}
