<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php __('SimplEVE'); ?>
        <?php echo $title_for_layout; ?>
    </title>
    <meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
    <?php
    
        echo $this->Html->meta('icon');

        echo $this->Html->css('reset');
        echo $this->Html->css('style');

        echo $this->Html->script('mootools-1.2.4-core-yc');
        echo $this->Html->script('hover');

        echo $scripts_for_layout;
    ?>

    <!--[if IE 6]><link href="/css/ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
    <!--[if gte IE 7]><link href="/css/ie7.css" rel="stylesheet" type="text/css" /><![endif]-->
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
</head>
<body>

    <div id="wrapper">
        
        <div id="header">
            <div id="sitetitle">SimplEve beta</div>
        </div>
        
        <div class="clr"></div>
 
        <div id="container">

            <div id="navigation">
                <div class="moduletable">
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
            </div>

            <div id="page_content">
                <div id="content_outer" style="width: 98%">
                    <div id="content_up">
                        <div id="content_up_left">
                            <div id="breadcrumbs">
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
                            <div class="box">
                                <h3>Notice</h3>
                                <p class="flash"><?php echo $message; ?></p>
                                <p class="flash">
                                    <?php echo $html->link(
                                        'Back',
                                        '/');
                                    ?>
                                </p>
                                <br />
                                <br />
                            </div>
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
            </div>  
            
            <div id="container2">
                <div id="footer">
                </div>
            </div>
            
            <div class="clr"></div>
        </div>
    </div>
    
</body>
</html>
