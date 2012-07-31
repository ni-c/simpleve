<?php

/**
 * View tools
 * 
 * @author Willi Thiel
 * @date 2010-09-11
 * @version 1.0
 */
class ToolsHelper extends AppHelper {
    
    var $helpers = array(
        'Html',
        'EveIgb',
        'CharacterXml',
        'EveIcon');
    
    /**
     * Save reference to controller on startup.
     * 
     * @param $controller The parent controller of this component.
     */
    function startup(&$controller) {
    }
    
    function randomStr($length = 32) {
        return $this->_str_rand($length);
    }

    function getRomanNumber($int) {
        switch ($int) {
            case 1: return 'I';
            case 2: return 'II';
            case 3: return 'III';
            case 4: return 'IV';
            case 5: return 'V';
        }
        return $int;
    }

    function getSwitchArray($option) {
        $result = array();
        if ($option == 1) {
            $result['img'] = 'theme/minus.gif';
            $result['class'] = '';
        } else {
            $result['img'] = 'theme/plus.gif';
            $result['class'] = ' hidden';
        }
        return $result;
    }
    
    function getOptionsCheckbox($options, $key) {
        if ((isset($options[$key])) && ($options[$key]==1)) {
            $class = " checked";
            $value = "0";
        } else {
            $class = "";
            $value = "1";
        }
        return '<span class="checkbox' . $class . '" callbacks="saveOption(\'' . $key . '\', \'' . $value . '\')"></span>';
    }
    
    function getItemLinks($item, $icon = false, $id = null) {
        $item = $this->getItemInfo($item, $icon, $id);
        if ($icon) {
            $tmp = $item['icon'] . ' &nbsp; ';
        } else {
            $tmp = '';
        }
        return trim($tmp . $item['link']);
    }
    
    function getItemInfo($item, $icon = false, $id = null) {
        $result = array();
        if ($id==null) {
            $id = $this->randomStr();
        }
        if ($icon) {
            $EveInvType = $this->requestAction('/database/invtype/' . $item . '/2');
            
            $result['icon'] = $this->EveIcon->getIcon(
                16, 
                $EveInvType['EveGraphic'], 
                $EveInvType['EveInvType']['typeID'], 
                $EveInvType['EveInvGroup']['EveInvCategory']['categoryName'], 
                1
            );
        } else {
            $EveInvType = $this->requestAction('/database/invtype/' . $item);
            $result['icon'] = '';
        }
        $result['link'] =
            $this->Html->link($EveInvType['EveInvType']['typeName'], '/industry/manufacturingcalculator/' . $EveInvType['EveInvType']['typeID'], array('id' => $id . '_item')) .
            '<div class="linkbox hidden" id="' . $id . '_linkbox">' .
                $this->EveIgb->showMarketDetails($EveInvType['EveInvType']['typeID']) .
                $this->EveIgb->showInfo($EveInvType['EveInvType']['typeID']) .
                '<a href="http://www.eve-central.com/home/quicklook.html?typeid=' . $EveInvType['EveInvType']['typeID'] . '" target="_blank" title="Eve-Central">' .
                    $this->Html->image('theme/evecentral.png', array('alt' => 'Eve-Central')) .
                '</a>' . 
                '<a href="http://www.eve-metrics.com/market/18/items/' . $EveInvType['EveInvType']['typeID'] . '" target="_blank" title="EVE Metrics">' .
                    $this->Html->image('theme/evemetrics.png', array('alt' => 'EVE Metrics')) .
                '</a>' . 
                '<a href="http://en.jitonomic.com/Market/#id=' . $EveInvType['EveInvType']['typeID'] . '" target="_blank" title="Jitonomic">' .
                    $this->Html->image('theme/jitonomic.png', array('alt' => 'Jitonomic')) .
                '</a>' . 
            '</div>';
        return $result;
    }

    function getStationLinks($stationID) {

        $EveStaStation = $this->requestAction('database/stastation/' . $stationID);
        $station = str_replace(' ', '_', $EveStaStation['EveStaStation']['stationName']);
        $link = 'http://evemaps.dotlan.net/outpost/' . $station;
        $eveagents = 'http://www.eve-agents.com/index.dxd?Station=' . $stationID; 
        $title = $EveStaStation['EveStaStation']['stationName'];
        $rRnd = $this->randomStr();
        $result = '
            <a href="'. $link . '" target="_blank" id="' . $rRnd . '_item">' .
                $title .
            '</a>' .
            '<div class="linkbox hidden" id="' . $rRnd . '_linkbox">' .
                $this->EveIgb->showInfo(3867,$stationID) . 
                $this->EveIgb->showMap($EveStaStation['EveStaStation']['solarSystemID']) . 
                $this->EveIgb->setDestination($EveStaStation['EveStaStation']['solarSystemID']) .
                '<a href="' . $link .'" title="Dotlan Maps" target="_blank">' .
                    $this->Html->image('theme/dotlan.png', array('alt' => 'Dotlan Maps')) .
                '</a>' .
                '<a href="' . $eveagents .'" title="EVE Agents" target="_blank">' .
                    $this->Html->image('theme/eveagents.gif', array('alt' => 'EVE Agents')) .
                '</a>' .
            '</div>';
        return trim($result);        
    }
    
    function getMapLinks($regionID, $solarSystemID = null) {
        
        $additional = '';
        $title = '';
        $eveagents = '';
        if ($regionID==0) {
            $link = 'http://evemaps.dotlan.net/map';
        } else {
            $EveMapRegion = $this->requestAction('database/mapregion/' . $regionID );
            $region = str_replace(' ', '_', $EveMapRegion['EveMapRegion']['regionName']);
            $link = 'http://evemaps.dotlan.net/map/' . $region;
            $eveagents = 'http://www.eve-agents.com/index.dxd?Region=' . $regionID; 
            $title = $EveMapRegion['EveMapRegion']['regionName'];
            $additional = $this->EveIgb->showInfo(3,$regionID);
        }
        
        if ($solarSystemID!=null) {
            $EveMapSolarSystem = $this->requestAction('database/mapsolarsystem/' . $solarSystemID );
            $solarSystem = str_replace(' ', '_', $EveMapSolarSystem['EveMapSolarSystem']['solarSystemName']);
            $link = $link . '/' . $solarSystem;
            $eveagents = 'http://www.eve-agents.com/index.dxd?System=' . $EveMapSolarSystem['EveMapSolarSystem']['solarSystemName']; 
            $title = $EveMapSolarSystem['EveMapSolarSystem']['solarSystemName'];
            $additional = $this->EveIgb->showInfo(5,$solarSystemID) . $this->EveIgb->showMap($solarSystemID) . $this->EveIgb->setDestination($solarSystemID);
        }
        
        $rRnd = $this->randomStr();
        $result = '
            <a href="'. $link . '" target="_blank" id="' . $rRnd . '_item">' .
                $title .
            '</a>' .
            '<div class="linkbox hidden" id="' . $rRnd . '_linkbox">' .
                $additional .
                '<a href="' . $link .'" title="Dotlan Maps" target="_blank">' .
                    $this->Html->image('theme/dotlan.png', array('alt' => 'Dotlan Maps')) .
                '</a>' .
                '<a href="' . $eveagents .'" title="EVE Agents" target="_blank">' .
                    $this->Html->image('theme/eveagents.gif', array('alt' => 'EVE Agents')) .
                '</a>' .
            '</div>';
        return trim($result);        
    }

    function getAllianceLinks($allianceID) {
        $alliance = $this->requestAction('/eveapi/get/eve/AllianceList/allianceID/' . $allianceID);
        
        $link = 'http://evemaps.dotlan.net/alliance/' . str_replace(' ', '_', $alliance[0]['ApiEveAllianceList']['name']);

        $battleclinic = 'http://eve.battleclinic.com/killboard/combat_record.php?type=alliance&amp;name=' . str_replace(' ', '+', $alliance[0]['ApiEveAllianceList']['name']);

        $evekill = 'http://eve-kill.net/?a=search&amp;searchtype=alliance&amp;searchphrase=' . $alliance[0]['ApiEveAllianceList']['name'];
        
        $additional = $this->EveIgb->showInfo(16159, $allianceID);
        
        $rRnd = $this->randomStr();
        $result = '
            <a href="'. $link . '" target="_blank" id="' . $rRnd . '_item">' .
                $alliance[0]['ApiEveAllianceList']['name'] .
            '</a>' .
            '<div class="linkbox hidden" id="' . $rRnd . '_linkbox">' .
                $additional .
                '<a href="' . $link .'" title="Dotlan Maps" target="_blank">' .
                    $this->Html->image('theme/dotlan.png', array('alt' => 'Dotlan Maps')) .
                '</a>' .
                '<a href="' . $battleclinic .'" title="Battleclinic" target="_blank">' .
                    $this->Html->image('theme/battleclinic.png', array('alt' => 'Battleclinic')) .
                '</a>' .
                '<a href="' . $evekill .'" title="eve-kill" target="_blank">' .
                    $this->Html->image('theme/evekill.png', array('alt' => 'eve-kill')) .
                '</a>' .
            '</div>';
        return trim($result);        
    }

    function getCharacterLinks($characterID) {
        $title = $this->requestAction('/eveapi/getCharacterName/' . $characterID);
        
        $link = 'http://eveboard.com/pilot/' . str_replace(' ', '_', $title);

        $battleclinic = 'http://eve.battleclinic.com/killboard/combat_record.php?type=player&amp;name=' . $title;

        $evekill = 'http://eve-kill.net/?a=search&amp;searchtype=pilot&amp;searchphrase=' . $title;

        $additional = $this->EveIgb->showInfo(1377 , $characterID);
        
        $rRnd = $this->randomStr();
        $result = '
            <a href="'. $link . '" target="_blank" id="' . $rRnd . '_item">' .
                $title .
            '</a>' .
            '<div class="linkbox hidden" id="' . $rRnd . '_linkbox">' .
                $additional .
                '<a href="' . $link .'" title="Eveboard" target="_blank">' .
                    $this->Html->image('theme/eveboard.png', array('alt' => 'Eveboard')) .
                '</a>' .
                '<a href="' . $battleclinic .'" title="Battleclinic" target="_blank">' .
                    $this->Html->image('theme/battleclinic.png', array('alt' => 'Battleclinic')) .
                '</a>' .
                '<a href="' . $evekill .'" title="eve-kill" target="_blank">' .
                    $this->Html->image('theme/evekill.png', array('alt' => 'eve-kill')) .
                '</a>' .
            '</div>';
        return trim($result);        
    }

    function getCorporationLinks($corporationID) {
        $title = $this->requestAction('/eveapi/getCharacterName/' . $corporationID);
        
        $battleclinic = 'http://eve.battleclinic.com/killboard/combat_record.php?type=corp&amp;name=' . $title;

        $evekill = 'http://eve-kill.net/?a=search&amp;searchtype=corp&amp;searchphrase=' . $title;

        $additional = $this->EveIgb->showInfo(2 , $corporationID);
        
        $rRnd = $this->randomStr();
        $result = '
            <a href="'. $battleclinic . '" target="_blank" id="' . $rRnd . '_item">' .
                $title .
            '</a>' .
            '<div class="linkbox hidden" id="' . $rRnd . '_linkbox">' .
                $additional .
                '<a href="' . $battleclinic .'" title="Battleclinic" target="_blank">' .
                    $this->Html->image('theme/battleclinic.png', array('alt' => 'Battleclinic')) .
                '</a>' .
                '<a href="' . $evekill .'" title="eve-kill" target="_blank">' .
                    $this->Html->image('theme/evekill.png', array('alt' => 'eve-kill')) .
                '</a>' .
            '</div>';
        return trim($result);        
    }
    
    function getSkill($skill, $active_character, $id = false, $callbacks = '') {
            
        if ($id == false) {
            $id = $this->randomStr();
        }
            
        $this->Html->script('skillswitch', array('inline' => false));
        
        $EveInvType = $this->requestAction('/database/invtype/' . $skill);
        
        $result = array();
        $result['icon']  = $this->Html->image('eve/icons/16_16/icon50_11.png', array('alt' => $EveInvType['EveInvType']['typeName'], 'class' => 'left'));
        $result['name']  = $EveInvType['EveInvType']['typeName'];
        $result['level'] = $this->CharacterXml->getSkillLevel($active_character, $EveInvType['EveInvType']['typeID']);
        if ($callbacks=='') {
            $result['image'] = $this->Html->image('theme/skill_' . $result['level'] . '.png', array('rel' => $result['level'], 'class' => 'skillswitch', 'id' => $id));
        } else {
            $result['image'] = $this->Html->image('theme/skill_' . $result['level'] . '.png', array('rel' => $result['level'], 'class' => 'skillswitch', 'id' => $id, 'callbacks' => $callbacks));            
        }
        $result['tr']    = '<tr><td class="icon">' . $result['icon'] . '</td><td>' . $result['name'] .'</td><td>' . $result['image'] . '</td></tr>';
        return $result;
    }
    
    /**
     * Generate and return a random string
     *
     * The default string returned is 8 alphanumeric characters.
     *
     * The type of string returned can be changed with the "seeds" parameter.
     * Four types are - by default - available: alpha, numeric, alphanum and hexidec. 
     *
     * If the "seeds" parameter does not match one of the above, then the string
     * supplied is used.
     *
     * @author      Aidan Lister <aidan@php.net>
     * @version     2.1.0
     * @link        http://aidanlister.com/repos/v/function.str_rand.php
     * @param       int     $length  Length of string to be generated
     * @param       string  $seeds   Seeds string should be generated from
     */
    private function _str_rand($length = 32, $seeds = 'alpha') {
        // Possible seeds
        $seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $seedings['numeric'] = '0123456789';
        $seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $seedings['hexidec'] = '0123456789abcdef';
        
        // Choose seed
        if (isset($seedings[$seeds]))
        {
            $seeds = $seedings[$seeds];
        }
        
        // Seed generator
        list($usec, $sec) = explode(' ', microtime());
        $seed = (float) $sec + ((float) $usec * 100000);
        mt_srand($seed);
        
        // Generate
        $str = '';
        $seeds_count = strlen($seeds);
        
        for ($i = 0; $length > $i; $i++)
        {
            $str .= $seeds{mt_rand(0, $seeds_count - 1)};
        }
        
        return $str;
    }
    
}
?>
