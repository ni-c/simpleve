<div class="inner box">

    <?php $rnd = $tools->randomStr(); ?>
    <?php $sw = $tools->getSwitchArray((isset($options['shoppinglist_tab'])) ? $options['shoppinglist_tab'] : 0); ?>
    <h4><?php echo $html->image($sw['img'], array('alt' => '', 'class' => 'left switch', 'rel' => $rnd, 'callbacks' => "saveOption('shoppinglist_tab', '1')"))?> Shopping List</h4>
    <div class="clr"></div>
    <div class="subbox <?php echo $sw['class']; ?>" id="<?php echo $rnd; ?>">
        <table>
            <tbody>
                <tr>
                    <td class="icon">
                        &nbsp;
                    </td>
                    <td>
                        Create shopping list for                      
                    </td>
                    <td class="nr">
                        <input type="text" value="1" size="3" class="inputbox numeric shoppinglistruns nr" id="shoppinglistruns"></input>
                    </td>
                    <td>
                        manufacturing run(s).                  
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="material">
            <thead>
                <tr>
                    <th class="icon">
                        &nbsp;
                    </th>
                    <th>Material</th>
                    <th class="nr">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($MaterialList as $material) {
                    $ItemInfo = $tools->getItemInfo($material['typeID'], true, $rnd);     
                ?>
                    <tr>
                        <td class="icon">
                            <?php echo $ItemInfo['icon']; ?>
                        </td>
                        <td>
                            <?php echo $ItemInfo['link']; ?>
                        </td>
                        <td class="nr">
                            <span class="shoppinglist calc" id="shoppinglistitem_<?php echo $material['typeID'] ?>">0</span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>