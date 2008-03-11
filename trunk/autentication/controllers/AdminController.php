<?php
require_once './application/autentication/models/Autentication.php';
class Autentication_AdminController extends Zsurforce_Generic_Controller {

	public function loginAction() 
	{
    	Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
        $dbAdapter  = Zend_Registry::get('dbAdapter');
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter->setTableName('usuarios');
        $authAdapter->setIdentityColumn('usuario');
        $authAdapter->setCredentialColumn('password');
		
        $request = $this->getPostsFiltered();
        $usuario 	= $request['usuario'];
        $password 	= md5($request['password']);
		$authAdapter->setIdentity($usuario);
        $authAdapter->setCredential($password);
        $auth 		= Zend_Auth::getInstance();
        $result 	= $auth->authenticate($authAdapter);
       	Zend_Loader::loadClass('Zend_Json');
		$varsJson = Zend_Json::encode(array('verificado'=> $result->isValid()));
		echo $varsJson;
		$this->_helper->viewRenderer->setNoRender();
	}
    public	function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }
	private	function getPostsFiltered()
	{
		$parmsPost = array();
		Zend_Loader::loadClass('Zend_Filter_StripTags');
		$f = new Zend_Filter_StripTags();
		foreach ($this->_request->getParams() as $key => $value){
			$parmsPost[$key]=$f->filter($value);
		}
		return $parmsPost;
	}
}
