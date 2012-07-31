<?php

/**
 * Skill helper
 * 
 * @author Willi Thiel
 * @date 2010-09-15
 * @version 1.0
 */
class CharacterXmlHelper extends AppHelper {
        
    function getSkillLevel($character, $skill) {
        if (!isset($character)) {
            return 0;
        }
        if (isset($character['api'])) {
            $character = $character['api'];
        }
        $result = 0;
        $node = $character->xpath("//rowset[@name='skills']/row[@typeID='" . $skill . "']");
        if (isset($node[0])) {
            $arr = $node[0]->attributes();
            $result = $arr['level']; 
        }
        return $result;
    }
    
}
?>
