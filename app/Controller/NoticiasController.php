<?php

class NoticiasController extends AppController {

    var $name = 'Noticias';
    var $components = array('Auth', 'Email');

    function afterFilter() {
        // Update User last_access datetime
        if ($this->Auth->user()) {
            $this->loadModel('User');
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('last_access', date('Y-m-d H:i:s'));
        }
    }

    function index() {
        //$this->_refreshAuth();
        switch ($this->Auth->user('role_id')) {
            case 1:
                $this->Session->setFlash('Acceso denegado', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
                break;
            case 2:
                $this->redirect(array('controller' => 'noticias', 'action' => 'search', 0));
                break;
            default:
                $this->redirect(array('controller' => 'publicos', 'action' => 'index'));
        }
    }

    function search($buscar = 1) {
        $pantalla = 7;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado	
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado                

                if ($this->Session->check('modulo') || $this->Session->check('modulo_id') || $this->Session->check('modulo_titulo') || $this->Session->check('modulo_codigo')) {
                    $this->Session->delete('modulo');
                    $this->Session->delete('modulo_id');
                    $this->Session->delete('modulo_titulo');
                    $this->Session->delete('modulo_codigo');
                }

                if ($buscar == 1) {

                    $status = $this->request->data['Noticia']['status'];

                    if ($status != "") {
                        $conditions2 = array('Noticia.status' => $status);
                    } else {
                        $conditions2 = "true";
                    }

                    if (($this->request->data['Noticia']['fecha_ini']['year'] != "") AND ( $this->request->data['Noticia']['fecha_ini']['month'] != "") AND ( $this->request->data['Noticia']['fecha_ini']['day'] != "") AND ( $this->request->data['Noticia']['fecha_fin']['year'] != "") AND ( $this->request->data['Noticia']['fecha_fin']['month'] != "") AND ( $this->request->data['Noticia']['fecha_fin']['day'] != "")
                    ) {

                        $fecha_ini = $this->request->data['Noticia']['fecha_ini']['year'] . "-" . $this->request->data['Noticia']['fecha_ini']['month'] . "-" . $this->request->data['Noticia']['fecha_ini']['day'];
                        $fecha_fin = $this->request->data['Noticia']['fecha_fin']['year'] . "-" . $this->request->data['Noticia']['fecha_fin']['month'] . "-" . $this->request->data['Noticia']['fecha_fin']['day'];

                        if ((date(strtotime($fecha_ini))) <= (date(strtotime($fecha_fin)))) {

                            $conditions1 = array('Noticia.fecha between ? and ?' => array($fecha_ini, $fecha_fin));
                        } else {
                            $this->Session->setFlash('La fecha de Inicio es mayor que la fecha de Fin', 'flash_failure');
                            $this->redirect('index');
                        }
                    } else if (($this->request->data['Noticia']['fecha_ini']['year'] == "") AND ( $this->request->data['Noticia']['fecha_ini']['month'] == "") AND ( $this->request->data['Noticia']['fecha_ini']['day'] == "") AND ( $this->request->data['Noticia']['fecha_fin']['year'] == "") AND ( $this->request->data['Noticia']['fecha_fin']['month'] == "") AND ( $this->request->data['Noticia']['fecha_fin']['day'] == "")
                    ) {

                        $conditions1 = "true";
                    } else if (($this->request->data['Noticia']['fecha_ini']['year'] == "") AND ( $this->request->data['Noticia']['fecha_ini']['month'] == "") AND ( $this->request->data['Noticia']['fecha_ini']['day'] == "") AND ( $this->request->data['Noticia']['fecha_fin']['year'] != "") AND ( $this->request->data['Noticia']['fecha_fin']['month'] != "") AND ( $this->request->data['Noticia']['fecha_fin']['day'] != "")
                    ) {


                        $fecha_fin = $this->request->data['Noticia']['fecha_fin']['year'] . "-" . $this->request->data['Noticia']['fecha_fin']['month'] . "-" . $this->request->data['Noticia']['fecha_fin']['day'];

                        $conditions1 = array('Noticia.fecha <= ?' => array($fecha_fin));
                    } else if (($this->request->data['Noticia']['fecha_ini']['year'] != "") AND ( $this->request->data['Noticia']['fecha_ini']['month'] != "") AND ( $this->request->data['Noticia']['fecha_ini']['day'] != "") AND ( $this->request->data['Noticia']['fecha_fin']['year'] == "") AND ( $this->request->data['Noticia']['fecha_fin']['month'] == "") AND ( $this->request->data['Noticia']['fecha_fin']['day'] == "")
                    ) {


                        $fecha_ini = $this->request->data['Noticia']['fecha_ini']['year'] . "-" . $this->request->data['Noticia']['fecha_ini']['month'] . "-" . $this->request->data['Noticia']['fecha_ini']['day'];

                        $conditions1 = array('Noticia.fecha >= ?' => array($fecha_ini));
                    } else {
                        $this->Session->setFlash('Debe ingresar una Fecha v&aacute;lida', 'flash_failure');
                        $this->redirect('index');
                    }


                    $this->Noticia->recursive = 0;
                    $noticias_encontradas = $this->Noticia->find('all', array('conditions' => array($conditions1, $conditions2), 'order' => array('Noticia.fecha DESC', 'Noticia.status ASC')));
                } else {
                    $noticias_encontradas = array();
                }

                $this->set('noticias_encontradas', $noticias_encontradas);
                $this->set('buscar', $buscar);
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function view($id = null) {
        $pantalla = 8;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado			
                //Obtengo los datos de la notica que queremos ver con el ID pasado por parametro. 
                $this->Noticia->recursive = 1;
                $this->set('noticia', $this->Noticia->read(null, $id));
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function add() {
        $pantalla = 9;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                if (!empty($this->request->data)) {
                    $this->Noticia->set($this->request->data);
                    if ($this->Noticia->validates()) {
                        $this->Noticia->save($this->request->data, false);

                        $this->Noticia->saveField('user_created', $this->Auth->user('id'));

                        $this->Session->setFlash('Noticia agregada correctamente', 'flash_success');
                        $this->redirect('index');
                    }
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function edit($id = null) {
        $pantalla = 10;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                if (!empty($this->request->data)) {
                    $this->Noticia->set($this->request->data);
                    if ($this->Noticia->validates()) {
                        $this->Noticia->save($this->request->data, false);

                        $this->Noticia->saveField('user_modified', $this->Auth->user('id'));

                        $this->Session->setFlash('Noticia actualizada correctamente', 'flash_success');
                        $this->redirect('index');
                    }
                } else {
                    $this->Noticia->recursive = -1;
                    $noticia = $this->Noticia->findById($id);
                    if (empty($noticia)) {
                        $this->Session->setFlash('ID de Noticia inv&aacute;lido', 'flash_failure');
                        $this->redirect('add');
                    } else {
                        $this->request->data = $noticia;
                    }
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function delete() {
        $pantalla = 11;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                $delete_count = 0;
                if (!empty($this->request->data['Noticia']['delete'])) {
                    foreach ($this->request->data['Noticia']['delete'] as $id => $delete) {
                        if ($delete == 1) {
                            if ($this->Noticia->delete($id)) {
                                $conditions = array('Image.noticia_id' => $id);
                                $results = $this->Noticia->Image->find('all', array('conditions' => $conditions));
                                foreach ($results as $result) {
                                    if ($this->Noticia->Image->delete($result['Image']['id'])) {
                                        $this->Noticia->Image->delImage($result['Image']['location']);
                                    }
                                }
                                $delete_count++;
                            }
                        }
                    }
                }
                $this->Session->setFlash($delete_count . ' Noticia' . (($delete_count == 1) ? ' fue' : 's fueron') . ' eliminada/s', 'flash_success');
                $this->redirect('index');
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function pre_send($id = null) {
        $pantalla = 35;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                if ($id) {
                    $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                    $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                    $this->Noticia->recursive = 1;
                    $noticia = $this->Noticia->findById($id);
                    if (empty($noticia)) {
                        $this->Session->setFlash('ID de Noticia inv&aacute;lido', 'flash_failure');
                        $this->redirect('index');
                    } else {
                        $this->set('noticia', $noticia);
                    }
                } else {
                    $this->Session->setFlash('ID de Noticia inv&aacute;lido', 'flash_failure');
                    $this->redirect('index');
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function send() {
        $pantalla = 35;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                if ($this->request->data['Noticia']['id_noticia'] != "") {
                    //completar 
                    // Obtengo el correo de cada USUARIO
                    $this->loadModel('User');
                    $this->User->recursive = -1;
                    $result1 = $this->User->find('all', array('fields' => array('User.email')
                            )
                    );

                    // Obtengo la Noticia a enviar 
                    $this->Noticia->recursive = 0;
                    $noticia = $this->Noticia->findById($this->request->data['Noticia']['id_noticia']);

                    /*
                      $emails = "";
                      foreach($result1 as $r1) {
                      $emails .= $r1['User']['email'].",";
                      }

                      if ($emails != ""){
                      $emails = substr($emails,0,strlen($emails)-1);
                      }
                     */

                    $emails = array();
                    if (is_array($emails)) {
                        foreach ($result1 as $r1) {
                            $emails[] = $r1['User']['email'];
                        }
                    }

                    $this->Email->delivery = 'smtp';
                    $this->Email->smtpOptions = array(
                        'port' => '465',
                        'timeout' => '30',
                        'host' => 'ssl://smtp.gmail.com',
                        'username' => 'el.viejo.martin.webmaster@gmail.com',
                        'password' => 'fedora1234',
                        'auth' => true,
                    );

                    //$this->Email->from = 'el.viejo.martin.webmaster@gmail.com';  				 
                    $this->Email->to = 'el.viejo.martin.webmaster@gmail.com';
                    //$this->Email->to = $emails;
                    $this->Email->bcc = $emails;
                    //$this->Email->replyTo = $this->request->data['Publicos']['name'].' <'.$this->request->data['Publicos']['email'].'>'; 
                    //$this->Email->bcc = array('el.viejo.martin@gmail.com');      
                    $this->Email->subject = "Config Sistemas - Noticias destacadas";
                    $this->Email->sendAs = 'both';

                    $cuerpo_correo = "
                    <table style='padding:2%'>
                        <tbody>
                            <tr>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                    			<td style='text-align:right'><span><b>Fecha:</b></span></td>	
                                    			<td style='text-align:left'><span>" . date('d-m-Y', strtotime($noticia['Noticia']['fecha'])) . "</span></td>
                                    		</tr>
                                    		<tr>
                                    			<td style='text-align:right'><span><b>T&iacute;tulo:</b></span></td>	
                                    			<td style='text-align:left'><span>" . $noticia['Noticia']['titulo'] . "</span></td>
                                    		</tr>
                                    		<tr>
                                    			<td style='text-align:right'><span><b>Resumen:</b></span></td>	
                                    			<td style='text-align:left'><span>" . $noticia['Noticia']['resumen'] . "</span></td>
                                    		</tr> 
                                    		<tr>
                                    			<td style='text-align:right'><span><b>Contenido:</b></span></td>	
                                    			<td style='text-align:left'><span>" . $noticia['Noticia']['contenido'] . "</span></td>
                                    		</tr>
                                            <tr>
                                                <td>
                                                    <br/>
                                                </td>
                                            </tr>
                                    		<tr>
                                    			<td style='text-align:right'></td>	
                                    			<td style='text-align:left'><span><a href='http://www.configsistemas.com/publicos/view_noticia/" . $noticia['Noticia']['id'] . "' target='_blank'>Ir a la Noticia</a></span></td>
                                    		</tr>                           
                                        </tbody>
                                    </table>                           
                                </td>
                            </tr>      
                    	</tbody>
                    </table>
                    ";
                    $asunto_correo = $noticia['Noticia']['titulo'];

                    $this->Session->write('cuerpo_correo', $cuerpo_correo);
                    $this->Session->write('asunto_correo', $asunto_correo);
                    $this->Email->template = 'correo';

                    if ($this->Email->send()) {
                        $this->Session->setFlash('Noticia Enviada', 'flash_success');
                        $this->redirect('index');
                    } else {
                        $this->Session->setFlash('Noticia no enviada', 'flash_failure');
                        $this->redirect('index');
                    }

                    if ($this->Session->check('cuerpo_correo') || $this->Session->check('asunto_correo')) {
                        $this->Session->delete('cuerpo_correo');
                        $this->Session->delete('asunto_correo');
                    }
                } else {
                    $this->Session->setFlash('ID de Noticia inv&aacute;lido', 'flash_failure');
                    $this->redirect('index');
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    /**
     * Refreshes the Auth session
     * @param string $field
     * @param string $value
     * @return void 
     */
    /*
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
     * 
     */

}

?>