<?php

/**
 * Behaviour for models that access readonly tables. 
 * 
 * @author Willi Thiel
 * @date 2010-09-01
 * @version 0.1
 */
class ReadonlyBehavior extends ModelBehavior {

    /**
     * Behaviour callback
     * 
     * You can return false from a behavior's beforeDelete to abort the delete. Return true to allow it continue.
     */
    function beforeDelete(&$model, $cascade = true) {
        trigger_error('Cannot delete datasets from readonly models (' . get_class($model) . ')', E_USER_WARNING);
        return false;
    }

    /**
     * Behaviour callback
     * 
     * You can return false from a behavior's beforeSave to abort the save. Return true to allow it continue.
     */
    function beforeSave(&$model, $cascade = true) {
        trigger_error('Cannot write into readonly models (' . get_class($model) . ')', E_USER_WARNING);
        return false;
    }

}

?>
