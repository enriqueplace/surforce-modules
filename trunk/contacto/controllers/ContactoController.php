<?php
class Contacto_ContactoController extends Zcms_Generic_Controller{

    function init()
    {
        parent::init();
        Zend_Loader::loadClass('Contacto');
    }
    function indexAction(){
        //Obtenemos las etiquetas que necesitemos del archivo config.ini
        $this->view->buttonText = $this->info->sitio->contacto->agregar->buttonText;
        $this->view->subtitle = $this->info->sitio->contacto->agregar->titulo;
        $contacto = new Contacto();
    }
    function agregarAction(){
        $this->view->subtitle = $this->info->sitio->contacto->agregar->titulo;
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter 	= new Zend_Filter_StripTags();
            $nombre 	= trim($filter->filter($this->_request->getPost('nombre')));
            $email  	= trim($filter->filter($this->_request->getPost('email')));
            $comentario = trim($filter->filter($this->_request->getPost('comentario')));
            $telefono   = trim($filter->filter($this->_request->getPost('telefono')));
            $fecha		= date("Y-m-d H:i:s");
            if ($nombre != '' && $email != '' && $comentario != '' && $telefono !='' ) {
                $data = array(
                    'nombre' 	=> $nombre,
                    'email' 	=> $email,
                    'comentario'=> $comentario,
                    'telefono'  => $telefono,
                    'fecha' 	=> $fecha
                );
                $contacto = new contacto();
                $contacto->insert($data);
                //Enviamos el correo.
                $destinatario = $email;
                $asunto = $this->info->sitio->contacto->add->asunto;
                $mensaje = $this->info->sitio->contacto->add->mensaje;
                $cuerpo = "$nombre"." "."$comentario";
                $headers = $this->info->sitio->contacto->add->sender;;
                mail($destinatario,$asunto,$cuerpo,$headers);

                $this->view->message = " El comentario fue enviado con exito ! Muchas gracias.";
                $this->view->buttonText = $this->info->sitio->contacto->agregar->buttonText;


                return;

            }
            else
            {
                $this->view->message = "Deben completar todos los campos";
            }
        }

        $this->view->contacto = new stdClass();
        $this->view->contacto->id = null;
        $this->view->contacto->nombre = '';
        $this->view->contacto->email = '';
        $this->view->contacto->comentario = '';
        $this->view->action = $this->info->sitio->usuarios->agregar->action;
        $this->view->buttonText = $this->info->sitio->contacto->agregar->buttonText;
        $this->render();
    }




}
?>
