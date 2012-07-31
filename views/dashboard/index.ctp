<?php 
    $html->addCrumb('Dashboard', '/dashboard');
    $this->Html->script('dashboard', array('inline' => false));
    echo $this->element('apinotice', array('siteName' => 'Dashboard', 'fullRequired' => true));
?>

<?php if (isset($active_character)) { ?>
    <div class="box">
        <h3>
            Dashboard
        </h3>
        <div class="subbox">
            <table class="subbox dashboard">
                <thead>
                    <tr>
                        <th colspan="2">
                            &nbsp;
                        </th>
                        <th>
                            Activity
                        </th>
                        <th>
                            Type
                        </th>
                        <th colspan="2">
                            Char/Corp
                        </th>
                        <th class="nr">
                            Remaining
                        </th>
                        <th>
                            Ends
                        </th>
                    </tr>
                </thead>
                <tbody>
                        
                    <?php foreach ($DashboardItems as $DashboardItem) { ?>
                        
                        <?php
                            $rows = array();
                        
                            switch ($DashboardItem['type']) {
                                
                                /*
                                 * ------------------------------------------ InustryJobs -----------------------------------------------------
                                 */
                                case 'IndustryJob':
                                        $rows = array();

                                        $activity = $EveRamActivity[$DashboardItem['data']['activityID']];
                                        $activity['activityName'] = str_replace('Researching Material Productivity', 'Material Research', $activity['activityName']);
                                        $activity['activityName'] = str_replace('Researching Time Productivity', 'Time Efficiency Research', $activity['activityName']);

                                        $rRnd = $tools->randomStr();
                                        
                                        $EveInvType = $this->requestAction('database/invtype/' . $DashboardItem['data']['outputTypeID']);
                    
                                        $activity['activityType'] = $tools->getItemLinks($EveInvType['EveInvType']['typeID'], false, $rRnd);
                                        
                                        $EveMapSolarSystem = $this->requestAction('database/mapsolarsystem/' . $DashboardItem['data']['installedInSolarSystemID']);
                                        $rows[0] = '
                                            <td>Location:</td>
                                            <td>
                                                '. $this->Tools->getMapLinks($EveMapSolarSystem['EveMapSolarSystem']['regionID']) .'
                                                &gt;
                                                '. $this->Tools->getMapLinks($EveMapSolarSystem['EveMapSolarSystem']['regionID'], $DashboardItem['data']['installedInSolarSystemID']) .'
                                                &gt;
                                                '. $this->Tools->getStationLinks($DashboardItem['data']['outputLocationID']) .'
                                            </td>';
                                        $rows[1] = '
                                            <td>Start time:</td>
                                            <td id="{$timeID}_startTime" rel="' . strtotime($DashboardItem['data']['beginProductionTime']) . '">' .
                                               date('Y-m-d H:i', strtotime($DashboardItem['data']['beginProductionTime'])) .
                                            '</td>';
                                    
                                        switch($DashboardItem['data']['activityID']) {
                                        // Manufactoring
                                        case 1:
                                            $rows[2] = '
                                                <td>Runs:</td>
                                                <td>
                                                    ' . $DashboardItem['data']['runs'] . '
                                                </td>';
                                            break;
                                            
                                        // Researching Technology
                                        case 2:
                                            break;
                                            
                                        // Researching Time Productivity
                                        case 3:
                                            $rows[2] = '
                                                <td>P.E.:</td>
                                                <td>
                                                    ' . $DashboardItem['data']['installedItemProductivityLevel'] . '
                                                    to
                                                    ' . $DashboardItem['data']['runs'] . '
                                                </td>';
                                            break;
                                            
                                        // Researching Material Productivity
                                        case 4:
                                            $rows[2] = '
                                                <td>M.E.:</td>
                                                <td>
                                                    ' . $DashboardItem['data']['installedItemMaterialLevel'] . '
                                                    to
                                                    ' . $DashboardItem['data']['runs'] . '
                                                </td>';
                                            break;
                                            
                                        // Copying
                                        case 5:
                                            break;
                                            
                                        // Duplicating
                                        case 6:
                                            break;
                                            
                                        // Reverse Engineering
                                        case 7:
                                            break;
                                            
                                        // Invention
                                        case 8:
                                            break;
                                    }
                                    break;
                                    
                                /*
                                 * ------------------------------------------ SkillQueue -----------------------------------------------------
                                 */
                                case 'SkillQueue':
                                        $rows = array();
                                        
                                        $EveInvType = $this->requestAction('/database/invtype/' . $DashboardItem['data']['typeID']);
                    
                                        $activity['activityName'] = 'Skill training completed';
                                        $activity['activityType'] = $EveInvType['EveInvType']['typeName'] . ' ' . $this->Tools->getRomanNumber($DashboardItem['data']['level']);
                                        $activity['iconNo'] = '50_14';
                                        
                                        $rows[0] = '
                                            <td>Skill:</td>
                                            <td>' .
                                                $EveInvType['EveInvType']['typeName'] . ' (' . number_format($DashboardItem['data']['endSP'],0,'.',',') . ' SP)' .
                                            '</td>';
                                        $rows[1] = '
                                            <td>Start time:</td>
                                            <td id="{$timeID}_startTime" rel="' . strtotime($DashboardItem['data']['startTime']) . '">' .
                                                date('Y-m-d H:i:s', strtotime($DashboardItem['data']['startTime'])) .
                                            '</td>';
                                    break;
                                    
                                /*
                                 * ------------------------------------------ Free room in SkillQueue -----------------------------------------------------
                                 */
                                case 'SkillQueueFree':
                                        $rows = array();
                                        $activity['activityName'] = 'Free room in skill queue';
                                        $activity['activityType'] = '&nbsp';
                                        $activity['iconNo'] = '50_12';
                                break;
                                    
                                /*
                                 * ------------------------------------------ Market Orders -----------------------------------------------------
                                 */
                                case 'MarketOrder':
                                        $rows = array();
                                        $rRnd = $tools->randomStr();
                                        
                                        $EveInvType = $this->requestAction('/database/invtype/' . $DashboardItem['data']['typeID']);
                    
                                        $activity['activityName'] = 'Market Order ' . (($DashboardItem['data']['bid']==1) ? '(buy)' : '(sell)');
                                        $activity['activityType'] = $tools->getItemLinks($EveInvType['EveInvType']['typeID'], false, $rRnd);
                                        $activity['iconNo'] = '18_01';
                                        
                                        $EveStaStation = $this->requestAction('database/stastation/' . $DashboardItem['data']['stationID']);
                                        $EveMapSolarSystem = $this->requestAction('database/mapsolarsystem/' . $EveStaStation['EveStaStation']['solarSystemID']);
                                        $rows[0] = '
                                            <td>Location:</td>
                                            <td>
                                                '. $this->Tools->getMapLinks($EveMapSolarSystem['EveMapSolarSystem']['regionID']) .'
                                                &gt;
                                                '. $this->Tools->getMapLinks($EveMapSolarSystem['EveMapSolarSystem']['regionID'], $EveMapSolarSystem['EveMapSolarSystem']['solarSystemID']) .'
                                                &gt;
                                                '. $this->Tools->getStationLinks($DashboardItem['data']['stationID']) .'
                                            </td>';
                                        if ($DashboardItem['data']['bid']==1) {
                                            $rows[1] = '
                                            <td>Range:</td>
                                            <td>';
                                            switch ($DashboardItem['data']['range']) {
                                                case -1:
                                                    $rows[1] .= 'Station';
                                                    break;
                                                case 0:
                                                    $rows[1] .= 'Solar System';
                                                    break;
                                                case 1:
                                                    $rows[1] .= '1 Jump';
                                                    break;
                                                case 32767:
                                                    $rows[1] .= 'Region';
                                                    break;
                                                default:
                                                    $rows[1] .= $DashboardItem['data']['range'] . ' Jumps';
                                                    break;
                                            }
                                            $rows[1] .= '</td>';
                                        }
                                        $rows[2] = '
                                            <td>Cost per unit:</td>
                                            <td>' .
                                                 number_format($DashboardItem['data']['price'],2,'.',',') .
                                                 ' ISK' .
                                            '</td>';
                                        $rows[3] = '
                                            <td>Quanity:</td>
                                            <td>' .
                                                number_format($DashboardItem['data']['volRemaining'],0,'.',',') .
                                                '/' . 
                                                number_format($DashboardItem['data']['volEntered'],0,'.',',') .
                                            '</td>';
                                break;
                                    
                                /*
                                 * ------------------------------------------ Expired Market Orders -----------------------------------------------------
                                 */
                                case 'MarketOrderExpired':
                                        $rows = array();
                                        $rRnd = $tools->randomStr();
                                        
                                        $EveInvType = $this->requestAction('/database/invtype/' . $DashboardItem['data']['typeID']);
                    
                                        $type = (($DashboardItem['data']['bid']==1) ? '(buy)' : '(sell)');
                                        
                                        if ($DashboardItem['data']['volRemaining']==0) {
                                            $activity['activityName'] = 'Market Order Fulfilled ' . $type;
                                        } else {
                                            $activity['activityName'] = 'Market Order Expired ' . $type;
                                        }
                                        
                                        $activity['activityType'] = $tools->getItemLinks($EveInvType['EveInvType']['typeID'], false, $rRnd);
                                        $activity['iconNo'] = '18_01';
                                        
                                        $EveStaStation = $this->requestAction('database/stastation/' . $DashboardItem['data']['stationID']);
                                        $EveMapSolarSystem = $this->requestAction('database/mapsolarsystem/' . $EveStaStation['EveStaStation']['solarSystemID']);
                                        $rows[0] = '
                                            <td>Location:</td>
                                            <td>
                                                '. $this->Tools->getMapLinks($EveMapSolarSystem['EveMapSolarSystem']['regionID']) .'
                                                &gt;
                                                '. $this->Tools->getMapLinks($EveMapSolarSystem['EveMapSolarSystem']['regionID'], $EveMapSolarSystem['EveMapSolarSystem']['solarSystemID']) .'
                                                &gt;
                                                '. $this->Tools->getStationLinks($DashboardItem['data']['stationID']) .'
                                            </td>';
                                        if ($DashboardItem['data']['bid']==1) {
                                            $rows[1] = '
                                            <td>Range:</td>
                                            <td>';
                                            switch ($DashboardItem['data']['range']) {
                                                case -1:
                                                    $rows[1] .= 'Station';
                                                    break;
                                                case 0:
                                                    $rows[1] .= 'Solar System';
                                                    break;
                                                case 1:
                                                    $rows[1] .= '1 Jump';
                                                    break;
                                                case 32767:
                                                    $rows[1] .= 'Region';
                                                    break;
                                                default:
                                                    $rows[1] .= $DashboardItem['data']['range'] . ' Jumps';
                                                    break;
                                            }
                                            $rows[1] .= '</td>';
                                        }
                                        $rows[2] = '
                                            <td>Cost per unit:</td>
                                            <td>' .
                                                 number_format($DashboardItem['data']['price'],2,'.',',') .
                                                 ' ISK' .
                                            '</td>';
                                        $rows[3] = '
                                            <td>Quanity:</td>
                                            <td>' .
                                                number_format($DashboardItem['data']['volEntered'],0,'.',',') .
                                            '</td>';
                                break;
                             }
                        ?>
                        
                        <?php $rnd = $tools->randomStr(); ?>
                        <tr class="switchrow rowhover" id="<?php echo $rnd; ?>_tr">
                            <td class="icon">
                                <?php echo $html->image('theme/plus.gif', array('alt' => '', 'class' => 'left switch dashboardswitch', 'rel' => $rnd))?>
                            </td>
                            <td class="icon">
                                <?php echo $this->EveIcon->getSimpleIcon($activity['iconNo']); ?>
                            </td>
                            <td>
                                <span id="<?php echo $rnd;?>_activity"><?php echo $activity['activityName']; ?></span>
                            </td>
                            <td>
                                <?php echo trim($activity['activityType']); ?>
                            </td>
                            <td class="icon">
                                <?php 
                                    if ($DashboardItem['apitype']=='char') {
                                        echo $this->Html->image(
                                            'http://image.eveonline.com/Character/' . $DashboardItem['characterID'] . '_32.jpg',
                                            array('height' => 16, 'width' => 16, 'class' => 'right')
                                            ); 
                                    } else {
                                        echo $this->Html->image(
                                            'http://image.eveonline.com/Corporation/' . $DashboardItem['corporationID'] . '_32.png',
                                            array('height' => 16, 'width' => 16, 'class' => 'right')
                                            ); 
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if ($DashboardItem['apitype']=='char') {
                                        echo $this->Tools->getCharacterLinks($DashboardItem['characterID']); 
                                    } else {
                                        echo $this->Tools->getCorporationLinks($DashboardItem['corporationID']);
                                    }
                                ?>
                            </td>
                            <td class="nr">
                               <abbr id="<?php echo $rnd;?>_remaining" class="remainingtime"></abbr>
                            </td>
                            <td>
                                <span class="timestamp" id="<?php echo $rnd;?>_timestamp" rel="<?php echo strtotime($DashboardItem['datetime']); ?>">
                                    <?php echo date('Y-m-d H:i:s', strtotime($DashboardItem['datetime'])); ?>
                                </span>
                            </td>
                        </tr>
                        <tr id="<?php echo $rnd; ?>" class="hidden">
                            <td colspan="8" class="switchable">
                                <div class="innertable box">
                                    <div class="subbox">
                                        <?php 
                                            if ($DashboardItem['apitype']=='char') {
                                                echo $this->Html->image(
                                                    'http://image.eveonline.com/Character/' . $DashboardItem['characterID'] . '_64.jpg',
                                                    array('class' => 'left')
                                                    ); 
                                            } else {
                                                echo $this->Html->image(
                                                    'http://image.eveonline.com/Corporation/' . $DashboardItem['corporationID'] . '_64.png',
                                                    array('class' => 'left')
                                                    ); 
                                            }
                                        ?>
                                        <table class="dashboardtable">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <?php 
                                                            if ($DashboardItem['apitype']=='char') {
                                                                echo 'Character:'; 
                                                            } else {
                                                                echo 'Corporation:';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            if ($DashboardItem['apitype']=='char') {
                                                                echo $this->Tools->getCharacterLinks($DashboardItem['characterID']); 
                                                            } else {
                                                                echo $this->Tools->getCorporationLinks($DashboardItem['corporationID']);
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php if ($DashboardItem['apitype']=='corp') { ?>
                                                    <tr>
                                                        <td>Character:</td>
                                                        <td>
                                                            <?php 
                                                                if (isset($DashboardItem['data']['charID'])) {
                                                                    echo $this->Tools->getCharacterLinks($DashboardItem['data']['charID']); 
                                                                }
                                                                if (isset($DashboardItem['data']['installerID'])) {
                                                                    echo $this->Tools->getCharacterLinks($DashboardItem['data']['installerID']); 
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <?php 
                                                    foreach($rows as $row) {
                                                        echo '<tr>';
                                                        echo str_replace('{$timeID}', $rnd, $row);
                                                        echo '</tr>';
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    
                    <?php } ?>
    
                </tbody>
            </table>
        </div>
    </div>
    <div class="subbox">
        <div class="inner box">
            <?php $enabled = ((isset($options['ical_feed'])) ? $options['ical_feed'] : 0); ?>
            <?php $alarm = ((isset($options['ical_feed_alarm'])) ? $options['ical_feed_alarm'] : 0); ?>
            <?php $ical_feed_alarm_from = ((isset($options['ical_feed_alarm_from'])) ? $options['ical_feed_alarm_from'] : 0); ?>
            <?php $ical_feed_alarm_to = ((isset($options['ical_feed_alarm_to'])) ? $options['ical_feed_alarm_to'] : 0); ?>
            <?php $rnd = $tools->randomStr(); ?>
            <h4><?php echo $html->image('theme/plus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> iCalendar Feed</h4>
            <div class="clr"></div>            
            <div class="subbox hidden" id="<?php echo $rnd; ?>">
                <div class="subbox">
                    <span class="checkbox<?php if ($enabled==1) { echo ' checked'; }?>" callbacks="saveOption('ical_feed', '<?php echo $enabled; ?>')" id="<?php echo $rnd; ?>_icalfeed"></span> Enabled <br />
                    <span class="checkbox<?php if ($alarm==1) { echo ' checked'; }?>" callbacks="saveOption('ical_feed_alarm', '<?php echo $alarm; ?>')" id="<?php echo $rnd; ?>_icalfeedalarm"></span> Enable calendar alarm events between
                    <select class="optionselect" id="ical_feed_alarm_from">
                        <?php for ($i=0; $i < 24; $i++) { ?> 
                            <option value="<?php echo $i; ?>"<?php if ($i==$ical_feed_alarm_from) { echo ' selected="selected"'; }?>><?php echo $i; ?>:00</value>                
                        <?php } ?>
                    </select>
                    UTC and
                    <select class="optionselect" id="ical_feed_alarm_to">
                        <?php for ($i=0; $i < 24; $i++) { ?> 
                            <option value="<?php echo $i; ?>"<?php if ($i==$ical_feed_alarm_to) { echo ' selected="selected"'; }?>><?php echo $i; ?>:00</value>
                        <?php } ?>
                    </select>
                    UTC
                </div>
                <div class="subbox">
                    <div class="inner box">
                        <?php $rnd = $tools->randomStr(); ?>
                        <h4><?php echo $html->image('theme/minus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> Skillqueue calendar feeds</h4>
                        <div class="clr"></div>            
                        <div class="subbox" id="<?php echo $rnd; ?>">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Calendar type</th>
                                        <th>Calendar URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            All characters
                                        </td>
                                        <td>
                                            <?php
                                                $icalUrl = "http://ical.simpleve.com/" . ($user['id'] + 1000000) . "/" . $user['hash'] . "/Skillqueue_All.ics";
                                            ?>
                                            <a href="<?php echo $icalUrl; ?>"><?php echo $icalUrl; ?></a>
                                        </td>
                                    </tr>
                                    <?php 
                                        foreach($apis as $api) {
                                            if ($api['Api']['errorcode']<200) {
                                                foreach($characters[$api['Api']['id']] as $character) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $character['api']->name; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $icalUrl = "http://ical.simpleve.com/" . ($user['id'] + 1000000) . "/" . $user['hash'] . "/Skillqueue_" . str_replace(' ', '_', $character['api']->name) . '.ics';
                                                            ?>
                                                            <a href="<?php echo $icalUrl; ?>"><?php echo $icalUrl; ?></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                        } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="subbox">
                    <div class="inner box">
                        <?php $rnd = $tools->randomStr(); ?>
                        <h4><?php echo $html->image('theme/minus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> Industry jobs calendar feeds</h4>
                        <div class="clr"></div>            
                        <div class="subbox" id="<?php echo $rnd; ?>">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Calendar type</th>
                                        <th>Calendar URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            All characters
                                        </td>
                                        <td>
                                            <?php
                                                $icalUrl = "http://ical.simpleve.com/" . ($user['id'] + 1000000) . "/" . $user['hash'] . "/Jobs_All.ics";
                                            ?>
                                            <a href="<?php echo $icalUrl; ?>"><?php echo $icalUrl; ?></a>
                                        </td>
                                    </tr>
                                    <?php 
                                        foreach($apis as $api) {
                                            if ($api['Api']['errorcode']<200) {
                                                foreach($characters[$api['Api']['id']] as $character) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $character['api']->name; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $icalUrl = "http://ical.simpleve.com/" . ($user['id'] + 1000000) . "/" . $user['hash'] . "/Jobs_" . str_replace(' ', '_', $character['api']->name) . '.ics';
                                                            ?>
                                                            <a href="<?php echo $icalUrl; ?>"><?php echo $icalUrl; ?></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                        } 
                                        foreach($Corporations as $corporation) {
                                            if (!$corporation['npccorp']) { ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo '[' . $corporation['corporationSheet']->ticker . '] ' . $corporation['corporationSheet']->corporationName; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $icalUrl = "http://ical.simpleve.com/" . ($user['id'] + 1000000) . "/" . $user['hash'] . "/Jobs_" . str_replace(' ', '_', $corporation['corporationSheet']->ticker) . '.ics';
                                                            ?>
                                                            <a href="<?php echo $icalUrl; ?>"><?php echo $icalUrl; ?></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="subbox">
                    If you believe that someone is misusing your iCal Feed / API key, you can create a new one in the <?php echo $this->Html->link('account settings', '/settings', array()); ?>.
                </div>
            </div>
        </div>
    </div>
 <?php } ?>