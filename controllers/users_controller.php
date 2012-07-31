<?php
 
/**
 * Controller for the user authentication system.
 * 
 * @author Willi Thiel
 * @date 2010-09-03
 * @version 1.0
 */
class UsersController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Users';

    /**
     * An array containing the class names of models this controller uses.
     *
     * - User for modifying user datasets
     * - Group for assigning Users to groups
     * - Ticket for activation and retrievepassword eMails
     */
    var $uses = array('User', 'Group', 'Ticket');
    
    /**
     * Controller actions for which user validation is not required.
     */
    var $allowedActions = array('logout', 'add', 'retrieve');
    
    /**
     * Array containing the names of components this controller uses. Component names
     * should not contain the "Component" portion of the classname.
     */
    var $components = array('CustomEmail');

    /**
     * Loads Model classes based on the the uses property
     * see Controller::loadModel(); for more info.
     * Loads Components and prepares them for initialization.
     *
     * @return mixed true if models found and instance created, or cakeError if models not found.
     * @access public
     * @see Controller::loadModel()
     * @link http://book.cakephp.org/view/977/Controller-Methods#constructClasses-986
     */
    public function constructClasses() {
        parent::constructClasses();
        $this->Email = $this->CustomEmail;
    }
    
    /**
     * Perform the startup process for this controller.
     * Fire the Component and Controller callbacks in the correct order.
     *
     * - Initializes components, which fires their `initialize` callback
     * - Calls the controller `beforeFilter`.
     * - triggers Component `startup` methods.
     *
     * @return void
     * @access public
     */
    function beforeFilter() {
        $this->_configureAuthCookie();
        $this->Auth->mapActions(
            array(
                'create' => array('build_acl'),
                'update' => array('switchcharacter', 'remove_api', 'add_api', 'apiUserIdExists', 'newapikey'),
            )
        );
        parent::beforeFilter();
    }
 
    /**
     * There is no index for users
     *
     */
    function index() {
        $this->flash("This page is not available for this content.", "/");
    }

    /**
     * Adds a new user to the database
     * 
     * A new ticket is created and the url of this ticket is sent to the user via email, he can activate his account calling the url. 
     */
    function add() {
        if ((!empty($this->data)) && ($this->Options->getGeneral('sign_up_enabled')!=0)) {
            $this->User->set($this->data);
            if ($this->User->validates()) {
                // Set new user to Trial
                $this->User->set('group_id', $this->Group->field('id', array('name' => 'Trials')));
                $this->User->save();
                $user_id = $this->User->getLastInsertId();
                $this->Ticket->set('user_id', $user_id);
                $this->Ticket->set('action', 'activate');
                $this->Ticket->save();
                $url = 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot . 'tickets/approve/' . $this->Ticket->field('hash');
                if ($this->_sendActivationEmail($user_id, $url)) {
                    $this->flash(
                        'An email with your login information has been sent to ' . $this->data['User']['email'] . '.' . 
                        'Please follow the instructions in this email to activate your account. ', '/', 60);
                }
            } else {
               $this->set('errors', $this->User->invalidFields()); 
            }
        }
        $this->set('sign_up_enabled', $this->Options->getGeneral('sign_up_enabled'));
    }

    /**
     * Custom login function to allow for cookies.
     *
     * @access public
     * @return null will redirect upon success.
     *
     */
    function login() {
        if ($this->Auth->user()) {
            if (!empty($this->data)) {
                if (empty($this->data['User']['remember_me'])) {
                    $this->Cookie->delete('User');
                } elseif( $this->allowCookie ) {
                    $cookie = array();
                    $cookie['username'] = $this->data['User']['username'];
                    $cookie['password'] = $this->data['User']['password'];
                    $this->Cookie->write('User', $cookie, true, $this->cookieTerm );
                }
                unset($this->data['User']['remember_me']);
                $User = $this->User->findByUsername($this->data['User']['username']);
                $this->Session->write('User.id', $User['User']['id']);
            }
            $this->redirect($this->Auth->redirect());
        }
        $this->render('/pages/home');
    }

    /**
     * Destroys both cookie and session login variables.
     *
     * @access public
     * @return null will redirect.
     */
    function logout() {
        $this->Auth->logout();
        $this->Session->delete('User');
        $this->Cookie->delete('User'); 
        $this->flash("You are now logged out of the site.", '/', 1);
    }

    /**
     * There is no delete action for users, this is reserved for the usersmanager controller
     *
     */
    function delete($id = null) {
        if ($this->loggedUser!='admin') {
            $this->redirect('/');
            exit();
        }
        $this->User->read(null, $id);
        $user = $this->User->field('name');
        $this->User->set('group_id', $this->Group->field('id', array('name' => 'Users')));
        $this->User->set('is_active', 0);
        $this->User->save();
        $this->flash('User ' . $user . ' has been deleted.', '/', 10000);
    }   

    /**
     * allows retrieving a lost password
     * 
     * A new ticket is created and the url of this ticket is sent to the user via email, he can change his password after calling the url. 
     */
    function retrieve() {
        if (!empty($this->data)) {
            if ($this->User->find('count', array('conditions' => array('User.email' => $this->data['User']['email'])))==1) {
                $User = $this->User->findByEmail($this->data['User']['email']);
                $this->Ticket->set('user_id', $User['User']['id']);
                $this->Ticket->set('action', 'newpasswd');
                $this->Ticket->save();
                $url = 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot . 'tickets/approve/' . $this->Ticket->field('hash');
                if ($this->_sendRetrievePasswdEmail($this->User->field('username'), $this->data['User']['email'], $url)) {
                    $this->flash(
                        'An email with your login information has been sent to ' . $this->data['User']['email'] . '.' . 
                        'Please follow the instructions in this email to restore your password. ', '/', 60);
                }
            } else {
                $this->flash('Email not found in database.');
            }
        } else {
        }
    }

    /**
     * allows editing of the email and the password
     */
    function edit() {
        if (!empty($this->data)) {
            $this->User->read(null, $this->loggedUser['id']);
            $this->User->set('email', $this->data['User']['email']);
            $this->loggedUser['email'] = $this->data['User']['email'];
            $this->set('User', $this->User->data['User']);
            if (($this->data['User']['passwd']!='') || ($this->data['User']['passwd2']!='')) {
                $this->User->set('passwd', $this->data['User']['passwd']);
                $this->User->set('passwd2', $this->data['User']['passwd2']);
                $this->User->validatePasswordOn('update');
            }
            $this->User->save();
        }
        $this->Api->unbindModel(array('belongsTo' => array('User')));
        $allApis = $this->Api->find('all', array('conditions' => array(
            'Api.user_id' => $this->loggedUser['id'])));
        $this->set('allApis', $allApis);
    }
    
    /**
     * Switch to another character
     */
    function switchcharacter($id) {
        $valid_id = false;        
        foreach($this->characters as $api_characters) {
            foreach ($api_characters as $api) {
                if ($api['characterID'] == $id) {
                    $valid_id = true;
                    break;
                }
            }   
        };
        if ($valid_id) {
            $this->Options->set('active_character', $id);
        }
        $this->redirect($this->referer());
    }

    function newapikey() {
        $this->User->read(null, $this->loggedUser['id']);
        $this->User->set('hash', '');
        $this->User->save();
        $this->_refreshAuth();
        $this->redirect($this->referer());
    }
    
    /**
     * Delete an API connection
     */
    function remove_api($id) {
        $this->Api->deleteAll(
            array(
                'user_id' => $this->loggedUser['id'],
                'api_user_id' => $id,
            ), false);
        $this->Options->set('active_character', false);
        $this->redirect($this->referer());
    }

    /**
     * Delete an API connection
     */
    function add_api() {
        if (!empty($this->data)) {
            if (!empty($this->data['User']['api_user_id']) && 
                (!empty($this->data['User']['api_key']))) {
                $api = array(
                    'Api' => array(
                        'user_id' => $this->loggedUser['id'],
                        'api_user_id' => $this->data['User']['api_user_id'],
                        'api_key' => $this->data['User']['api_key'],
                        'errorcode' => 0,
                        )
                    );
                $this->Api->set($api);
                $this->Api->save();
            }
        }
        $this->redirect($this->referer());
    }
    
    /**
     * Create ACL entries in the database
     */
    function build_acl() {
        $this->autoRender = false;
        if ($this->loggedUser['username']!='admin') {
            $this->redirect('/');
        } else {
            if (!Configure::read('debug')) {
                return $this->_stop();
            }
            $log = array();
    
            $aco =& $this->Acl->Aco;
            $root = $aco->node('controllers');
            if (!$root) {
                $aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers'));
                $root = $aco->save();
                $root['Aco']['id'] = $aco->id; 
                $log[] = 'Created Aco node for controllers';
            } else {
                $root = $root[0];
            }   
    
            App::import('Core', 'File');
            $Controllers = Configure::listObjects('controller');
            $appIndex = array_search('App', $Controllers);
            if ($appIndex !== false ) {
                unset($Controllers[$appIndex]);
            }
            $baseMethods = get_class_methods('Controller');
            $baseMethods[] = 'buildAcl';
    
            $Plugins = $this->_getPluginControllerNames();
            $Controllers = array_merge($Controllers, $Plugins);
    
            // look at each controller in app/controllers
            foreach ($Controllers as $ctrlName) {
                $methods = $this->_getClassMethods($this->_getPluginControllerPath($ctrlName));
    
                // Do all Plugins First
                if ($this->_isPlugin($ctrlName)){
                    $pluginNode = $aco->node('controllers/'.$this->_getPluginName($ctrlName));
                    if (!$pluginNode) {
                        $aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $this->_getPluginName($ctrlName)));
                        $pluginNode = $aco->save();
                        $pluginNode['Aco']['id'] = $aco->id;
                        $log[] = 'Created Aco node for ' . $this->_getPluginName($ctrlName) . ' Plugin';
                    }
                }
                // find / make controller node
                $controllerNode = $aco->node('controllers/'.$ctrlName);
                if (!$controllerNode) {
                    if ($this->_isPlugin($ctrlName)){
                        $pluginNode = $aco->node('controllers/' . $this->_getPluginName($ctrlName));
                        $aco->create(array('parent_id' => $pluginNode['0']['Aco']['id'], 'model' => null, 'alias' => $this->_getPluginControllerName($ctrlName)));
                        $controllerNode = $aco->save();
                        $controllerNode['Aco']['id'] = $aco->id;
                        $log[] = 'Created Aco node for ' . $this->_getPluginControllerName($ctrlName) . ' ' . $this->_getPluginName($ctrlName) . ' Plugin Controller';
                    } else {
                        $aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $ctrlName));
                        $controllerNode = $aco->save();
                        $controllerNode['Aco']['id'] = $aco->id;
                        $log[] = 'Created Aco node for ' . $ctrlName;
                    }
                } else {
                    $controllerNode = $controllerNode[0];
                }
    
                //clean the methods. to remove those in Controller and private actions.
                foreach ($methods as $k => $method) {
                    if (strpos($method, '_', 0) === 0) {
                        unset($methods[$k]);
                        continue;
                    }
                    if (in_array($method, $baseMethods)) {
                        unset($methods[$k]);
                        continue;
                    }
                    $methodNode = $aco->node('controllers/'.$ctrlName.'/'.$method);
                    if (!$methodNode) {
                        $aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => null, 'alias' => $method));
                        $methodNode = $aco->save();
                        $log[] = 'Created Aco node for '. $method;
                    }
                }
            }
            if(count($log)>0) {
                debug($log);
            }
        }
        die();
    }

    /**
     * Checks for allowCookie value and sets proper view value.
     *
     * @access private
     * @returns NULL
     */
    private function _configureAuthCookie(){
        if( $this->allowCookie ){
            // this prevents the remember_me option from appearing in the user login form
            $this->set('remember_me', TRUE);
        } else {
            $this->set('remember_me', FALSE);
        }
    }

    /**
     * Checks if logged in user has same id as one being edited
     *
     * @access private
     * @params string $recordId the id of the record being accessed
     * @returns boolean True if logged in User id is same as id being edited
     */
    private function _checkUsersOwnRecord($recordId = null) {
        if( $this->Auth->user('id') == $recordId ){
            return TRUE;
        } else {
            return FALSE;
        }
    }
        
    /**
     * Hash submitted passwords according to the scheme used by the Auth component
     *
     * We need to keep a copy of the string submitted by the user, so we can
     * use built-in validation rules on it.  However, we also need to convert this value
     * to the hashed string that will be stored in the database.
     *
     * @access private
     * @return null
     *
     */
    private function _convertPasswords() {
        if(!empty( $this->data['User']['new_passwd'] ) ){
            // we still want to validate the value entered in new_passwd
            // so we store the hashed value in a new data field which
            // we will later pass on to the passwd field in an 
            // afterSave() function 
            $this->data['User']['new_passwd_hash'] = $this->Auth->password( $this->data['User']['new_passwd'] );
        }
    }

    /**
     * Sent the account activation email to the user.
     * 
     * @access private
     * @param $user_id The id of the new user.
     * @param $url The activation link.
     * @return If sending was successful
     */
    private function _sendActivationEmail($user_id, $url) {
        $User = $this->User->read(null,$user_id);
        $this->Email->to = $User['User']['email'];
        $this->Email->subject = 'Registration verification';
        $this->Email->template = 'accountactivation';
        $this->set('url', $url);
        return $this->Email->send();
    } 

    /**
     * Sent the account activation email to the user.
     * 
     * @access private
     * @param email The email of the user.
     * @param $url The retrieve password link.
     * @return If sending was successful
     */
    private function _sendRetrievePasswdEmail($username, $email, $url) {
        $this->Email->to = $email;
        $this->Email->subject = 'Verify password reset';
        $this->Email->template = 'retrievepasswd';
        $this->set('username', $username);
        $this->set('email', $email);
        $this->set('url', $url);
        return $this->Email->send();
    }

    private function _getClassMethods($ctrlName = null) {
        App::import('Controller', $ctrlName);
        if (strlen(strstr($ctrlName, '.')) > 0) {
            // plugin's controller
            $num = strpos($ctrlName, '.');
            $ctrlName = substr($ctrlName, $num+1);
        }
        $ctrlclass = $ctrlName . 'Controller';
        $methods = get_class_methods($ctrlclass);

        // Add scaffold defaults if scaffolds are being used
        $properties = get_class_vars($ctrlclass);
        if (array_key_exists('scaffold',$properties)) {
            if($properties['scaffold'] == 'admin') {
                $methods = array_merge($methods, array('admin_add', 'admin_edit', 'admin_index', 'admin_view', 'admin_delete'));
            } else {
                $methods = array_merge($methods, array('add', 'edit', 'index', 'view', 'delete'));
            }
        }
        return $methods;
    }

    private function _isPlugin($ctrlName = null) {
        $arr = String::tokenize($ctrlName, '/');
        if (count($arr) > 1) {
            return true;
        } else {
            return false;
        }
    }

    private function _getPluginControllerPath($ctrlName = null) {
        $arr = String::tokenize($ctrlName, '/');
        if (count($arr) == 2) {
            return $arr[0] . '.' . $arr[1];
        } else {
            return $arr[0];
        }
    }

    private function _getPluginName($ctrlName = null) {
        $arr = String::tokenize($ctrlName, '/');
        if (count($arr) == 2) {
            return $arr[0];
        } else {
            return false;
        }
    }

    private function _getPluginControllerName($ctrlName = null) {
        $arr = String::tokenize($ctrlName, '/');
        if (count($arr) == 2) {
            return $arr[1];
        } else {
            return false;
        }
    }

    /**
     * Get the names of the plugin controllers ...
     * 
     * This function will get an array of the plugin controller names, and
     * also makes sure the controllers are available for us to get the 
     * method names by doing an App::import for each plugin controller.
     *
     * @return array of plugin names.
     *
     */
    private function _getPluginControllerNames() {
        App::import('Core', 'File', 'Folder');
        $paths = Configure::getInstance();
        $folder =& new Folder();
        $folder->cd(APP . 'plugins');

        // Get the list of plugins
        $Plugins = $folder->read();
        $Plugins = $Plugins[0];
        $arr = array();

        // Loop through the plugins
        foreach($Plugins as $pluginName) {
            // Change directory to the plugin
            $didCD = $folder->cd(APP . 'plugins'. DS . $pluginName . DS . 'controllers');
            // Get a list of the files that have a file name that ends
            // with controller.php
            $files = $folder->findRecursive('.*_controller\.php');

            // Loop through the controllers we found in the plugins directory
            foreach($files as $fileName) {
                // Get the base file name
                $file = basename($fileName);

                // Get the controller name
                $file = Inflector::camelize(substr($file, 0, strlen($file)-strlen('_controller.php')));
                if (!preg_match('/^'. Inflector::humanize($pluginName). 'App/', $file)) {
                    if (!App::import('Controller', $pluginName.'.'.$file)) {
                        debug('Error importing '.$file.' for plugin '.$pluginName);
                    } else {
                        /// Now prepend the Plugin name ...
                        // This is required to allow us to fetch the method names.
                        $arr[] = Inflector::humanize($pluginName) . "/" . $file;
                    }
                }
            }
        }
        return $arr;
    }
    
}
?>