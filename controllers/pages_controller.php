<?php

/**
 * Controller for the static pages
 * 
 * @author Willi Thiel
 * @date 2010-09-04
 * @version 1.0
 */
class PagesController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Pages';

    /**
     * An array containing the class names of models this controller uses.
     *
     * This controller for static pages doesn't use a model.
     */
    var $uses = array();

    /**
     * Provides access for actions which most often do not require any access control. 
     */
    public $allowedActions = array(
        'display'
    );

    /**
     * Called after the controller action is run, but before the view is rendered.
     *
     * Sets the newsflash to true, so it will be rendered in the view.
     */
    function beforeRender() {
        parent::beforeRender();
    }

    /**
     * Displays a static page.
     */
    function display() {

        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $this->title_for_layout = Inflector::humanize($path[$count - 1]);
            if ($this->title_for_layout=='Home') {
                $this->title_for_layout = '';
            }
        }
        
        App::import('Vendor', 'feedparser/feedparser');
        $Parser     = new FeedParser();
        $Parser->parse('http://blog.simpleve.com/feed/');
        $items      = $Parser->getItems();
        $this->set('blogrss', $items);

        $Parser     = new FeedParser();
        $Parser->parse('http://www.eveonline.com/feed/rdfdevblog.asp');
        $items      = $Parser->getItems();
        $this->set('evedevblogrss', $items);
        
        $motd = file_get_contents('http://www.eveonline.com/motd.asp?s=xml');
        $motd = trim(str_replace('MOTD', '', $motd));
        $motd = trim(str_replace('shellexec:', '', $motd));
        $motd = trim(str_replace('<center>', '', $motd));
        $motd = trim(str_replace('</center>', '', $motd));
        $this->set('evemotd', $motd);
                    
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        $this->render(implode('/', $path));
    }
    
}
?>
