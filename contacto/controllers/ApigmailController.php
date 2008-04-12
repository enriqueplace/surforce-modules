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
            //Página donde volverá despues de autenticar en google
            $url = 'http://'. $_SERVER['SERVER_NAME'] . '/surforce-base/contacto/apigmail/viewcontacts/?usergmail=' . $userGmail;
            $link = Zsurforce_ZGdata_AuthSub::getZGdataAuthSubTokenUri($url);
            echo '<a href="' . $link . '">Autorizar desde la pagina de google >></a>';
        }else{
            echo 'Falta el nombre de usuario.';
        }

    }
    
    public function viewcontactsAction(){
    
        if (isset($_GET['token'])){
            
            $sessionToken = Zsurforce_ZGdata_AuthSub::getAuthSubSessionToken($_GET['token']);
            $httpClient = Zsurforce_ZGdata_AuthSub::getHttpClient($sessionToken);
           
            /**
            * @desc Opcion 1: Llamar a getContactsEmail() solo con el parámetro $user
            * esto produce un array con los primeros 25 contactos
            */
            //$GmailService = new ZsurForce_ZGdata_Gmail($httpClient);
            //$emails = $GmailService->getContactsEmail($_GET['usergmail']);
            
            /**
            * @desc Opcion 2: Llamar a getContactsEmail() con el parámetro $user = null
            * y pasando en segundo lugar una instancia del objeto Zurforce_ZGdata_Gmail_ContactsQuery
            */
            $userContactsUrl = 'http://www.google.com/m8/feeds/contacts/' . 
                   $_GET['usergmail'] . '/base';
            $gMailService = new ZsurForce_ZGdata_Gmail($httpClient);
            // Creamos una instancia de ContactsQuery
            $gmQuery = $gMailService->newContactsQuery($userContactsUrl);  
            // order by esta disponible unque no produce cambios ya que hay una sola opcion de parámetro (lastmodified).
            $gmQuery->setOrderBy('lastmodified');
            // Recibir un maximo de 10 contactos.
            $gmQuery->setMaxResults(10); 
            // Listar a partir del contacto 9 en adelante
            $gmQuery->setStartIndex(9);
            // Listar contactos que se hayan agregado solo despues del..
            $gmQuery->setUpdatedMin('2007-02-05');
            // Despues de setear la consulta se la pasamos a la funcion que nos va a devolver un array con los resultados
            // El primer parámetro debe ser nulo porque de lo contrario tomara éste y no la consulta.
            $emails = $gMailService->getContactsEmail(null,$gmQuery);
            
            
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