<?php 
    $html->addCrumb('Industry', '/industry');
    $html->addCrumb('Refining Calculator', '/industry/refiningcalculator');
    $this->Html->script('refiningcalculator', array('inline' => false));
    echo $this->element('apinotice', array('siteName' => 'Refining Calculator', 'fullRequired' => false));
?>

<?php echo $this->element('locationpicker', array('regionurl' => 'industry/refiningcalculator/{regionID}')); ?>

<div class="box">
    <h3>
        Base Skills
    </h3>
    <div class="subbox">
        <table>
            <tbody>
                <?php 
                    $skill1 = $this->Tools->getSkill('Refining', $active_character, 'refining_skill', 'calcEfficiencies()'); 
                    echo $skill1['tr'];
                ?>
                <?php 
                    $skill2 = $this->Tools->getSkill('Refinery Efficiency', $active_character, 'refineryefficiency_skill', 'calcEfficiencies()'); 
                    echo $skill2['tr'];
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="box">
    <h3>
        Base Minerals
    </h3>
    <div class="subbox">
        <table class="refiningcalculatortable">
            <thead>
                <tr>
                    <th colspan="2">
                        &nbsp;
                    </th>
                    <th>
                        Refining Skill
                    </th>
                    <th>
                        Skill Level
                    </th>
                    <th>
                        Base Efficiency
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($orelist as $ore) {
                    echo $this->element('industry_refinery_oretype', $ore);            
                } 
            ?>
            </tbody>
        </table>
    </div>
</div>
