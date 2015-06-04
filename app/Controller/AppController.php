<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    var $components = array('DebugKit.Toolbar', 'Session', 'RequestHandler', 'Captcha');
    //var $helpers = array('Html', 'Form', 'Javascript', 'Session', 'Ajax','DatePicker');
    var $helpers = array('Html', 'Form', 'Session', 'DatePicker');

    /**
     * Creates object of Captcha Component class  
     *
     * @return void
     * @access protected
     */
    function create_captcha() {
        App::import("Component", "Captcha"); //including captcha class
        $this->Captcha = new CaptchaComponent(); //creating an object instance
        $this->Captcha->controller = & $this; //assign this conroller(CaptchaController) object to its captcha object's controller property.
        $this->set('captcha_src', $captcha_src = $this->Captcha->create()); //create a capthca and assign to a variable
    }

    function permiso_pantalla($id_user = null, $id_pantalla = null) {
        $this->loadModel('Permiso');
        $this->Permiso->recursive = -1;
        $conditions1 = array('Permiso.user_id' => $id_user, 'Permiso.pantalla_id' => $id_pantalla);
        $result1 = $this->Permiso->find('first', array('conditions' => $conditions1,
            'fields' => array('Permiso.user_id', 'Permiso.pantalla_id')
                )
        );
        //$cantidad_result1 = count($result1);
        if ($result1) {
            return true;
        } else {
            return false;
        }
    }

    /*
      function permiso_array_pantallas ($id_user=null, $array_pantallas=array()){
      $bandera_permiso = false;
      if (is_array($array_pantallas)){
      foreach ($array_pantallas as $pantalla){
      $permiso = $this->permiso_pantalla($id_user,$pantalla);
      if ($permiso){
      $bandera_permiso = true;
      }
      }
      }
      return $bandera_permiso;
      }
     */
}
