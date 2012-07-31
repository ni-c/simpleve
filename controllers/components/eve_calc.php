<?php

/**
 * EveCalc component, used to calculate everelated things
 * 
 * @author Willi Thiel
 * @date 2010-09-11
 * @version 1.0
 */
class EveCalcComponent extends Object {

    /**
     * Save reference to controller on startup.
     * 
     * @param $controller The parent controller of this component.
     */
    function startup(&$controller)
    {
    }
    
    /**
     * Returns the submenu
     */
    function get() {
        return $this->submenus;
    }

    /**
     * Returns the productivity time for a blueprint depending on its data
     */
    function productivityTime($productionTime, $productivityModifier, $productivityLevel) {
        if ($productionTime>0) {
            if ($productivityLevel > 0) {
                return round($productionTime * (1 - (($productivityModifier/$productionTime) * ($productivityLevel/(1+$productivityLevel)))));
            } else {
                return round($productionTime * (1 - (($productivityModifier/$productionTime) * ($productivityLevel-1))));
            }
        } else {
            return 0;
        }
    }

    /**
     * Returns the quanitity for the given material level
     */
    function materialEfficience($me_level, $base_cost, $productionEfficiency = 5) {
        if ($me_level>=0) {
            return round($base_cost * (1 + 0.1 / ($me_level + 1)) * (1.25 - 0.05 * $productionEfficiency));
        } else {
            return round($base_cost * (1 + 0.1 - $me_level / 10) * (1.25 - 0.05 * $productionEfficiency));
        }
    }
}
?>