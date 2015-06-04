<?php

class AlbumsController extends AppController {

    var $name = 'Albums';
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
        $this->_refreshAuth();
        switch ($this->Auth->user('role_id')) {
            case 1:
                $this->Session->setFlash('Acceso denegado', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'home'));
                break;
            case 2:
                $this->redirect(array('controller' => 'albums', 'action' => 'search', 0));
                break;
            default:
                $this->redirect(array('controller' => 'publicos', 'action' => 'index'));
        }
    }

    function search($buscar = 1) {
        $pantalla = 50;
        $this->_refreshAuth();
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

                    $titulo = $this->request->data['Album']['titulo'];
                    $estado = $this->request->data['Album']['status'];

                    if ($titulo != "") {
                        //$conditions1 = array('User.username' => $username); 
                        $conditions3 = array('Album.titulo LIKE' => "%" . $titulo . "%");
                    } else {
                        $conditions3 = "true";
                    }

                    if ($estado != "") {
                        $conditions2 = array('Album.status' => $estado);
                    } else {
                        $conditions2 = "true";
                    }

                    if (($this->request->data['Album']['fecha_ini']['year'] != "") AND ( $this->request->data['Album']['fecha_ini']['month'] != "") AND ( $this->request->data['Album']['fecha_ini']['day'] != "") AND ( $this->request->data['Album']['fecha_fin']['year'] != "") AND ( $this->request->data['Album']['fecha_fin']['month'] != "") AND ( $this->request->data['Album']['fecha_fin']['day'] != "")
                    ) {

                        $fecha_ini = $this->request->data['Album']['fecha_ini']['year'] . "-" . $this->request->data['Album']['fecha_ini']['month'] . "-" . $this->request->data['Album']['fecha_ini']['day'];
                        $fecha_fin = $this->request->data['Album']['fecha_fin']['year'] . "-" . $this->request->data['Album']['fecha_fin']['month'] . "-" . $this->request->data['Album']['fecha_fin']['day'];

                        if ((date(strtotime($fecha_ini))) <= (date(strtotime($fecha_fin)))) {

                            $conditions1 = array('Album.fecha between ? and ?' => array($fecha_ini, $fecha_fin));
                        } else {
                            $this->Session->setFlash('La fecha de Inicio es mayor que la fecha de Fin', 'flash_failure');
                            $this->redirect('index');
                        }
                    } else if (($this->request->data['Album']['fecha_ini']['year'] == "") AND ( $this->request->data['Album']['fecha_ini']['month'] == "") AND ( $this->request->data['Album']['fecha_ini']['day'] == "") AND ( $this->request->data['Album']['fecha_fin']['year'] == "") AND ( $this->request->data['Album']['fecha_fin']['month'] == "") AND ( $this->request->data['Album']['fecha_fin']['day'] == "")
                    ) {

                        $conditions1 = "true";
                    } else if (($this->request->data['Album']['fecha_ini']['year'] == "") AND ( $this->request->data['Album']['fecha_ini']['month'] == "") AND ( $this->request->data['Album']['fecha_ini']['day'] == "") AND ( $this->request->data['Album']['fecha_fin']['year'] != "") AND ( $this->request->data['Album']['fecha_fin']['month'] != "") AND ( $this->request->data['Album']['fecha_fin']['day'] != "")
                    ) {


                        $fecha_fin = $this->request->data['Album']['fecha_fin']['year'] . "-" . $this->request->data['Album']['fecha_fin']['month'] . "-" . $this->request->data['Album']['fecha_fin']['day'];

                        $conditions1 = array('Album.fecha <= ?' => array($fecha_fin));
                    } else if (($this->request->data['Album']['fecha_ini']['year'] != "") AND ( $this->request->data['Album']['fecha_ini']['month'] != "") AND ( $this->request->data['Album']['fecha_ini']['day'] != "") AND ( $this->request->data['Album']['fecha_fin']['year'] == "") AND ( $this->request->data['Album']['fecha_fin']['month'] == "") AND ( $this->request->data['Album']['fecha_fin']['day'] == "")
                    ) {


                        $fecha_ini = $this->request->data['Album']['fecha_ini']['year'] . "-" . $this->request->data['Album']['fecha_ini']['month'] . "-" . $this->request->data['Album']['fecha_ini']['day'];

                        $conditions1 = array('Album.fecha >= ?' => array($fecha_ini));
                    } else {
                        $this->Session->setFlash('Debe ingresar una Fecha v&aacute;lida', 'flash_failure');
                        $this->redirect('index');
                    }


                    $this->Album->recursive = 0;
                    $albums_encontrados = $this->Album->find('all', array('conditions' => array($conditions1, $conditions2, $conditions3), 'order' => array('Album.fecha DESC', 'Album.status ASC')));
                } else {
                    $albums_encontrados = array();
                }

                $this->set('albums_encontrados', $albums_encontrados);
                $this->set('buscar', $buscar);
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function view($id = null) {
        $pantalla = 51;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado			
                //Obtengo los datos de la notica que queremos ver con el ID pasado por parametro. 
                $this->Album->recursive = 1;
                $this->set('album', $this->Album->read(null, $id));
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function add() {
        $pantalla = 52;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                if (!empty($this->request->data)) {
                    $this->Album->set($this->request->data);
                    if ($this->Album->validates()) {
                        $this->Album->save($this->request->data, false);

                        $this->Album->saveField('user_created', $this->Auth->user('id'));

                        $this->Session->setFlash('Album agregado correctamente', 'flash_success');
                        $this->redirect('index');
                    }
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function edit($id = null) {
        $pantalla = 53;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                if (!empty($this->request->data)) {
                    $this->Album->set($this->request->data);
                    if ($this->Album->validates()) {
                        $this->Album->save($this->request->data, false);

                        $this->Album->saveField('user_modified', $this->Auth->user('id'));

                        $this->Session->setFlash('Album actualizado correctamente', 'flash_success');
                        $this->redirect('index');
                    }
                } else {
                    $this->Album->recursive = -1;
                    $album = $this->Album->findById($id);
                    if (empty($album)) {
                        $this->Session->setFlash('ID de Album inv&aacute;lido', 'flash_failure');
                        $this->redirect('add');
                    } else {
                        $this->request->data = $album;
                    }
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function delete() {
        $pantalla = 54;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                $delete_count = 0;
                if (!empty($this->request->data['Album']['delete'])) {
                    foreach ($this->request->data['Album']['delete'] as $id => $delete) {
                        if ($delete == 1) {
                            if ($this->Album->delete($id)) {
                                $conditions = array('Image.album_id' => $id);
                                $results = $this->Album->Image->find('all', array('conditions' => $conditions));
                                foreach ($results as $result) {
                                    if ($this->Album->Image->delete($result['Image']['id'])) {
                                        $this->Album->Image->delImage($result['Image']['location']);
                                    }
                                }
                                $delete_count++;
                            }
                        }
                    }
                }
                $this->Session->setFlash($delete_count . ' Album' . (($delete_count == 1) ? ' fue' : 's fueron') . ' eliminado/s', 'flash_success');
                $this->redirect('index');
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function pre_send($id = null) {
        $pantalla = 55;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                if ($id) {
                    $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                    $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                    $this->Album->recursive = 1;
                    $album = $this->Album->findById($id);
                    if (empty($album)) {
                        $this->Session->setFlash('ID de Album inv&aacute;lido', 'flash_failure');
                        $this->redirect('index');
                    } else {
                        $this->set('album', $album);
                    }
                } else {
                    $this->Session->setFlash('ID de Album inv&aacute;lido', 'flash_failure');
                    $this->redirect('index');
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function send() {
        $pantalla = 55;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                if ($this->request->data['Album']['id_album'] != "") {
                    //completar 
                    // Obtengo el correo de cada USUARIO
                    $this->loadModel('User');
                    $this->User->recursive = -1;
                    $result1 = $this->User->find('all', array('fields' => array('User.email')
                            )
                    );

                    // Obtengo el Album a enviar 
                    $this->Album->recursive = 0;
                    $album = $this->Album->findById($this->request->data['Album']['id_album']);

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
                    $this->Email->subject = "Config Sistemas - Albums destacados";
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
                                    			<td style='text-align:left'><span>" . date('d-m-Y', strtotime($album['Album']['fecha'])) . "</span></td>
                                    		</tr>
                                    		<tr>
                                    			<td style='text-align:right'><span><b>T&iacute;tulo:</b></span></td>	
                                    			<td style='text-align:left'><span>" . $album['Album']['titulo'] . "</span></td>
                                  		    </tr>                                         
                                    		<tr>
                                    			<td style='text-align:right'><span><b>Contenido:</b></span></td>	
                                    			<td style='text-align:left'><span>" . $album['Album']['descripcion'] . "</span></td>
                                    		</tr>
                                            <tr>
                                                <td>
                                                    <br/>
                                                </td>
                                            </tr>                                            
                                    		<tr>
                                    			<td style='text-align:right'></td>	
                                    			<td style='text-align:left'><span><a href='http://www.configsistemas.com/publicos/view_album/" . $album['Album']['id'] . "' target='_blank'>Ir al Album</a></span></td>
                                    		</tr>                           
                                        </tbody>
                                    </table>                           
                                </td>
                            </tr>      
                    	</tbody>
                    </table>
                    ";
                    $asunto_correo = $album['Album']['titulo'];

                    $this->Session->write('cuerpo_correo', $cuerpo_correo);
                    $this->Session->write('asunto_correo', $asunto_correo);
                    $this->Email->template = 'correo';

                    if ($this->Email->send()) {
                        $this->Session->setFlash('Album Enviado', 'flash_success');
                        $this->redirect('index');
                    } else {
                        $this->Session->setFlash('Album no enviado', 'flash_failure');
                        $this->redirect('index');
                    }

                    if ($this->Session->check('cuerpo_correo') || $this->Session->check('asunto_correo')) {
                        $this->Session->delete('cuerpo_correo');
                        $this->Session->delete('asunto_correo');
                    }
                } else {
                    $this->Session->setFlash('ID de Album inv&aacute;lido', 'flash_failure');
                    $this->redirect('index');
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
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