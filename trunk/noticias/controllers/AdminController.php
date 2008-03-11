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
		$p = $this->getPostsFiltered();			
		$noticias = new Noticias();
			
        if ($this->_request->isPost()) {
        	
        	
            $id 	= (int)$p['id'];
            $del 	= $p['del'];

            if ( $del == 'Si' && $id > 0 ){
                $where = 'id = ' . $id;
                $rows_affected = $noticias->delete( $where );
            }
            $this->_redirect('/noticias/admin/');
            return;
        }
        
        $id = (int)$p['id'];
        if ($id > 0) {
        	$this->view->noticias = $noticias->fetchRow( 'id=' . $id );
            if ($this->view->noticias->id > 0) {
            	$this->render();
                return;
            }
        }
        $this->_redirect('/noticias/admin/');
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
