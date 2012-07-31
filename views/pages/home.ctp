<?php
    $MineralIndexTypes = $this->requestAction('mineralIndexTypes/getAll');
?>
<div id="user_modules1">
    <div id="user1">
        <div class="moduletable">
            <h3>Mineral Index</h3>
            <table class="subbox mineralindex">
                <tbody>
                    <?php foreach($MineralIndexTypes as $key => $MineralIndexType) { ?>
                        <?php if (isset($MineralIndexTypes[$key]['MineralIndex'][1])) { ?>
                            <tr>
                                <td class="icon">
                                     <?php 
                                        echo $eveIcon->getIcon(
                                            16, 
                                            $MineralIndexType['EveInvType']['EveGraphic'], 
                                            $MineralIndexType['EveInvType']['typeID'], 
                                            $MineralIndexType['EveInvType']['EveInvGroup']['EveInvCategory']['categoryName'], 
                                            0
                                        ); 
                                    ?>
                                </td>
                                <td>
                                    <?php $rRnd = $tools->randomStr(); ?>
                                    <?php echo $tools->getItemLinks($MineralIndexType['EveInvType']['typeID'], false, $rRnd); ?>
                                </td>
                                <td class="nr">
                                    <abbr title="<?php echo date('c', strtotime($MineralIndexType['MineralIndex'][0]['created'])); ?>">
                                        <?php echo number_format($MineralIndexType['MineralIndex'][0]['price'],2,'.',','); ?> ISK
                                    </abbr>
                                </td>
                                <?php 
                                    $diff = (1 - ((float)$MineralIndexTypes[$key]['MineralIndex'][1]['price'] / (float)$MineralIndexType['MineralIndex'][0]['price']))*100; 
                                ?>
                                <td class="nr <?php if ($diff>0) { echo 'up'; } if ($diff<0) { echo 'down'; }?>">
                                    <abbr title="<?php echo date('c', strtotime($MineralIndexTypes[$key]['MineralIndex'][1]['created'])); ?>">
                                        <?php if ($diff>0) { echo '+'; } if ($diff<0) { echo '-'; } if ($diff==0) { echo '+/-'; }?> <?php echo number_format(abs($diff),3,'.',','); ?> %
                                    </abbr>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="user2">
        <div class="moduletable">
            <h3>Sovereignty changes</h3>
            <?php $MapSovereigntyChanges = $this->requestAction('/eveapi/lastsovereigntychanges/8'); ?>
            <table class="subbox sovereignitychanges">
                <tbody>
                    <?php foreach ($MapSovereigntyChanges as $MapSovereigntyChange) { ?>
                        <tr>
                            <?php
                                $mapSolarSystem = $this->requestAction('/database/mapsolarsystem/' . $MapSovereigntyChange['ApiMapSovereigntyChanges']['solarSystemID']); 
                            ?>
                            <td><?php echo date('H:i:s', strtotime($MapSovereigntyChange['ApiMapSovereigntyChanges']['created'])); ?></td>
                            <td>
                                <?php echo $this->Tools->getMapLinks($mapSolarSystem['EveMapSolarSystem']['regionID']); ?>
                            </td>
                            <td>
                                <?php echo $this->Tools->getMapLinks($mapSolarSystem['EveMapSolarSystem']['regionID'], $MapSovereigntyChange['ApiMapSovereigntyChanges']['solarSystemID']); ?>
                            </td>
                            <?php 
                                if ($MapSovereigntyChange['ApiMapSovereigntyChanges']['action'] == 'Gain') {
                                    ?><td class="up">Gain</td><?php
                                } else {
                                    ?><td class="down">Lost</td><?php
                                }
                            ?>
                            <td>
                                <?php echo $this->Tools->getAllianceLinks($MapSovereigntyChange['ApiMapSovereigntyChanges']['allianceID']); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="clr"></div>

<div class="box">
    <h3>Eve MOTD</h3>
    <div class="subbox">
        <?php echo $evemotd; ?>
    </div>
</div>

<div id="user_modules1">
    <div id="user1">
        <div class="moduletable">
            <h3>SimplEve Dev Blog (<a href="http://blog.simpleve.com">blog.simpleve.com</a>)</h3>
            <table class="subbox">
                <tbody>
                    <?php
                        $i = 0; 
                        foreach($blogrss as $item) {
                        if ($i==8) {
                            break;
                        }
                        $i++;
                    ?>
                        <tr>
                            <td nowrap="nowrap">
                                <?php echo date('Y-m-d H:i', $item['PUBDATE']); ?>
                            </td>
                            <td>
                                <a href="<?php echo $item['LINK']; ?>"><?php echo $item['TITLE']; ?></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="user1">
        <div class="moduletable">
            <h3>Eve Online Dev Blog (<a href="http://www.eveonline.com/devblog.asp">www.eveonline.com/devblog.asp</a>)</h3>
            <table class="subbox">
                <tbody>
                    <?php
                        $i = 0; 
                        foreach($evedevblogrss as $item) {
                        if ($i==5) {
                            break;
                        }
                        $i++;
                    ?>
                        <tr>
                            <td nowrap="nowrap">
                                <?php echo date('Y-m-d H:i', $item['DC:DATE']); ?>
                            </td>
                            <td>
                                <a href="<?php echo $item['LINK']; ?>"><?php echo $item['TITLE']; ?></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="clr"></div>