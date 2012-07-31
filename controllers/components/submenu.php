<?php

/**
 * Submenu component
 * 
 * @author Willi Thiel
 * @date 2010-09-11
 * @version 1.0
 */
class SubmenuComponent extends Object {

    var $submenus = array();
    
    /**
     * Save reference to controller on startup.
     * 
     * @param $controller The parent controller of this component.
     */
    function startup(&$controller)
    {
    }
    
    /**
     * Returns the submenu
     */
    function get() {
        return $this->submenus;
    }

    /**
     * Add a new section (link) to a menu
     * 
     * @param $menu The title of the menu where to add the section
     * @param $title The title of the section
     * @param $url The URL of the section
     * @param $options Additional options for the section
     */
    function add($menu, $title, $url, $options = array()) {
        if (!isset($this->submenus[$menu])) {
            $this->submenus[$menu] = array(
                'title' => $menu,
                'sections' => array()
            );
        }
        $this->submenus[$menu]['sections'][] = array(
            'title'     => $title,
            'url'       => $url,
            'options'   => $options
        );
    }
    
    function addLinks() {
        $this->add('Community', 'DevBlog', 'http://blog.simpleve.com', array('target' => '_blank'));
        $this->add('Community', 'Twitter', 'http://twitter.com/simpleve_com', array('target' => '_blank'));
        $this->add('Links', 'Eve Survival', 'http://eve-survival.org', array('target' => '_blank'));
        $this->add('Links', 'Dotlan Evemaps', 'http://evemaps.dotlan.net', array('target' => '_blank'));
        $this->add('Links', 'Eve Agents', 'http://www.eve-agents.com', array('target' => '_blank'));
        $this->add('Links', 'Eve Platoon', 'http://eve-platoon.de', array('target' => '_blank'));
        $this->add('Links', 'Eve Central', 'http://www.eve-central.com', array('target' => '_blank'));
        $this->add('Links', 'Eve Metrics', 'http://www.eve-metrics.com', array('target' => '_blank'));
        $this->add('Links', 'Jitonomic', 'http://www.jitonomic.com', array('target' => '_blank'));
        $this->add('Links', 'Eveboard', 'http://eveboard.com', array('target' => '_blank'));
        $this->add('Links', 'Battleclinic', 'http://eve.battleclinic.com', array('target' => '_blank'));
        $this->add('Links', 'eve-kill', 'http://eve-kill.net', array('target' => '_blank'));
    }
}
?>