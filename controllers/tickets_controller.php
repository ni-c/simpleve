<?php

/**
 * Controller for tickets
 * 
 * @author Willi Thiel
 * @date 2010-09-08
 * @version 1.0
 */
class TicketsController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Tickets';

    /**
     * An array containing the class names of models this controller uses.
     *
     * - User for modifying user datasets
     * - Ticket for activation and retrievepassword eMails
     */
    var $uses = array('Ticket', 'User');
     
    /**
     * Controller actions for which user validation is not required.
     */
    var $allowedActions = array('approve');
    
    /**
     * Call the ticket.
     */
    function approve($hash = null) {
        
        if (($hash==null) && (!empty($this->data))) {
                $hash = $this->data['Ticket']['hash'];    
        }       
        
        $ticket = $this->_getTicket($hash); 
        
        if ($ticket) {
            switch ($ticket['Ticket']['action']) {
                case 'activate':
                    $ticket['User']['is_active'] = 1;
                    $ticket['User']['expires'] = time() + (60*60*24*14);
                    $this->User->save($ticket['User']);
                    $ticket['Ticket']['closed'] = 1;
                    $this->Ticket->save($ticket['Ticket']);
                    $this->flash('Your account has been activated.', '/', 60);
                     break;
                case 'newpasswd':
                    $this->set('hash', $hash);
                    
                    if (!empty($this->data)) {
                        $user = array_merge($ticket['User'], $this->data['User']);
                        $this->User->validatePasswordOn('update');
                        $this->User->set($user);
                        if ($this->User->validates()) {
                            $this->User->save();
                            $ticket['Ticket']['closed'] = 1;
                            $this->Ticket->save($ticket['Ticket']);
                            $this->flash('Your password has been changed.', '/', 60);
                        } else {
                           $this->set('errors', $this->User->invalidFields()); 
                        }
                    }
                    break;
            }
        } else {
            $this->flash('Invalid ticket id, please request a new one.', '/', 60);
        }
    }
    
    /**
     * Checks if the given ticket is valid and returns it
     */
    private function _getTicket($hash) {
        
        if ($hash==null)
            return false;
        
        $ticket = $this->Ticket->findByHash($hash);
        
        if ($ticket==false)
            return false;
        if ($ticket['Ticket']['closed']!=0)
            return false;
            
        return $ticket;
    }
}
?>