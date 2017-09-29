<?php

/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 11:11 AM
 */
class OpsWay_Actions_Model_Mysql4_Category extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('opsway_actions/categories', 'category_id');
    }

}