<?php
require_once './application/noticias/models/Noticias.php';
require_once './application/noticias/models/Secciones.php';
require_once './application/noticias/models/Noticias_tags.php';
require_once './application/usuarios/models/Usuarios.php';

class Noticias_AdminController extends Zsurforce_Generic_Controller 
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
		$noticias = new Noticias();
		$where = array();
		$order = "id_noticia";
		$this->view->noticias = $noticias->fetchAll($where, $order);
		$this->render();
	}
	public	function agregarAction()
	{
		$this->view->action	=	$this->view->baseUrl.'/noticias/admin/agregar';
		$this->view->titulo	=	'Agregar Noticia';
		$this->user = Zend_Auth::getInstance()->getIdentity();
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		$secciones	=	new	Secciones();
		$noticias	=	new	Noticias();
		if ($this->_request->isPost()) {
			$request = $this->_getPostsFiltered();
			if(isset($request['titulo'])&&isset($request['copete'])&&isset($request['texto'])&&isset($request['id_seccion'])){
				$id_noticia = 
					$noticias->insert(array(
						'titulo'=>$request['titulo'],
						'copete'=>$request['copete'],
						'texto'=>$request['texto'],
						'id_seccion'=>$request['id_seccion'],
						'aud_fecha_hora_ingreso'=>date("Y-m-d H-i-s"),
						'aud_id_usuario_ingreso'=>$usuario->id_usuario
					));
				/* Agregamos los tags referentes a esta noticia	 */
				$this->_agregarTags($request['tags'],$id_noticia);			
			}
			$this->_redirect('/noticias/admin/');
		}else{
			$where = " estado=1 ";
			$order = "nombre";
			$this->view->secciones = $secciones->fetchAll($where, $order);
			$this->view->tags = '';						
		}
	}
	public	function modificarAction()
	{
		$this->view->action	=	$this->view->baseUrl.'/noticias/admin/modificar/';
		$this->view->titulo	=	'Modificar Noticia';
		$this->user = Zend_Auth::getInstance()->getIdentity();
		$usuarios	=	new	Usuarios();
		$usuario	=	$usuarios->traerIdFromUsuario($this->user);
		$secciones	=	new	Secciones();
		$noticias	=	new	Noticias();
		$request = $this->_getPostsFiltered();
		if ($this->_request->isPost()) {
			if(isset($request['titulo'])&&isset($request['copete'])&&isset($request['texto'])&&isset($request['id_seccion'])){
				$where	=	" id_noticia=".$request['id_noticia'];
				$noticias->update(array(
						'titulo'=>$request['titulo'],
						'copete'=>$request['copete'],
						'texto'=>$request['texto'],
						'id_seccion'=>$request['id_seccion'],
						'aud_id_usuario_actualizacion'=>$usuario->id_usuario
					),$where);
				/* Agregamos los tags referentes a esta noticia	 */
				$this->_agregarTags($request['tags'],$request['id_noticia']);			
			}
			$this->_redirect('/noticias/admin/');
		}else{
			$where = " estado=1 ";
			$order = "nombre";
			$this->view->secciones = $secciones->fetchAll($where, $order);
			$where = " id_noticia=".$request['id_noticia'];
			$noticia = $noticias->fetchRow($where);
			$this->view->noticia_id_noticia	=	$noticia->id_noticia;
			$this->view->noticia_titulo	=	$noticia->titulo;
			$this->view->noticia_copete	=	$noticia->copete;
			$this->view->noticia_texto	=	$noticia->texto;
			$this->view->noticia_id_seccion	=	$noticia->id_seccion;
			$noticias_tags	=	new	Noticias_tags();
			$this->view->tags = $noticias_tags->traerTagsDeNoticias($request['id_noticia']);						
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
	private	function	_agregarTags($tags,$id_noticia)
	{
		if($id_noticia >0 && $tags!=''){
			$noticias_tags	=	new	Noticias_tags();
			$where	=	" id_noticia='$id_noticia'";
			$noticias_tags->delete($where);
			$tags	=	explode(',',$tags);
			foreach($tags as $tag){
				$noticias_tags->insert(array(
					'id_noticia'=>$id_noticia,
					'tag'=>trim($tag)
				));
			}
		}				
	}
}
