<?php

// FIXME!
require_once './application/noticias/models/Noticias.php';

class Noticias_AdminController extends Zsurforce_Generic_Controller {

	public function indexAction() {
		$noticias = new Noticias();
		$where = array();
		$order = "id";
		$this->view->noticias = $noticias->fetchAll($where, $order);

		$this->view->base_path = Zend_Registry::get('base_path');

		$this->render();
	}
	function agregarAction()
	{
		if ($this->_request->isPost()) {
			$p = $this->getPostsFiltered();
			
			$noticias = new Noticias();
			
			if( isset( $p['titulo'])  ){
				$resultado = 
					$noticias->insert(array(
						'titulo' 	=> $p['titulo'],
						'contenido' 	=> $p['contenido'],
						'contenido_ext' 	=> $p['contenido_ext']
					));
			}		
			$this->_redirect('/noticias/admin/');
            return;
		}
		
        $this->view->noticias = new stdClass();
        $this->view->noticias->id = null;
        $this->view->noticias->titulo = '';
        $this->view->noticias->contenido = '';
        $this->view->noticias->contenido_ext = '';

        $this->view->action = "accion";
        $this->view->buttonText = "botón texto";
        $this->render();
	}
	function modificarAction()
	{      
	}
	function eliminarAction()
	{
	}
	function getPostsFiltered(){
		
		$parmsPost = array();
		
		Zend_Loader::loadClass('Zend_Filter_StripTags');
		$f = new Zend_Filter_StripTags();
		
		foreach ($this->_request->getParams() as $key => $value){
			$parmsPost[$key]=$f->filter($value);
		}
		
		return $parmsPost;
	}
}
