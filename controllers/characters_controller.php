<?php

/**
 * Controller for the Characters.
 * 
 * @author Willi Thiel
 * @date 2010-10-17
 * @version 0.2
 */
class CharactersController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Characters';
    
    /**
     * An array containing the class names of models this controller uses.
     */
    var $uses = array();

    function beforeFilter() {
        $this->Auth->mapActions(
            array(
                'read' => array('wallet'),
            )
        );
        parent::beforeFilter();
    }

    function index() {
        
    }
    
    function wallet() {
        $_journal = $this->AleApi->requestApis($this->apis, 'char', 'WalletJournal', true);
        $_journal = $this->AleApi->convertToArray($_journal);
        $journal = array();
        for ($i=0; $i < 20; $i++) { 
            if (isset($_journal[$i])) {
                $journal[] = $_journal[$i];
            }    
        }
        
        $_transactions = $this->AleApi->requestApis($this->apis, 'char', 'WalletTransactions', true);
        $_transactions = $this->AleApi->convertToArray($_transactions);
        $transactions = array();
        for ($i=0; $i < 20; $i++) {
            if (isset($_transactions[$i])) {
                $transactions[] = $_transactions[$i];
            }
        }
        $orders = $this->AleApi->requestApis($this->apis, 'char', 'MarketOrders', true);
        $orders = $this->AleApi->convertToArray($orders);
        $buyorders = array();
        $sellorders = array();
        foreach($orders as $order) {
            if ($order['orderState']==0) {
                if ($order['bid']==0) {
                    $sellorders[] = $order;
                } else {
                    $buyorders[] = $order;
                }
            }
        }

        $refTypes = $this->AleApi->requestApi('eve', 'RefTypes');
        $refTypes = $this->AleApi->convertToArray($refTypes);
        $sRefType = array();
        foreach ($refTypes as $refType) {
            $sRefType[$refType['refTypeID']] = $refType['refTypeName'];
        }
        
        $this->set('journal', $journal);
        $this->set('buyorders', $buyorders);
        $this->set('sellorders', $sellorders);
        $this->set('transactions', $transactions);
        $this->set('refTypes', $sRefType);
    }
}
