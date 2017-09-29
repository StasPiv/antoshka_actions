<?php

/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 11:57 AM
 */
class OpsWay_Actions_Model_Mysql4_ActInCat extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('opsway_actions/act_in_cat', 'act_in_cat_id');
    }

}