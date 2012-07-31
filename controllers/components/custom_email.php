<?php

/**
 * Extention of the default Email component. Is used to set pseudoconstants like the BASEURL and MAILTO
 * 
 * @author Willi Thiel
 * @date 2010-09-09
 * @version 1.0
 */
App::import('Component', 'Email');
class CustomEmailComponent extends EmailComponent {
    
    /**
     * The parent controller of this component.
     */
    var $controller = null;
    
    /**
     * Save reference to controller on startup.
     * 
     * @param $controller The parent controller of this component.
     */
    function startup(&$controller)
    {
        $this->controller = $controller;
        parent::startup($controller);
    }
    
    /**
     * Set some global values before sending the email.
     */
    function send($content = null, $template = null, $layout = null) {
           /* SMTP Options */
       $this->smtpOptions = array(
            'port'=>'25', 
            'timeout'=>'30',
            'auth' => true,
            'host' => 'smtp.1und1.de',
            'username'=>'noreply@simpleve.com',
            'password'=>'dimnelP23',
            'client' => 'SimplEve Webapp'
       );
        
        $this->delivery  = 'smtp';
        $this->replyTo   = 'noreply@simpleve.com';
        $this->from      = 'SimplEve <noreply@simpleve.com>';
        $this->sendAs    = 'both';
        $this->subject   = 'SimplEVE.com - ' . $this->subject;
        
        $this->controller->set('baseurl', 'http://' . $_SERVER['HTTP_HOST'] . $this->controller->webroot);
        $this->controller->set('mailto', 'noreply@simpleeve.com');
        
        $send = parent::send($content, $template, $layout);
        if (!$send) {
            $this->controller->flash(
                'An error occured while sending an email to ' . $this->to . '.' . 
                'Please try again. ', '/', 60);
        }
        return $send;
    }
    
}
?>