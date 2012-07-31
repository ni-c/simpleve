<?php

/**
 * Helper for creating Eve Ingamebrowser Links
 * 
 * @author Willi Thiel
 * @date 2010-09-20
 * @version 1.0
 */
class EveIgbHelper extends AppHelper {

    var $helpers = array('Html');

    function showInfo($typeID, $itemID = null) {
        if ($this->isIGB()) {
            return '<a onclick="CCPEVE.showInfo(' . $typeID . (($itemID!=null) ? ', ' . $itemID : '') . ')" title="Show Info">' . $this->Html->image('theme/info.gif', array('class' => 'igb', 'alt' => 'Show Info')) . '</a>';
        }
        return '';
    }

    function showMarketDetails($typeID) {
        if ($this->isIGB()) {
            return '<a onclick="CCPEVE.showMarketDetails(' . $typeID . ')" title="Show Market Details">' . $this->Html->image('theme/market.gif', array('class' => 'igb', 'alt' => 'Show Market Details')) . '</a>';
        }
        return '';
    }
    
    function showMap($systemID) {
        if ($this->isIGB()) {
            return '<a onclick="CCPEVE.showMap(' . $systemID . ')" title="Show Map">' . $this->Html->image('theme/map.png', array('class' => 'igb', 'alt' => 'Show Map')) . '</a>';
        }
        return '';
    }
    
    function setDestination($systemID) {
        if ($this->isIGB()) {
            return '<a onclick="CCPEVE.setDestination(' . $systemID . ')" title="Set Destination">' . $this->Html->image('theme/route.png', array('class' => 'igb', 'alt' => 'Set Destination')) . '</a>';
        }
        return '';
    }
    
    function isIGB() {
        return (strpos($_SERVER['HTTP_USER_AGENT'],"EVE-IGB"));
    }
}

?>