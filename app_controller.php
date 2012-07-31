<?php

/**
 * The AppController class is the parent class to all of your application's controllers.
 * 
 * @author Willi Thiel
 * @date 2010-09-02
 * @version 1.0
 */
class AppController extends Controller {
 
    /**
     * The basic components
     */
    public $components = array(
        'Acl', 
        'Auth', 
        'Cookie',
        'Session',
        'Submenu',
        'EveCalc',
        'AleApi',
        'Options',
        'EveDbTool',
        'RequestHandler'
    );
    
    /**
     * The basic helpers
     */
    public $helpers = array(
        'Html', 
        'Form',
        'Js' => array(
            'Mootools'
        ), 
        'Session',
        'EveIcon',
        'EveIgb',
        'Timespan',
        'Tools',
        'CharacterXml'
    );

    /**
     * The basic models
     */
    var $uses = array(
        'Api',
        'Option',
        'CustomValue',
        'User'
        );

    /**
     * provides default page title in case custom is not created within controller
     */
    public $pageTitle = 'simplEVE';

    /**
     * Provides access for actions which most often do not require any access control. 
     */
    public $allowedActions = array(
        'build_acl'
    );

    /**
     * By default all actions are denied.  However, sometimes we
     * want to deny the actions allowed by default, so you can use
     * this class attribute in sub classes to deny an index, view or display action
     */
    public $deniedActions = array();

    /*
     * where to go after a successful login?
     */
    public $loginRedirect = '/';

    /**
     * user model of logged in user. 
     */
    public $loggedUser = null;

    /**
     * Determines if a user can use the remember me feature of the Users/login function
     */
    public $allowCookie = TRUE;

    /**
     * Determines length of time that the cookie will be valid.
     *
     * If a value is here, but allowCookie is FALSE, then the term value is ignored.
     */
    public $cookieTerm = '+4 weeks';

    /**
     * Name to use for cookie holding user values
     */
    public $cookieName = 'User';

    /**
     * The basepath of the homepage
     */
    public $BP = '';
  
    /**
     * All options for the current user
     */
    public $options = array();

    /**
     * The custom vales for the current user
     */
    public $customvalues = array();

    public $title_for_layout = '';
    
    /**
     * Configures the items that appear on the site's menu
     */
    var $menuItems = array(
        array(
            'restricted' => FALSE, 
            'label' => 'Home',
            'controller' => 'Pages',
            'crud' => 'read',
            'url' => '/'
        ),
        array(
            'restricted' => TRUE,
            'label' => 'Dashboard',
            'controller' => 'Dashboard',
            'crud' => 'read',
            'url' => '/dashboard'
        ),
        array(
            'restricted' => TRUE,
            'label' => 'Character',
            'controller' => 'Characters',
            'crud' => 'read',
            'url' => '/character'
        ),
        array(
            'restricted' => TRUE,
            'label' => 'Industry',
            'controller' => 'Industries',
            'crud' => 'read',
            'url' => '/industry'
        ),
        array(
            'restricted' => FALSE,
            'label' => 'About',
            'controller' => 'Pages',
            'crud' => 'read',
            'url' => '/about'
        ),
        array(
            'restricted' => TRUE,
            'label' => 'Admin',
            'controller' => 'Administrations',
            'crud' => 'create',
            'url' => '/admin'
        )
    );

    /**
     * If the site is accessed via the IngameBrowser
     */
    var $IGB = false;
    
    /**
     * The header info of the InGameBrowser
     */
    var $igbInfo = array();
    
    /**
     * Holds data used to build site menu
     */
    var $menu = array();
    
    function beforeFilter() {
        $cookie = null;

        $this->Auth->userScope = array('User.is_active' => 1);
        
        // first tell Auth which actions do not need any access control
        foreach( $this->allowedActions as $allowAction ){
            $this->Auth->allow( $allowAction );
        }
        // now tell Auth which actions require authentication
        foreach( $this->deniedActions as $denyAction ){
            $this->Auth->deny( $denyAction );
        }
        $this->checkAuth();
        if( !$this->__setLoggedUserValues() && ($cookie = $this->Cookie->read( $this->cookieName ) ) ){
            $this->Auth->login($cookie);
            $this->__setLoggedUserValues();
        }   
        $this->set('newsflash', false);
        $this->BP = 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot;
        
        App::import('Vendor', 'ale/factory');
        $this->AleApi->init($this);
        $this->apis = $this->Api->find('all', array('conditions' => array(
            'Api.user_id' => $this->loggedUser['id'], 
            'Api.is_active' => '1')));
        $this->characters = $this->AleApi->requestApis($this->apis, 'char', 'CharacterSheet');

        $this->_setIgbInformations();
        
        $this->active_character = null; 
        $this->Options->init($this);

        $active_CharacterID = $this->Options->get('active_character');
        if ($active_CharacterID==false) {
            $first_api = reset($this->apis);
            if (isset($this->characters[$first_api['Api']['id']])) {
                $first_character = reset($this->characters[$first_api['Api']['id']]);
                $this->active_character = $first_character;
            }
        } else {
            foreach($this->characters as $api_characters) {
                foreach ($api_characters as $character) {
                    if ($character['characterID'] == $active_CharacterID) {
                        $this->active_character = $character;
                        break;
                    }
                }   
            };
        }
        $this->options = $this->Options->get();
        $this->generalOptions = $this->Options->getGeneral();
        $this->EveDbTool->init($this);

        // Check if account is expired                
        if (($this->Auth->user()) &&
            ($this->loggedUser['group_id']<4) &&
            ($this->loggedUser['group_id']>1) && 
            ($this->loggedUser['expires']!=0) && 
            ($this->loggedUser['expires']<time())) {
            $this->loggedUser['group_id'] = 1;
            unset($this->loggedUser['modified']);
            $this->User->id = $this->loggedUser['id'];
            $this->User->set($this->loggedUser);
            $this->User->save();
            $this->_refreshAuth();
            $this->redirect($this->referer());
        } 
        // Check if subscription is renewed
        if (($this->Auth->user()) &&
            ($this->loggedUser['group_id']==1) &&
            ($this->loggedUser['expires']!=0) && 
            ($this->loggedUser['expires']>time())) {
            $this->loggedUser['group_id'] = 3;
            unset($this->loggedUser['modified']);
            $this->User->id = $this->loggedUser['id'];
            $this->User->set($this->loggedUser);
            $this->User->save();
            $this->_refreshAuth();
            $this->redirect($this->referer());
        }
    }

    function beforeRender(){
        $this->__buildMenu();
        $this->Submenu->addLinks();
        $this->set('submenus', $this->Submenu->get());
        $this->set('BP', $this->BP);
        $this->set('apis', $this->apis);
        $this->set('characters', $this->characters);
        $this->set('active_character', $this->active_character);
        $this->set('options', $this->options);
        $this->set('generalOptions', $this->generalOptions);
        $this->set('limitedApi', $this->loggedUser['limitedApi']);
        if ($this->loggedUser) {
            $this->set('user', $this->loggedUser);
            $this->set('CustomValues', $this->_createCustomValuesArray());
        }
        $this->set('IGB', $this->IGB);
        $this->set('title_for_layout', $this->title_for_layout);
    }

    function _setIgbInformations() {
        $this->IGB = strpos($_SERVER['HTTP_USER_AGENT'],"EVE-IGB");
        if (($this->IGB) && ($_SERVER['HTTP_EVE_TRUSTED']=="Yes")) {
            $this->igbInfo['serverIP'] = (isset($_SERVER['HTTP_EVE_SERVERIP']) ? $_SERVER['HTTP_EVE_SERVERIP'] : '');
            $this->igbInfo['characterName'] = (isset($_SERVER['HTTP_EVE_CHARNAME']) ? $_SERVER['HTTP_EVE_CHARNAME'] : '');
            $this->igbInfo['characterID'] = (isset($_SERVER['HTTP_EVE_CHARID']) ? $_SERVER['HTTP_EVE_CHARID'] : '');
            $this->igbInfo['corporationName'] = (isset($_SERVER['HTTP_EVE_CORPNAME']) ? $_SERVER['HTTP_EVE_CORPNAME'] : '');
            $this->igbInfo['corporationID'] = (isset($_SERVER['HTTP_EVE_CORPID']) ? $_SERVER['HTTP_EVE_CORPID'] : '');
            $this->igbInfo['allianceName'] = (isset($_SERVER['HTTP_EVE_ALLIANCENAME']) ? $_SERVER['HTTP_EVE_ALLIANCENAME'] : '');
            $this->igbInfo['allianceID'] = (isset($_SERVER['HTTP_EVE_ALLIANCEID']) ? $_SERVER['HTTP_EVE_ALLIANCEID'] : '');
            $this->igbInfo['regionName'] = (isset($_SERVER['HTTP_EVE_REGIONNAME']) ? $_SERVER['HTTP_EVE_REGIONNAME'] : '');
            $this->igbInfo['solarSystemName'] = (isset($_SERVER['HTTP_EVE_SOLARSYSTEMNAME']) ? $_SERVER['HTTP_EVE_SOLARSYSTEMNAME'] : '');
            $this->igbInfo['stationName'] = (isset($_SERVER['HTTP_EVE_STATIONNAME']) ? $_SERVER['HTTP_EVE_STATIONNAME'] : '');
            $this->igbInfo['stationID'] = (isset($_SERVER['HTTP_EVE_STATIONID']) ? $_SERVER['HTTP_EVE_STATIONID'] : '');
            $this->igbInfo['corpRole'] = (isset($_SERVER['HTTP_EVE_CORPROLE']) ? $_SERVER['HTTP_EVE_CORPROLE'] : '');
        }        
    }

    /**
     * Sets a value for current logged user that is easily accessed by rest of application.
     * @returns boolean TRUE if there is a logged user FALSE if no user is logged in.
     */
    function __setLoggedUserValues(){
        $user = null;
        if( $user = $this->Auth->user() ){
            $this->set('User', $user[$this->Auth->userModel]);
            $this->loggedUser = $user[$this->Auth->userModel];
            $this->loggedUser['limitedApi'] = false;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sets configuration options for Auth component.
     *
     * @access public
     */
    function checkAuth(){
        if (isset($this->Auth)) {
            $this->Auth->autoRedirect = FALSE;
            $this->Auth->mapActions(array('display'=>'read') );

            // Change the default field names for the username and password 
            $this->Auth->fields = array('username' => 'username', 'password' => 'password');

            // this sets the 
            $this->Auth->loginAction = '/users/login';
            // Where do we go after a successful login?
            $this->Auth->loginRedirect = $this->loginRedirect;
            // what type of authorization setup are we using
            $this->Auth->authorize = 'crud';
            // What to say when the login was incorrect.
            $this->Auth->loginError = 'Sorry, login failed. Either your username or password are incorrect.';
            $this->Auth->authError = 'The page you tried to access is restricted. You have been redirected to this page.';
        }  

    }
    
    function _createCustomValuesArray() {
        $CustomValues = $this->CustomValue->find('all', array('conditions' => array('CustomValue.user_id' => $this->loggedUser['id'])));
        $result = array();
        $allowedValueTypes = $this->requestAction('custom_values/getAllowedValueTypes');
        foreach($CustomValues as $CustomValue) {
            foreach ($allowedValueTypes as $allowedValueType) {
                if (!isset($result[$allowedValueType])) {
                    $result[$allowedValueType] = array();
                }
                if ($CustomValue['CustomValue']['value_type']==$allowedValueType) {
                    $result[$allowedValueType][$CustomValue['CustomValue']['eve_inv_type_id']] = (float)$CustomValue['CustomValue']['value'];
                }
            }
        }
        return $result;
    }

    /**
     * Builds a menu adding restricted links, if user is logged in.
     * @access private
     * @returns null
     */
    function __buildMenu(){
        $this->menu = array();
        foreach( $this->menuItems as $menuLink ){
            if( $menuLink['restricted'] ){
                if( $this->Auth->user() && $this->Acl->check( $this->Auth->user(), $menuLink['controller'], $menuLink['crud'] ) ){
                    $this->menu[] = array('label' => $menuLink['label'], 'url' => $menuLink['url']);
                } else {
                    continue;
                }
            } else {
                $this->menu[] = array('label' => $menuLink['label'], 'url' => $menuLink['url']);
            }
        }
        $this->__buildAdminMenu();
        $this->set('simpleve_menu', $this->menu);

    }

    /**
     * Adds standard links to admin functions depending on logged in user's permissions.
     *
     * @access private
     * @returns null
     */
    function __buildAdminMenu(){
        if( isset( $this->adminLinks[ $this->params['action'] ] ) ){
            foreach( $this->adminLinks[ $this->params['action'] ] as $action ){
                $crud = $this->Auth->actionMap[ $action ];
                $controllerName = Inflector::camelize($this->params['controller']);
                if( $this->loggedUser && $this->Acl->check( $this->loggedUser, $controllerName, $crud ) ){
                    if( ( $action == 'edit' || $action == 'delete' ) && isset($this->params['pass'][0]) ){
                        $actionMod = '/'.$this->params['pass'][0];
                    } else {
                        $actionMod = null;
                    }
                    $this->menu[] = array('label' => $action, 'url' => '/'.$this->params['controller'].'/'.$action.$actionMod);
                }
            }
        }
    }

    
    /**
     * Refreshes the Auth session with new/updated data
     * @param string $field
     * @param string $value
     * @return void 
     */
    function _refreshAuth($field = '', $value = '') {
        if (!empty($field) && !empty($value)) { 
            $this->Session->write($this->Auth->sessionKey .'.'. $field, $value);
        } else {
            if (isset($this->User)) {
                $this->Auth->login($this->User->read(false, $this->Auth->user('id')));
            } else {
                $this->Auth->login(ClassRegistry::init('User')->findById($this->Auth->user('id')));
            }
        }
    }

}