<?php

class GestionesController extends AppController {

    var $name = 'Gestiones';
    var $components = array('Auth');

    function afterFilter() {
        // Update User last_access datetime
        if ($this->Auth->user()) {
            $this->loadModel('User');
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('last_access', date('Y-m-d H:i:s'));
        }
    }

    function index() {
        $this->_refreshAuth();
        switch ($this->Auth->user('role_id')) {
            case 1:
                $this->Session->setFlash('Acceso denegado', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'home'));
                break;
            case 2:
                if ($this->Auth->user('status') == 'Activo') {
                    $this->set('index');
                    $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                    $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                    /*
                      if ($this->Session->check('noticia_id') || $this->Session->check('noticia_titulo')) {
                      $this->Session->delete('noticia_id');
                      $this->Session->delete('noticia_titulo');
                      } */

                    if ($this->Session->check('modulo') || $this->Session->check('modulo_id') || $this->Session->check('modulo_titulo') || $this->Session->check('modulo_codigo')) {
                        $this->Session->delete('modulo');
                        $this->Session->delete('modulo_id');
                        $this->Session->delete('modulo_titulo');
                        $this->Session->delete('modulo_codigo');
                    }
                } elseif ($this->Auth->user('status') == 'Inactivo') {
                    $this->Session->setFlash('Usuario inactivo', 'flash_failure');
                    $this->redirect(array('controller' => 'users', 'action' => 'inactivo'));
                }
                break;
            default:
                $this->redirect(array('controller' => 'publicos', 'action' => 'index'));
        }
    }

    /**
     * Refreshes the Auth session
     * @param string $field
     * @param string $value
     * @return void 
     */
    function _refreshAuth($field = '', $value = '') {
        if (!empty($field) && !empty($value)) {
            $this->Session->write($this->Auth->sessionKey . '.' . $field, $value);
        } else {
            if (isset($this->User)) {
                $this->Auth->login($this->User->read(false, $this->Auth->user('id')));
            } else {
                $this->Auth->login(ClassRegistry::init('User')->findById($this->Auth->user('id')));
            }
        }
    }

}

?>