<?php

/**
 * IndexController - The default controller class
 * 
 * @author
 * @version 
 */

 require_once 'Zend/Controller/Action.php';
 require_once 'ZsurForce/ZGdata/Gmail.php';
 require_once 'ZsurForce/ZGdata/AuthSub.php';
 require_once 'Zend/Gdata/AuthSub.php'; 

 class Contacto_ApigmailController extends Zsurforce_Generic_Controller 
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction() 
    {
        
    }
    
    public function viewlinkAction(){
       
        if(isset($_POST['user'])){
            $userGmail = $_POST['user'] . '@gmail.com';
            $url = 'http://'. $_SERVER['SERVER_NAME'] . '/surforce-base/contacto/apigmail/viewcontacts/?usergmail=' . $userGmail;
            $link = Zsurforce_ZGdata_AuthSub::getAuthSubTokenUri($url);
            echo '<a href="' . $link . '">Autorizar desde la pagina de google >></a>';
        }else{
            echo 'Falta el nombre de usuario.';
        }

    }
    public function viewcontactsAction(){
    
        if (isset($_GET['token'])){
            
            $sessionToken = Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);
            $httpClient = Zend_Gdata_AuthSub::getHttpClient($sessionToken);
            
            $GmailService = new ZsurForce_ZGdata_Gmail($httpClient);
            $emails = $GmailService->getContacts($_GET['usergmail']);
            
            $listEntries = '<ul>';
            $entriesFound = 0;
    
            foreach($emails as $email) {
                $listEntries .=  '<li><h4>'. $email . '</h4>';
                $entriesFound++;
            }        
  
            $listEntries .= '</ul>';
            
            if($entriesFound > 0){
                echo $listEntries;
            }else{
                echo 'No hay contactos en su cuenta';
            }             
        }
    }       
    
}