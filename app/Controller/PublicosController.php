<?php

/*Llamamos a la clase CakeEmail y Network/Email para habilitar su uso*/
App::uses('CakeEmail', 'Network/Email');

class PublicosController extends AppController {

    var $name = 'Publicos';


    function index() {
        $this->set('index');
        $this->loadModel('Noticia');
        $this->Noticia->recursive = 1;
        $conditions1 = array('Noticia.status' => 'Activa');
        $this->set('noticias', $this->Noticia->find('all', array('conditions' => $conditions1, 'order' => array('Noticia.created DESC'), 'limit' => 10)));

        $this->loadModel('Video');
        $this->Video->recursive = 1;
        $this->set('videos', $this->Video->find('all'));

        $this->loadModel('Publicidade');
        $this->Publicidade->recursive = 1;
        $this->set('publicidades', $this->Publicidade->find('all'));

        $this->loadModel('Album');
        $this->Album->recursive = 1;
        $conditions2 = array('Album.status' => 'Activo');
        $this->set('albums', $this->Album->find('all', array('conditions' => $conditions2, 'order' => array('Album.created DESC'), 'limit' => 15)));
    }

    function view_noticia($id = null) {
        $this->loadModel('Noticia');
        $this->Noticia->recursive = 1;
        $this->set('noticia', $this->Noticia->read(null, $id));

        $this->loadModel('Publicidade');
        $this->Publicidade->recursive = 1;
        $this->set('publicidades', $this->Publicidade->find('all'));
    }

    function view_album($id = null) {
        $this->loadModel('Album');
        $this->Album->recursive = 1;
        $this->set('album', $this->Album->read(null, $id));

        $this->loadModel('Publicidade');
        $this->Publicidade->recursive = 1;
        $this->set('publicidades', $this->Publicidade->find('all'));
    }

    function contacto() {
        $this->captcha = true; // ATENCION: Poner en 'false' para que funcione el captcha correctamentere
        if (isset($this->request->data['Publicos']['ver_code'])) {
            if ($this->Session->read('ver_code') == $this->request->data['Publicos']['ver_code']) {
                $this->captcha = true;
            }
        }

        if (!empty($this->request->data) && $this->captcha) {

            /*Creamos una clase de la componente que creamos en app(Config/mail.php) */
            $Email = new CakeEmail('gmail');

            
            $Email->subject('Config Sistemas - Contacto');
            
            $Email->from ('el.viejo.martin.webmaster@gmail.com');
            $Email->to('el.viejo.martin.webmaster@gmail.com');
            $Email->replyTo($this->data['Publicos']['email']);

               
            /* Aca como parametro va el cuerpo del mensaje*/
            if ($Email->send($this->data['Publicos']['message'])) {

                $this->Session->setFlash('Mensaje enviado. Gracias por contactarnos', 'flash_success');
                $this->redirect(array('controller' => 'publicos', 'action' => 'contacto'));
            } else {
                $this->request->data['Publicos']['ver_code'] = '';
                $this->Session->setFlash('E-Mail no enviado', 'flash_failure');
                $this->redirect(array('controller' => 'publicos', 'action' => 'contacto'));
            }

         
        } elseif (!empty($this->request->data) && !$this->captcha) {
            $this->request->data['Publicos']['ver_code'] = '';
            $this->Session->setFlash('C&oacute;digo de seguridad incorrecto', 'flash_failure');
        }

        $this->create_captcha();
        $this->render();
        $this->set('contacto');
    }


    /* No esta arreglado todavia la funcion enviar_pass()  aun!!*/


    function enviar_pass() {
        $this->captcha = false; // ATENCION: Poner en 'false' para que funcione el captcha correctamente
        if (isset($this->request->data['Publicos']['ver_code'])) {
            if ($this->Session->read('ver_code') == $this->request->data['Publicos']['ver_code']) {
                $this->captcha = true;
            }
        }

        if (!empty($this->request->data) && $this->captcha) {
            $this->loadModel('User');
            $this->User->recursive = -1;
            $conditions1 = array('User.username' => $this->request->data['Publicos']['username']);
            $result1 = $this->User->find('all', array('conditions' => $conditions1, 'fields' => array('User.username', 'User.clear_password', 'User.email')));

            $numUsers = count($result1);

            if ($numUsers == '1') {

                $this->Email->delivery = 'smtp';
                $this->Email->smtpOptions = array(
                    'port' => '465',
                    'timeout' => '30',
                    'host' => 'ssl://smtp.gmail.com',
                    'username' => 'el.viejo.martin.webmaster@gmail.com',
                    'password' => 'fedora1234',
                    'auth' => true,
                );
                //$this->Email->attach('/ruta/file.pdf', 'data.pdf'); 
                //$this->Email->from = 'el.viejo.martin.webmaster@gmail.com';  				 

                $this->Email->to = $result1[0]['User']['email'];
                //$this->Email->replyTo = 'Administrador <el.viejo.martin.webmaster@gmail.com>';
                $this->Email->replyTo = 'Administrador <el.viejo.martin.webmaster@gmail.com>';
                //$this->Email->bcc = array('el.viejo.martin@gmail.com');      
                $this->Email->subject = "Config Sistemas - Datos de cuenta";
                $this->Email->sendAs = 'both';

                $cuerpo_correo = "<b>Usuario:</b> " . $result1[0]['User']['username'] . "<br><b>Contrase&ntilde;a:</b> " . $result1[0]['User']['clear_password'] . "";
                $asunto_correo = "Datos de Cuenta";

                $this->Session->write('cuerpo_correo', $cuerpo_correo);
                $this->Session->write('asunto_correo', $asunto_correo);
                $this->Email->template = 'correo';

                if ($this->Email->send()) {
                    $this->Session->setFlash('Se ha enviado su contrase&ntilde;a al correo que tenemos registrado en el sistema, por favor revise en correo no deseado en caso que no este en su bandeja de entrada', 'flash_success');
                    $this->redirect(array('controller' => 'publicos', 'action' => 'enviar_pass'));
                } else {
                    $this->request->data['Publicos']['ver_code'] = '';
                    $this->Session->setFlash('E-Mail no enviado', 'flash_failure');
                    $this->redirect(array('controller' => 'publicos', 'action' => 'enviar_pass'));
                }

                if ($this->Session->check('cuerpo_correo') || $this->Session->check('asunto_correo')) {
                    $this->Session->delete('cuerpo_correo');
                    $this->Session->delete('asunto_correo');
                }
            } else {
                $this->request->data['Publicos']['ver_code'] = '';
                $this->Session->setFlash('Usuario inv&aacute;lido', 'flash_failure');
                $this->redirect(array('controller' => 'publicos', 'action' => 'enviar_pass'));
            }
        } elseif (!empty($this->request->data) && !$this->captcha) {
            //$this->request->data['Publicos']['username'] = '';
            $this->request->data['Publicos']['ver_code'] = '';
            $this->Session->setFlash('C&oacute;digo de seguridad incorrecto', 'flash_failure');
        }

        $this->create_captcha();
        $this->render();
        $this->set('enviar_pass');
    }

}

?>