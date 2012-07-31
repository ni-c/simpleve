<?php if (isset($submenu['sections']) && (count($submenu['sections'])>0)) { ?>
    <div class="box_menu">
        <h3><?php if (isset($submenu['title'])) echo $submenu['title']; ?></h3>
        <ul class="menu">
            <?php 
                foreach ($submenu['sections'] as $section) {
                    echo $html->tag('li', 
                        $html->link(
                            $section['title'],
                            $section['url'], 
                            $section['options']
                        )
                    ); 
                } 
            ?>
        </ul>
    </div>
<?php } ?>