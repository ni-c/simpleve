<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
    Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
    Router::connect('/about', array('controller' => 'pages', 'action' => 'display', 'about'));
    Router::connect('/dashboard', array('controller' => 'dashboard', 'action' => 'index'));
    Router::connect('/industry', array('controller' => 'industries', 'action' => 'index'));
    Router::connect('/admin', array('controller' => 'administrations', 'action' => 'index'));
    Router::connect('/lostpw', array('controller' => 'users', 'action' => 'retrieve'));
    Router::connect('/signup', array('controller' => 'users', 'action' => 'add'));
    Router::connect('/settings', array('controller' => 'users', 'action' => 'edit'));
    Router::connect('/options', array('controller' => 'options', 'action' => 'index'));
    Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
    Router::connect('/industry/manufacturingcalculator', array('controller' => 'industries', 'action' => 'item_search'));
    Router::connect('/industry/manufacturingcalculator/*', array('controller' => 'industries', 'action' => 'item_view'));
    Router::connect('/industry/refiningcalculator', array('controller' => 'industries', 'action' => 'refiningcalculator'));
    Router::connect('/industry/refiningcalculator/*', array('controller' => 'industries', 'action' => 'refiningcalculator'));
    Router::connect('/character', array('controller' => 'characters', 'action' => 'index'));
    Router::connect('/character/wallet', array('controller' => 'characters', 'action' => 'wallet'));
    Router::connect('/character/*', array('controller' => 'users', 'action' => 'switchcharacter'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
    Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
