<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php 
		    echo 'SimplEve beta'; 
		    if ($title_for_layout!='') {
                echo ' &#124; ' . $title_for_layout;
            } 
		?>
	</title>
	<?php
	
		echo $this->Html->meta('icon');

        echo $this->Html->css('reset');
        echo $this->Html->css('style');

        echo $this->Html->script('mootools-1.2.4-core-yc');
        echo $this->Html->script('default');
        echo $this->Html->script('hover');
        echo $this->Html->script('switch');
        echo $this->Html->script('checkbox');
        echo $this->Html->script('radiobutton');
        echo $this->Html->script('dashboard');
        
        if ($this->EveIgb->isIGB()) {
            echo $this->Html->script('igb');
        }

		echo $scripts_for_layout;
	?>

    <!--[if IE 6]><link href="<?php echo $BP; ?>css/ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
    
    <?php if (env("HTTP_HOST") != "localhost") { ?>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-18970634-2']);
            _gaq.push(['_setDomainName', 'none']);
            _gaq.push(['_setAllowLinker', true]);
            _gaq.push(['_trackPageview']);
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
    <?php } ?>
    <meta name="description" content="Simpleve is the all-in-one tool for Eve Online. It contains a Manufacturing Calculator, Refining Calculator, Wallet, Skills, etc." />
    <meta name="keywords" content="eve online, api, manufacturing, refining, calculator, tool, wallet, skill, queue, ical, ics, calendar" />
    <link rel="canonical" href="http://www.simpleve.com" />
</head>
<body>
    <?php /* see http://www.templates-15.joomla-downloads.de/index.php?template_selector=eve_online_lernvid.com */ ?>
    <input type="hidden" id="BP" value="<?php echo $BP; ?>"></input>
    <div id="wrapper">
        
        <div id="header">
            <div id="sitetitle">SimplEve beta</div>
        </div>
        
        <div class="clr"></div>
 
        <div id="container">

            <div id="navigation">
                <ul id="mainlevel-nav">
                    <?php foreach ($simpleve_menu as $menuitem) { ?>
                        <?php
                            if ((strpos('/' . $this->params['url']['url'], $menuitem['url'])===0) &&
                                (($menuitem['url']!='/') && ($this->params['url']['url']!='/'))) {
                                $id = ' id="active_menu-nav"';
                            } else {
                                if (($menuitem['url']=='/') && ($this->params['url']['url']=='/')) {
                                    $id = ' id="active_menu-nav"';
                                } else {
                                    $id = '';
                                }
                            }
                        ?>
                        <li><a href="<?php echo $html->url($menuitem['url'], true); ?>" class="mainlevel-nav"<?php echo $id; ?>><?php echo $menuitem['label'] ?></a></li>
                    <?php } ?>
                </ul>
            </div>

            <div id="page_content">
                <div id="left_outer">
                    <div id="left_top"></div>
                    <div id="left_inner_float">
                        <div id="left_inner">
                            <div class="box_menu">
                                <?php 
                                    if (!isset($User)) {
                                        echo $this->element('loginform');
                                    } else {
                                        echo $this->element('profilebox'); 
                                    } 
                                ?> 
                            </div>
                            <?php
                                foreach ($submenus as $submenu) {
                                    echo $this->element(
                                        'submenu',
                                        array('submenu' => $submenu)
                                    );                         
                                }
                            ?>            
                        </div>
                    </div>
                    <div id="left_bottom"></div>
                </div>                  
                <div id="content_outer">
                    <div id="content_up">
                        <div id="content_up_left">
                            <div id="breadcrumbs">
                                <?php echo $html->getCrumbs(' > ','Home'); ?>
                            </div>
                            <div id="content_up_right">
                                <div id="search">
                                    <div id="search_inner">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="content_inner">
                        <div id="content">
                
                            <?php echo $this->Session->flash(); ?>

                            <?php echo $this->Session->flash('auth'); ?>
                            
                            <?php echo $content_for_layout; ?>

                        </div>
                    </div>

                    <div class="clr"></div>

                    <div id="content_down">
                        <div id="content_down_left">
                            <div id="content_down_right">
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="clr"></div>
            </div>  
            
            <div id="container2">
                <div id="footer">
                    <p>Copyright 2010 - Wilhelm Thiel</p>
                    <p>Design by: <a target="_blank" href="http://www.lernvid.com">LernVid.com</a> feat. <a target="_blank" href="http://www.game-template.com/">game-template</a> sponsored by <a target="_blank" href="http://eve.guidezworld.com">EVE Guide</a></p>
                    <p>
                        <a title="EVE Online and the EVE logo are the registered trademarks of CCP hf. All rights are reserved worldwide. All other trademarks are the property of their respective owners. EVE Online, the EVE logo, EVE and all associated logos and designs are the intellectual property of CCP hf. All artwork, screenshots, characters, vehicles, storylines, world facts or other recognizable features of the intellectual property relating to these trademarks are likewise the intellectual property of CCP hf. CCP hf. has granted permission to SimplEVE to use EVE Online and all associated logos and designs for promotional and information purposes on its website but does not endorse, and is not in any way affiliated with, SimplEVE. CCP is in no way responsible for the content on or functioning of this website, nor can it be liable for any damage arising from the use of this website." href="#">CCP Copyright Notice</a>                    
                    </p>                    
                </div>
            </div>
            
            <div class="clr"></div>
        </div>
    </div>
   
    <?php /**
   
    <div id="debug">
        <?php echo $this->element('sql_dump'); ?>
    </div>
    <div id="debug">
        <?php debug($MetaTypes); ?>
    </div>

    <div id="debug">
        <?php debug($MetaTypes); ?>
    </div>

    <div id="debug">
        <?php debug($Invention); ?>
    </div>
    <div id="debug">
        <?php debug($Decryptors); ?>
    </div>
    <div id="debug">
        <?php debug($apis); ?>
    </div>
    
    <div id="debug">
        <?php debug($characters); ?>
    </div>
    
    <div id="debug">
        <?php echo $this->element('sql_dump'); ?>
    </div>

    <div id="debug">
        <?php debug($session->read()); ?>
    </div>

    <?php
        }
    ?>
    */ ?>
</body>
</html>
