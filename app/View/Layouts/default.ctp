<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset('utf-8'); ?>
        <title>
            <?php echo $this->fetch('') . 'Config Sistemas'; ?>
        </title>
        <?php
        echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon'));
        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
            </div>
            <div id="content">
                <?php echo $content_for_layout ?>
            </div>
            <div id="footer">
            </div>
        </div>
        <!--<?php //echo $this->element('sql_dump');  ?>   -->  <!-- para que funciones DebugKit.Toolbar-->
    </body>
</html>
