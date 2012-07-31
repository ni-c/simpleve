<?php 
    $html->addCrumb('Character', '/character');
    $html->addCrumb('Wallet', '/character/wallet');
    echo $this->element('apinotice', array('siteName' => 'Dashboard', 'fullRequired' => true)); 
?>

<?php if (isset($active_character)) { ?>
    <?php if (sizeof($journal)>0) { ?>
        <div class="inner box">
            <?php $rnd = $tools->randomStr(); ?>
            <h4><?php echo $html->image('theme/plus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> Journal</h4>
            <div class="clr"></div>
            <div class="subbox hidden" id="<?php echo $rnd; ?>">
                <table class="innertable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>&nbsp;</th>
                            <th>Partner</th>
                            <th>Reason</th>
                            <th class="nr">Amount</th>
                            <th class="nr">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($journal as $item) { ?>
                        <?php
                            $owner = '';
                            $ownerId = '';
                            if ($item['amount']<0.0) {
                                $owner = $item['ownerName2']; 
                                $ownerId = $item['ownerID2']; 
                                $ownerIcon = false;
                            } else {
                                $owner = $item['ownerName1'];
                                $ownerId = $item['ownerID1'];
                                $ownerIcon = false; 
                            }
                            if ($ownerId > 9999999) {
                                $owner = $this->Tools->getCharacterLinks($ownerId);
                                $ownerIcon = $this->Html->image(
                                            'http://image.eveonline.com/Character/' . $ownerId . '_32.jpg',
                                            array('height' => 16, 'width' => 16, 'class' => 'left'));
                            }
                        ?>
                        
                            <tr>
                                <td nowrap="nowrap">
                                    <?php echo date('Y-m-d H:i', strtotime($item['date'])); ?>
                                </td>
                                <td>
                                    <?php echo $refTypes[$item['refTypeID']]; ?>
                                </td>
                                <td class="icon">
                                    <?php 
                                        if ($ownerIcon!==false) {
                                            echo $ownerIcon;    
                                        } else {
                                            echo '&nbsp;';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $owner; ?>
                                </td>
                                <td>
                                    <?php
                                        if ($item['refTypeID']!=85 /* Bounty */) {
                                            echo $item['reason'];
                                        }
                                    ?>  
                                </td>
                                <td class="nr<?php if ($item['amount']<0.0) echo ' down'; else echo ' up'; ?>" nowrap="nowrap">
                                    <?php echo number_format($item['amount'],2,'.',','); ?>
                                </td>
                                <td class="nr" nowrap="nowrap">
                                    <?php echo number_format($item['balance'],2,'.',','); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>           
        </div>
    <?php } ?>
    
    <?php if (sizeof($transactions)>0) { ?>
        <div class="inner box">
            <?php $rnd = $tools->randomStr(); ?>
            <h4><?php echo $html->image('theme/plus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> Transactions</h4>
            <div class="clr"></div>
            <div class="subbox hidden" id="<?php echo $rnd; ?>">
                <table class="innertable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>&nbsp;</th>
                            <th>Type</th>
                            <th>&nbsp;</th>
                            <th>Partner</th>
                            <th>Location</th>
                            <th class="nr">Price</th>
                            <th class="nr">Qty.</th>
                            <th class="nr">Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($transactions as $item) { ?>
                            <tr>
                                <td nowrap="nowrap">
                                    <?php echo date('Y-m-d H:i', strtotime($item['transactionDateTime'])); ?>
                                </td>
                                <?php $itemInfo = $tools->getItemInfo($item['typeID'], true); ?>
                                <td class="icon">
                                    <?php echo $itemInfo['icon'] ?>
                                </td>
                                <td>
                                    <?php echo $itemInfo['link'] ?>
                                </td>
                                <td class="icon">
                                    <?php
                                        if ($item['clientID'] > 9999999) { 
                                            echo $this->Html->image(
                                                'http://image.eveonline.com/Character/' . $item['clientID'] . '_32.jpg',
                                                array('height' => 16, 'width' => 16, 'class' => 'left'));
                                        } else {
                                            echo '&nbsp;';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if ($item['clientID'] > 9999999) { 
                                            echo $this->Tools->getCharacterLinks($item['clientID']);
                                        } else {
                                            echo $item['clientName'];
                                        } 
                                    ?>
                                </td>
                                <td>
                                    <?php echo $this->Tools->getStationLinks($item['stationID']); ?>
                                </td>
                                <td class="nr<?php if ($item['transactionType']=='buy') echo ' down'; else echo ' up'; ?>" nowrap="nowrap">
                                    <?php echo number_format($item['price'],2,'.',','); ?>
                                </td>
                                <td class="nr" nowrap="nowrap">
                                    <?php echo $item['quantity']; ?>
                                </td>
                                <td class="nr<?php if ($item['transactionType']=='buy') echo ' down'; else echo ' up'; ?>" nowrap="nowrap">
                                    <?php if ($item['transactionType']=='buy') { echo '-'; } echo number_format($item['price']*$item['quantity'],2,'.',','); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>           
        </div>
    <?php } ?>
    
    <?php if (sizeof($sellorders)>0) { ?>
        <div class="inner box">
            <?php $rnd = $tools->randomStr(); ?>
            <h4><?php echo $html->image('theme/plus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> Sell Orders</h4>
            <div class="clr"></div>
            <div class="subbox hidden" id="<?php echo $rnd; ?>">
                <table class="innertable">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Location</th>
                            <th class="nr">Qty.</th>
                            <th class="nr">Price</th>
                            <th>Expires</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sellorders as $item) { ?>
                            <tr>
                                <td nowrap="nowrap">
                                    <?php echo $tools->getItemLinks($item['typeID'], true); ?>
                                </td>
                                <td>
                                    <?php echo $this->Tools->getStationLinks($item['stationID']); ?>
                                </td>
                                <td class="nr" nowrap="nowrap">
                                    <?php echo $item['volRemaining'] . '/' . $item['volEntered']; ?>
                                </td>
                                <td class="nr" nowrap="nowrap">
                                    <?php echo number_format($item['price'],2,'.',','); ?>
                                </td>
                                <td nowrap="nowrap">
                                    <?php echo date('Y-m-d H:i:s', strtotime($item['issued']) + $item['duration']); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>           
        </div>
    <?php } ?>
    
    <?php if (sizeof($buyorders)>0) { ?>
        <div class="inner box">
            <?php $rnd = $tools->randomStr(); ?>
            <h4><?php echo $html->image('theme/plus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> Buy Orders</h4>
            <div class="clr"></div>
            <div class="subbox hidden" id="<?php echo $rnd; ?>">
                <table class="innertable">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Location</th>
                            <th class="nr">Qty.</th>
                            <th class="nr">Price</th>
                            <th>Expires</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($buyorders as $item) { ?>
                            <tr>
                                <td nowrap="nowrap">
                                    <?php echo $tools->getItemLinks($item['typeID'], true); ?>
                                </td>
                                <td>
                                    <?php echo $this->Tools->getStationLinks($item['stationID']); ?>
                                </td>
                                <td class="nr" nowrap="nowrap">
                                    <?php echo $item['volRemaining'] . '/' . $item['volEntered']; ?>
                                </td>
                                <td class="nr" nowrap="nowrap">
                                    <?php echo number_format($item['price'],2,'.',','); ?>
                                </td>
                                <td>
                                    <?php echo date('Y-m-d H:i:s', strtotime($item['issued']) + $item['duration']); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>           
        </div>
    <?php } ?>
<?php } ?>