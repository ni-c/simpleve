<?php

/**
 * Controller for EveCentral requests.
 * 
 * @author Willi Thiel
 * @date 2010-09-19
 * @version 1.0
 */
class PricesController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Evecentral';
    
    /**
     * An array containing the class names of models this controller uses.
     */
    var $uses = array();

    var $customvalues = array();
    
    function beforeFilter() {
        $this->Auth->mapActions(
            array(
                'read' => array('single'),
            )
        );
    }
    
    function single($id, $region = 'custom', $type = 'buy') {
        if (!isset($this->AleApi)) {
            App::import('Vendor', 'ale/factory');
            App::import('Component', 'AleApi');
            $this->AleApi = new AleApiComponent();
        }
        if ($region==0) {
            $region = null;
        }
        
        if ($region=='all') {
            $region = null;
        }
        if ($region=='custom') {
            if (isset($this->customvalues['price'][$id])) {
                $this->customvalues = $this->_createCustomValuesArray();
                return $this->customvalues['price'][$id];
            } else {
                $region = 10000002; 
            }
        }
        $MarketStat = $this->AleApi->getEveCentralMarketStat($id, $region);
        switch ($type) {
            case 'median':        
                return $MarketStat->marketstat->type->all->median;
                break;
            case 'buy':  
                if ($MarketStat->marketstat->type->buy->max=='') {
                    // fallback to sell price if no buy price is set
                    $price = $MarketStat->marketstat->type->sell->min;
                } else {
                    $price = $MarketStat->marketstat->type->buy->max;
                }
                return $price;
                break;
            case 'sell':
                if ($MarketStat->marketstat->type->sell->min=='') {
                    // fallback to buy price if no buy price is set
                    $price = $MarketStat->marketstat->type->buy->max;
                } else {
                    $price = $MarketStat->marketstat->type->sell->min;
                }
                return $price;
                break;
            default:
                return 0.0;
        }
    }
}
?>
