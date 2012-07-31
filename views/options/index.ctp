<?php $html->addCrumb('Options', '/options'); ?>

<div class="box">
    <h3>
        Industry
    </h3>
    <div class="subbox">
        <table>
            <tbody>
                <tr>
                    <td>
                        <?php echo $tools->getOptionsCheckbox($options, 'marketdetails'); ?>
                    </td>
                    <td> 
                        Show prices for <?php echo $this->Tools->getMapLinks(10000002); ?>, <?php echo $this->Tools->getMapLinks(10000030); ?>, <?php echo $this->Tools->getMapLinks(10000032); ?> and <?php echo $this->Tools->getMapLinks(10000043); ?> (slow) 
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $tools->getOptionsCheckbox($options, 'yourme_column'); ?>
                    </td>
                    <td> 
                        Always show "You (ME)" column in the manufacturing tab.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
