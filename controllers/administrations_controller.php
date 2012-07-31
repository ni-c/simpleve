<?php

/**
 * Controller for the administration menu
 * 
 * @author Willi Thiel
 * @date 2010-10-05
 * @version 1.0
 */
class AdministrationsController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Administrations';

    var $title_for_layout = "Administration";
    
    /**
     * An array containing the class names of models this controller uses.
     *
     * This controller for static pages doesn't use a model.
     */
    var $uses = array('SubscriptionJournal', 'Api', 'User');
    
    /**
     * Array containing the names of components this controller uses. Component names
     * should not contain the "Component" portion of the classname.
     */
    var $components = array('Options');
    
    public $allowedActions = array(
        'updateSubscriptions'
    ); 
    
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
        $this->Auth->mapActions(
            array(
                'create' => array('index', 'save_api', 'setGeneralOption'),
            )
        );
        parent::beforeFilter();
    }
 
    /**
     * Displays a static page.
     */
    function index() {
        if ($this->loggedUser['username']!='admin') {
            $this->redirect('/');
            exit();
        }

        $subscription_api_user_id = $this->Options->getGeneral('subscription_api_user_id');
        $subscription_api_key = $this->Options->getGeneral('subscription_api_key');
        $subscription_character_id = $this->Options->getGeneral('subscription_character_id');
        $data = array(
            'Administration' => array(
                'subscription_api_user_id' => $subscription_api_user_id,
                'subscription_api_key' => $subscription_api_key,
                'subscription_character_id' => $subscription_character_id
            )
        );
        if (($subscription_api_user_id!==false) && ($subscription_api_key!==false)) {
            $Apis = $this->_createApi();
            $SubscriptionCharacters = $this->AleApi->getCharacterSheets($Apis);
            $this->set('SubscriptionCharacters', $SubscriptionCharacters);
        }
        
        $SubscriptionJournal = $this->SubscriptionJournal->find('all', 
            array(
                'limit' => 20,
                'order' => 'SubscriptionJournal.timestamp DESC'
            )
        );
        
        $this->set('SubscriptionJournal', $SubscriptionJournal);
        $this->set('data', $data);
    }
    
    function save_api() {
        $this->autoRender = false;
        if (!empty($this->data)) {
            $this->Options->setGeneral('subscription_api_user_id', $this->data['Administration']['subscription_api_user_id']);
            $this->Options->setGeneral('subscription_api_key', $this->data['Administration']['subscription_api_key']);
            if (isset($this->data['Administration']['subscription_character_id'])) {
                $this->Options->setGeneral('subscription_character_id', $this->data['Administration']['subscription_character_id']);
            }
        }
        $this->redirect($this->referer());
    }
    
    function setGeneralOption($key, $value) {
        $this->autoRender = false;
        $this->Options->setGeneral($key, $value);
        $this->redirect($this->referer());
    }
 
    function updateSubscriptions() {
        $this->autoRender = false;
        $SubscriptionApi = $this->_createApi();
        $EveWalletJournal = $this->AleApi->requestApi('char', 'WalletJournal', array(), $SubscriptionApi[1]['Api']);
        foreach ($EveWalletJournal->getSimpleXMLElement()->result->rowset->row as $row) {
            $attributes = $row->attributes();
            // Player Donation refTypeID = 10 
            if (($attributes['refTypeID']=='10') && 
                ($attributes['ownerID2']==$SubscriptionApi[1]['Api']['api_character_id']) && 
                (((float)$attributes['amount'])>0.0)) {
                $SubscriptionJournal = array();
                $SubscriptionJournal['SubscriptionJournal']['ref_id'] = $attributes['refID'];
                $SubscriptionJournal['SubscriptionJournal']['character_id'] = ((int)$attributes['ownerID1']);
                $SubscriptionJournal['SubscriptionJournal']['character_name'] = $attributes['ownerName1'];
                $SubscriptionJournal['SubscriptionJournal']['reason'] = strtotime($attributes['reason']);
                $SubscriptionJournal['SubscriptionJournal']['amount'] = ((float)$attributes['amount']);
                $SubscriptionJournal['SubscriptionJournal']['timestamp'] = strtotime($attributes['date']);
                
                $count = $this->SubscriptionJournal->find('count',
                    array('conditions' =>
                        array(
                            'SubscriptionJournal.ref_id' => $SubscriptionJournal['SubscriptionJournal']['ref_id']
                        )
                    )
                );
                if ($count==0) {
                    $Apis = $this->Api->find('all');
                    $characterSheets = $this->AleApi->getCharacterSheets($Apis);
                    foreach ($characterSheets as $api_id => $characterSheet) {
                        if ($characterSheet!=false) {
                            foreach ($characterSheet->getSimpleXMLElement()->result->rowset->row as $characterSheet) {
                                $attributes = $characterSheet->attributes();
                                $character_id = ((int)$attributes['characterID']);
                                if ($character_id==$SubscriptionJournal['SubscriptionJournal']['character_id']) {
                                    $Api = $this->Api->findById($api_id);
                                    $user_id = $Api['Api']['user_id'];
                                    $User = $this->User->findById($user_id);
                                    $User['User']['balance'] = $User['User']['balance'] + $SubscriptionJournal['SubscriptionJournal']['amount'];
                                    $this->User->id = $User['User']['id'];
                                    unset($User['User']['modified']);
                                    $this->_updateExpireDate($User['User']['balance'], $User['User']['expires'], 180000000.0, 365);
                                    $this->_updateExpireDate($User['User']['balance'], $User['User']['expires'], 50000000.0, 90);
                                    $this->_updateExpireDate($User['User']['balance'], $User['User']['expires'], 20000000.0, 30);
                                    $this->User->set($User);
                                    $this->User->save();
                                }
                            }
                        }
                    }
                    
                    $this->SubscriptionJournal->id = null;
                    $this->SubscriptionJournal->set($SubscriptionJournal);
                    $this->SubscriptionJournal->save();
                }
            }
        }
    }

    private function _createApi() {
        $subscription_api_user_id = $this->Options->getGeneral('subscription_api_user_id');
        $subscription_api_key = $this->Options->getGeneral('subscription_api_key');
        $subscription_character_id = $this->Options->getGeneral('subscription_character_id');
        return array(
            1 => array(
                'Api' => array(
                    'id' => 0,
                    'is_active' => 1,
                    'errorcode' => 0,
                    'api_user_id' => $subscription_api_user_id,
                    'api_key' => $subscription_api_key,
                    'api_character_id' => $subscription_character_id
                )    
            ) 
        );
    }
    
    private function _updateExpireDate(&$balance, &$expires, $amount, $days) {
        if ($expires!=0) {
            while ($balance>=$amount) {
                if ($expires<time()) {
                    $expires = time();
                }
                $balance = $balance - $amount;
                $expires = $expires + ($days * 24 * 60 * 60);
            }   
        }
    }
}
?>