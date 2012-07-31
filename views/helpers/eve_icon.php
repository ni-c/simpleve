<?php

/**
 * Helper for creating Eve Icons
 * 
 * @author Willi Thiel
 * @date 2010-09-11
 * @version 0.2
 */
class EveIconHelper extends AppHelper {

    var $helpers = array('Html');
    
    /**
     * Creates the html tag for the icon
     * 
     * @param $size Size of the icon
     * @param $icon Icon number
     * @param $alt Alt text for the icon
     */
    function getIcon($size, $graphics, $typeID, $category, $techLevel = 0) {
 
        if ($techLevel==2) {
            if (!empty($graphics['icon'])) {
                return $this->Html->image(
                    'theme/t2_64.png', 
                        array(
                            'class' => 'left', 
                            'width' => $size.'', 'height' => $size.'', 
                            'style' => "background-image: url('" . $this->assetTimestamp($this->webroot(IMAGES_URL . '/eve/icons/'.$size.'_'.$size.'/icon' . $graphics['icon'] . '.png' . "')"))));
            } else {
                if ($size==16) {
                    $size = 32;
                    $imgsize = 16;
                } else {
                    $imgsize = $size;
                }       
                return $this->Html->image(
                    'theme/t2_64.png', 
                        array(
                            'class' => 'left', 
                            'width' => $size.'', 'height' => $size.'', 
                            'style' => "background-image: url('" . $this->assetTimestamp($this->webroot(IMAGES_URL . '/eve/types/'.strtolower($category).'types_png/' .$size.'_'.$size. '/' . $typeID . '.png' . "')"))));
            }
        } else {
            if (!empty($graphics['icon'])) {
                $filename = 'eve/icons/'.$size.'_'.$size.'/icon' . $graphics['icon'] . '.png';
                $imgsize = $size;
            } else {
                if ($size==16) {
                    $size = 32;
                    $imgsize = 16;
                } else {
                    $imgsize = $size;
                }
                $filename = 'eve/types/'.strtolower($category).'types_png/' .$size.'_'.$size. '/' . $typeID . '.png';
            }
            
            if (file_exists(IMAGES_URL . $filename)) {
                return $this->Html->image($filename, array('class' => 'left', 'width' => $imgsize.'', 'height' => $imgsize.''));
            } else {
                return '<p class="debug">WARNING: Icon "' . $filename . '" not found!</p>';
            }
        }
    }   
 
    /**
     * Returns the icon with the given id and size
     */
    function getSimpleIcon($icon, $size = 16) {
        $filename = 'eve/icons/' .$size.'_'.$size. '/icon' . $icon . '.png';
        return $this->Html->image($filename, array('class' => 'left', 'width' => $size.'', 'height' => $size.''));
    }
 
    /**
     * Creates the html tag for the blueprint icon
     * 
     * @param $icon Blueprint icon number
     * @param $alt Alt text for the blueprint icon
     */
    function getBlueprintIcon($icon, $alt, $techLevel, $small = false) {
        if ($small) {
            $size = 16;
        } else {
            $size = 64;
        }
        if ($techLevel==2) {            
            return $this->Html->image('theme/t2_64.png', array('class' => 'left', 'width' => $size, 'height' => $size, 'style' => "background-image: url('" . $this->assetTimestamp($this->webroot(IMAGES_URL . '/eve/blueprints/' . $icon . ".png')"))));
        } else {
            return $this->Html->image('eve/blueprints/' . $icon . '.png', array('alt' => $alt, 'class' => 'left', 'width' => $size, 'height' => $size));
        }
    }   
}

?>
